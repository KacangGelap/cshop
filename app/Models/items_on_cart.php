<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class items_on_cart extends Model
{
    use HasFactory;
    protected $table = 'items_on_cart';

    protected $fillable = [
        'user_id',
        'item_id',
        'item_count'
    ];

    public function item(){
        return $this->belongsTo('App\Models\items');
    }
    public function user(){
        return $this->belongsTo('App\Models\Users');
    }
}
