<?php

namespace App\Domains\Admin\Project\Models;

use App\Domains\Admin\Master\Upload\Models\Uploads;
use App\Domains\Admin\Technology\Models\Technology;
use App\Domains\Admin\User\Models\User;
use App\Domains\Admin\Milestone\Models\Milestone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Project extends Model
{
    use SoftDeletes;
    
    protected $append = ['project_document_url'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'created_at' => 'datetime',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'uuid',
        'name',
        'start_date',
        'end_date',
        'project_lead',
        'description',
        'refrence_details',
        'live_url',
        'credentials',
        'project_status',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function boot ()
    {
        parent::boot();
        static::creating(function(Project $model) {
            $model->uuid = Str::uuid();
            $model->created_by = auth()->user()->id;
        });
    }

    public function getProjectDocumentUrlAttribute()
    {
        $query_check = $this->uploads;
        $media=[];
        foreach($query_check as $query){
            if($query && Storage::disk('public')->exists($query->file_path)){
                $media []= asset('storage/'.$query->file_path);
            }
        }
        return $media;
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function assignDevelopers()
    {
        return $this->belongsToMany(User::class);
    }

    public function projectLead()
    {
        return $this->belongsTo(User::class,'project_lead','id');
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }

    public function uploads()
    {
        return $this->morphMany(Uploads::class, 'uploadsable');
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }
}
