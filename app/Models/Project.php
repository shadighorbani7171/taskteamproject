<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'start_date', 'end_date', 'status'
    ];
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'project_team', 'project_id', 'team_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'project_resource', 'project_id', 'resource_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id');
    }
    
}
