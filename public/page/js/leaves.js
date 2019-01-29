 $("#my_leaves").DataTable({
    'order': [
        [0, "DESC"]
    ],
    'processing': true,
    'serverSide': true,
    'ajax': {
        'type': 'POST',
        'url': '/my-leaves/data',
        'data': {
            '_token': $("meta[name=csrf-token]").attr('content')
        }

    }, 
    'columns': [{
            orderable: false,
            name: 'id',
            width: '15%'
        },
        {
            'name': 'created_at',
            width: '15%'
        },
        {
            'name': 'from',
            width: '20%'
        },
        {
            'name': 'to',
            width: '20%'
        },
        {
            'name': 'status',
            width: '15%'
        },
        {
            'name': 'action',
            width: '15%'
        }
    ],
    initComplete : function() {
        $("#my_leaves_length").append('&nbsp;&nbsp; <button class="btn btn-default btn-sm" style="color:#73879C;" data-toggle="modal" data-target="#leave-balance"><i class="fa fa-info-circle"></i> My Leave Balance</button>');
    }
});

$("#my_leaves").on('click', '.view', function() {
    var id = $(this).data('id');
    var employee_id = $(this).data('employee');
    var campus_id = $(this).data('campus');
    var row = $(this).parents('tr');

    $.ajax({
        type: 'POST',
        url: '/leaves/summary',
        data: {
            _token: token,
            id: id,
            employee_id: employee_id,
            campus_id: campus_id
        },
        success: function(data) {
            var summary = JSON.parse(data);
            var employee_id = summary.employee_id;
            var campus_id = summary.campus_id;
            var leave_id = summary.leave_id;
            console.log(summary.summary[0].name);
            $("#name").text('Name: ' + summary.summary[0].name);
            $("#duration").text('Date: ' + summary.summary[0].duration);
            $("#status").text('Status: ' + summary.status);
            $("#document").html('Document: ' + 'Download Attachment');
            $("#reason").text('Reason: ' + summary.summary[0].reason);
            $("#leave_type").text(summary.summary[0].leave_type);
            $("#interval").text(summary.summary[0].interval);
            console.log(summary)
            var heads = summary.heads[0];
            $("#department-heads-approval").empty();

            $.each(heads, function(key, value) {
                var status = "";
                var view = "";
                
                if (summary.status != "Approved") {
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
                    }
                }else {

                    status = '<span class="label label-success">Approved</span>';
                    if (value.status != "approved") {
                        status = '<span class="label label-default">closed</span>';

                    }

                    if (value.note)
                            view = "<i class='fa fa-envelope-o'></i> View note";
                }

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

            if (summary.needsApproval) {
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
                                    $.ajax({
                                        type: 'POST',
                                        url: 'leaves-approval/insert',
                                        data: {
                                            _token: token,
                                            leave_id: leave_id,
                                            campus_id: campus_id,
                                            employee_id: employee_id,
                                            status: 'approved'
                                        },
                                        success: function(data) {
                                            console.log(data);
                                            $.alert('Leave Request Approved!');
                                            $("#summary").modal('toggle');
                                            if ($data == "approved") {
                                                row.find('td').eq(4).text(data);
                                            }
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

                                                            $.alert('Leave request declined!');
                                                            row.find('td').eq(4).text('declined');

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
                $("#action-btns").hide();
            }
        }
    })
})

$("#my_leaves").on('click', '.view-my-leave', function() {

    var leave_id = $(this).data('id');
    $.ajax({
        type: 'POST',
        url: 'my-leaves/summary',
        data: {
            _token: token,
            id: leave_id
        },
        success: function(data) {
            var dataset = JSON.parse(data);
            console.log(dataset);
        }
    });
})