<!-- resources/views/ownerdashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Owner Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="{{ route('teams.index') }}" class="bg-white p-6 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
                    <h4 class="text-xl font-bold text-blue-600">Teams</h4>
                    <p class="text-3xl text-gray-700">{{ $teamCount }}</p>
                </a>
                <a href="{{ route('projects.index') }}" class="bg-white p-6 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
                    <h4 class="text-xl font-bold text-green-600">Projects</h4>
                    <p class="text-3xl text-gray-700">{{ $projectCount }}</p>
                </a>
                <a href="{{ route('tasks.index') }}" class="bg-white p-6 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
                    <h4 class="text-xl font-bold text-yellow-600">Tasks</h4>
                    <p class="text-3xl text-gray-700">{{ $taskCount }}</p>
                </a>
            </div>

           
</x-app-layout>
