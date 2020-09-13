<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'responses',
        'request',
        'email',
        'user_id',
    ];

    protected $casts = [
        'responses' => 'array',
        'request'   => 'array',
    ];

    public static function findByEmail($email)
    {
        return self::where('email', $email)->first();
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
    }
}
