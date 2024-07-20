<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'team_id', 'project_id', 'due_date', 'status'];
    protected $dates = ['due_date'];

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
}

