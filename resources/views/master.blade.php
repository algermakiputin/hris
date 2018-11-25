<!DOCTYPE html>
<html>
<head>
	 @include('template.header')
	 <meta name="csrf-token" content="{{ csrf_token() }}">
	 <meta name="role" content="{{Auth::user()->role}}">
	 <meta name="base-url" content="{{ url('') }}">
</head>
<body class="nav-md">
	<div class="container body">
		<div class="main-container">
			@include('template.sidebar')

			@include('template.topnavigation')
			
			<div class="right_col" role="main">
            		@yield('main')
          	</div>
          	
		</div>
	</div>
	<footer>
     <div class="pull-right">
       Human Resource Information System By <a href="https://algermakiputin.com">Alger Makiputin</a>
     </div>
     <div class="clearfix"></div>
   </footer>
</body>
 
	<script type="text/javascript">
		var deptHead = "{{ count(checkDepartmentHead())  }}"
	</script>
	@include('template.footer')
	@yield('js')
</html>

