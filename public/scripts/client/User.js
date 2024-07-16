// VARIABLES

// FUNCTIONS
// Save User
function SaveUser(){
    let url = globalLink.replace('link', 'save_user');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'post',
        data: frmSaveUser.serialize(),
        dataType: 'json',
        beforeSend() {
            btnSaveUser.prop('disabled', true);
            btnSaveUser.html('Saving...');
            $(".input-error", frmSaveUser).text('');
            $(".form-control", frmSaveUser).removeClass('is-invalid');
            cnfrmLoading.open();
        },
        success(data){
            btnSaveUser.prop('disabled', false);
            btnSaveUser.html('Save');
            cnfrmLoading.close();
            $("input[name='description']", frmSaveUser).focus();

            if(data['auth'] == 1){
                if(data['result'] == 1){
                    toastr.success('Record Saved!');
                    frmSaveUser[0].reset();
                    $(".input-error", frmSaveUser).text('');
                    $(".form-control", frmSaveUser).removeClass('is-invalid');
                    dtUsers.draw();
                }
                else{
                    toastr.error('Saving Failed!');
                    if(data['error'] != null){
                        if(data['error']['description'] != null){
                            $("input[name='description']", frmSaveUser).addClass('is-invalid');
                            $("input[name='description']", frmSaveUser).siblings('.input-error').text(data['error']['description']);
                        }
                        else{
                            $("input[name='description']", frmSaveUser).removeClass('is-invalid');
                            $("input[name='description']", frmSaveUser).siblings('.input-error').text('');
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
            btnSaveUser.prop('disabled', false);
            btnSaveUser.html('Save');
            toastr.error('Saving Failed!');
        }
    });
}

function GetUserById(userId){
    let url = globalLink.replace('link', 'get_user_by_id');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'get',
        data: {
            user_id: userId
        },
        dataType: 'json',
        beforeSend() {
            btnSaveUser.prop('disabled', true);
            btnSaveUser.html('Saving...');
            $(".input-error", frmSaveUser).text('');
            $(".form-control", frmSaveUser).removeClass('is-invalid');
            cnfrmLoading.open();
            frmSaveUser[0].reset();
            $('input[name="user_id"]', frmSaveUser).val('');
        },
        success(data){
            btnSaveUser.prop('disabled', false);
            btnSaveUser.html('Save');
            cnfrmLoading.close();
            $("input[name='description']", frmSaveUser).focus();

            if(data['auth'] == 1){
                if(data['user_info'] != null){
                    $("#mdlSaveUser").modal('show');
                    $('input[name="user_id"]', frmSaveUser).val(data['user_info']['id']);
                    $('input[name="description"]', frmSaveUser).val(data['user_info']['description']);
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
            btnSaveUser.prop('disabled', false);
            btnSaveUser.html('Save');
            toastr.error('An error occured!');
        }
    });
}

function UserAction(userId, action, status){
    let url = globalLink.replace('link', 'user_action');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'post',
        data: {
            _token: _token,
            user_id: userId,
            action: action,
            status: status,
        },
        dataType: 'json',
        beforeSend() {
            cnfrmLoading.open();
        },
        success(data){
            cnfrmLoading.close();
            dtUsers.draw();

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

function AssignUser(userId, action, val){
    let url = globalLink.replace('link', 'assign_user');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'post',
        data: {
            _token: _token,
            user_id: userId,
            action: action,
            val: val,
        },
        dataType: 'json',
        beforeSend() {
            cnfrmLoading.open();
        },
        success(data){
            cnfrmLoading.close();
            dtUsers.draw();

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