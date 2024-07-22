<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\Resource;
use Illuminate\Http\Request;

class ResourceAllocationController extends Controller
{
    public function index()
    {
        $resources = Resource::all();
        $allocations = Allocation::with(['resource', 'project', 'task'])->get();
        return view('resources.index', compact('resources', 'allocations'));
    }
}
