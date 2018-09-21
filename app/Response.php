<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $fillable = [
        'responses',
        'request',
        'email',
    ];

    protected $casts = [
        'responses' => 'collection',
        'request'   => 'collection'
    ];

    public static function findByEmail($email)
    {
        return self::where('email', $email)->first();
    }

    /**
     * Get the survey that owns the response.
     */
    public function survey()
    {
        return $this->belongsTo(\App\Form::class);
    }
}
