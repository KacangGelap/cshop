<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class track extends Model
{
    use HasFactory;
    protected $table = 'track';

    protected $fillable = [
        'shipped_item_id',
        'status',
        'img'
    ];
    public function ship(){
        return $this->belongsTo('App\Models\shipped_item','shipped_item_id','id');
    }
}
