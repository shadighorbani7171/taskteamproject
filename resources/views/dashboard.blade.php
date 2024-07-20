<!-- resources/views/dashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <div class="flex-1 text-right mr-4">
                <a href="{{ route('owner.dashboard') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 transition duration-300">
                    Owner team
                </a>
            </div>
       
    </x-slot>
   
    
    
    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Teams Button -->
                <a href="{{ route('teams.index') }}" class="bg-blue-500 text-white p-6 rounded-lg shadow-md hover:bg-blue-600 transition duration-300 flex items-center justify-center">
                    <span class="text-xl font-bold">Teams</span>
                </a>
                
                <!-- Tasks Button -->
                <a href="{{ route('tasks.index') }}" class="bg-yellow-500 text-white p-6 rounded-lg shadow-md hover:bg-yellow-600 transition duration-300 flex items-center justify-center">
                    <span class="text-xl font-bold">Tasks</span>
                </a>

                <!-- Projects Button -->
                <a href="{{ route('projects.index') }}" class="bg-green-500 text-white p-6 rounded-lg shadow-md hover:bg-green-600 transition duration-300 flex items-center justify-center">
                    <span class="text-xl font-bold">Projects</span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
