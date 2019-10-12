<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $fillable = [
        'responses',
        'request',
        'email',
        'user_id',
    ];

    protected $casts = [
        'responses' => 'array',
        'request'   => 'array'
    ];

    public static function findByEmail($email)
    {
        return self::where('email', $email)->first();
    }

    /**
     * Get the survey that owns the response.
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    /**
     * Get the survey that owns the response.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
