<?php

namespace App\Http\Livewire\App\Forms;

use App\Models\Form;
use App\Models\Response;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Show extends Component
{

    public Form $form;
    public Response $response;
    public $answers;
    public $showPreviousResponses = true;

    protected $rules;

    public function mount()
    {
        $this->answers = $this->form->form
            ->filter(fn($item) => $item['style'] === 'question')
            ->mapWithKeys(function($question) {
                if($question['type'] === 'list' && $question['list-style'] === 'checkbox') {
                    return [$question['id'] => []];
                }

                return [$question['id'] => ''];
            })->toArray();

        $this->rules = $this->form->form
            ->filter(fn($item) => $item['style'] === 'question')
            ->mapWithKeys(function($question) {
                return [$question['id'] => $question['rules']];
            })->toArray();
    }

    public function render()
    {
        return view('livewire.app.forms.show')
            ->with([
                'previousResponses' => $this->previousResponses,
            ]);
    }

    public function getPreviousResponsesProperty()
    {
        return auth()->user()->responses()->where('form_id', $this->form->id)->get();
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

    public function save()
    {
        // validate

        $response = Response::create([
            'user_id' => auth()->id(),
            'form_id' => $this->form->id,
            'answers' => $this->answers,
        ]);

        // if form has collaborators
        if(isset($this->answers['collaborators'])) {
            $emails = explode(",", preg_replace("/((\r?\n)|(\r\n?))/", ',', $this->answers['collaborators']));
            $emails[] = auth()->user()->email;

            [$users, $invites] = collect($emails)->partition(function ($email) {
                return DB::table('users')->where('email', $email)->exists();
            });

            $ids = DB::table('users')->whereIn('email', $users)->select('id')->get()->pluck('id');
            $response->collaborators()->attach($ids);

            // create invites for new users
        }

        $this->emit('notify', ['message' => 'Successfully saved submission. You can leave this page and come back to continue working on the submission.', 'type' => 'success']);
    }
}
