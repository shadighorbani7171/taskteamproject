<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'total_quantity', 'available_quantity'];

    public function allocations()
    {
        return $this->hasMany(Allocation::class);
    }
    

}
