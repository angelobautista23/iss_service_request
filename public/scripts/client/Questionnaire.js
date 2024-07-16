// VARIABLES

// FUNCTIONS
// Save Questionnaire
function SaveQuestionnaire(){
    let url = globalLink.replace('link', 'save_questionnaire');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'post',
        data: frmSaveQuestionnaire.serialize(),
        dataType: 'json',
        beforeSend() {
            btnSaveQuestionnaire.prop('disabled', true);
            btnSaveQuestionnaire.html('Saving...');
            $(".input-error", frmSaveQuestionnaire).text('');
            $(".form-control", frmSaveQuestionnaire).removeClass('is-invalid');
            cnfrmLoading.open();
        },
        success(data){
            btnSaveQuestionnaire.prop('disabled', false);
            btnSaveQuestionnaire.html('Save');
            cnfrmLoading.close();
            $("input[name='description']", frmSaveQuestionnaire).focus();

            if(data['auth'] == 1){
                if(data['result'] == 1){
                    toastr.success('Record Saved!');
                    frmSaveQuestionnaire[0].reset();
                    $(".input-error", frmSaveQuestionnaire).text('');
                    $(".form-control", frmSaveQuestionnaire).removeClass('is-invalid');
                    dtQuestionnaires.draw();
                }
                else{
                    toastr.error('Saving Failed!');
                    if(data['error'] != null){
                        if(data['error']['description'] != null){
                            $("input[name='description']", frmSaveQuestionnaire).addClass('is-invalid');
                            $("input[name='description']", frmSaveQuestionnaire).siblings('.input-error').text(data['error']['description']);
                        }
                        else{
                            $("input[name='description']", frmSaveQuestionnaire).removeClass('is-invalid');
                            $("input[name='description']", frmSaveQuestionnaire).siblings('.input-error').text('');
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
            btnSaveQuestionnaire.prop('disabled', false);
            btnSaveQuestionnaire.html('Save');
            toastr.error('Saving Failed!');
        }
    });
}

function GetQuestionnaireById(questionnaireId){
    let url = globalLink.replace('link', 'get_questionnaire_by_id');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'get',
        data: {
            questionnaire_id: questionnaireId
        },
        dataType: 'json',
        beforeSend() {
            btnSaveQuestionnaire.prop('disabled', true);
            btnSaveQuestionnaire.html('Saving...');
            $(".input-error", frmSaveQuestionnaire).text('');
            $(".form-control", frmSaveQuestionnaire).removeClass('is-invalid');
            cnfrmLoading.open();
            frmSaveQuestionnaire[0].reset();
            $('input[name="questionnaire_id"]', frmSaveQuestionnaire).val('');
        },
        success(data){
            btnSaveQuestionnaire.prop('disabled', false);
            btnSaveQuestionnaire.html('Save');
            cnfrmLoading.close();
            $("input[name='description']", frmSaveQuestionnaire).focus();

            if(data['auth'] == 1){
                if(data['questionnaire_info'] != null){
                    $("#mdlSaveQuestionnaire").modal('show');
                    $('input[name="questionnaire_id"]', frmSaveQuestionnaire).val(data['questionnaire_info']['id']);
                    $('input[name="description"]', frmSaveQuestionnaire).val(data['questionnaire_info']['description']);
                    $('textarea[name="remarks"]', frmSaveQuestionnaire).val(data['questionnaire_info']['remarks']);
                    $('input[name="passing_score"]', frmSaveQuestionnaire).val(data['questionnaire_info']['passing_score']);
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
            btnSaveQuestionnaire.prop('disabled', false);
            btnSaveQuestionnaire.html('Save');
            toastr.error('An error occured!');
        }
    });
}

function QuestionnaireAction(questionnaireId, action, status){
    let url = globalLink.replace('link', 'questionnaire_action');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'post',
        data: {
            _token: _token,
            questionnaire_id: questionnaireId,
            action: action,
            status: status,
        },
        dataType: 'json',
        beforeSend() {
            cnfrmLoading.open();
        },
        success(data){
            cnfrmLoading.close();
            dtQuestionnaires.draw();

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