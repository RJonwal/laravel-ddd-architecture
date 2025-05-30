<?php

namespace App\Domains\Admin\Milestone\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Domains\Admin\Project\Models\Project;
use App\Domains\Admin\Sprint\Models\Sprint;
use App\Domains\Admin\Task\Models\Task;
use Illuminate\Database\Eloquent\SoftDeletes;

class Milestone extends Model
{
    use SoftDeletes;
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'project_id',
        'start_date',
        'end_date',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function boot ()
    {
        parent::boot();
        static::creating(function(Milestone $model) {
            $model->uuid = Str::uuid();
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class)->whereNull('parent_task_id'); //->orderBy('position')
    }

    public function sprints()
    {
        return $this->hasMany(Sprint::class);
    }
}
