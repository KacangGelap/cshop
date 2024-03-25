<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shipped_item extends Model
{
    use HasFactory;
    protected $table = 'shipped_item';
    protected $fillable = [
        'user_id',
        'item_id',
        'item_count',
        'total_price',
        'status',
        'payment_status'
    ];
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function item(){
        return $this->belongsTo('App\Models\items');
    }
    public function track(){
        return $this->hasMany('App\Models\track');
    }
}
