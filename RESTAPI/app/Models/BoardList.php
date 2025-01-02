<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardList extends Model
{
    protected $table = 'board_lists';
    
    protected $fillable = [
        'board_id',
        'order',
        'name',
    ];

    public function cards() {
        return $this->hasMany(Card::class, 'list_id','id');
    }

    public function board() {
        return $this->belongsTo(Board::class, 'board_id', 'id');
    }
}
