	<script src="{{ asset('js/jquery.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/moment.min.js') }}"></script>
 	<script src="{{ asset('DataTables/js/jquery.dataTables.min.js') }}"></script>
 	<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
	<script src="{{ asset('js/bootstrap-datetimepicker.js') }}"></script>
 	<script src="{{ asset('js/chosen.jquery.min.js') }}"></script>
	<script src="{{ asset('js/daterangepicker.js') }}"></script>
	<script src="{{ asset('js/parsely.min.js') }}"></script>
	<script src="{{ asset('js/jquery-loading.min.js') }}"></script>
	<script src="{{ asset('Vendor/js/jquery.mask.min.js') }}"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script> 
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
	@if (\Request::route()->uri() == "calendar")
		<script src="{{ asset('js/calendar.js') }}"></script>
	@endif
 
	@if (\Request::route()->uri() == "department")
		<script src="{{ asset('Vendor/js/Sortable.min.js') }}"></script>
		<script src="{{ asset('js/departmentHeads.js') }}"></script>
	@endif
	<script src="{{ asset('js/custom.min.js') }}"></script>

	<script src="{{ asset('js/index.js') }}"></script>