<div class="top_nav">
   <div class="nav_menu">
      <nav>
         <div class="nav toggle">
          <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        
         <ul class="nav navbar-nav navbar-right">
            <li class="">
               <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
               <img src="{{ url('storage/avatar') . '/' . Auth()->user()->avatar }}" alt="">{{ Auth::check() ? Auth::user()->email : ''}}
               <span class=" fa fa-angle-down"></span>
               </a>
               <ul class="dropdown-menu dropdown-usermenu pull-right">
                  @if (Auth()->user()->role != 3)
                  <li>
                     <a type="submit" class="btn-link" onclick="document.getElementById('myprofile').submit()">
                     </i>My Profile 
                     </a>
                     <form style="display: none;" id="myprofile" method="get" action="{{ url('employee/profile') }}">
                        <input type="hidden" name="id" value="{{ Auth()->user()->employee_id }}">
                     </form>
                  </li>
                  @else 
                  <li>
                     <a type="submit" class="btn-link" onclick="document.getElementById('myprofile').submit()">
                     </i>My Profile 
                     </a>
                     <form style="display: none;" id="myprofile" method="get" action="{{ url('admin/profile') }}">
                        <input type="hidden" name="id" value="{{ Auth()->user()->id }}">
                     </form>
                  </li>
                  @endif
                  <li>
                     <a class="" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                     <i class="fa fa-sign-out pull-right"></i>
                     {{ __('Logout') }} 
                     </a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                     </form>
                  </li>
               </ul>
            </li>
            
         </ul>
      </nav>
   </div>
</div>