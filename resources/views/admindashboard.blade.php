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
                        <a href="{{ route('resources.index') }}" class="bg-purple-100 p-6 rounded-lg shadow-md hover:bg-purple-200 transition duration-300">
                            <h4 class="text-xl font-bold text-purple-800">Resources</h4>
                            <p class="text-3xl">{{ $resourceCount }}</p>
                        </a>
                    </div>
                </div>
            </div>
            
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Tasks by Project</h3>
                    <canvas id="myChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                    datasets: [{
                        label: 'My First dataset',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
