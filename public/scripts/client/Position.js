// VARIABLES

// FUNCTIONS
// Save Position
function SavePosition(){
    let url = globalLink.replace('link', 'save_position');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'post',
        data: frmSavePosition.serialize(),
        dataType: 'json',
        beforeSend() {
            btnSavePosition.prop('disabled', true);
            btnSavePosition.html('Saving...');
            $(".input-error", frmSavePosition).text('');
            $(".form-control", frmSavePosition).removeClass('is-invalid');
            cnfrmLoading.open();
        },
        success(data){
            btnSavePosition.prop('disabled', false);
            btnSavePosition.html('Save');
            cnfrmLoading.close();
            $("input[name='description']", frmSavePosition).focus();

            if(data['auth'] == 1){
                if(data['result'] == 1){
                    toastr.success('Record Saved!');
                    frmSavePosition[0].reset();
                    $('#mdlSavePosition').modal('hide');
                    $(".input-error", frmSavePosition).text('');
                    $(".form-control", frmSavePosition).removeClass('is-invalid');
                    dtPositions.draw();
                }
                else{
                    toastr.error('Saving Failed!');
                    if(data['error'] != null){
                        if(data['error']['description'] != null){
                            $("input[name='description']", frmSavePosition).addClass('is-invalid');
                            $("input[name='description']", frmSavePosition).siblings('.input-error').text(data['error']['description']);
                        }
                        else{
                            $("input[name='description']", frmSavePosition).removeClass('is-invalid');
                            $("input[name='description']", frmSavePosition).siblings('.input-error').text('');
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
            btnSavePosition.prop('disabled', false);
            btnSavePosition.html('Save');
            toastr.error('Saving Failed!');
        }
    });
}

function GetPositionById(positionId){
    let url = globalLink.replace('link', 'get_position_by_id');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'get',
        data: {
            position_id: positionId
        },
        dataType: 'json',
        beforeSend() {
            btnSavePosition.prop('disabled', true);
            btnSavePosition.html('Saving...');
            $(".input-error", frmSavePosition).text('');
            $(".form-control", frmSavePosition).removeClass('is-invalid');
            cnfrmLoading.open();
            frmSavePosition[0].reset();
            $('input[name="position_id"]', frmSavePosition).val('');
        },
        success(data){
            btnSavePosition.prop('disabled', false);
            btnSavePosition.html('Save');
            cnfrmLoading.close();
            $("input[name='description']", frmSavePosition).focus();

            if(data['auth'] == 1){
                if(data['position_info'] != null){
                    $("#mdlSavePosition").modal('show');
                    $('input[name="position_id"]', frmSavePosition).val(data['position_info']['id']);
                    $('input[name="description"]', frmSavePosition).val(data['position_info']['description']);
                    $('select[name="type"]', frmSavePosition).val(data['position_info']['type']);
                    $('select[name="questionnaire_id"]', frmSavePosition).html('<option value="' + data['position_info']['q_id'] + '">' + data['position_info']['q_description'] + '</option>').val(data['position_info']['q_id']).trigger('change');

                    let shuffle = data['position_info']['shuffle'].split(',');
                    for(let index = 0; index < shuffle.length; index++) {
                        $('select[name="shuffle_' + (index + 1) + '"]', frmSavePosition).val(shuffle[index]);
                    }

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
            btnSavePosition.prop('disabled', false);
            btnSavePosition.html('Save');
            toastr.error('An error occured!');
        }
    });
}

function PositionAction(positionId, action, status){
    let url = globalLink.replace('link', 'position_action');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'post',
        data: {
            _token: _token,
            position_id: positionId,
            action: action,
            status: status,
        },
        dataType: 'json',
        beforeSend() {
            cnfrmLoading.open();
        },
        success(data){
            cnfrmLoading.close();
            dtPositions.draw();

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