<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $table = 'boards';

    protected $fillable = [
        'creator_id',
        'name',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public function board_lists() {
        return $this->hasMany(BoardList::class);
    }

    public function board_members() {
        return $this->hasMany(BoardMember::class);
    }
}
