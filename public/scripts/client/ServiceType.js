// VARIABLES

// FUNCTIONS
// Save ServiceType
function SaveServiceType(){
    let url = globalLink.replace('link', 'save_service_type');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'post',
        data: frmSaveServiceType.serialize(),
        dataType: 'json',
        beforeSend() {
            btnSaveServiceType.prop('disabled', true);
            btnSaveServiceType.html('Saving...');
            $(".input-error", frmSaveServiceType).text('');
            $(".form-control", frmSaveServiceType).removeClass('is-invalid');
            cnfrmLoading.open();
        },
        success(data){
            btnSaveServiceType.prop('disabled', false);
            btnSaveServiceType.html('Save');
            cnfrmLoading.close();
            $("input[name='description']", frmSaveServiceType).focus();

            if(data['auth'] == 1){
                if(data['result'] == 1){
                    toastr.success('Record Saved!');
                    frmSaveServiceType[0].reset();
                    $(".input-error", frmSaveServiceType).text('');
                    $(".form-control", frmSaveServiceType).removeClass('is-invalid');
                    $("#mdlSaveServiceType").modal('hide');
                    dtServiceTypes.draw();
                }
                else{
                    toastr.error('Saving Failed!');
                    if(data['error'] != null){
                        if(data['error']['description'] != null){
                            $("input[name='description']", frmSaveServiceType).addClass('is-invalid');
                            $("input[name='description']", frmSaveServiceType).siblings('.input-error').text(data['error']['description']);
                        }
                        else{
                            $("input[name='description']", frmSaveServiceType).removeClass('is-invalid');
                            $("input[name='description']", frmSaveServiceType).siblings('.input-error').text('');
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
            btnSaveServiceType.prop('disabled', false);
            btnSaveServiceType.html('Save');
            toastr.error('Saving Failed!');
        }
    });
}

function GetServiceTypeById(serviceTypeId){
    let url = globalLink.replace('link', 'get_service_type_by_id');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'get',
        data: {
            service_type_id: serviceTypeId
        },
        dataType: 'json',
        beforeSend() {
            btnSaveServiceType.prop('disabled', true);
            btnSaveServiceType.html('Saving...');
            $(".input-error", frmSaveServiceType).text('');
            $(".form-control", frmSaveServiceType).removeClass('is-invalid');
            cnfrmLoading.open();
            frmSaveServiceType[0].reset();
            $('input[name="service_type_id"]', frmSaveServiceType).val('');
        },
        success(data){
            btnSaveServiceType.prop('disabled', false);
            btnSaveServiceType.html('Save');
            cnfrmLoading.close();
            $("input[name='description']", frmSaveServiceType).focus();

            if(data['auth'] == 1){
                if(data['service_type_info'] != null){
                    $("#mdlSaveServiceType").modal('show');
                    $('input[name="service_type_id"]', frmSaveServiceType).val(data['service_type_info']['id']);
                    $('select[name="task_type"]', frmSaveServiceType).val(data['service_type_info']['task_type']);
                    $('input[name="description"]', frmSaveServiceType).val(data['service_type_info']['description']);
                    $('select[name="suggested_trt"]', frmSaveServiceType).val(data['service_type_info']['suggested_trt']);
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
            btnSaveServiceType.prop('disabled', false);
            btnSaveServiceType.html('Save');
            toastr.error('An error occured!');
        }
    });
}

function ServiceTypeAction(serviceTypeId, action, status){
    let url = globalLink.replace('link', 'service_type_action');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'post',
        data: {
            _token: _token,
            service_type_id: serviceTypeId,
            action: action,
            status: status,
        },
        dataType: 'json',
        beforeSend() {
            cnfrmLoading.open();
        },
        success(data){
            cnfrmLoading.close();
            dtServiceTypes.draw();

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