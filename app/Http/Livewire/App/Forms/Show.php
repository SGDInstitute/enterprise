<?php

namespace App\Http\Livewire\App\Forms;

use App\Models\Form;
use App\Models\Order;
use App\Models\Response;
use App\Models\User;
use App\Notifications\AddedAsCollaborator;
use App\Notifications\RemovedAsCollaborator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Livewire\Component;

class Show extends Component
{
    public Form $form;

    public Response $parent;

    public Response $response;

    public $answers;

    public $collaborators;

    public $newCollaborator;

    public $showPreviousResponses = false;

    public $showCollaboratorModal = false;

    protected $listeners = ['refresh' => '$refresh'];

    protected $rules = [
        'newCollaborator.email' => ['required', 'email'],
        'newCollaborator.name' => ['required'],
        'newCollaborator.pronouns' => ['required'],
    ];

    protected $messages = [
        'newCollaborator.email.required' => 'The email field cannot be empty.',
        'newCollaborator.email.email' => 'The email format is not valid.',
        'newCollaborator.name.required' => 'The name field cannot be empty.',
        'newCollaborator.pronouns.required' => 'The pronouns field cannot be empty.',
    ];

    public function mount()
    {
        $this->newCollaborator = ['name' => '', 'email' => '', 'id' => '', 'pronouns'];

        if (request()->query('edit')) {
            // @todo check if user is authorized to view
            $this->load(request()->query('edit'));
        } else {
            if (auth()->check() && $this->isWorkshopForm && $this->previousResponses->count() > 0) {
                $this->showPreviousResponses = true;
            }

            if (auth()->check() && $this->form->type === 'finalize' && $this->previousResponses->count() > 0) {
                $this->emit('notify', ['message' => 'You have already submitted a response for this form.', 'type' => 'error']);

                return redirect()->route('app.dashboard', ['page' => 'workshops']);
            }

            $this->response = (new Response(['user_id' => auth()->id(), 'form_id' => $this->form->id]));
            if (isset($this->parent)) {
                $this->response->parent_id = $this->parent->id;
            }

            $this->answers = $this->form->form
                ->filter(fn ($item) => $item['style'] === 'question')
                ->mapWithKeys(function ($item) {
                    if (isset($item['data']) && isset($this->parent)) {
                        $parentAnswer = $this->parent->answers[$item['id']];
                    }

                    if ($item['type'] === 'list' && $item['list-style'] === 'checkbox') {
                        return [$item['id'] => $parentAnswer ?? []];
                    }

                    return [$item['id'] => $parentAnswer ?? ''];
                })->toArray();

            if ($this->form->hasCollaborators) {
                if (isset($this->parent)) {
                    $this->collaborators = $this->parent->collaborators->map(fn ($user) => $user->only('id', 'name', 'email', 'pronouns'));
                } else {
                    $user = auth()->check() ? auth()->user()->only(['id', 'name', 'email', 'pronouns']) : ['name' => 'Luz Noceda', 'id' => '', 'email' => 'luz@hexide.edu', 'pronouns' => 'she/her'];
                    $this->collaborators = collect([$user]);
                }
            }
        }
    }

    public function updatedAnswers()
    {
        // @todo remember why this if is here
        if ($this->form->type !== 'finalize') {
            $this->save();
        }
    }

    public function updatedNewCollaborator($value, $field)
    {
        if ($field === 'email' && $user = User::whereEmail($value)->first()) {
            $this->newCollaborator = $user->only('id', 'name', 'email', 'pronouns');
        }
    }

    public function render()
    {
        return view('livewire.app.forms.show')
            ->with([
                'fillable' => $this->fillable,
                'previousResponses' => $this->previousResponses,
                'showResponseLog' => $this->showResponseLog,
                'isWorkshopForm' => $this->isWorkshopForm,
            ]);
    }

    // Properties

    public function getFillableProperty()
    {
        return $this->form->auth_required ? auth()->check() : true;
    }

    public function getIsWorkshopFormProperty()
    {
        return $this->form->type === 'workshop';
    }

    public function getPreviousResponsesProperty()
    {
        if (isset($this->parent)) {
            return auth()->user()->responses()->where('form_id', $this->form->id)->where('parent_id', $this->parent)->get();
        }

        return auth()->user()->responses()->where('form_id', $this->form->id)->get();
    }

    public function getShowResponseLogProperty()
    {
        return in_array($this->response->status, ['submitted', 'in-review', 'approved', 'rejected', 'scheduled', 'canceled', 'confirmed', 'waiting-list']);
    }

    // Methods

    public function saveCollaborator()
    {
        $this->validate();

        if (! isset($this->newCollaborator['id'])) {
            $user = User::create(array_merge($this->newCollaborator, ['password' => Hash::make(Str::random(15))]));
            $this->newCollaborator['id'] = $user->id;
        } else {
            $user = User::find($this->newCollaborator['id']);
        }

        $this->collaborators[] = $this->newCollaborator;

        if ($this->isWorkshopForm) {
            $this->save();
        } else {
            $this->save(false);
        }

        Notification::send($user, new AddedAsCollaborator($this->response));

        $this->reset('newCollaborator', 'showCollaboratorModal');
    }

    public function delete($id)
    {
        $this->previousResponses->firstWhere('id', $id)->safeDelete();

        $this->emit('refresh');
        $this->emit('notify', ['message' => 'Successfully deleted previous submission.', 'type' => 'success']);
    }

    public function deleteCollaborator($id)
    {
        $this->response->collaborators()->detach($id);

        Notification::send(User::find($id), new RemovedAsCollaborator($this->response));

        $this->collaborators = $this->collaborators->filter(fn ($collaborator) => $collaborator['id'] !== $id);

        $this->emit('notify', ['message' => 'Successfully removed presenter.', 'type' => 'success']);
    }

    public function isVisible($item)
    {
        if (isset($item['visibility']) && isset($item['conditions']) && $item['visibility'] === 'conditional' && count($item['conditions']) > 0) {
            [$passes, $fails] = collect($item['conditions'])->partition(function ($condition) {
                if ($condition['method'] === 'equals') {
                    return $this->answers[$condition['field']] == $condition['value'];
                } elseif ($condition['method'] === 'not') {
                    return $this->answers[$condition['field']] != $condition['value'];
                } elseif ($condition['method'] === '>') {
                    return $this->answers[$condition['field']] > $condition['value'];
                } elseif ($condition['method'] === '>=') {
                    return $this->answers[$condition['field']] >= $condition['value'];
                } elseif ($condition['method'] === '<') {
                    return $this->answers[$condition['field']] < $condition['value'];
                } elseif ($condition['method'] === '<=') {
                    return $this->answers[$condition['field']] <= $condition['value'];
                }
            });

            if (isset($item['visibility-andor']) && $item['visibility-andor'] === 'or') {
                return $passes->count() > 0;
            } else {
                return $fails->count() === 0;
            }
        }

        return true;
    }

    public function load($id)
    {
        $this->response = Response::find($id);
        $this->response->load('activities.causer');

        $this->answers = $this->response->answers;
        $this->collaborators = $this->response->collaborators->map(fn ($user) => $user->only('id', 'name', 'email', 'pronouns'));
        $this->emit('notify', ['message' => 'Successfully loaded previous submission.', 'type' => 'success']);
        $this->showPreviousResponses = false;
    }

    public function save($withNotification = true, $status = 'work-in-progress')
    {
        if ($this->response->id !== null) {
            $this->response->answers = $this->answers;
            $this->response->status = $status;
            $this->response->save();
        } else {
            $this->response = Response::create([
                'user_id' => auth()->id(),
                'type' => $this->form->type,
                'form_id' => $this->form->id,
                'answers' => $this->answers,
                'status' => $status,
            ]);

            if ($this->form->has_reminders) {
                // $this->response->setUpReminders($this->form->settings->reminders);
            }
        }

        // if form has collaborators
        if ($this->form->hasCollaborators) {
            $this->response->collaborators()->sync($this->collaborators->pluck('id'));
        }

        if ($withNotification) {
            $this->emit('notify', ['message' => 'Successfully saved submission. You can leave this page and come back to continue working on the submission.', 'type' => 'success']);
        }
    }

    public function submit()
    {
        $this->validate($this->form->rules);

        // $this->response->status = 'submitted';
        $this->save(false, 'submitted');

        if ($this->form->type === 'workshop') {
            $this->emit('notify', ['message' => 'Successfully submitted submission for review.', 'type' => 'success']);
        } elseif ($this->form->type === 'finalize') {
            $this->emit('notify', ['message' => 'Successfully submitted.', 'type' => 'success']);
            $this->response->update(['parent_id' => $this->parent->id]);
            $this->parent->update(['status' => 'finalized']);

            activity()->performedOn($this->parent)
                ->withProperties([
                    'comment' => 'Submitted Program Book details finalization form. Any changes you made will be updated on the original submission when it is scheduled.',
                    'finalResponse' => $this->response->id,
                ])
                ->log('finalized');

            $ticketData = $this->response->collaborators
                ->filter(fn ($user) => ! $user->isRegisteredFor($this->form->event))
                ->map(function ($user) {
                    return [
                        'event_id' => $this->form->event_id,
                        'ticket_type_id' => 29, // @todo HARDCODED VALUE
                        'price_id' => 40, // @todo HARDCODED VALUE
                        'user_id' => $user->id,
                    ];
                });

            if ($ticketData->isNotEmpty()) {
                $order = Order::create(['event_id' => $this->form->event->id, 'user_id' => auth()->id()]);
                $order->tickets()->createMany($ticketData);
                $order->markAsPaid('comped-workshop-presenter', 0);

                return redirect()->route('app.orders.show', $order);
            } else {
                return redirect()->route('app.forms.thanks', $this->form);
            }
        } else {
            $this->emit('notify', ['message' => 'Successfully submitted.', 'type' => 'success']);

            return redirect()->route('app.forms.thanks', $this->form);
        }
    }
}
