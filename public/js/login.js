$(document).ready(function() {

	$("#setPassword").parsley();
	$("#activate").parsley();
	$("#login").parsley();

	$("input").keyup(function() {
		$('input').parents('.form-group').find('.invalid-feedback').remove()
	})
})