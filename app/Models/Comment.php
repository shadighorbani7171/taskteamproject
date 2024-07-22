<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'task_id',
        'user_id',
        'content',
      
    ];
  
   

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function task(){
        return $this->belongsTo(Task::class);
    }
    public function files()
    {
        return $this->hasMany(File::class);
    }
}
