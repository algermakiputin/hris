'use-strict';
var maxDate = '12/31/' + (new Date).getFullYear();
var token = $("meta[name=csrf-token]").attr('content');
var role = $("meta[name=role]").attr('content');
var actions = role == 0 ? false : true;
var leaveActions = role == true ? false : true;
var startDate;
var endDate;
var employee_id;
var campus_id;
var base_url = $("meta[name='base-url']").attr('content');
if (deptHead == 1) {
    leaveActions = true;
}

function readURL(input) {

    if (input.files && input.files[0]) {
        $("#p-holder").text(input.files[0].name.substring(0, 25) + '...');
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#img').attr('src', e.target.result);
            $("#img-container .profile_img").attr('src', e.target.result);
            $("#img-container").show();
        }

        reader.readAsDataURL(input.files[0]);
    }
}

if (typeof balance != 'undefined') {
    var myLeaveBalance = (JSON.parse(balance.replace(/&quot;/g, '"')));
}

$(document).ready(function() {

    $("body").on('click','.notify', function(e) {
 
        $.ajax({
            type : 'GET',
            url : '/notification/viewed',
            data : {
                id : $(this).data('id')
            },
            success : function() {
              
            },
            error : function() {
                e.preventDefault();
            }
        });
    })
    $('input, select').change(function() {
        if ($(this).val())
            $(this).parents(".form-group").find('.parsley-errors-list').empty();
    })

    $("#campus-select").change(function() {

        var campus_id = $(this).val();
  
        $.ajax({
            type : 'POST',
            url : base_url + '/employee/getEmployeesByCampus',
            data : {
                _token : token,
                campus_id : campus_id
            },
            success : function(data) {
                var result = JSON.parse(data);
                $.each(result, function(key,value) {
                    
                    $("#employees").append("<option value='"+ value.employee_id +"'>"+value.first_name + ' ' + value.last_name +"</option>");
                })

                $("#employee-wrapper").show();
            }

        })
    })

    $("#report-type").change(function(){
     
        if ($(this).val() == "leave"){
            $("#daterange").hide();
            $("#to").removeAttr('required');
            $("#from").removeAttr('required');
            $("#sy-wrapper").show();
            $("#daterange").hide();
            $("#employment-type-wrap").hide();
        }else {
            $("#employment-type-wrap").show();
            $("#daterange").show();
            $("#sy-wrapper").hide();
            $("#to").attr('required','required');
            $("#from").attr('required','required');
        }
            
    })
    sy_options();

    $("#general-reports-form").parsley();
   
    $("#general-reports-form").submit(function(e) {
        var type = $("[name='report']").val();
        var campus = $("[name='campus']").val();
        var department = $("[name='department']").val();
        var designation = $("[name='designation']").val();
        var from = $('[name="from"]').val();
        var to = $('[name="to"]').val();
        var sy = $('[name="sy"]').val();
        var employmentType = $('[name="employment-type"]').val();
        $.ajax({
            type : 'POST',
            data : {
                _token : token,
                type : type,
                campus : campus,
                department : department,
                designation : designation,
                from : from,
                to : to,
                sy : sy,
                employmentType : employmentType
            },
            url : '/reports/all',
            beforeSend : function() {
                $("#run").button('loading');
            },
            success : function(data) {
                var result = JSON.parse(data);
                
                if (type == "attendance") {
                    $("#range").text(from + ' - ' + to);
                    var tbody = $("#general-attendance tbody");
                    tbody.empty();
                    if (parseInt(result.length) >= 1) {
                        $.each(result, function(key, value) {
                        
                            tbody.append('<tr>' +
                                    '<td>' + value.name + '</td>' +
                                    '<td>' + value.working + '</td>' +
                                    '<td>' + value.worked + '</td>' +
                                    '<td>' + value.total_hours + '</td>' +
                                    '<td>' + value.total_absent + '</td>' +
                                    '<td>' + value.total_late + '</td>' +
                                    '<td>' + value.total_overtime + '</td>' +
                                '</tr>');

                        });
                    }else {
                        tbody.append("<tr><td colspan='5' class='text-center'>No result found...</td></tr>");
                    }
                    $("#leaves").hide();
                    $("#attendance").show();

                }else if (type == "leave") {
                    var tbody = $("#general-leave tbody");
                    tbody.empty();
                
                    if (result.length) {
                        $.each(result, function(key,value) {
                            if (value[0]) {
                                if (value.length >= 2) {
                                    $.each(value, function(key, val) {
                                        if (key == 0) {
                                            tbody.append('<tr>' +
                                                        '<td rowspan="2" class="align-middle">' + val.employee + '</td>' +
                                                        '<td>' + val.name + '</td>' +
                                                        '<td>' + val.allowance + '</td>' +
                                                        '<td>' + val.used + '</td>' +
                                                        '<td>' + val.balance + '</td>' +
                                                    '</tr>'
                                            );
                                        }else {
                                            tbody.append('<tr>' + 
                                                        '<td>' + val.name + '</td>' +
                                                        '<td>' + val.allowance + '</td>' +
                                                        '<td>' + val.used + '</td>' +
                                                        '<td>' + val.balance + '</td>' +
                                                    '</tr>'
                                            );
                                        }
                                    });
                                }
                            }else {
                                tbody.append("<tr><td>"+value[1]+"</td><td colspan='4' class='text-center'>Leave not set.</td></tr>");
                            }
                            
                        });
                    }else {
                        tbody.append("<tr><td colspan='5' class='text-center'>No employee found.</td></tr>");
                    
                    }

                    $("#attendance").hide();
                    $("#leaves").show();
                }

                $("#run").button('reset');
            },
            error : function() {
                $("#run").button('reset');
            }
        });
        


       e.preventDefault();
    })

    $("#select_employment_type").change(function(){
        if ($(this).val() == 1) {
            $("#sched-wrap").show();
            $("#sched-wrap select").prop('required',true);
        }else {
            $("#sched-wrap").hide();
            $("#sched-wrap select").prop('required',false);
        }
    }) 

    $("#export-attendance").click(function(e) {
        var url = $(this).attr('href');
        var empID = $("#employee_id").val();
        var campusID = $("#employee_id").data('campusid');
        
        if (startDate && endDate && empID && campusID) {
            window.location = url + '?employee_id=' + empID +'&campus_id=' + campusID +'&start_date=' + startDate + '&end_date=' + endDate;
        }
        e.preventDefault();
    
    })

    var leave_calendar = $("#leave-calendar").fullCalendar({
        header: {
            left: 'prev,next ',
            center: 'title',
            right: 'today'
        },
        defaultView: 'listMonth',
        selectable: true,
        dayClick: function(date, jsEvent, view, event) {


        },
        eventClick: function(event) {
            var id = event.leave_id;
            var employee_id = event.employee_id;
            var campus_id = event.campus_id;
            summary(id, employee_id, campus_id, row = null);
            $("#summary").modal('toggle');
        },
        eventRender: function(event, element) {

        },
        viewRender: function() {

            var d = $("#leave-calendar").fullCalendar('getDate');
            var date = d.format('MM');
            var longD = d.format('MMMM');
            var year = d.format('YYYY');

            $.ajax({
                type: 'POST',
                url: '/leaves/getCalendar',
                data: {
                    _token: token,
                    month: date,
                    year: year
                },
                beforeSend: function() {

                },
                success: function(data) {
                    var data = JSON.parse(data);
                    leave_calendar.fullCalendar('removeEvents');
                    leave_calendar.fullCalendar('addEventSource', data);
                    if (Object.keys(data).length == 0) {
                        $(".fc-list-empty").text('No on leave employee');
                    }
                },
                error : function() {
                    $.alert("Opps! Something went wrong please reload the page.");
                }
            });
        }
    });


    var leaves_report_table = $("#leaves_report_table").DataTable({
        searchDelay: 800,
        processing: true,
        serverSide: true, 
        'ajax': {
            'type': 'POST',
            'url': '/leaves/general-report',
            'data': {
                '_token': $("meta[name=csrf-token]").attr('content')
            }

        },
        'columns': [{
                'name': 'id',
                orderable: false
            },
            {
                'name': 'leave_type_id',
                orderable: false
            },
            {
                'name': 'allowance',
                orderable: false
            },
            {
                orderable: false
            },
            {
                orderable: false
            }
        ],
        fnDrawCallback : function() {
            var table = $(this);
            table.find("tbody tr").each(function(){
                var tr = $(this);
                var next =  tr.next("tr");
                var trCol = tr.find('td').eq(0);
                var nextCol = next.find('td').eq(0);
                
                if (trCol.text() == nextCol.text()) {
                    trCol.attr('rowspan','2');
                    trCol.addClass('align-middle');
                    nextCol.remove();     
                }
            })
        },  
        initComplete: function() {
             
            $("#leaves_report_table_length").append('&nbsp;&nbsp;<label>School Year <select aria-controls="leaves_report_table" style="width:150px;" id="sy" class="">' +
                '<option value="">Select School Year</option></select></label>'
            );
            sy_options();

            $("#sy").change(function() {
                leaves_report_table.search('');
                leaves_report_table.columns(3).search($(this).val()).draw();
            });


        }
    });

   

    $("#leaves-report").on('change', '#employee', function() {
        var id = $(this).val();
        $.ajax({
            type: 'POST',
            url: '/leave/employee-report',
            data: {
                _token: token,
                id: id
            },
            success: function(data) {
                var report = JSON.parse(data);
            }
        });
    })

    $("#duration").change(function(e) {
        e.preventDefault();
        var duration = $(this).val();

        if (duration === "short") {
            $("#short").fadeIn();
            $("#whole_day").hide();
            $("#long").hide();
        } else if (duration === "whole_day") {
            $("#short").hide();
            $("#whole_day").fadeIn();
            $("#long").hide();
        } else if (duration === "long") {
            $("#short").hide();
            $("#whole_day").hide();
            $("#long").fadeIn();
        }
    })

    $("#leave_table").on('click', '.view', function() {
        var id = $(this).data('id');
        employee_id = $(this).data('employee');
        campus_id = $(this).data('campus');
        var row = $(this).parents('tr');
        summary(id, employee_id, campus_id, row)
    })

    $("#check-balance").click(function() {
        
        $.ajax({
            type : 'POST',
            data : {
                _token : token,
                employee_id : employee_id,
                campus_id : campus_id
            },
            url : '/leaves/checkbalance',
            success : function(data) {
                var result = JSON.parse(data);
                var table = $("#balance-table tbody");
                table.empty();
                $.each(result, function(key, value) {
                    table.append("<tr>" +
                            '<td>' + value.name  +'</td>' + 
                            '<td>' + value.allowance  +'</td>' + 
                            '<td>' + value.used  +'</td>' + 
                            '<td>' + value.balance  +'</td>' + 
                        "</tr>");
                });
            }
        });

    })

    $("#summary").on('hidden.bs.modal', function() {
        $("#leave-b").collapse('hide');
    })


    function summary(leave_id, employee_id, campus_id, row) {
        var id = leave_id;
        var employee_id = employee_id;
        var campus_id = campus_id;
        var row = row;
        $.ajax({
            type: 'POST',
            url: '/leaves/summary',
            data: {
                _token: token,
                id: id,
                employee_id: employee_id,
                campus_id: campus_id
            },
            beforeSend: function() {
                $("#summary .modal-content").loading({
                    base: 0.2,
                    circles: 1,
                    overlay: true
                });
            },
            success: function(data) {
                var summary = JSON.parse(data);
                var employee_id = summary.employee_id;
                var campus_id = summary.campus_id;
                var leave_id = summary.leave_id;
                $("#name").text('Name: ' + summary.summary[0].name);
                $("#duration").text('Date: ' + summary.summary[0].duration);
                $("#status").text('Status: ' + summary.status);

                if (summary.summary[0].document)
                    $("#document").html('Document: ' + '<a href="' + summary.summary[0].document + '" target="__blank">Download attachment</a>');
                $("#reason").text('Reason: ' + summary.summary[0].reason);
                $("#leave_type").text(summary.summary[0].leave_type);
                $("#interval").text(summary.summary[0].interval);

                var heads = summary.heads[0];
                $("#department-heads-approval").empty();


                if (heads[0] !== null) {
                    $.each(heads, function(key, value) {
                        var status = "";
                        var view = "";
                        if (value.status === "pending") {
                            status = '<span class="label label-info">Pending</span>';
                        }else if (value.status === "declined") {
                            status = '<span class="label label-danger">Declined</span>';
                            if (value.note)
                                view = "<i class='fa fa-envelope-o'></i> View reason";
                        }else if (value.status === "approved") {
                            status = '<span class="label label-success">Approved</span>';
                            if (value.note)
                                view = "<i class='fa fa-envelope-o'></i> View note";
                        }else {
                            status = '<span class="label label-default">Closed</span>';
                        }

                        if (summary.status == "Approved")
                            status = '<span class="label label-success">Approved</span>'; 


                        $("#department-heads-approval").append(
                            '<div class="col-md-6 col-md-12">' +
                            '<div class="department-head-box">' +
                            '<div class="pull-left">' +
                            '<div>' + value.name + '</div>' +
                            '<div>' + value.position + '</div>' +
                            '</div>' +
                            '<div class="pull-right float-vertical-align">' +
                            status +
                            '</div>' +
                            '<div class="clearfix"></div>' +
                            '<button class="btn btn-link btn-sm" data-toggle="collapse" data-target="#note'+key+'">'+view+'</button>' +
                            '<div id="note'+key+'" class="collapse">'+value.note+'</div>' +
                            '</div>' +
                            '</div>'
                        );
                    });
                }

                if (summary.needsApproval) {
                    $("#leave-title").text('Take a decision');
                    $("#approve").unbind();
                    $("#decline").unbind();
                    $("#action-btns").show();
                    $("#approve").click(function() {
                        $.confirm({
                            title: 'Confirmation',
                            content: 'This dialog will automatically trigger \'cancel\' in 6 seconds if you don\'t respond.',
                            autoClose: 'cancelAction|8000',
                            buttons: {
                                Approve: {
                                    text: 'Approve Leave Request',
                                    btnClass: 'btn btn-success',
                                    action: function() {
                                        $("#summary").modal('toggle');
                                        $.confirm({
                                            title: 'Note',
                                            content: '' +
                                                '<form action="" class="formName">' +
                                                '<div class="form-group">' +
                                                '<label>Note:</label>' +
                                                '<input type="text" placeholder="Leave empty if none" class="reason form-control" required />' +
                                                '</div>' +
                                                '</form>',
                                            buttons: {
                                                formSubmit: {

                                                    text: 'Submit',
                                                    btnClass: 'btn-blue',
                                                    action: function() {
                                                        var note = this.$content.find('.reason').val();
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: 'leaves-approval/insert',
                                                            data: {
                                                                _token: token,
                                                                leave_id: leave_id,
                                                                campus_id: campus_id,
                                                                employee_id: employee_id,
                                                                status: 'approved',
                                                                note : note
                                                            },
                                                            success: function(data) {
                                                                $.alert({
                                                                    title: '<i class="fa fa-check text-success"></i> Approved',
                                                                    content: 'Leave successfully approved!'
                                                                });
                                                              
                                                                if (data == 'approved')
                                                                    row.find('td').eq(5).text(data);
                                                            }
                                                        });
                                                    }
                                                },
                                                cancel: function() {
                                                    $.alert('Action cancelled');
                                                }
                                            },
                                            onContentReady: function() {
                                                // bind to events
                                                var jc = this;
                                                this.$content.find('form').on('submit', function(e) {
                                                    // if the user submits the form by pressing enter in the field.
                                                    e.preventDefault();
                                                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                                                });
                                            }
                                        });
                                        

                                    }
                                },
                                cancelAction: function() {
                                    $.alert('action is canceled');
                                }
                            }
                        });
                    })

                    $("#decline").click(function() {
                        $.confirm({
                            title: 'Confirmation',
                            content: 'This dialog will automatically trigger \'cancel\' in 6 seconds if you don\'t respond.',
                            autoClose: 'cancelAction|8000',
                            buttons: {
                                decline: {
                                    text: 'Decline Leave Request',
                                    btnClass: 'btn btn-danger',
                                    action: function() {
                                        $("#summary").modal('toggle');
                                        $.confirm({
                                            title: 'Reason',
                                            content: '' +
                                                '<form action="" class="formName">' +
                                                '<div class="form-group">' +
                                                '<label>Enter reason:</label>' +
                                                '<input type="text" placeholder="Enter reason" class="reason form-control" required />' +
                                                '</div>' +
                                                '</form>',
                                            buttons: {
                                                formSubmit: {

                                                    text: 'Submit',
                                                    btnClass: 'btn-blue',
                                                    action: function() {
                                                        var reason = this.$content.find('.reason').val();
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: 'leave/decline',
                                                            data: {
                                                                _token: token,
                                                                leave_id: leave_id,
                                                                campus_id: campus_id,
                                                                employee_id: employee_id,
                                                                status: 'declined',
                                                                reason: reason
                                                            },
                                                            success: function() {
                                                                $.alert({
                                                                    title: '<i class="fa fa-ban text-danger"></i> Declined',
                                                                    content: 'Leave request has been declined!'
                                                                });
                                                                row.find('td').eq(5).text('declined');
                                                            }
                                                        });
                                                    }
                                                },
                                                cancel: function() {
                                                    $.alert('Action cancelled');
                                                }
                                            },
                                            onContentReady: function() {
                                                // bind to events
                                                var jc = this;
                                                this.$content.find('form').on('submit', function(e) {
                                                    // if the user submits the form by pressing enter in the field.
                                                    e.preventDefault();
                                                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                                                });
                                            }
                                        });

                                    }
                                },
                                cancelAction: function() {
                                    $.alert('action is canceled');
                                }
                            }
                        });
                    })
                } else {
                    $("#leave-title").text('Leave Details');
                    $("#action-btns").hide();
                }

                $("#summary .modal-content").loading({
                    destroy: true
                });
            }
        })
    }

    

    $(".birthday").mask('0000-00-00'); 
    $(".mobile").mask("0000-0000-000");
    $(".telephone").mask('0000-000');

    $(".back").click(function(e) {
        e.preventDefault();
        history.go(-1);
    })

    $('.alert-success').fadeIn().delay(5000).fadeOut();


    var rolesTable = $("#roles_table").DataTable({
        'order': [
            [0, "DESC"]
        ],
        'processing': true,
        'serverSide': true,
        'ajax': {
            'type': 'GET',
            'url': '/roles/data',
            'data': {
                '_token': $("meta[name=csrf-token]").attr('content')
            }

        },
        'columns': [{
                'name': 'name',
                width: '25%'
            },
            {
                'name': 'description',
                width: '45%'
            },
            {
                orderable: false,
                width: '15%'
            },
            {
                'name': 'id',
                width: '15%'
            },
        ]
    });

    $("#select_role_campus").change(function() {
        var campus_id = $(this).val();
        $.ajax({
            type: 'POST',
            url: '/campus/getDepartments',
            data: {
                _token: token,
                campus_id: campus_id
            },
            success: function(data) {

                $("#campus-department").fadeOut();
                $("#campus-department-select").empty();
                $("#campus-department-select").fadeOut();
                var departments = JSON.parse(data);
                $("#campus-department-select").append("<option value=''>Select Department</option>");
                $.each(departments, function(key, value) {
                    $("#campus-department-select").append("<option value='" + value.id + "'>" + value.name.charAt(0).toUpperCase() + value.name.slice(1) + "</option>");
                });
                $("#campus-department").fadeIn();
                $("#campus-department-select").fadeIn();
                $("#campus-department-select").selectpicker('refresh');
            }

        });

    })

    $(".campus-department-select").change(function() {
        var id = $(this).val();
        $.ajax({
            type: 'GET',
            url: '/roles/getDepartmentRoles',
            data: {
                id: id
            },
            success: function(data) {
                var roles = JSON.parse(data);
                $("#select-role").hide();
                $("#roles").empty();
                $("#roles").append('<option value="">Select Role</option>');
                $.each(roles, function(key, value) {
                    $("#roles").append('<option value="' + value.id + '">' + value.name + '</option>')
                });
                $("#select-role").fadeIn();
            }

        })
    })

    $("#schedules_table").DataTable({
        'order': [
            [0, "DESC"]
        ],
        'processing': true,
        'serverSide': true,
        'ajax': {
            'type': 'GET',
            'url': '/schedule/data',
            'data': {
                '_token': $("meta[name=csrf-token]").attr('content')
            }

        },
        searching : false,
        'columns': [{
                'name': 'name',
                width: '30%'
            },
            {
                'name': 'start',
                width: '15%'
            },
            {
                'name': 'end',
                width: '15%'
            },
            {
                'name': 'days',
                width: '20%'
            },
            {
                orderable: false,
                width: '20%'
            }
        ],
        initComplete : function() {
            $("#schedules_table_length").prepend('<button class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal">New Schedule</button>&nbsp;');
        }
    });

    $("#submit-schedule").click(function() {
        var name = $("#schedule_form input[name='name']").val();
        var start = $("#schedule_form input[name='start']").val();
        var end = $("#schedule_form input[name='end']").val();
        var days = $("#schedule_form select[name='days']").val();
        var text = $("#schedule_form select[name='days'] option:selected").text();

        $.ajax({
            type: 'POST',
            url: '/schedule/insert',
            data: {
                _token: token,
                name: name,
                start: start,
                end: end,
                days : days
            },
            success: function(data) {
                var table = $("#schedules_table tbody");
                table.append("<tr>" +
                        '<td>' + name + '</td>' +
                        '<td>' + start + '</td>' +
                        '<td>' + end + '</td>' +
                        '<td>' + text + '</td>' +
                        '<td>' + 
                            '<div class="dropdown">' +
                            '<a class="icon_action btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="padding:3px 7px;border-radius:5px; ">' +
                            'Action <span class="caret"></span> </a>' +
                            '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">' +
                                    '<li>' +
                                        '<form >' +  
                                            '<button type="submit" class="btn-link edit" data-id="'+data+'"> <i class="fa fa-edit" ></i> Edit </button>'+
                                        '</form>'+
                                    '</li>'+
                                    '<li>'+
                                        '<form method="post" action="'+base_url+'schedule/destroy" class="delete-form" data-name="Schedule">'+
                                            '<input type="hidden" name="_token" value="'+token+'">'+
                                            '<input type="hidden" name="id" value="'+data+'">'+
                                            '<input name="_method" type="hidden" value="delete">'+
                                            '<button type="submit" class="btn-link"> <i class="fa fa-trash"></i> delete </button>'+
                                        '</form>'+
                                    '</li>'+
                                '</ul>'+
                            '</div>' +
                        '</td>' +
                    '</tr>');
            }
        });
    })


    $("#schedules_table").on('click', '.edit', function(e) {
        e.preventDefault();

        var id = $(this).data('id');

        var row = $(this).parents('tr');
        var name = row.find('td').eq(0).text();
        var start = row.find('td').eq(1).text().toLowerCase();
        var end = row.find('td').eq(2).text().toLowerCase();
        var days = row.find('td').eq(3).text();
        $("#schedule_id").val(id);

        $('#edit_schedule_form input[name="name"]').val(name);
        $('#edit_schedule_form input[name="start"]').val(start);
        $('#edit_schedule_form input[name="end"]').val(end);
        var d = $("#edit_schedule_form select[name='days']").find('option:contains("'+days+'")');
        d.attr('selected','selected');
        $("#edit-modal").modal('toggle');
    })



    $("#roles_table").on('click', '.delete', function() {
        var id = ($(this).data('id'));
        var row = $(this).parents('tr');
        $.confirm({
            title: 'Delete Role?',
            content: 'This dialog will automatically trigger \'cancel\' in 6 seconds if you don\'t respond.',
            autoClose: 'cancelAction|8000',
            buttons: {
                deleteUser: {
                    text: 'Delete Role',
                    btnClass: 'btn btn-danger',
                    action: function() {
                        $.ajax({
                            type: 'POST',
                            url: 'roles/destroy',
                            data: {
                                _token: token,
                                id: id
                            },
                            success: function() {
                                $.alert('Deleted the role!');
                                row.remove();
                            }
                        });

                    }
                },
                cancelAction: function() {
                    $.alert('action is canceled');
                }
            }
        });

    })

    var addEmployeeForm = new AddEmployeeFormStep;
    addEmployeeForm.prev($(".prev"));
    $("#menu_toggle").click(function() {
        var width = ($(".left_col").width());

        if ($(document).width() > 991) {
            $(".top_nav").css('margin-left', width);
        }else {
            if (width <= 70)
            $(".top_nav").css('margin-left', width);
            else {
                $(".top_nav").css('margin-left', 0);
            }
        }
        

    });

    var employee = new Employee;
    employee.dataTables();

    $("#avatar").change(function() {

        readURL(this);
    });
    $("#resume").change(function() {
        var fileName = this.files[0].name;
        if (fileName.length > 35) {
            return $("#r-holder").text(fileName.substring(0, 35) + '....');
        }

        return $("#r-holder").text(fileName);
    })

    var department = new Department;
    department.dataTables();
    department.validate();

    var leave = new Leave;
    leave.dataTables();
    leave.validate();
   
    $("#leave_table").on('submit', '.approve', function(e) {
        e.preventDefault();
        var action = $(this).attr('action');
        var id = $(this).find('input[name="id"]').val();
        var row = $(this).parents('tr');
        $.confirm({
            title: 'Confirmation',
            content: 'Are you sure you want to approve that leave request?',
            autoClose: 'cancelAction|8000',
            buttons: {
                yes: {
                    text: 'Yes',
                    btnClass: 'btn btn-success',
                    action: function() {
                        $.ajax({
                            type: 'POST',
                            url: action,
                            data: {
                                _token: token,
                                id: id
                            },
                            success: function() {
                                row.find('td').eq(6).text('Approved');
                                row.find('td').eq(7).text('-- --');
                                $.alert('Leave application has been successfully approved');
                            },
                            error: function() {
                                $.alert('Opps.. Something went wrong please try again later');
                            }
                        });


                    }
                },
                cancelAction: function() {
                    $.alert('action is canceled');
                }
            }
        });

    });
    $("#leave_table").on('submit', '.disapprove', function(e) {
        e.preventDefault();
        var action = $(this).attr('action');
        var id = $(this).find('input[name="id"]').val();
        var row = $(this).parents('tr');
        $.confirm({
            title: 'Prompt!',
            content: '' +
                '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<label>Reason for declining</label>' +
                '<input type="text" placeholder="Reason" class="name form-control" required />' +
                '</div>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function() {
                        var name = this.$content.find('.name').val();
                        if (!name) {
                            $.alert('provide a valid reason');
                            return false;
                        } else {
                            $.ajax({
                                type: 'POST',
                                url: action,
                                data: {
                                    _token: token,
                                    id: id,
                                    reason: name
                                },
                                success: function() {
                                    row.find('td').eq(6).text('Declined');
                                    row.find('td').eq(7).text('-- --');
                                    $.alert('Leave application has been declined');
                                },
                                error: function() {
                                    $.alert('Opps.. Something went wrong please try again later');
                                }
                            });
                        }

                    }
                },
                cancel: function() {
                    //close
                },
            },
            onContentReady: function() {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function(e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    });

    $("#my_leaves").on("click", '.delete', function() {
        var id = $(this).data('id');
        var row = $(this).parents('tr');
        $.confirm({
            title: 'Delete leave Request?',
            content: 'Leave request will be canceled',
            autoClose: 'cancelAction|8000',
            buttons: {
                DeleteRequest: {
                    text: 'Delete Request',
                    btnClass: 'btn btn-danger',
                    action: function() {
                        $.ajax({
                            type: 'POST',
                            url: '/my-leaves/delete',
                            data: {
                                '_token': token,
                                'id': id
                            },
                            success: function() {
                                row.remove();
                                $.alert({
                                    title: 'Request Deleted!',
                                    content: 'Your leave application has been deleted',
                                    icon: 'fa fa-info'
                                });
                            },
                            error: function() {
                                $.alert('Opps.. Something went wrong please try again later');
                            }
                        });

                    }
                },
                cancelAction: function() {
                    $.alert('action is canceled');
                }
            }
        });

    })

    var leaveType = new LeaveType;
    leaveType.validate();
    leaveType.dataTables();

    var attendance = new Attendance;
    attendance.dataTables();
    attendance.upload_sheet();
    attendance.changeInput();
    attendance.validation();

    var user = new User;
    user.validation();
    user.dataTables();

    new Confirmation;

    var campus = new Campus;
    campus.dataTables();


    $("#employee_id").change(function() {
        var campus_id = $("#employee_id option:selected").data('campusid');
        $(this).data('campusid', campus_id);

    });

    new DatePicker;
})

class Confirmation {

    constructor() {
        $("body").on('submit', '.delete-form', function(e) {
            var row = $(this).parents('tr');
            var form = this;
            var name = $(this).data('name');
            var action = $(this).attr('action');

            var id = $(this).find('input[name="id"]').val();
            $(this).parents(".dropdown").find('a').dropdown("toggle");
            e.preventDefault();

            $.confirm({
                title: 'Delete ' + name + '?',
                content: 'Are you sure you want to delete that ' + name + '?',
                autoClose: 'cancelAction|8000',
                buttons: {
                    DeleteRequest: {
                        text: 'Delete',
                        btnClass: 'btn btn-danger',
                        action: function() {
                            $.ajax({
                                type: 'post',
                                url: action,
                                data: {
                                    '_token': token,
                                    'id': id
                                },
                                beforeSend: function() {
                                    $("#employee_table tbody").loading({
                                        circles: 1,
                                        overlay: true,
                                        base: 0.15
                                    });
                                },
                                success: function() {
                                    $("#employee_table tbody").loading({
                                        destroy: true
                                    });
                                    row.remove();
                                    $.alert({
                                        title: name + ' Deleted!',
                                        content: 'Deleted successfully...'
                                    });
                                },
                                error: function() {
                                    $("#employee_table tbody").loading({
                                        destroy: true
                                    });
                                    $.alert('Opps.. Something went wrong please try again later');
                                }
                            });

                        }
                    },
                    cancelAction: function() {
                        $.alert('action is canceled');
                    }
                }
            });

        })
    }
}


class Campus {
    dataTables() {
        var campusDataTable = $("#campus_table").dataTable({
            responsive : true,
            searchDelay: 800,
            'processing': true,
            'serverSide': true,
            'ajax': {
                'type': 'POST',
                'url': '/campus/data',
                'data': {
                    '_token': $("meta[name=csrf-token]").attr('content')
                }

            },
            'columns': [{
                    'name': 'name',
                    orderable: false
                },
                {
                    'name': 'description',
                    orderable: false
                },
                {
                    orderable: false
                },
                {
                    orderable: false
                },
                {
                    'visible': actions,
                    orderable: false
                }
            ]
        });
 
    }
}

class User {

    validation() {
        $("#user_form").parsley();
    }

    dataTables() {
        $("#user_table").DataTable({
            responsive : true,
            'processing': true,
            'serverSide': true,
            'ajax': {
                'type': 'POST',
                'url': '/users/data',
                'data': {
                    '_token': $("meta[name=csrf-token]").attr('content')
                }

            },
            'columns': [{
                    'name': 'name'
                },
                {
                    'name': 'email'
                },
                {
                    'name': 'role'
                },
                {
                    'name': 'active'
                },
                {
                    orderable: false
                }
            ]

        });
    }
}

class Attendance {

    dataTables() {

        $("#attendance_table").dataTable({
            responsive : true,
            'processing': true,
            'serverSide': true,
            'ajax': {
                'type': 'POST',
                'url': '/attendance/data',
                'data': {
                    '_token': $("meta[name=csrf-token]").attr('content')
                }

            },
            'columns': [{
                    'name': 'id'
                },
                {
                    'name': 'name'
                },
                {
                    'name': 'date'
                },
                {
                    "name": 'campus'
                }
            ]
        });

    }

    changeInput() {
        $("#attendance").change(function() {
            $("#progress-indicator").text('');
            $("#progressbar").addClass('active');
            $("#progress-container").hide();
        })
    }

    validation() {
        $("#attendance_upload_form").parsley();
    }

    upload_sheet() {

        var bar = $("#progressbar");
        $("#attendance").change(function(e) {
            $("#p-holder").text(e.target.files[0].name);
        })
        $("#attendance_upload_form").submit(function(e) {
            var form = $(this);

            form.find('input[type="submit"]').prop('disabled', true);
            e.preventDefault();

            if ($("#attendance").val() != "" && $("[name='campus_id']").val() != "") {
                var formData = new FormData($(this)[0]);
                $.ajax({

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'text',
                    contentType: false,
                    method: 'POST',
                    url: '/attendance/file_upload',
                    data: formData,
                    beforeSend: function() {
                        $(".x_content").loading({
                            base: 0.15,
                            overlay: true,
                            circles: 1,
                        });
                    },
                    success: function(data) {
                  
                        $(".x_content").loading({
                            destroy: true
                        });

                        $("#attendance_upload_form").trigger('reset');
                        form.find('input[type="submit"]').prop('disabled', false);
                        $("#p-holder").text("Choose files");
                        if (data == 0) 
                            $.alert('<b>ERROR!</b> only xlxs, xls, csv or text file is accepted');
                        else 
                            $.alert('Attendance uploaded successfully!');

                    },
                    error : function() {
                        $(".x_content").loading({
                            destroy: true
                        });
                        $("#p-holder").text("Choose files");
                        $.alert("Opps! Something went wrong please try again");
                    },
                    cache: false,
                    processData: false
                });

            }
        });
    }
}


class DatePicker {

    constructor() {
        $("#birthday").keyup(function() {
            var val = this.value;
            if (val.length > 6) {
                var birthday = moment().diff((moment(val, "YYYY-MM-DD")), 'years', false);
                if (birthday)
                    $("#age").val(birthday);
            }
        })

     
        $('#date_joining_datepicker').datetimepicker({
            format: 'YYYY-MM-DD',
            viewMode: 'years'
        }).on('dp.change', function() {
            $(this).removeClass('parsley-error');
            $(this).parents('.input-group').find('.parsley-errors-list li').text('');
        });
      
        $('#start_date').datetimepicker({
            format: 'YYYY-MM-DD'
        }).on('dp.change', function() {
            $(this).removeClass('parsley-error');
            $(this).parents('.form-group').find('.parsley-errors-list li').text('');
        });
        

        $("#leave_type").change(function() {
            $("#a-error").hide();
            $("#a-success").hide();
            $("#end_date").val('');
            $("#leave_start_date").val('');
            $("#days").val('');
        });
        $("#short_leave_date").datetimepicker({
            format: 'YYYY-MM-DD'
        });
        
        $('#end_date').datetimepicker({
            format: 'YYYY-MM-DD'
        }).on('dp.change', function(timestamp) {

            var id = $("#leave_type").val();

            var start_date = $("#start_date").data('DateTimePicker').date();
            var end_date = $(this).data('DateTimePicker').date();
            var days = Math.round((end_date - start_date) / (1000 * 60 * 60 * 24));

            $.each(myLeaveBalance, function(key, value) {
                if (value.id == id) {
                    var allowance = value.allowance - value.total;

                    if (days > value.allowance) {
                        $("#a-error").show();
                        $("#a-success").hide();
                        $("#a-error .message").text('Your applicated exceeds your allowable days limit please check your leave balance');
                    } else {
                        $("#a-error").hide();
                        $("#a-success").show();
                        $("#a-success .message").text('Your application has high approval rate, ready to submit');
                    }

                }
            });

            if (days > 0) {
                var output = (days > 1 ? days + ' Days' : days + ' Day');
                $("#days").val(output);
            }else {
                $("#days").val("Start date is greater than end date.");
            }

            $(this).removeClass('parsley-error');
            $(this).parents('.form-group').find('.parsley-errors-list li').text('');
        });


        $("#start_time").datetimepicker({
            format: 'LT'
        });
        $("#end_time").datetimepicker({
            format: 'LT'
        })
        $("#whole_day_leave").datetimepicker({
            format: 'YYYY-MM-DD'
        });

        $(".schedule-time").datetimepicker({
            format: 'hh:mm A'
        });

        $(".date").datetimepicker({
            format: 'YYYY-MM-DD',
            viewMode : 'months'
        })

       
        
        $(".attendance-date").datetimepicker({
            format: 'YYYY-MM-DD'
        })

      
        $(".time").datetimepicker({
            format: 'LT'
        });
      
        

    }
}

class Employee {

    dataTables() {
        var employeeTable = $("#employee_table").DataTable({
            responsive : true,
            'processing': true,
            'serverSide': true,
            bLengthChange : false,
            dom : '<"toolbar">frtip',
            'order': [
                [7, 'desc']
            ],
            'ajax': {
                'type': 'POST',
                'url': '/employee/data',
                'data': {
                    '_token': $("meta[name=csrf-token]").attr('content')
                }

            },
            searchDelay: 800,
            'columns': [
                {
                    "name": 'employee_id',
                    width: '10%'
                },
                {
                    "name": 'first_name',
                    width: '10%'
                },
                {
                    'name': 'campus_id',
                    width: '10%',
                    orderable: false
                },
                {
                    'name': 'designation',
                    width: '10%',
                    orderable: false
                },
                {
                    'name': 'department_id',
                    width: '10%'
                },
                {
                    'name': 'salary',
                    'visible': actions,
                    width: '10%'
                },
                {
                    'orderable': false,
                    'name': 'employment_type',
                    width: '22%'
                },
                {
                    'name': 'status',
                    width: '8%'
                },
                {
                    'orderable': false,
                    'visible': actions,
                    'name': 'created_at',
                    width: '10%',
                    class: 'text-center'
                },

            ],
            initComplete: function() {                

                $.ajax({
                    type: 'GET',
                    url: '/campus/getCampuses',
                    success: function(data) {
                        var campuses = JSON.parse(data);
                        console.log(campuses);
                        
                        $.each(campuses, function(key, value) {

                            $("#select-campus").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });

                        $("#select-campus").change(function() {
                            employeeTable.search('');
                            employeeTable.columns(7).search('');
                            $("#employment_filter").val('');
                            employeeTable.columns(1).search($(this).val()).draw();
                        })
                    }
                });
                $("#employee_table_filter").keyup(function() {
                    $("#employment_filter").val('');
                    employeeTable.columns(7).search('');
                })
                

                $("#employment_filter").change(function() {
               
                    employeeTable.search('');
                    employeeTable.columns(7).search($(this).val()).draw();
                })
            }

        });
        $("#employee_table_wrapper .toolbar").html('Campus:&nbsp;' +
            '<select id="select-campus" name="select-campus" aria-controls="department_table" style="width:150px;">'+
                '<option value="">Select Campus</option>'+
                '</select>&nbsp;&nbsp; Type: <select id="employment_filter" style="width:140px;"><option value="">Employment Type</option><option value="1">Full Time</option><option value="0">Part time</option></select>');

        $("#employee_table_filter input[type='search']").keyup(function() {
            employeeTable.columns(7).search('');
            $("#employment_filter").val('');
            $("#select-campus").val('');
            employeeTable.columns(1).search('');
        })
    }

}

class Leave {

    dataTables() {
        var leave_table = $("#leave_table").DataTable({
            responsive : true,
            'processing': true,
            'serverSide': true,
            'order': [
                [0, 'desc']
            ],
            'ajax': {
                'type': 'POST',
                'url': '/leave/data',
                'data': {
                    '_token': $("#token").val()
                }

            },
            'columns': [{
                    "name": 'created_at'
                },
                {
                    'name': 'employee_id'
                },
                {
                    'orderable': false
                },
                {
                    'orderable': false
                },
                {
                    'orderable': false
                },
                {
                    'name': 'status'
                },
                {
                    'orderable': false,
                    "visible": leaveActions
                }
            ],
            initComplete : function() {
                $("#leave_table_length").append("&nbsp;&nbsp; <select style='width:100px;' id='leave-status'>" +
                            "<option value=''>Status</option>" +
                            "<option value='pending'>Pending</option>" +
                            "<option value='approved'>Approved</option>" +
                            "<option value='declined'>Declined</option>" +
                        "</select>"
                    );

                $("#leave-status").change(function() {
                    var status = $(this).val();
                    leave_table.columns(2).search(status).draw();
                })
            }
        });
    }

    validate() {
        $("#leave_application_form").parsley({
            errorsContainer: function(pEle) {
                var $err = pEle.$element.siblings('.errorBlock');
                return $err;
            }
        });
    }

    report() {
        $("#leave_reports_table").DataTable({
            'processing': true,
            'serverSide': true,
            'order': [
                [0, 'desc']
            ],
            'ajax': {
                'type': 'POST',
                'url': '/leave/reports',
                'data': {
                    '_token': token
                }

            }
        });
    }
}

class LeaveType {
    validate() {
        $("#leave_type_form").parsley();
    }

    dataTables() {
        var leavesTypeTable = $("#leave_type_table").DataTable({
            responsive : true,
            'processing': true,
            'serverSide': true,
            'order': [
                [0, 'desc']
            ],
            'ajax': {
                'type': 'POST',
                'url': '/leave-types/data',
                'data': {
                    '_token': token
                }

            },
            'columns': [{
                    name: 'name'
                },
                {
                    name: 'campus_id',
                    orderable: false
                },
                {
                    orderable: false
                },
                {
                    name: 'description'
                },
                {
                    name: 'allowance'
                },
                {
                    orderable: false
                },
            ],
            "bLengthChange": false,

            initComplete: function() {
                $("#leave_type_table_wrapper").prepend('<div class="dataTables_length" id="leave_type_table_length"></div>');
                $.ajax({
                    type: 'GET',
                    url: '/campus/getCampuses',
                    success: function(data) {
                        var campuses = JSON.parse(data);
                        console.log(campuses);
                        $("#leave_type_table_length").append('<label>Campus:&nbsp; <select id="select-campus" name="select-campus" aria-controls="department_table" style="width:150px;"><option value="">Select Campus</option></select></label>');
                        $.each(campuses, function(key, value) {

                            $("#select-campus").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });

                        $("#select-campus").change(function() {
                            leavesTypeTable.search('');
                            leavesTypeTable.columns(1).search($(this).val()).draw();
                        })
                    }
                });

                $("#leave_type_table_filter input[type='search']").keyup(function(event) {
                    if (event.type == "keypress" && (event.shiftKey || event.which <= 55 || event.which >= 58))
                        return false;
                    leavesTypeTable.columns().search('').draw();
                    $("#select-campus").val('');
                })
            }
        });
    }

}

class Department {

    dataTables() {

        var departmentTable = $("#department_table").DataTable({
            responsive : true,
            'processing': true,
            'serverSide': true,
            'bLengthChange': false,
            'order': [
                [1, 'ASC']
            ],
            'ajax': {
                'type': 'POST',
                'url': '/department/data',
                'data': {
                    '_token': token
                }
            },
            'columns': [{
                    'name': 'id',
                    width: '15%'
                },
                {
                    'name': "name",
                    width: '35%'
                },
                {
                    'name': "description",
                    'title': 'Desciption',
                    width: '35%'
                },
                {
                    'name': 'campus_id',
                    'orderable': false,
                    'title': 'Actions',
                    'visible': actions,
                    width: '15%'
                }
            ],
            initComplete: function() {
                $("#department_table_wrapper").prepend('<div class="dataTables_length" id="department_table_length"></div>');
                $.ajax({
                    type: 'GET',
                    url: '/campus/getCampuses',
                    success: function(data) {
                        var campuses = JSON.parse(data);
                        $("#department_table_length").append('<label>Campus:&nbsp; <select id="select-campus" name="select-campus" aria-controls="department_table" style="width:150px;"><option value="">Select Campus</option></select></label>');
                        $.each(campuses, function(key, value) {
                            $("#select-campus").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });

                        $("#select-campus").change(function() {
                            departmentTable.search('');
                            departmentTable.columns(3).search($(this).val()).draw();
                        })

                        $("#department_table_filter input[type='search']").keyup(function(event) {
                            if (event.type == "keypress" && (event.shiftKey || event.which <= 55 || event.which >= 58))
                                return false;
                            departmentTable.columns().search('').draw();
                            $("#select-campus").val('');
                        })
                    }
                });
            }
        })
        var tr = $("#department_table_length tbody tr").size();
    }

    validate() {
        $("#new_department_form").parsley();
    }
}

class AddEmployeeFormStep {

    constructor() {
        $("#new_employee_form .next").click(function(e) {
            var elem = $(this);
            var sections = $(".form-step");
            var index = sections.index(sections.filter('.active'));
            var block = 'block' + (index + 1);
            var test = $("#new_employee_form").parsley().validate(block);

            if (test) {
                var container = elem.parents('.form-step');
                var stepNumber = container.attr('step-no');
                $('.form-step.active').removeClass('active');
                container.next('.form-step').addClass('active');
                $('input').removeClass('parsley-error');
                $('select').removeClass('parsley-error');
                $(".parsley-errors-list li").text("");
                e.preventDefault();
                switch (index) {
                    case 0:
                        $("#x_title h2 ").replaceWith('<h2>Step 2: <small>Employment Details</small></h2>');
                        break;
                    case 1:
                        $("#x_title h2 ").replaceWith('<h2>Step 3: <small>Resume Upload</small></h2>');
                        break;
                    default:
                        $("#x_title h2 ").replaceWith('<h2>Step 1: <small>Personal Details</small></h2>');
                        break;
                }
            }
        })

    }
    prev(elem) {

        $(elem).click(function() {
            var elem = $(this).parents('.form-step');
            var currentStep = elem.attr('step-no');
            elem.removeClass('active');
            elem.prev('.form-step').addClass('active');
            if (currentStep == 1) {

                $("#x_title h2 ").replaceWith('<h2>Step 2: <small>Employment Details</small></h2>');

            } else if (currentStep == 2) {

                $("#x_title h2 ").replaceWith('<h2>Step 1: <small>Personal Details</small></h2>');

            } else if (currentStep == 3) {

                $("#x_title h2 ").replaceWith('<h2>Step 2: <small>Employment Details!</small></h2>');

            }

            return false;
        })


    }
}

function init_daterangepicker() {
    if ("undefined" != typeof $.fn.daterangepicker) {
        var a = function(a,
                b,
                c) {

                $("#reportrange span").html(a.format("MMMM D, YYYY") + " - " + b.format("MMMM D, YYYY"))

            },
            b = {
                startDate: moment().subtract(29,
                    "days"),
                endDate: moment(),

                minDate: "01/01/2017",
                maxDate: maxDate,
                dateLimit: {
                    days: 90,
                    months: 12
                },
                showDropdowns: !0,
                showWeekNumbers: !0,
                timePicker: !1,
                timePickerIncrement: 1,
                timePicker12Hour: !0,
                ranges: {
                    Today: [moment(), moment()],
                    Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
                    "Last 7 Days": [moment().subtract(6, "days"), moment()],
                    "Last 30 Days": [moment().subtract(29, "days"), moment()],
                    "This Month": [moment().startOf("month"), moment().endOf("month")],
                    "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")],

                },
                opens: "left",
                buttonClasses: ["btn btn-default"],
                applyClass: "btn-small btn-primary",
                cancelClass: "btn-small",
                format: "MM/DD/YYYY",
                separator: " to ",
                locale: {
                    applyLabel: "Submit",
                    cancelLabel: "Clear",
                    fromLabel: "From",
                    toLabel: "To",
                    customRangeLabel: "Custom",
                    daysOfWeek: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
                    monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                    firstDay: 1
                }
            };
        $("#reportrange span").html(moment().subtract(29, "days").format("MMMM D, YYYY") + " - " + moment().format("MMMM D, YYYY")),
            $("#reportrange").daterangepicker(b,
                a),
            $("#reportrange").on("show.daterangepicker",
                function(a, b) {

                }
            ),
            $("#reportrange").on("hide.daterangepicker",
                function() {

                }
            ),
            $("#reportrange").on("apply.daterangepicker",
                function(a, b) {

                    var start_date = b.startDate.format("MMMM D, YYYY");
                    var end_date = b.endDate.format("MMMM D, YYYY");
                    startDate = start_date;
                    endDate = end_date;
                    var employee_id = $("#employee_id").val();
                    var campus_id = $("#employee_id").data('campusid');

                    if (employee_id !== "") {
                        $.ajax({
                            url: '/attendance/report',
                            type: 'POST',
                            data: {
                                '_token': token,
                                start_date: start_date,
                                end_date: end_date,
                                employee_id: employee_id,
                                campus_id: campus_id
                            },
                            beforeSend: function() {
                                $(".process-loader").show();
                                $("#employee_attendance_table").show();
                            },
                            success: function(data) {
                                $(".tile_count").show();
                                var result = JSON.parse(data);
                                $(".process-loader").hide();
                                $(".stats-overview").show();
                                var table = $("#employee_attendance_table tbody");
                                table.empty();

                                if (result) {
                                    var eType = result.employmentType;

                                    if (result.data) {

                                        $.each(result.data, function(key, result) {
                                            var row = "";
                                            if (result.status !== "present"  && result.status !== "late") {

                                                var row = "<tr> <td> " + moment(result.date).format('YYYY-MM-DD') + "</td> <td>  - - </td> <td> - - </td><td> - - </td><td> - - </td><td> - - </td><td> " + result.status + "</td></tr>";

                                            } else if (result.status !== "present" && result.status !== "late" && eType == 0) {
                                                return;
                                            } else if (result.status === "late") {
                                                var row = "<tr> <td> " + result.date + "</td> <td> " + result.in + "</td> <td> " + result.out + "</td><td> " + result.total_hours + "</td><td> " + result.late + "</td><td> " + result.overtime + "</td><td>late</td></tr>";

                                            } else {
                                                var row = "<tr> <td> " + result.date + "</td> <td> " + result.in + "</td> <td> " + result.out + "</td><td> " + result.total_hours + "</td><td> " + result.late + "</td><td> " + result.overtime + "</td><td> " + result.status + "</td></tr>";
                                            }

                                            table.append(row);
                                        })

                                    } else {
                                        table.append('<tr><td colspan="5" class="text-center">No records found</td></tr>')
                                    }

                                    
                                    $("#total_hours").text(result.total_hours);
                                    $("#working").text(result.working);
                                    $("#total_Late").text(result.late + ' min');
                                    $("#name").text(result.name);
                                    $("#overtime").text(result.overtime);
                                    $("#absent").text(result.absent);
                                    $("#worked").text(result.worked);
                                    $("#working-wrapper").show();
                                    $("#worked-wrapper").show();
                                    $("#absent-wrapper").show();
                                    

                                    $("#employmentType").text(eType == 'part_time' ? 'Part Time' : 'Full Time');
                                } else {
                                    table.append('<tr><td colspan="5" style="text-align:center">No Result Found.</td></tr>')
                                }


                            }
                        });
                    } else {
                        $("table tbody tr td").text('Please select an employee');
                    }

                }
            ),
            $("#reportrange").on("cancel.daterangepicker",
                function(a, b) {}
            ),
            $("#options1").click(function() {
                $("#reportrange").data("daterangepicker").setOptions(b, a)
            }),
            $("#options2").click(function() {
                $("#reportrange").data("daterangepicker").setOptions(optionSet2, a)
            }),
            $("#destroy").click(function() {
                $("#reportrange").data("daterangepicker").remove()
            })
    }
}

function bs_input_file() {

    $(".input-file").before(
        function() {
            if (!$(this).prev().hasClass('input-ghost')) {
                var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
                element.attr("name", $(this).attr("name"));
                element.change(function() {
                    element.next(element).find('input').val((element.val()).split('\\').pop());
                });
                $(this).find("button.btn-choose").click(function() {
                    element.click();
                });
                $(this).find("button.btn-reset").click(function() {
                    element.val(null);
                    $(this).parents(".input-file").find('input').val('');
                });
                $(this).find('input').css("cursor", "pointer");
                $(this).find('input').mousedown(function() {
                    $(this).parents('.input-file').prev().click();
                    return false;
                });
                return element;
            }
        }
    );
}
$(function() {
    bs_input_file();
});

function ucfirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function sy_options() {
    var year = moment().get('year').toString();
    var s = year.substr(0, 2);
    var currentYear = year.substr(2, 4);
    var startYear = 17;

    for (i = startYear; i <= currentYear; i++) {
        $("#sy").append('<option value="' + (s + i) + '">' + (s + i) + ' - ' + (s + (i + 1)) + '</option>');

    }
}