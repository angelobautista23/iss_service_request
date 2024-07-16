// VARIABLES

// FUNCTIONS
// Save Question
function SaveQuestion(){
    let url = globalLink.replace('link', 'save_question');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'post',
        data: new FormData($("#frmSaveQuestion")[0]),
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend() {
            btnSaveQuestion.prop('disabled', true);
            btnSaveQuestion.html('Saving...');
            $(".input-error", frmSaveQuestion).text('');
            $(".form-control", frmSaveQuestion).removeClass('is-invalid');
            cnfrmLoading.open();
        },
        success(data){
            btnSaveQuestion.prop('disabled', false);
            btnSaveQuestion.html('Save');
            cnfrmLoading.close();
            $("input[name='description']", frmSaveQuestion).focus();

            if(data['auth'] == 1){
                if(data['result'] == 1){
                    toastr.success('Record Saved!');
                    frmSaveQuestion[0].reset();
                    $(".input-error", frmSaveQuestion).text('');
                    $(".form-control", frmSaveQuestion).removeClass('is-invalid');
                    $('#mdlSaveQuestion').modal('hide');
                    dtQuestions.draw();
                }
                else{
                    toastr.error('Saving Failed!');
                    if(data['error'] != null){
                        if(data['error']['description'] != null){
                            $("input[name='description']", frmSaveQuestion).addClass('is-invalid');
                            $("input[name='description']", frmSaveQuestion).siblings('.input-error').text(data['error']['description']);
                        }
                        else{
                            $("input[name='description']", frmSaveQuestion).removeClass('is-invalid');
                            $("input[name='description']", frmSaveQuestion).siblings('.input-error').text('');
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
            btnSaveQuestion.prop('disabled', false);
            btnSaveQuestion.html('Save');
            toastr.error('Saving Failed!');
        }
    });
}

function GetQuestionById(questionId){
    let url = globalLink.replace('link', 'get_question_by_id');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'get',
        data: {
            question_id: questionId
        },
        dataType: 'json',
        beforeSend() {
            btnSaveQuestion.prop('disabled', true);
            btnSaveQuestion.html('Saving...');
            $(".input-error", frmSaveQuestion).text('');
            $(".form-control", frmSaveQuestion).removeClass('is-invalid');
            cnfrmLoading.open();
            frmSaveQuestion[0].reset();
            $('input[name="question_id"]', frmSaveQuestion).val('');
        },
        success(data){
            btnSaveQuestion.prop('disabled', false);
            btnSaveQuestion.html('Save');
            cnfrmLoading.close();
            $("input[name='no']", frmSaveQuestion).focus();

            if(data['auth'] == 1){
                if(data['question_info'] != null){
                    $("#mdlSaveQuestion").modal('show');
                    $('input[name="question_id"]', frmSaveQuestion).val(data['question_info']['id']);
                    $('input[name="questionnaire_id"]', frmSaveQuestion).val(data['question_info']['questionnaire_id']);
                    $('input[name="no"]', frmSaveQuestion).val(data['question_info']['no']);
                    $('input[name="points"]', frmSaveQuestion).val(data['question_info']['points']);
                    $('input[name="description"]', frmSaveQuestion).val(data['question_info']['description']);
                    $('input[name="current_image"]', frmSaveQuestion).val(data['question_info']['image']);
                    $('select[name="section"]', frmSaveQuestion).val(data['question_info']['section']);

                    let imgSrc = globalPublic.replace('path', 'images/image-icon.png');

                    if(data['question_info']['image'] != null) {
                        imgSrc = globalPublic.replace('path', 'storage/question_images/' + data['question_info']['image']);
                    }

                    $('#imgSaveQuestionImage').attr('src', imgSrc);

                    let htmlChoices = "";
                    let choices = JSON.parse(data['question_info']['choices']);
                    for(let index = 0; index < choices.length; index++) {
                        htmlChoices += '<div class="input-group input-group-md mb-3">';
                            htmlChoices += '<div class="input-group-prepend w-20">';
                            if(choices[index]['answer'] == 1) {
                              htmlChoices += '<span class="input-group-text w-100"><input type="checkbox" value="1" class="chkAnswer" checked="true"></span>';
                            }
                            else{
                              htmlChoices += '<span class="input-group-text w-100"><input type="checkbox" value="1" class="chkAnswer"></span>';   
                            }
                            htmlChoices += '</div>';
                            htmlChoices += '<input type="text" class="form-control" name="choices[]" placeholder="Option" required="true" value="' + choices[index]['choice'] + '">';
                            htmlChoices += '<input type="text" class="form-control txtAnswer" name="answer[]" placeholder="Answer" value="' + choices[index]['answer'] + '" required="true" style="display: none;">';
                            if(index > 0) {
                                htmlChoices += '<div class="input-group-append w-20">';
                                  htmlChoices += '<button type="button" class="col-sm-12 btn btn-danger btn-sm btnRemoveChoice" title="Remove"><i class="fa fa-times"></i></button>';
                                htmlChoices += '</div>';
                            }
                          htmlChoices += '</div>';
                    }
                    $('.divChoices').append(htmlChoices);
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
            btnSaveQuestion.prop('disabled', false);
            btnSaveQuestion.html('Save');
            toastr.error('An error occured!');
        }
    });
}

function QuestionAction(questionId, action, status){
    let url = globalLink.replace('link', 'question_action');
    let login = globalLink.replace('link', 'login');

    $.ajax({
        url: url,
        method: 'post',
        data: {
            _token: _token,
            question_id: questionId,
            action: action,
            status: status,
        },
        dataType: 'json',
        beforeSend() {
            cnfrmLoading.open();
        },
        success(data){
            cnfrmLoading.close();
            dtQuestions.draw();

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