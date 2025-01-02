<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginToken extends Model
{
    protected $table = 'login_tokens';

    protected $fillable = [
        'user_id',
        'token',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
