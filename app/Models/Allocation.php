<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
    use HasFactory;


    protected $fillable = ['resource_id', 'project_id', 'task_id', 'quantity'];

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    protected static function booted()
    {
        static::created(function ($allocation) {
            $resource = $allocation->resource;
            $resource->decrement('available_quantity', $allocation->quantity);
        });

        static::updated(function ($allocation) {
            if ($allocation->isDirty('quantity')) {
                $resource = $allocation->resource;
                $difference = $allocation->getOriginal('quantity') - $allocation->quantity;
                $resource->increment('available_quantity', $difference);
            }
        });

        static::deleted(function ($allocation) {
            $resource = $allocation->resource;
            $resource->increment('available_quantity', $allocation->quantity);
        });
    }
}


