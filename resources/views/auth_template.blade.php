<!DOCTYPE html>
<html>
<head>
	 @include('template.header')
	 <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@yield('content')

	@include('template.footer')
</html>