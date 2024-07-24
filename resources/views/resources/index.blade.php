<!-- resources/views/resources/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white bg-blue-500 p-4 rounded-md shadow-md leading-tight text-center">
            {{ __('Resources and Allocations') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 p-6 min-h-screen flex flex-col items-center justify-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-full">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-300">
                <div class="p-6 bg-white border-b border-gray-300 text-center">
                    <h3 class="text-2xl font-medium text-gray-900 mb-6">{{ __('Resource List') }}</h3>
                    @if($resources->isEmpty())
                        <p class="text-lg text-gray-600">{{ __('No resources available.') }}</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($resources as $resource)
                                <div class="bg-white p-6 rounded-lg shadow border border-gray-300">
                                    <h2 class="text-xl font-bold mb-2">
                                        {{ $resource->name }}
                                    </h2>
                                    <p class="text-gray-600 mb-4">{{ $resource->description }}</p>
                                    <h4 class="text-lg font-semibold text-gray-700 mb-2">{{ __('Allocations') }}</h4>
                                    <ul class="list-disc pl-5 text-left">
                                        @foreach ($allocations->where('resource_id', $resource->id) as $allocation)
                                            <li>
                                                <strong>Project:</strong> {{ $allocation->project->name ?? 'N/A' }}<br>
                                                <strong>Task:</strong> {{ $allocation->task->name ?? 'N/A' }}<br>
                                                <strong>Allocated on:</strong> {{ $allocation->created_at->format('d M Y') }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
