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
                padding:0;
                margin:0;
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
                    <li class="breadcrumb-item active" aria-current="page">Employee Report</li>
                </ol>
            </nav>
        </div> 
    </div>
    
    <div class="row"> 
        <div class="col-md-12 col-xs-12">
            <div class="x_panel"> 
                <div class="row">
                    <div class="col-2"><button id="printMe"><i class="fa fa-print"></i> Print</button></div>
                    <div class="col-2" class="form-control" id="report-select"><select>
                        <option value="Recruitment">Employee Hired by Year</option>
                        <option value="Sex">Sex</option>
                        <option value="Years of Service">Years of Service</option>
                        <option value="Employment Status">Employment Status</option>
                        <option value="Academic Rank">Academic Rank</option>
                    </select></div>
                </div>
                <div id="section-to-print" style="width:65%;margin:auto">
                    <h1 class="text-center" id="chart-label" style="text-align:center;">Recruitment Reports</h1>
                    <div id="canvas-area" ></div> 
                </div>
            </div>
        </div>
        <div class="clearfix"></div> 
    </div> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
    <script> 
       

        $(document).ready(function() {
            var chart;
            var index = 0;
            var labels = JSON.parse('<?php echo json_encode(array_keys($data)); ?>');
            var data = JSON.parse('<?php echo json_encode(array_values($data)); ?>');
        
            var sexReportsLabel = JSON.parse('<?php echo json_encode(array_keys($sexReports ? $sexReports : [])); ?>');
            var sexReportsData = JSON.parse('<?php echo json_encode(array_values($sexReports ? $sexReports : [])); ?>');
            var ageReportsLabel = JSON.parse('<?php echo json_encode(array_keys($ageReports ? $ageReports : [])); ?>');
            var ageReportsData = JSON.parse('<?php echo json_encode(array_values($ageReports ? $ageReports : [])); ?>');
            var employmentStatusReportsLabel = JSON.parse('<?php echo json_encode(array_Keys($employmentStatusReports ? $employmentStatusReports : [])) ?>');
            var employmentStatusReportsData = JSON.parse('<?php echo json_encode(array_values($employmentStatusReports ? $employmentStatusReports : [])) ?>');
            var academicRankLabel = JSON.parse('<?php echo json_encode(array_keys($academicRankReports ? $academicRankReports : [])) ?>');
            var academicRankData = JSON.parse('<?php echo json_encode(array_values($academicRankReports ? $academicRankReports : [])) ?>');
            console.log(academicRankData);
            // console.log(academicRankLabel);
            $("#report-select").change(function(event) {
                chart?.destroy();
                var value = event.target.value;
                if (value === "Recruitment") {  
                    chart = createChart(document.getElementById("myChart"), labels,data);
                } else if (value === "Sex") {   
                    chart = createChart(document.getElementById("sex"), sexReportsLabel,sexReportsData); 
                } else if (value === "Years of Service") { 
                    chart = createChart(document.getElementById("sex"), ageReportsLabel,ageReportsData);
                } else if (value === "Employment Status") {
                    chart = createChart(document.getElementById("sex"), employmentStatusReportsLabel,employmentStatusReportsData);
                } else if (value === "Academic Rank") { 
                    chart = createChart(document.getElementById("sex"), academicRankLabel, academicRankData);
                }
                $("#chart-label").text(value);
            });
            chart = createChart(document.getElementById("myChart"), labels,data);
            function hideAllCanvas() {
                $("#myChart").hide();
                $("#sex").hide();
                $("#tenure").hide();
                $("#employment").hide();
                $("#academicRank").hide(); 
            }

            var button = document.getElementById("printMe");
            button.onclick = function() {
                window.print()
            }

            function removeData(chart) {
                chart.data.labels.pop();
                chart.data.datasets.forEach((dataset) => {
                    dataset.data.pop();
                });
                chart.update();
            }
            

            function addData(chart, label, newData) {
                chart.data.labels.push(label);
                chart.data.datasets.forEach((dataset) => {
                    dataset.data.push(newData);
                });
                chart.update();
            } 

            function createChart(ctx, labels, data) {
                console.log(index);
                chart?.destroy();
                $("#canvas-area").empty();
                $("#canvas-area").append('<canvas id="canvas'+index+'" width="inherit" height="100" ></canvas>');
                var canvas = $("#canvas" + index);
                const backgrounds = ["#03fc41", "#0335fc", "#f4fc03", "#fc8403", "#fc8403", "#f003fc", "#2874A6", "#4d5963", "#578f9c","#D35400", "#F4D03F"]
                new Chart(canvas, {
                    type: 'pie',
                    data: {
                    labels: labels,
                    datasets: [{ 
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
                index++;
            }
        }); 
        
    </script>
@endsection