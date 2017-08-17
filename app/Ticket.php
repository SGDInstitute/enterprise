<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['ticket_type_id'];

    public function ticket_type()
    {
        return $this->belongsTo(TicketType::class);
    }
}
