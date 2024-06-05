@extends('admin.layout')

@section('content')
    <section> 
        <h1 style="font-size: 35px; font-weight:bold;">Completed Sales</h1>

        <canvas id="salesChart" width="400" height="200"></canvas>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Extract dates and sales data from PHP variable passed from controller
            var dates = {!! json_encode($dates) !!};
            var sales = {!! json_encode($sales) !!};

            var ctx = document.getElementById('salesChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: 'Completed Sales',
                        data: sales,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
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
