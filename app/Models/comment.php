<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    use HasFactory;
    protected $table = 'comment';
    
    protected $fillable = [
        'user_id',
        'item_id',
        'rating',
        'comment',
        'media1',
        'media2',
        'media3'
    ];

}
