<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="{{ url('/') }}" class="site_title"><img src="{{ url('images/logo.png') }}" style="height: 45px;" ><span>HR System</span></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
      <div class="profile_pic">
          @if (Auth()->user()->avatar)
          <img src="{{ url('storage/avatar' . '/' . Auth()->user()->avatar)}}" alt="..." class="img-circle profile_img">
          @else
          <img src="{{ url('images/default.png')}}" alt="..." class="img-circle profile_img">
            @endif
      </div>
      <div class="profile_info">
        <span>{{ config('config.access')[Auth()->user()->role] }}</span>
        <h2>{{ Auth::check() ? Auth::user()->name : ''}}</h2>
      </div>
    </div>
    <!-- /menu profile quick info -->

    <br />
  
    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
          
          <li>
            <a href="{{ url('/') }}"><i class="fa fa-home"></i> Dashboard  </a>

          </li>
          @if ((int)Auth()->user()->role == 3 || (int)Auth()->user()->role == 2)
          <li><a><i class="fa fa-user-md"></i> Employee/Faculty <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ url('employee') }}">View All</a></li>
              @if (Auth()->user()->role)
              <li><a href="{{ url('employee/new') }}">New Employee/Faculty</a></li> 
              @endif
            </ul>
          </li>
          @endif

          <!--@if ((int)Auth()->user()->role == 3 || (int)Auth()->user()->role == 2)
          <li><a><i class="fa fa-clock-o"></i> Attendance <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu"> 
              <li><a href="{{ url('attendance/import') }}">Import</a></li>
              <li><a href="{{ url('attendance/entry') }}">Manual Entry</a></li>
            </ul>
          </li>
          @endif-->
         
          @if((int)Auth()->user()->employmentType() == 1 || (int)Auth()->user()->role !== 0 )
            <li><a><i class="fa fa-bed"></i> Leaves <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                @if ((int)Auth()->user()->role == 3 || (int)Auth()->user()->role == 2 || count(checkDepartmentHead()))
                <li>
                  <a href="{{ url('leaves') }}">View Leaves</a>
                </li>
                <li>
                  <a href="{{ url('leaves/calendar') }}">Leave Calendar</a>
                </li>
                @endif
                @if ((int)Auth()->user()->role !== 3)
                <li>
                  <a href="{{ url('my-leaves') }}">My Leaves</a>
                </li>
                <li>
                  <a href="{{ url('leave/application') }}">Apply Leave</a>
                </li>
                @endif
             
              </ul>
            </li>
          @endif
          @if(Auth()->user()->employee_id)
            <li><a><i class="fa fa-calendar"></i> Appointments <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu"> 
                <li>
                  <a href="{{ url('appointments') }}">View Appointments</a>
                </li>
                <li>
                  <a href="{{ url('appointments/new') }}">New Appointment</a>
                </li> 
              </ul>
            </li>
          @endif
          @if(Auth()->user()->employee_id)
            <li><a><i class="fa fa-file"></i> Request <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu"> 
                <li>
                  <a href="{{ url('request') }}">View Request</a>
                </li>
                <li>
                  <a href="{{ url('request/new') }}">New Request</a>
                </li> 
              </ul>
            </li>
          @endif
          @if(!Auth()->user()->employee_id)
            <li><a><i class="fa fa-calendar"></i> Appointments <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu"> 
                <li>
                  <a href="{{ url('admin/appointments') }}">Appointments</a>
                </li> 
              </ul>
            </li>
          @endif
          @if ((int)Auth()->user()->role == 3 || (int)Auth()->user()->role == 2)
            <li><a><i class="fa fa-cog"></i> Leaves Settings <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <li>
                  <a href="{{ url('leave-types') }}">View Leave Types</a>
                </li>
                <li>
                  <a href="{{ url('leave-types/add') }}">Add leave Type</a>
                </li>    

              </ul>
            </li>
            
          @endif
          <li>
            <a href="{{ url('calendar') }}"><i class="fa fa-calendar"></i>School Calendar  </a>

          </li>
          
          @if ((int)Auth()->user()->role == 3 || (int)Auth()->user()->role == 2)
          <li><a><i class="fa fa-line-chart"></i> Reports <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ url('reports/employees') }}">Employees/Faculties</a></li>
              <!--<li><a href="{{ url('reports/attendance') }}">Attendance</a></li>-->
              <li><a href="{{ url('reports/leaves') }}">Leaves</a></li>
             <!-- <li><a href="{{ url('reports/general') }}">General Reports</a></li> -->
            </ul>
          </li>
          
          <li><a><i class="fa fa-bookmark"></i> Campus <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ url('campus') }}">View Campus</a></li>
              @if ((int)Auth()->user()->role == 3 || (int)Auth()->user()->role == 2)
              <li><a href="{{ url('campus/new') }}">New Campus</a></li>
              @endif
            </ul>
          </li>
          <li><a><i class="fa fa-building-o"></i> School/Office <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ url('department') }}">View All</a></li>
              @if ((int)Auth()->user()->role == 3 || (int)Auth()->user()->role == 2)
              <li><a href="{{ url('department/new') }}">Add School/Office</a></li>
              <li><a href="{{ url('roles') }}">View Job Titles</a></li>
              <li><a href="{{ url('roles/new') }}">New Job Titles</a></li>
              @endif
              
            </ul>
          </li>
          @endif
      
          @if ((int)Auth()->user()->role == 3 || (int)Auth()->user()->role == 2)
          <li><a><i class="fa fa-user"></i> User <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ url('users') }}">View Users</a></li>
              <li><a href="{{ url('users/new') }}">Add Admin</a></li>
            </ul>
          </li>
          @endif

        </ul>
      </div>
      </div>
      <!-- /sidebar menu -->

    </div>
  </div>