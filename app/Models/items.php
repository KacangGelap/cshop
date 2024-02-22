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
        'item_price',
        'item_description',
        'user_id',
        'item_count',
        'status',
        'foto1',
        'foto2'
    ];
    public function comment(){
        return $this->hasMany('App\Models\comment');
    }
}
