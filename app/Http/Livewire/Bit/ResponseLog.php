<?php

namespace App\Http\Livewire\Bit;

use Illuminate\Support\Str;
use App\Models\Response;
use App\Notifications\WorkshopStatusChanged;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class ResponseLog extends Component
{
    public Response $response;

    protected $listeners = ['refresh' => '$refresh'];

    public $comment = '';
    public $internal = false;
    public $status;
    public $isGalaxy = false;
    public $statusChanged = false;

    public function mount()
    {
        $this->status = $this->response->status;
        if(Str::contains(url()->current(), 'galaxy')) {
            $this->internal = true;
            $this->isGalaxy = true;
        }
    }

    public function updated($field)
    {
        if($field === 'status') {
            $this->statusChanged = true;
        }
    }

    public function render()
    {
        return view('livewire.bit.response-log')
            ->with([
                'activities' => $this->activities,
            ]);
    }

    public function getActivitiesProperty()
    {
        return $this->response->activities
            ->load('causer')
            ->when(!$this->isGalaxy, function($collection) {
                return $collection->filter(function($activity) {
                    if(isset($activity['properties']['internal'])) {
                        return !$activity['properties']['internal'];
                    }

                    return true;
                });
            });
    }

    public function save()
    {
        if($this->comment !== '') {
            if($this->isGalaxy) {
                activity()->performedOn($this->response)->withProperties(['comment' => $this->comment, 'internal' => $this->internal])->log('commented');
            } else {
                activity()->performedOn($this->response)->withProperties(['comment' => $this->comment])->log('commented');
            }
        }

        if($this->statusChanged) {
            $this->response->status = $this->status;
            $this->response->save();
        }

        if(($this->comment !== '' && !$this->internal) || $this->statusChanged) {
            $comment = $this->internal ? '' : $this->comment;
            Notification::send($this->response->collaborators->where('id', '<>', auth()->id()), new WorkshopStatusChanged($this->response, $comment, $this->statusChanged, auth()->user()->name));
        }

        $this->emit('refresh');
        $this->reset('comment', 'statusChanged');
    }
}
