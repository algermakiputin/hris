$(document).ready(function(){

	var list = document.getElementById("department-heads-list");
	Sortable.create(list, {
		animation : 200,
		onUpdate : function() {
			var order = [];
			var list = $("#department-heads-list li");

			list.each(function() {
				order.push([$(this).data('id'), $(this).data('campus')]);
			})
 
			$.ajax({
				type : 'POST',
				url : 'departmentHeads/order',
				data : {
					_token : token,
					order : order
				}, 
				success : function (data) {

				}
			});
		}
	})

	$("#department-head").click(function() {

		var department_id = $("#department_id").val();
		var campus_id = $("#campus_id").val();
		var current = [];
		var list = $("#department-heads-list li");
		var text = $("#department-heads-list li:first").text(); 
		
		list.each(function() {
			current.push([$(this).data('id'), $(this).data('campus')]);
		})
	 	

		$("#select-employee").empty();
 
		$.ajax({
			type : 'POST',
			url : '/departmentHeads/getEmployees',
			data : {
				_token : token,
				department_id : department_id,
				campus_id : campus_id,
				current : current
			}, 
			success : function(data) {
				$("#select-employee").selectpicker('destroy');
				var employees = JSON.parse(data);
				$("#select-employee").empty();
				var i = Object.keys(employees).length;
			  
				if (i) {
					$("#select-employee").append('<option value="">Select Employee</option>');
					$.each(employees, function(key, value) {
						$("#select-employee").append("<option value='"+ value.employee_id +"' data-campus='"+ value.campus_id +"'>"+ ucfirst(value.first_name)  + ' ' + ucfirst(value.last_name) +"</option>");
					})
				}else {
					$("#select-employee").append('<option value="">No employee found</option>');
				}

				$("#select-employee").selectpicker({
					size : 5,
					liveSearch : true
				});
	 
			}

		});
	 
			 
		 
	});


	//Insert Selected Department Head
	$("#save-department-head").click(function() {

		var employee_id = $("#select-employee").val();
		var department_id = $("#department_id").val();
		var campus_id = $("#select-employee option:selected").data('campus');
		var headOrder = 1;
		var firstList = $("#department-heads-list li:first").text();
		var employee_name = $("#select-employee option:selected").text(); 
		if (firstList !== 'Empty') {
			headOrder = $("#department-heads-list li").length + 1;
		}
	 
		if (employee_id) {

			$.ajax({
				type : 'POST',
				url : 'departmentHeads/insert',
				data : {
					_token : token,
					employee_id : employee_id,
					department_id : department_id,
					order : headOrder,
					campus_id : campus_id
				},
				success : function() {
					if (firstList === "Empty")
						$("#department-heads-list").empty();
					
					$("#add-department-heads").modal('toggle');
					$("#department-heads-list").append('<li class="list-group-item" data-id="'+employee_id+'" data-campus="'+ campus_id +'">'+
						' '+ employee_name +'<span class="pull-right btn-link text-danger remove" data-id="'+ employee_id +'" data-campus="'+ campus_id +'">Remove</span></li>');
				}

			});
		}
	})

	//View Department Heads
	$("#department_table").on('click', '.heads', function() {
		var campus = $(this).parents('tr').find('td').eq(0).text();
		var department = $(this).parents('tr').find('td').eq(1).text();
		var campus_id = $(this).data('campus');
		var department_id = $(this).data('id');

		$("#department_id").val(department_id);
		$("#campus_id").val(campus_id);
		$("#header").text(department + ' Department Heads - ' + campus + ' Campus');
		
		$.ajax({
			type : 'GET',
			url : 'departmentHeads/get',
			data : {
				department_id : department_id,
				campus_id : campus_id
			},
			beforeSend : function() {
				$("#modal-heads .modal-content").loading({
					circles : true,
					base : 0.3,
					overlay : true
				});
			},
			success : function(data) {

				var department_heads = JSON.parse(data);
				var count = Object.keys(department_heads).length;

				$("#department-heads-list").empty();
			 
				if (count) {
					$.each(department_heads, function(key, value) {
						$("#department-heads-list").append('<li class="list-group-item" data-head="'+value.id+'" data-id="'+value.employee_id+'" data-campus="'+value.campus_id+'">'
													+value.first_name+' '+ value.last_name+' - <span>'+ value.role +'</span>'+
													' <span class="pull-right btn-link text-danger remove" data-id="'+ value.employee_id  +'" data-campus="'+ value.campus_id  +'" data-department="'+ value.department_id  +'">Remove</span></li>');
					});
				}else {
					$("#department-heads-list").append('<li class="list-group-item">Empty</li>');
				}

				
				$("#modal-heads .modal-content").loading({
					destroy : true
				});
			}
		});
	})


	//delete 
	$("#department-heads-list").on('click','.remove',function() {
		var li = $(this).parents('li');
		var employee_id = $(this).data('id');
		var campus_id = $(this).data('campus');
		var department_id = $(this).data('department');
	 
		$.ajax({
			type : 'POST',
			url : 'departmentHeads/destroy',
			data :  {
				_token : token,
				employee_id : employee_id,
				campus_id : campus_id,
				department_id : department_id
			},
			success : function (data) {
				li.remove();
			}
		})
	})
})