@extends('master')

@section('main')

    <div class="page-title">
        <div class="title_left">
            <h3>Recruitment</h3>
        </div>

        <div class="title_right">
            <nav aria-label="breadcrumb" class="nav navbar-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Recruitment Report</li>
                </ol>
            </nav>
        </div> 
    </div>

    <div class="row"> 
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <canvas id="myChart" width="inherit" height="100"></canvas>
            </div>
        </div>
        <div class="clearfix"></div> 
    </div> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
    <script>
        var labels = JSON.parse('<?php echo json_encode(array_keys($data)); ?>');
        var data = JSON.parse('<?php echo json_encode(array_values($data)); ?>');
      
        var ctx = document.getElementById("myChart");
        new Chart(ctx, {
            type: 'pie',
            data: {
            labels: labels,
            datasets: [{
                label: '# of Votes',
                data: data,
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