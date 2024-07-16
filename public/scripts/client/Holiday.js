// VARIABLES

// FUNCTIONS
// Save Holiday
function SaveHoliday(){
    let url = globalLink.replace('link', 'save_holiday');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'post',
        data: frmSaveHoliday.serialize(),
        dataType: 'json',
        beforeSend() {
            btnSaveHoliday.prop('disabled', true);
            btnSaveHoliday.html('Saving...');
            $(".input-error", frmSaveHoliday).text('');
            $(".form-control", frmSaveHoliday).removeClass('is-invalid');
            cnfrmLoading.open();
        },
        success(data){
            btnSaveHoliday.prop('disabled', false);
            btnSaveHoliday.html('Save');
            cnfrmLoading.close();
            $("input[name='date']", frmSaveHoliday).focus();

            if(data['auth'] == 1){
                if(data['result'] == 1){
                    toastr.success('Record Saved!');
                    frmSaveHoliday[0].reset();
                    $(".input-error", frmSaveHoliday).text('');
                    $(".form-control", frmSaveHoliday).removeClass('is-invalid');
                    dtHolidays.draw();
                }
                else{
                    toastr.error('Saving Failed!');
                    if(data['error'] != null){
                        if(data['error']['date'] != null){
                            $("input[name='date']", frmSaveHoliday).addClass('is-invalid');
                            $("input[name='date']", frmSaveHoliday).siblings('.input-error').text(data['error']['date']);
                        }
                        else{
                            $("input[name='date']", frmSaveHoliday).removeClass('is-invalid');
                            $("input[name='date']", frmSaveHoliday).siblings('.input-error').text('');
                        }

                        if(data['error']['description'] != null){
                            $("input[name='description']", frmSaveHoliday).addClass('is-invalid');
                            $("input[name='description']", frmSaveHoliday).siblings('.input-error').text(data['error']['description']);
                        }
                        else{
                            $("input[name='description']", frmSaveHoliday).removeClass('is-invalid');
                            $("input[name='description']", frmSaveHoliday).siblings('.input-error').text('');
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
            btnSaveHoliday.prop('disabled', false);
            btnSaveHoliday.html('Save');
            toastr.error('Saving Failed!');
        }
    });
}

function GetHolidayById(holidayId){
    let url = globalLink.replace('link', 'get_holiday_by_id');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'get',
        data: {
            holiday_id: holidayId
        },
        dataType: 'json',
        beforeSend() {
            btnSaveHoliday.prop('disabled', true);
            btnSaveHoliday.html('Saving...');
            $(".input-error", frmSaveHoliday).text('');
            $(".form-control", frmSaveHoliday).removeClass('is-invalid');
            cnfrmLoading.open();
            frmSaveHoliday[0].reset();
            $('input[name="holiday_id"]', frmSaveHoliday).val('');
        },
        success(data){
            btnSaveHoliday.prop('disabled', false);
            btnSaveHoliday.html('Save');
            cnfrmLoading.close();
            $("input[name='date']", frmSaveHoliday).focus();

            if(data['auth'] == 1){
                if(data['holiday_info'] != null){
                    $("#mdlSaveHoliday").modal('show');
                    $('input[name="holiday_id"]', frmSaveHoliday).val(data['holiday_info']['id']);
                    $('input[name="description"]', frmSaveHoliday).val(data['holiday_info']['description']);
                    $('input[name="date"]', frmSaveHoliday).val(data['holiday_info']['date']);
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
            btnSaveHoliday.prop('disabled', false);
            btnSaveHoliday.html('Save');
            toastr.error('An error occured!');
        }
    });
}

function HolidayAction(holidayId, action, status){
    let url = globalLink.replace('link', 'holiday_action');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'post',
        data: {
            _token: _token,
            holiday_id: holidayId,
            action: action,
            status: status,
        },
        dataType: 'json',
        beforeSend() {
            cnfrmLoading.open();
        },
        success(data){
            cnfrmLoading.close();
            dtHolidays.draw();

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