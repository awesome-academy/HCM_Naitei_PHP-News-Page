@extends('admin.master_layout')

@section('pageTitle', 'Dashboard')
@section('content')
<link rel="stylesheet" href="\resouce\meranda-master\css\chart.css">
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"> 🔹{{ __('messages.dashboard') }} </h1>
    </div>

    <!-- Content -->
    <a href="{{ route('home.index') }}" class="btn btn-light btn-icon-split">
        <span class="icon text-gray-600">
            <i class="fas fa-arrow-right"></i>
        </span>
        <span class="text">{{ __('messages.goToHome') }}</span>
    </a>

    <div class="chart">
        <canvas id="barChart"></canvas>
    </div>
    <script>
    $(function() {
        var datas = <?php echo json_encode($datas); ?>;
        var days = <?php echo json_encode($days); ?>;
        var barCanvas = $("#barChart");
        var barChart = new Chart(barCanvas, {
            type: 'bar',
            data: {
                labels: days,
                datasets: [{
                    label: 'Count posts',
                    data: datas,
                    backgroundColor: Array(7).fill('LightPink')
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Last week\'s posts, 2022',
                    fontSize: 25
                },
                legend: {
                    position: 'right',
                },
                scales: {
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Count',
                        }
                    }],
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Days',
                        }
                    }]
                }
            }
        });

    })
    </script>
</div>
@endsection
