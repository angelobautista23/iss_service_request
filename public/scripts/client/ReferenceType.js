// VARIABLES

// FUNCTIONS
// Save ReferenceType
function SaveReferenceType(){
    let url = globalLink.replace('link', 'save_reference_type');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'post',
        data: frmSaveReferenceType.serialize(),
        dataType: 'json',
        beforeSend() {
            btnSaveReferenceType.prop('disabled', true);
            btnSaveReferenceType.html('Saving...');
            $(".input-error", frmSaveReferenceType).text('');
            $(".form-control", frmSaveReferenceType).removeClass('is-invalid');
            cnfrmLoading.open();
        },
        success(data){
            btnSaveReferenceType.prop('disabled', false);
            btnSaveReferenceType.html('Save');
            cnfrmLoading.close();
            $("input[name='description']", frmSaveReferenceType).focus();

            if(data['auth'] == 1){
                if(data['result'] == 1){
                    toastr.success('Record Saved!');
                    frmSaveReferenceType[0].reset();
                    $(".input-error", frmSaveReferenceType).text('');
                    $(".form-control", frmSaveReferenceType).removeClass('is-invalid');
                    dtReferenceTypes.draw();
                }
                else{
                    toastr.error('Saving Failed!');
                    if(data['error'] != null){
                        if(data['error']['description'] != null){
                            $("input[name='description']", frmSaveReferenceType).addClass('is-invalid');
                            $("input[name='description']", frmSaveReferenceType).siblings('.input-error').text(data['error']['description']);
                        }
                        else{
                            $("input[name='description']", frmSaveReferenceType).removeClass('is-invalid');
                            $("input[name='description']", frmSaveReferenceType).siblings('.input-error').text('');
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
            btnSaveReferenceType.prop('disabled', false);
            btnSaveReferenceType.html('Save');
            toastr.error('Saving Failed!');
        }
    });
}

function GetReferenceTypeById(referenceTypeId){
    let url = globalLink.replace('link', 'get_reference_type_by_id');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'get',
        data: {
            reference_type_id: referenceTypeId
        },
        dataType: 'json',
        beforeSend() {
            btnSaveReferenceType.prop('disabled', true);
            btnSaveReferenceType.html('Saving...');
            $(".input-error", frmSaveReferenceType).text('');
            $(".form-control", frmSaveReferenceType).removeClass('is-invalid');
            cnfrmLoading.open();
            frmSaveReferenceType[0].reset();
            $('input[name="reference_type_id"]', frmSaveReferenceType).val('');
        },
        success(data){
            btnSaveReferenceType.prop('disabled', false);
            btnSaveReferenceType.html('Save');
            cnfrmLoading.close();
            $("input[name='description']", frmSaveReferenceType).focus();

            if(data['auth'] == 1){
                if(data['reference_type_info'] != null){
                    $("#mdlSaveReferenceType").modal('show');
                    $('input[name="reference_type_id"]', frmSaveReferenceType).val(data['reference_type_info']['id']);
                    $('input[name="description"]', frmSaveReferenceType).val(data['reference_type_info']['description']);
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
            btnSaveReferenceType.prop('disabled', false);
            btnSaveReferenceType.html('Save');
            toastr.error('An error occured!');
        }
    });
}

function ReferenceTypeAction(referenceTypeId, action, status){
    let url = globalLink.replace('link', 'reference_type_action');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'post',
        data: {
            _token: _token,
            reference_type_id: referenceTypeId,
            action: action,
            status: status,
        },
        dataType: 'json',
        beforeSend() {
            cnfrmLoading.open();
        },
        success(data){
            cnfrmLoading.close();
            dtReferenceTypes.draw();

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