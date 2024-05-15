<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class selected_shipment extends Model
{
    use HasFactory;
    protected $table = 'selected_shipment';
    protected $fillable = [
        'user_id',
        'shipment_id'
    ];
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function ship(){
        return $this->hasOne('App\Models\shipped_item','id','shipment_id');
    }
}
