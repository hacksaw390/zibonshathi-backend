<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Blog extends Model
{
    Use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'image', 'title', 'description','deleted_at',
    ];
}
