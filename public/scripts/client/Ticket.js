// VARIABLES

// FUNCTIONS
// Save Ticket
function SaveTicket(){
    let url = globalLink.replace('link', 'save_ticket');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        data: new FormData($('#frmSaveTicket')[0]),
        dataType: "json",

        beforeSend() {
            btnSaveTicket.prop('disabled', true);
            btnSaveTicket.html('Saving...');
            $(".input-error", frmSaveTicket).text('');
            $(".form-control", frmSaveTicket).removeClass('is-invalid');
            cnfrmLoading.open();
        },
        success(data){
            btnSaveTicket.prop('disabled', false);
            btnSaveTicket.html('Save');
            cnfrmLoading.close();
            $("input[name='subject']", frmSaveTicket).focus();

            if(data['auth'] == 1){
                if(data['result'] == 1){
                    toastr.success('Record Saved!');
                    frmSaveTicket[0].reset();
                    $("#mdlSaveTicket").modal('hide');
                    $(".input-error", frmSaveTicket).text('');
                    $(".form-control", frmSaveTicket).removeClass('is-invalid');
                    dtTickets.draw();
                }
                else{
                    toastr.error('Saving Failed!');
                    if(data['error'] != null){
                        if(data['error']['subject'] != null){
                            $("input[name='subject']", frmSaveTicket).addClass('is-invalid');
                            $("input[name='subject']", frmSaveTicket).siblings('.input-error').text(data['error']['subject']);
                        }
                        else{
                            $("input[name='subject']", frmSaveTicket).removeClass('is-invalid');
                            $("input[name='subject']", frmSaveTicket).siblings('.input-error').text('');
                        }

                        if(data['error']['requests'] != null){
                            $("textarea[name='requests']", frmSaveTicket).addClass('is-invalid');
                            $("textarea[name='requests']", frmSaveTicket).siblings('.input-error').text(data['error']['requests']);
                        }
                        else{
                            $("textarea[name='requests']", frmSaveTicket).removeClass('is-invalid');
                            $("textarea[name='requests']", frmSaveTicket).siblings('.input-error').text('');
                        }
                    }
                }
            }
            else{ // if session expired
                cnfrmAutoLogin.open();
            }
        },
        error(xhr, data, status){
            cnfrmLoading.close();
            btnSaveTicket.prop('disabled', false);
            btnSaveTicket.html('Save');
            toastr.error('Saving Failed!');
        }
    });
}

function GetTicketById(ticketId){
    let url = globalLink.replace('link', 'get_ticket_by_id');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'get',
        data: {
            ticket_id: ticketId
        },
        dataType: 'json',
        beforeSend() {
            btnSaveTicket.prop('disabled', true);
            btnSaveTicket.html('Saving...');
            $(".input-error", frmSaveTicket).text('');
            $(".form-control", frmSaveTicket).removeClass('is-invalid');
            cnfrmLoading.open();
            frmSaveTicket[0].reset();
            $('input[name="ticket_id"]', frmSaveTicket).val('');
        },
        success(data){
            btnSaveTicket.prop('disabled', false);
            btnSaveTicket.html('Save');
            cnfrmLoading.close();
            $("input[name='description']", frmSaveTicket).focus();

            if(data['auth'] == 1){
                if(data['ticket_info'] != null){
                    $("#mdlSaveTicket").modal('show');
                    $('input[name="ticket_id"]', frmSaveTicket).val(data['ticket_info']['id']);
                    $('input[name="description"]', frmSaveTicket).val(data['ticket_info']['description']);
                }
                else{
                    toastr.error('No record found.');
                }
            }
            else{ // if session expired
                cnfrmAutoLogin.open();
            }
        },
        error(xhr, data, status){
            cnfrmLoading.close();
            btnSaveTicket.prop('disabled', false);
            btnSaveTicket.html('Save');
            toastr.error('An error occured!');
        }
    });
}

function GetTicketLogsById(ticketId){
    let url = globalLink.replace('link', 'get_ticket_logs_by_id');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'get',
        data: {
            ticket_id: ticketId
        },
        dataType: 'json',
        beforeSend() {
            cnfrmLoading.open();
        },
        success(data){
            cnfrmLoading.close();
            if(data['auth'] == 1){
                if(data['ticket_logs'].length > 0){
                    cnfrmLoading.close();
                    let result = "";
                    $("#mdlViewTicketLogs").modal('show');
                    for(let index = 0; index < data['ticket_logs'].length; index ++) {
                        result += '<tr>';
                        result += '<td>' + moment(data['ticket_logs'][index]['created_at']).format('MMMM DD, YYYY hh:mm:ss A') + '</td>';
                        result += '<td>' + data['ticket_logs'][index]['description'] + '</td>';
                        result += '</tr>';
                    }

                    $("#tblTicketLogs tbody").html(result);
                    // $('input[name="ticket_id"]', frmSaveTicket).val(data['ticket_info']['id']);
                    // $('input[name="description"]', frmSaveTicket).val(data['ticket_info']['description']);
                }
                else{
                    toastr.warning('No logs found.');
                }
            }
            else{ // if session expired
                cnfrmAutoLogin.open();
            }
        },
        error(xhr, data, status){
            toastr.error('An error occured!');
        }
    });
}

function ViewTicketById(ticketId){
    let url = globalLink.replace('link', 'get_ticket_by_id');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'get',
        data: {
            ticket_id: ticketId
        },
        dataType: 'json',
        beforeSend() {
            // btnSaveTicket.prop('disabled', true);
            // btnSaveTicket.html('Saving...');
            $(".input-error", frmSaveTicket).text('');
            $(".form-control", frmViewTicket).removeClass('is-invalid');
            cnfrmLoading.open();
            $('input[name="ticket_id"]', frmViewTicket).val('');
        },
        success(data){
            // btnSaveTicket.prop('disabled', false);
            // btnSaveTicket.html('Save');
            cnfrmLoading.close();
            $("input[name='description']", frmViewTicket).focus();

            if(data['auth'] == 1){
                if(data['ticket_info'] != null){
                    mdlViewTicket.modal('show');
                    $('input[name="ticket_id"]', frmViewTicket).val(data['ticket_info']['id']);
                    $('input[name="description"]', frmViewTicket).val(data['ticket_info']['description']);
                }
                else{
                    toastr.error('No record found.');
                }
            }
            else{ // if session expired
                cnfrmAutoLogin.open();
            }
        },
        error(xhr, data, status){
            cnfrmLoading.close();
            // btnSaveTicket.prop('disabled', false);
            // btnSaveTicket.html('Save');
            toastr.error('An error occured!');
        }
    });
}

function TicketAction(ticketId, action, status){
    let url = globalLink.replace('link', 'ticket_action');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'post',
        data: {
            _token: _token,
            ticket_id: ticketId,
            action: action,
            status: status,
        },
        dataType: 'json',
        beforeSend() {
            cnfrmLoading.open();
        },
        success(data){
            cnfrmLoading.close();
            dtTickets.draw();

            if(data['auth'] == 1){
                if(data['result'] == 1){
                    toastr.success('Record Saved!');
                }
                else{
                    toastr.error('Saving Failed!');
                }
            }
            else{ // if session expired
                cnfrmAutoLogin.open();
            }
        },
        error(xhr, data, status){
            cnfrmLoading.close();
            toastr.error('An error occured!');
        }
    });
}

function AssignTicket(){
    let url = globalLink.replace('link', 'assign_ticket');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        data: new FormData($('#frmAssignTicket')[0]),
        dataType: "json",

        beforeSend() {
            btnAssignTicket.prop('disabled', true);
            btnAssignTicket.html('Assigning...');
            $(".input-error", frmAssignTicket).text('');
            $(".form-control", frmAssignTicket).removeClass('is-invalid');
            cnfrmLoading.open();
        },
        success(data){
            btnAssignTicket.prop('disabled', false);
            btnAssignTicket.html('Assign');
            cnfrmLoading.close();
            $("input[name='subject']", frmAssignTicket).focus();

            if(data['auth'] == 1){
                if(data['result'] == 1){
                    toastr.success('Record Saved!');
                    $("#frmAssignTicket")[0].reset();
                    $("#mdlAssignTicket").modal('hide');
                    $(".input-error", frmAssignTicket).text('');
                    $(".form-control", frmAssignTicket).removeClass('is-invalid');
                    dtTickets.draw();
                }
                else{
                    toastr.error('Assigning Failed!');
                    if(data['error'] != null){
                        if(data['error']['assignee'] != null){
                            $("assignee[name='assignee']", frmAssignTicket).addClass('is-invalid');
                            $("assignee[name='assignee']", frmAssignTicket).siblings('.input-error').text(data['error']['assignee']);
                        }
                        else{
                            $("assignee[name='assignee']", frmAssignTicket).removeClass('is-invalid');
                            $("assignee[name='assignee']", frmAssignTicket).siblings('.input-error').text('');
                        }
                    }
                }
            }
            else{ // if session expired
                cnfrmAutoLogin.open();
            }
        },
        error(xhr, data, status){
            cnfrmLoading.close();
            btnAssignTicket.prop('disabled', false);
            btnAssignTicket.html('Assign');
            toastr.error('Assign Ticket Failed!');
        }
    });
}

function ReassignTicket(){
    let url = globalLink.replace('link', 'reassign_ticket');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        data: new FormData($('#frmReassignTicket')[0]),
        dataType: "json",

        beforeSend() {
            btnReassignTicket.prop('disabled', true);
            btnReassignTicket.html('Reassigning...');
            $(".input-error", frmReassignTicket).text('');
            $(".form-control", frmReassignTicket).removeClass('is-invalid');
            cnfrmLoading.open();
        },
        success(data){
            btnReassignTicket.prop('disabled', false);
            btnReassignTicket.html('Reassign');
            cnfrmLoading.close();
            // $("input[name='subject']", frmReassignTicket).focus();

            if(data['auth'] == 1){
                if(data['result'] == 1){
                    toastr.success('Record Saved!');
                    $("#frmReassignTicket")[0].reset();
                    $("#mdlReassignTicket").modal('hide');
                    $(".input-error", frmReassignTicket).text('');
                    $(".form-control", frmReassignTicket).removeClass('is-invalid');
                    dtTickets.draw();
                }
                else{
                    toastr.error('Reassigning Failed!');
                    if(data['error'] != null){
                        if(data['error']['assignee'] != null){
                            $("assignee[name='assignee']", frmReassignTicket).addClass('is-invalid');
                            $("assignee[name='assignee']", frmReassignTicket).siblings('.input-error').text(data['error']['assignee']);
                        }
                        else{
                            $("assignee[name='assignee']", frmReassignTicket).removeClass('is-invalid');
                            $("assignee[name='assignee']", frmReassignTicket).siblings('.input-error').text('');
                        }
                    }
                }
            }
            else{ // if session expired
                cnfrmAutoLogin.open();
            }
        },
        error(xhr, data, status){
            cnfrmLoading.close();
            btnAssignTicket.prop('disabled', false);
            btnAssignTicket.html('Reassign');
            toastr.error('Reassign Ticket Failed!');
        }
    });
}

function ForVerificationTicket(){
    let url = globalLink.replace('link', 'for_verification_ticket');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        data: new FormData($('#frmForVerificationTicket')[0]),
        dataType: "json",

        beforeSend() {
            btnForVerificationTicket.prop('disabled', true);
            btnForVerificationTicket.html('Saving...');
            $(".input-error", frmForVerificationTicket).text('');
            $(".form-control", frmForVerificationTicket).removeClass('is-invalid');
            cnfrmLoading.open();
        },
        success(data){
            btnForVerificationTicket.prop('disabled', false);
            btnForVerificationTicket.html('Reassign');
            cnfrmLoading.close();

            if(data['auth'] == 1){
                if(data['result'] == 1){
                    toastr.success('Record Saved!');
                    $("#frmForVerificationTicket")[0].reset();
                    $("#mdlForVerificationTicket").modal('hide');
                    $(".input-error", frmForVerificationTicket).text('');
                    $(".form-control", frmForVerificationTicket).removeClass('is-invalid');
                    dtTickets.draw();
                }
                else{
                    toastr.error('Saving Failed!');
                    if(data['error'] != null){
                        if(data['error']['assignee'] != null){
                            $("assignee[name='assignee']", frmForVerificationTicket).addClass('is-invalid');
                            $("assignee[name='assignee']", frmForVerificationTicket).siblings('.input-error').text(data['error']['assignee']);
                        }
                        else{
                            $("assignee[name='assignee']", frmForVerificationTicket).removeClass('is-invalid');
                            $("assignee[name='assignee']", frmForVerificationTicket).siblings('.input-error').text('');
                        }
                    }
                }
            }
            else{ // if session expired
                cnfrmAutoLogin.open();
            }
        },
        error(xhr, data, status){
            cnfrmLoading.close();
            btnForVerificationTicket.prop('disabled', false);
            btnForVerificationTicket.html('Save');
            toastr.error('Saving Ticket Failed!');
        }
    });
}

function CommentTicket(){
    let url = globalLink.replace('link', 'comment_ticket');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        data: new FormData($('#frmCommentTicket')[0]),
        dataType: "json",

        beforeSend() {
            btnCommentTicket.prop('disabled', true);
            btnCommentTicket.html('Sending...');
            $(".input-error", frmCommentTicket).text('');
            $(".form-control", frmCommentTicket).removeClass('is-invalid');
            cnfrmLoading.open();
        },
        success(data){
            btnCommentTicket.prop('disabled', false);
            btnCommentTicket.html('Send');
            cnfrmLoading.close();

            if(data['auth'] == 1){
                if(data['result'] == 1){
                    toastr.success('Record Saved!');
                    $("#frmCommentTicket")[0].reset();
                    $("#mdlCommentTicket").modal('hide');
                    $(".input-error", frmCommentTicket).text('');
                    $(".form-control", frmCommentTicket).removeClass('is-invalid');
                    $('input[name="ticket_id"]', frmCommentTicket).val($(".txtTicketLogTicketId").val());
                    GetTicketLogsById($(".txtTicketLogTicketId").val());
                }
                else{
                    toastr.error('Sending Comment Failed!');
                    if(data['error'] != null){
                        if(data['error']['comment'] != null){
                            $("textarea[name='comment']", frmCommentTicket).addClass('is-invalid');
                            $("textarea[name='comment']", frmCommentTicket).siblings('.input-error').text(data['error']['comment']);
                        }
                        else{
                            $("textarea[name='comment']", frmCommentTicket).removeClass('is-invalid');
                            $("textarea[name='comment']", frmCommentTicket).siblings('.input-error').text('');
                        }
                    }
                }
            }
            else{ // if session expired
                cnfrmAutoLogin.open();
            }
        },
        error(xhr, data, status){
            cnfrmLoading.close();
            btnAssignTicket.prop('disabled', false);
            btnAssignTicket.html('Send');
            toastr.error('Sending Comment Failed!');
        }
    });
}
