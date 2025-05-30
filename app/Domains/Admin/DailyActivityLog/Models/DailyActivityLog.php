<?php

namespace App\Domains\Admin\DailyActivityLog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Domains\Admin\Milestone\Models\Milestone;
use App\Domains\Admin\User\Models\User;
use App\Domains\Admin\Project\Models\Project;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyActivityLog extends Model
{
    use SoftDeletes;
    protected $casts = [
        'report_date' => 'date',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'uuid',
        'project_id',
        'milestone_id',
        'report_date',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function boot ()
    {
        parent::boot();
        static::creating(function(DailyActivityLog $model) {
            $model->uuid = Str::uuid();

            $model->created_by = auth('web')->user()->id;
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

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
