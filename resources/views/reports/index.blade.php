<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports and Analytics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Project Progress</h3>
                    <canvas id="projectProgressChart"></canvas>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Team Performance</h3>
                    <canvas id="teamPerformanceChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var projectProgressCtx = document.getElementById('projectProgressChart').getContext('2d');
            var projectProgressChart = new Chart(projectProgressCtx, {
                type: 'bar',
                data: {
                    labels: @json($projectProgress->pluck('name')),
                    datasets: [{
                        label: 'Project Progress (%)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        data: @json($projectProgress->pluck('progress')),
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });

            var teamPerformanceCtx = document.getElementById('teamPerformanceChart').getContext('2d');
            var teamPerformanceChart = new Chart(teamPerformanceCtx, {
                type: 'bar',
                data: {
                    labels: @json($teamPerformance->pluck('name')),
                    datasets: [{
                        label: 'Team Performance (%)',
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1,
                        data: @json($teamPerformance->pluck('performance')),
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });
        });
    </script>
@endsection
