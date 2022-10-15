<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;
    protected $table  = 'component';
    protected $fillable = [
        'category_id',
        'user_id',
        'viewes',
        'likes',
        'code_referance',
    ];
}
