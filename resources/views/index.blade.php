@extends('master')
@section('main')

 <div class="">
    <h2>Dashboard</h2>
    
</div>
<div class="">
  <div class="row top_tiles">
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
        <div class="icon"><i class="fa fa-users"></i></div>
        <div class="count">{{ $employeeCount }}</div>
        <h3>Employees</h3>
        <p>Total employees in the organization</p>
      </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
        <div class="icon"><i class="fa fa-bookmark "></i></div>
        <div class="count">{{ $departmentCount }}</div>
        <h3>Campus</h3>
        <p>Total campus in the organization</p>
      </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
        <div class="icon"><i class="fa fa-building-o "></i></div>
        <div class="count">{{ $campusCount }}</div>
        <h3>Department</h3>
        <p>Total department in the organization</p>
      </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
        <div class="icon"><i class="fa fa-check-square-o"></i></div>
        <div class="count">{{ $pendingLeave }}</div>
        <h3>Pending Leave</h3>
        <p>Leave applications pending for approval</p>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
           <h2>Leave applications summary <small>Yearly chart</small></h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <canvas id="myChart" width="inherit" height="100"></canvas>
    
            </div>
      </div>
    </div>
  </div>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
<script type="text/javascript">
  var applications = JSON.parse('{{ json_encode($applications) }}');
  var approved = JSON.parse('{{ json_encode($approved) }}');
  var disapprove = JSON.parse('{{ json_encode($disapprove) }}');

  console.log(applications);

  var ctx = document.getElementById("myChart");
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["January", "February", "March", "April", "May", "June","July",'August','September','October','November','December'],
        datasets: [{
            label: ['No. of leave applications'],
            data: applications,

            backgroundColor: [ 
            ],
            borderColor: [ 
              '#eee'
            ],
            borderWidth: 1
        },{
            label: ['No. of approved leave applications'],
            data: approved,

            backgroundColor: [
                '#75BCDD',
                '#75BCDD',
                '#75BCDD', 
                '#75BCDD',
                '#75BCDD',
                '#75BCDD',
                '#75BCDD',
                '#75BCDD',
                '#75BCDD',
                '#75BCDD',
                '#75BCDD',
                '#75BCDD',
            ],
            borderColor: [
                '#75BCDD',
                '#75BCDD',
                '#75BCDD', 
                '#75BCDD',
                '#75BCDD',
                '#75BCDD',
                '#75BCDD',
                '#75BCDD',
                '#75BCDD',
                '#75BCDD',
                '#75BCDD',
                '#3498DB',
            ],
            borderWidth: 1
        },
        {
            label: ['No. of rejected leave applications'],
            data: disapprove,

            backgroundColor: [
                '#4578a0',
                '#4578a0',
                '#4578a0', 
                '#4578a0',
                '#4578a0',
                '#4578a0',
                '#4578a0',
                '#4578a0',
                '#4578a0',
                '#4578a0',
                '#4578a0',
                '#4578a0',
            ],
            borderColor: [
                '#4578a0',
                '#4578a0',
                '#4578a0', 
                '#4578a0',
                '#4578a0',
                '#4578a0',
                '#4578a0',
                '#4578a0',
                '#4578a0',
                '#4578a0',
                '#4578a0',
                '#4578a0',
            ],
            borderWidth: 1
        }

        ],

    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true,
                    stepSize: 1
                }
            }]
        }
    }
});
</script>

@endsection