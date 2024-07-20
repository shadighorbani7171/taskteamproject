<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'owner_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'team_user', 'team_id', 'user_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    

    public function invites()
    {
        return $this->hasMany(TeamInvite::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_team', 'team_id', 'project_id');
    }

}
