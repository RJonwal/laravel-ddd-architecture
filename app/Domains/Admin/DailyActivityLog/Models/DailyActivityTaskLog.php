<?php

namespace App\Domains\Admin\DailyActivityLog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Domains\Admin\Milestone\Models\Milestone;
use App\Domains\Admin\User\Models\User;
use App\Domains\Admin\Project\Models\Project;
use App\Domains\Admin\Task\Models\Task;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyActivityTaskLog extends Model
{
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'uuid',
        'task_id',
        'sub_task_id',
        'description',
        'work_time',
        'status',
        'task_type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function boot ()
    {
        parent::boot();
        static::creating(function(DailyActivityTaskLog $model) {
            $model->uuid = Str::uuid();
        });
    }

    public function task(){
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    public function subTask(){
        return $this->belongsTo(Task::class, 'sub_task_id', 'id');
    }
}
