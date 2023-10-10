@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="text-black-50">Currency rates!</h1>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <canvas id="myChart" width="400" height="200"></canvas>

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',  // или любой другой тип графика, например, 'bar', 'pie' и т. д.
            data: {
                labels: ['1', '2', '3', '4'],
                datasets: [{
                    label: '# rate',
                    data: @json($rates),  // Здесь данные для графика
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
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
    </script>

@endsection
