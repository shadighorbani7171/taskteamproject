<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'team_id',
        'project_id',
        'start_time',
        'end_time',
        'is_completed',
        'progress'
    ];
  
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->is_completed = false;
        });

        static::updating(function ($model) {
            if ($model->is_completed) {
                $model->end_time = now();
            }
        });
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function subtasks()
    {
        return $this->hasMany(Subtask::class, 'task_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'task_id');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'task_id');
    }

    public function getCompletedSubtasksAttribute()
    {
        return $this->subtasks()->where('is_completed', true)->count();
    }

    public function getTotalSubtasksAttribute()
    {
        return $this->subtasks()->count();
    }

    public function getDueTimeAttribute()
    {
        return Carbon::now()->diffForHumans($this->due_date, true);
    }
    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'task_resource');
    }
    public function files()
{
    return $this->hasMany(File::class);
}
}

