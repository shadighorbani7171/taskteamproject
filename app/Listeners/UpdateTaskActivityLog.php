<?php

namespace App\Listeners;

use App\Events\TaskUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateTaskActivityLog
{
    public function handle(TaskUpdated $event)
    {
        $task = $event->task;

        
        ActivityLog::create([
            'task_id' => $task->id,
            'user_id' => $task->user_id,
            'description' => 'Task updated: ' . $task->name,
        ]);
    }
}

