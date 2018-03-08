$(document).ready(function() {
//    $(document).on('click', '.menu-toggler', showMenuToggler);
    $(document).on('click', '.menu-toggler-sidemenu', showMenuToggler);
    $(document).on('change', '.maskTelefone', ajustarTelefone);
    
    $('.password_strength').pwstrength({
        raisePower: 1.4,
        minChar: 8,
        verdicts: ["Weak","Normal","Medium","Strong","Very Strong"],
        scores: [17,26,40,50,60],
        ui: { showVerdictsInsideProgressBar: true }
    });
    
    $(document).on('change', '.password_strength', strongPassword);
    
    /**
     * Configuração base dos plugins
     */
    jqueryMask();
    numericTouchSpin();
    datePicker();
    dateTimePicker();
    inputMaxLength();
    dropDownSelect2();
    
    jQuery.datetimepicker.setLocale('pt');
});

/**
 * Configura o plugin pwstrength
 */
function strongPassword() {
    $(this).pwstrength("addRule", "testRule", function (options, word, score) {
        return word.match(/[a-z].[0-9]/) && score;
    }, 10, true);
}

/**
 * Configuração padrão do select2
 */
function dropDownSelect2() {
    $('.select2').select2();
}

/**
 * Configuração padrão do MaxLength
 */
function inputMaxLength() {
    $('input[maxlength]').maxlength({
        threshold: 15,
        placement: 'top-left',
        warningClass: "label label-success",
        limitReachedClass: "label label-danger"
    });
}

/**
 * Configuração padrão do datePicker
 * @returns {undefined}
 */
function datePicker() {
    $('.date-picker').datetimepicker({
        format: 'd/m/Y',
        timepicker: false
    });
}

/**
 * Configuração padrão do dateTimePicker
 * @returns {undefined}
 */
function dateTimePicker() {
    $('.datetime-picker').datetimepicker({
        format:'d/m/Y h:m:s'
    });
}

/**
 * Configuração padrão do TouchSpin
 * @returns {undefined}
 */
function numericTouchSpin() {
    $(".numeric-input-porcent").TouchSpin({
        min: 0,
        max: 100,
        step: 0.1,
        decimals: 2,
        boostat: 5,
        maxboostedstep: 10,
        postfix: '%'
    });
    
    $(".numeric-input").TouchSpin({
        min: 0,
        max: 9999999999
    });
}

/**
 * Configuração basica do datatables
 */
$.extend( true, $.fn.dataTable.defaults, {
    dom: "<'row'<'col-xs-12'<'col-xs-12 text-right'l><'col-xs-6'>>r>" +
         "<'row'<'col-xs-12't>>" +
         "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
    serverSide: true,
    searching: false,
    ordering: false,
    language: {
        processing: "Carregando"
    },
    processing: true,
    paging: true,
    pageLength: APP.resultados_datatable,
    drawCallback: function() {
        $('.popovers').popover();
    },
    language: { url: "/template/global/scripts/Portuguese-Brasil.json" }
});

/**
 * Class para mascaras dos formulários
 * @returns {undefined}
 */
function jqueryMask() {
    $('.maskDate').mask('00/00/0000');
    $('.maskTime').mask('00:00:00');
    $('.maskDateTime').mask('00/00/0000 00:00:00');
    $('.maskCep').mask('00000-000');
    $('.maskTelefone').mask('(00) 000000000');
    $('.maskTelefoneUs').mask('(000) 000-0000');
    $('.maskCpf').mask('000.000.000-00');
    $('.maskCnpj').mask('00.000.000/0000-00');
    $('.maskMoney').mask('000.000.000.000.000,00', {reverse: true});
    $('.maskNumber').mask('000.000.000.000.000', {reverse: true});
    $('.maskPercent').mask('##0,00%', {reverse: true});
    $('.maskIpAdress').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
        translation: {
            'Z': {
                pattern: /[0-9]/, optional: true
            }
        }
    });
}

/**
 * Calculador de total para todos os registros do datatables
 */
$.fn.dataTable.Api.register( 'sum()', function ( ) {
    return this.flatten().reduce( function ( a, b ) {
        if ( typeof a === 'string' ) {
            a = a.replace(/[^\d.-]/g, '') * 1;
        }
        if ( typeof b === 'string' ) {
            b = b.replace(/[^\d.-]/g, '') * 1;
        }

        return a + b;
    }, 0 );
});

/**
 * Função para mostrar o menu
 * @returns {undefined}
 */
function showMenuToggler() {
    if (!$('.page-sidebar-wrapper').is(':visible')) {   
        $('.page-content').removeClass('extra-class');
        $('.page-sidebar-wrapper').show();
    } else {
        $('.page-content').addClass('extra-class');
        $('.page-sidebar-wrapper').hide();
    }
}

/**
 * Ajusta o formato do telefone
 */
function ajustarTelefone(){
    String.prototype.InsertAt=function(CharToInsert,Position){
        return this.slice(0,Position) + CharToInsert + this.slice(Position);
    }
    
    var phone = $(this).val();
    var type_format = phone.length;

    if (type_format == 14) {
        $(this).val(phone.InsertAt('-',10));
    } else if (type_format == 13) {
        $(this).val(phone.InsertAt('-',9));
    }
}
