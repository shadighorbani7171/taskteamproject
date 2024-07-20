<!-- resources/views/admindashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Dashboard Statistics</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <a href="{{ route('users.index') }}" class="bg-blue-100 p-6 rounded-lg shadow-md hover:bg-blue-200 transition duration-300">
                            <h4 class="text-xl font-bold text-blue-800">Users</h4>
                            <p class="text-3xl">{{ $userCount }}</p>
                        </a>
                        <a href="{{ route('projects.index') }}" class="bg-green-100 p-6 rounded-lg shadow-md hover:bg-green-200 transition duration-300">
                            <h4 class="text-xl font-bold text-green-800">Projects</h4>
                            <p class="text-3xl">{{ $projectCount }}</p>
                        </a>
                        <a href="{{ route('tasks.index') }}" class="bg-yellow-100 p-6 rounded-lg shadow-md hover:bg-yellow-200 transition duration-300">
                            <h4 class="text-xl font-bold text-yellow-800">Tasks</h4>
                            <p class="text-3xl">{{ $taskCount }}</p>
                        </a>
                        <a href="{{ route('teams.index') }}" class="bg-red-100 p-6 rounded-lg shadow-md hover:bg-red-200 transition duration-300">
                            <h4 class="text-xl font-bold text-red-800">Teams</h4>
                            <p class="text-3xl">{{ $teamCount }}</p>
                        </a>
                    </div>
                </div>
            </div>

           
</x-app-layout>
