<?php

namespace App\Domains\Admin\Task\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Domains\Admin\Sprint\Models\Sprint;
use App\Domains\Admin\Milestone\Models\Milestone;
use App\Domains\Admin\User\Models\User;
use App\Domains\Admin\Project\Models\Project;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
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
        'milestone_id',
        'sprint_id',
        'parent_task_id',
        'user_id',
        'estimated_time',
        'priority',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function boot ()
    {
        parent::boot();
        static::creating(function(Task $model) {
            $model->uuid = Str::uuid();
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function milestone()
    {
        return $this->belongsTo(Milestone::class);
    }
    
    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subTasks()
    {
        return $this->hasMany(Task::class, 'parent_task_id', 'id');
    }
    
    public function parent()
    {
        return $this->belongsTo(Task::class, 'parent_task_id');
    }

    public function children()
    {
        return $this->hasMany(Task::class, 'parent_task_id');  //->orderBy('position')
    } 

    public function isTask()
    {
        return is_null($this->parent_task_id);
    }
}
