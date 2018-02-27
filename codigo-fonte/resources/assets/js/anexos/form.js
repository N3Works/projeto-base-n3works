$(document).ready(function() {
   $('')
   $(document).on('click', '.salvarForm', function() {
       if ($('.anexado_arquivo').val() != 'true') {
           appUtil.createFlashMesseger('Campo anexo é obrigatório.', false);
           return;
       }
       $('form').submit();
   });
});

$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:

    $('#fileupload').fileupload({
        url: APP.controller_url + '/attachupload',
        dataType: 'json',
        add: function(e, data) {
            data.submit();
        },
        done: function (e, data) {
            $('.salvarForm').removeAttr('disabled');
            if(data.result.success) {
                appUtil.createFlashMesseger(data.result.message, true);
                jQuery('#progress .progress-bar').css('width', '0%');
                var fileImput = $('.fileinput-button');
                fileImput.attr('disabled', 'disabled');
                fileImput.find('#fileupload').attr('disabled', 'disabled');
                fileImput.find('i').removeClass('glyphicon-download-alt');
                fileImput.find('i').addClass('glyphicon-ok');
                fileImput.find('span').html('Anexado');
                $('.anexado_arquivo').val('true');
            }
            else {
                appUtil.createFlashMesseger(data.result.message, false);
            }
        },
        
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            
            if (progress <= 20) {
                $('.salvarForm').attr('disabled', 'disabled');
                var fileImput = $('.fileinput-button');
                fileImput.attr('disabled', 'disabled');
                fileImput.find('#fileupload').attr('disabled', 'disabled');
                fileImput.find('i').removeClass('glyphicon-plus');
                fileImput.find('i').addClass('glyphicon-download-alt');
                fileImput.find('span').html('Anexando...');
            }
            
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    });
});