<?php

namespace App;

use App\Http\Resources\SpeakersResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['start', 'end'];

    public function activity_type()
    {
        return $this->belongsTo(ActivityType::class, 'activity_type_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function response()
    {
        return $this->belongsTo(Response::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function speakers()
    {
        return $this->belongsToMany(User::class, 'speakers');
    }

    public function type()
    {
        return $this->belongsTo(ActivityType::class, 'activity_type_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'schedule' => $this->schedule,
            'title' => $this->title,
            'speakers' => SpeakersResource::collection($this->speakers),
            'description' => $this->description,
            'type' => $this->type->title,
            'color' => $this->type->color,
            'text_color' => $this->type->text_color,
            'location' => $this->location->title ?? null,
            'room' => $this->room->title ?? $this->room->number ?? null,
            'start' => $this->start->tz($this->timezone)->format('Y-m-d H:i'),
            'start_time' => $this->start->tz($this->timezone)->format('g:i a'),
            'end' => $this->end->tz($this->timezone)->format('Y-m-d H:i'),
            'end_time' => $this->end->tz($this->timezone)->format('g:i a'),
        ];
    }
}
