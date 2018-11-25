var role = $("meta[name=role]").attr('content');

$(document).ready(function() { 

	var eDate = '';
	var CalendarEvent = null;
	var eventId = null;
	
	var holidays = $("#holidays").fullCalendar({
		header : {
			left:   'prev,next ',
			center: 'title', 
			right : 'today'
		}, 
		selectable : true,  
		dayClick: function(date, jsEvent, view,event) {
		 
			if (role !== "0") {
				eDate = date.format(); 
				$("#holidays-modal").modal('toggle');
			}
			
		},
		eventClick : function(event){ 
			 
			CalendarEvent = event;
			eventId = event.id;
			$("#edit-field").prop('disabled',true);
			
			$("#holidays-view").modal('toggle'); 

			$("#holidays-view #type").val(event.type);
			$("#holidays-view #title").val(event.title);
			$("#holidays-view #descr").val(event.description);
			$("#e_id").val(event.id);

			$("#edit").click(function() {

				$("#edit-field").prop('disabled',false);
				$("#update").prop('disabled',false);

			});
		},
		eventRender: function(event, element) {

	        element.attr('title', event.type + ': ' + event.title);
	    },
	    viewRender : function() {
	    	  	var d = $("#holidays").fullCalendar('getDate');
	     	var date = d.format('MM');
	     	var longD = d.format('MMMM'); 
	     	var year = d.format('YYYY'); 
	    	  	$("#holiday-list").empty();
	    	  	$("#event-list").empty();
	    	  	$("#e-month").text(longD);
	    	  	$("#h-month").text(longD);
	    	  	$.ajax({
		    	  	type : 'GET',
		    	  	url : 'calendar/events',
		    	  	data : {
		    	  		month : date,
		    	  		year : year
		    	  	},
		    	  	beforeSend : function() {
		    	  		$("#holidays").loading({
		    	  			circles : 1,
		    	  			base : 0.1, 
		    	  		});
		    	  		$("#event-wrap").loading({
		    	  			circles : 1,
		    	  			base : 0.3, 
		    	  		});
		    	  		$("#holiday-wrap").loading({
		    	  			circles : 1,
		    	  			base : 0.3, 
		    	  		});
		    	  	},
		    	  	success: function(data) {
		    	  		 
		    	  		$("#holidays").loading({
		    	  			destroy: true
		    	  		});
		    	  		$("#event-wrap").loading({
		    	  			destroy: true
		    	  		});
		    	  		$("#holiday-wrap").loading({
		    	  			destroy: true
		    	  		});
		    	  		var data = JSON.parse(data);
		    	  		holidays.fullCalendar( 'removeEvents');
		    	  		holidays.fullCalendar( 'addEventSource', data.calendar);
		    	  		if (!$.isEmptyObject(data.holiday)) {
		    	  			
		    	  			$.each(data.holiday, function(key,value) {
		    	  				var d = year + (value.start.slice(4,value.start.length));
			    	  			$("#holiday-list").append('<li>'+ value.title +'<br> <span class="small">'+ d +'</span></li>');
			    	  		})
		    	  		}else {
		    	  			$("#holiday-list").append('<li>No holidays</li>');
		    	  		}
		    	  		if (!$.isEmptyObject(data.event)) {
		    	  			$.each(data.event, function(key,value) {
		    	  				var d = year + (value.start.slice(4,value.start.length));
			    	  			$("#event-list").append('<li>'+ value.title +'<br> <span class="small">'+ d +'</span></li>');
			    	  		})
		    	  		}else {
		    	  			$("#event-list").append('<li>No events</li>');
		    	  		}
		    	  		
		    	  	}
		    	  });
	    }
	});

	$("#delete").click(function() { 
		$.confirm({
		    title: 'Delete event?',
		    content: 'This dialog will automatically trigger \'cancel\' in 6 seconds if you don\'t respond.',
		    autoClose: 'cancelAction|8000',
		    buttons: {
		        delete: {
		            text: 'delete', 
		            action: function () {
		            	$.ajax({
		            		type : 'POST',
		            		url : '/calendar/destroy',
		            		data : {
		            			_token : token,
		            			id : eventId
		            		},
		            		beforeSend : function() {
		            			$("#updateCalendar").loading({
								circles : 1,
								overlay :true,
								base : 0.1,
							});
		            		},
		            		success : function() {
		            			$("#updateCalendar").loading({
								destroy : true
							});
							$("#holidays-view").modal('toggle');  
		               		$.alert('Deleted the event!');
		               		holidays.fullCalendar('removeEvents', CalendarEvent.id);
		            		}
		            	});

		            },
		            btnClass : 'btn btn-danger'
		        },
		        cancelAction: function () {
		            $.alert('action is canceled');
		        }
		    }
		});
		
	})

	$("#updateCalendar").submit(function(e) {
		console.log(CalendarEvent);
		e.preventDefault();
		var id = $("#e_id").val();
		var type = $("#holidays-view #type").val();
		var title = $("#holidays-view #title").val();
		var desc = $("#holidays-view #descr").val();
		$.ajax({
			type :'POST',
			url :'/calendar/update',
			data : {
				_token : token,
				id :  id,
				type : type,
				title : title,
				description : desc
			},
			beforeSend : function() {
				$("#updateCalendar").loading({
					circles : 1,
					overlay :true,
					base : 0.1,
				});
			},
			success : function() { 
				$.alert('Changes saved!');
				var bg = "";

				if (type == 'event')
					bg = "#26B99A";
				else 
					bg = "#3a87ad";
			 
				CalendarEvent.type = type;
				CalendarEvent.title = title;
				CalendarEvent.description = desc;
				CalendarEvent.id = id;
				CalendarEvent.color = bg;

				holidays.fullCalendar('updateEvent',CalendarEvent);
				$("#holidays-view").modal('toggle');  
				$("#updateCalendar").loading({
					destroy :true
				});
			}
		})
	})

	$("#calendarForm").submit(function(e) {
		e.preventDefault();
		
		$.ajax({
			type : 'POST',
			url : '/calendar/store',
			data : {
				_token : token,
				title : $("#title").val(),
				description : $("#descr").val(),
				type : $("#type").val(),
				date : eDate
			},
			beforeSend : function() {
				$("#calendarForm").loading({
					circles : 1,
					overlay :true,
					base : 0.1,
				});
			},
			success : function() {
				var type = $("#type").val();
				var bg = "";
				$.alert('New ' + type + ' added successfully');
				
				if (type == 'event')
					bg = "#26B99A";
				else 
					bg = "#3a87ad";
				
				var event = {
					'title' : $("#title").val(),
					'description' : $("#descr").val(),
					'type' : type,
					'start'  : eDate,
					'color' : bg
				}; 

				holidays.fullCalendar('renderEvent', event);
				$("#calendarForm")[0].reset();
				$("#holidays-modal").modal('toggle');

				$("#calendarForm").loading({
					destroy : true
				});

				
			}
		});
	})

})