<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    use HasFactory;
    protected $table = 'payment';
    protected $fillable = [
        'user_id',
        'billing_id'
    ];
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function billing(){
        return $this->belongsTo('App\Models\billing');
    }
}
