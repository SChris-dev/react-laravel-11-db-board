<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';

    protected $fillable = [
        'list_id',
        'order',
        'task',
    ];

    public function board_list() {
        return $this->belongsTo(BoardList::class, 'list_id', 'id');
    }
}
