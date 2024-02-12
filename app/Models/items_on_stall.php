<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class items_on_stall extends Model
{
    use HasFactory;
    protected $table = 'items_on_stall';
    protected $fillable = [
        'user_id',
        'item_id',
        'item_count'
    ];
    public function item(){
        return $this->belongsTo('App\Models\items');
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
