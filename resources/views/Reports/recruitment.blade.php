@extends('master')

@section('main')
    <style>
        @media print {
            body {
                visibility: hidden;
            }
            #section-to-print {
                visibility: visible;
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
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
                <div class="row">
                    <div class="col-2"><button id="printMe"><i class="fa fa-print"></i> Print</button></div>
                    <div class="col-2"><select>
                        <option>Recruitment</option>
                        <option>Sex</option>
                        <option>Years of Service</option>
                        <option>Employment Status</option>
                        <option>Academic Rank</option>
                    </select></div>
                </div>
                <div style="padding:50px 0;" id="section-to-print">
                    <h1 class="text-center">Recruitment Reports</h1>
                    <canvas id="myChart" width="inherit" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="clearfix"></div> 
    </div> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
    <script>
        var labels = JSON.parse('<?php echo json_encode(array_keys($data)); ?>');
        var data = JSON.parse('<?php echo json_encode(array_values($data)); ?>');
        var button = document.getElementById("printMe");
        button.onclick = function() {
            window.print()
        }
        const backgrounds = ["#03fc41", "#0335fc", "#f4fc03", "#fc8403", "#fc8403", "#f003fc", "#f003fc", "#4d5963", "#578f9c"]
        var ctx = document.getElementById("myChart");
        
        var chart = new Chart(ctx, {
            type: 'pie',
            data: {
            labels: labels,
            datasets: [{
                label: '# of Votes',
                data: data,
                borderWidth: 1,
                backgroundColor: backgrounds
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