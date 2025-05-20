<?php

namespace App\Domains\Admin\Technology\Models;

use App\Domains\Admin\Project\Models\Project;
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

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

}
