<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class items extends Model
{
    use HasFactory;
    protected $table = 'items';
    protected $fillable = [
        'item_name',
        'category_id',
        'item_price',
        'item_description',
        'user_id',
        'item_count',
        'status',
        'foto1',
        'foto2'
    ];
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function category(){
        return $this->belongsTo('App\Models\category');
    }
    public function comment(){
        return $this->hasMany('App\Models\comment');
    }
    public function ship(){
        return $this->hasMany('App\Models\shipped_item', 'item_id', 'id');
    }
}
