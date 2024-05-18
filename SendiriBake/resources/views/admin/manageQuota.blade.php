@extends('admin.layout')

@section('content')
            <h1 style="font-size: 35px; font-weight:bold;">Order Quota</h1>
            <div>
                <canvas id="quotaChart" width="400" height="400"></canvas>
            </div>
            <div class="edit-button-container">
                <a href="{{ route('edit.quota') }}" class="edit-button">Edit Quota</a>
            </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('quotaChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [
                    {
                        label: ['Available Quota', 'Filled Quota', 'Custom Quota'],
                        data: {!! json_encode([$availableQuotas, $filledQuotas, $customQuotas]) !!},
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(75, 192, 192, 0.7)'
                        ],
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
@endsection
