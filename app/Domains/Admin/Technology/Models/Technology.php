<?php

namespace App\Domains\Admin\Technology\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Technology extends Model
{
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'description',
        'technology_type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

}
