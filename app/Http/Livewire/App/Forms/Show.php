<?php

namespace App\Http\Livewire\App\Forms;

use App\Models\Form;
use App\Models\Response;
use App\Models\User;
use App\Notifications\AddedAsCollaborator;
use App\Notifications\RemovedAsCollaborator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Livewire\Component;

class Show extends Component
{

    public Form $form;
    public Response $response;
    public $answers;
    public $showPreviousResponses = false;

    public function mount()
    {
        if(request()->query('edit')) {
            // check if user is authorized to view
            $this->load(request()->query('edit'));
        } else {
            if($this->previousResponses->count() > 0) {
                $this->showPreviousResponses = true;
            }

            $this->response = (new Response(['user_id' => auth()->id(), 'form_id' => $this->form->id]));

            $this->answers = $this->form->form
                ->filter(fn($item) => $item['style'] !== 'content')
                ->mapWithKeys(function($item) {
                    if($item['style'] === 'question') {
                        if($item['type'] === 'list' && $item['list-style'] === 'checkbox') {
                            return [$item['id'] => []];
                        }

                        return [$item['id'] => ''];
                    } elseif($item['style'] === 'collaborators') {
                        return [$item['id'] => auth()->user()->email ?? ''];
                    }
                })->toArray();
        }
    }

    public function render()
    {
        return view('livewire.app.forms.show')
            ->with([
                'fillable' => $this->fillable,
                'previousResponses' => $this->previousResponses,

            ]);
    }

    public function getFillableProperty()
    {
        return $this->form->auth_required && auth()->check();
    }

    public function getPreviousResponsesProperty()
    {
        if(auth()->check()) {
            return auth()->user()->responses()->where('form_id', $this->form->id)->get();
        }
        return collect([]);
    }

    public function isVisible($item)
    {
        if(isset($item['visibility']) && $item['visibility'] === 'conditional') {
            [$passes, $fails] = collect($item['conditions'])->partition(function ($condition) {
                if($condition['method'] === 'equals') {
                    return $this->answers[$condition['field']] == $condition['value'];
                } elseif($condition['method'] === 'not') {
                    return $this->answers[$condition['field']] != $condition['value'];
                } elseif($condition['method'] === '>') {
                    return $this->answers[$condition['field']] > $condition['value'];
                } elseif($condition['method'] === '>=') {
                    return $this->answers[$condition['field']] >= $condition['value'];
                } elseif($condition['method'] === '<') {
                    return $this->answers[$condition['field']] < $condition['value'];
                } elseif($condition['method'] === '<=') {
                    return $this->answers[$condition['field']] <= $condition['value'];
                }
            });

            if(!isset($item['visibility-andor'])) {
                dd($item, 'no and/or');
            }

            if($item['visibility-andor'] === 'and') {
                return $fails->count() === 0;
            }
            if($item['visibility-andor'] === 'pr') {
                return $passes->count() > 0;
            }
        }

        return true;
    }

    public function load($id)
    {
        $this->response = $this->previousResponses->find($id);
        $this->response->load('activities.causer');

        $this->answers = $this->response->answers;
        $this->emit('notify', ['message' => 'Successfully loaded previous submission.', 'type' => 'success']);
        $this->showPreviousResponses = false;
    }

    public function save($withNotification = true)
    {
        if($this->response->id !== null) {
            $this->response->answers = $this->answers;
            $this->response->save();
        } else {
            $this->response = Response::create([
                'user_id' => auth()->id(),
                'type' => $this->form->type,
                'form_id' => $this->form->id,
                'answers' => $this->answers,
                'status' => 'work-in-progress',
            ]);
        }

        // if form has collaborators
        if($this->form->hasCollaborators) {
            $emails = explode(",", preg_replace("/((\r?\n)|(\r\n?))/", ',', $this->answers['collaborators'] ?? auth()->user()->email));

            $users = collect($emails)->map(function ($email) {
                if($user = User::firstWhere('email', $email)) {
                    return $user;
                } else {
                    return User::create(['email' => $email, 'password' => Hash::make(Str::random(15))]);
                }
            });

            $oldCollaborators = $this->response->fresh()->collaborators->pluck('id');

            $ids = $users->pluck('id');
            $this->response->collaborators()->sync($ids);

            $oldCollaborators->forget($oldCollaborators->search(auth()->id()));
            $ids->forget($ids->search(auth()->id()));

            if($oldCollaborators->diff($ids)->count() > 0) {
                $users = User::find($oldCollaborators->diff($ids));
                Notification::send($users, new RemovedAsCollaborator($this->response));
            }
            if($ids->diff($oldCollaborators)->count() > 0) {
                $users = User::find($ids->diff($oldCollaborators));
                Notification::send($users, new AddedAsCollaborator($this->response));
            }
        }

        if($withNotification) {
            $this->emit('notify', ['message' => 'Successfully saved submission. You can leave this page and come back to continue working on the submission.', 'type' => 'success']);
        }
    }

    public function submit()
    {
        $this->validate($this->form->rules);

        $this->response->status = 'submitted';
        $this->save(false);

        $this->emit('notify', ['message' => 'Successfully submitted submission for review.', 'type' => 'success']);
    }
}
