$(function(){
    // Success: use yii2 modal
    $('#modal-button').click(function(){
        $('#create-bonus-modal').modal('show')
            .find('#modal-content')
            .load($(this).attr('value'))
    })

    // Success: use kartik dialog
    $("#dialog-modal-button").on("click", function () {        
        $('#modal-content').load($(this).attr('value'), function (response, status, xhr) {
            krajeeDialogCust.dialog(
                response,
                function (result) {
                    alert(result);
                }
            );
        })        
    });
})