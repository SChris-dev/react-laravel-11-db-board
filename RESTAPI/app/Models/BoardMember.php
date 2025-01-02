<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardMember extends Model
{
    protected $table = 'board_members';

    protected $fillable = [
        'board_id',
        'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function board() {
        return $this->belongsTo(Board::class, 'board_id', 'id');
    }
}
