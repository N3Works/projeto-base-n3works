$(document).ready(function() {
    $('.select2').select2();
    $('.menu-toggler-sidemenu').attr('onclick', 'showMenu()');
    $(document).on('click', '.group-checkable', checkAllCheckboxOnDataTable);
    jqueryMask();  
    $(document).on('click', '#limparFiltros', limparFiltros);
    configDatePicker();
});

/**
 * Função para fazer o sistema mimi
 * @param {integer} delay
 * @returns {undefined}
 */
function sleep(delay) {
    var start = new Date().getTime();
    while (new Date().getTime() < start + delay);
}

/**
 * Função para mostrar o menu
 * @returns {undefined}
 */
function showMenu() {
    if (!$('.page-sidebar-wrapper').is(':visible')) {   
        $('.page-content').removeClass('extra-class');
    } else {
        $('.page-content').addClass('extra-class');
    }
    $('.page-sidebar-wrapper').toggle();
}

/**
 * Class para mascaras dos formulários
 * @returns {undefined}
 */
function jqueryMask() {
    $('.maskDate').mask('00/00/0000');
    $('.maskTime').mask('00:00:00');
    $('.maskDateTime').mask('00/00/0000 00:00:00');
    $('.maskCep').mask('00000-000');
    $('.maskTelefone').mask('(00) 00000-0000');
    $('.maskTelefoneUs').mask('(000) 000-0000');
    $('.maskCpf').mask('000.000.000-00');
    $('.maskCnpj').mask('00.000.000/0000-00');
    $('.maskMoney').mask('000.000.000.000.000,00', {reverse: true});
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
 * Poe todos os checkbox na mesma situção do que tem no header do datatables
 * @returns {undefined}
 */
function checkAllCheckboxOnDataTable() {
    if ($(this).prop('checked')) {
        $('.checkbox-datatables').prop('checked', true);
    } else {
        $('.checkbox-datatables').prop('checked', false);
    }
}

function createFlashMesseger(message, target, success){

   var css = (success) ? 'success' : 'danger';
   var icon = (success) ? 'check' : 'remove';
   
   jQuery(target).append(jQuery.parseHTML(
       '<div class="alert alert-' + css +'">' +
       '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
       '<i class="fa fa-' + icon +'"></i> ' + message +
       '</div>'
   ));
   window.scrollTo(0, 0);
}

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
} );

/**
 * Formata numero em money
 * @param integer c Valor
 * @param string  d Centena
 * @param string  t Decimal
 * @returns {String}
 */
Number.prototype.formatMoney = function(c, d, t){
    var n = this, 
        c = isNaN(c = Math.abs(c)) ? 2 : c, 
        d = d == undefined ? "." : d, 
        t = t == undefined ? "," : t, 
        s = n < 0 ? "-" : "", 
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };
 
 /**
  * Limpa todos os dados do fomulário
  * @returns {undefined}
  */
 function limparFiltros() {
    $(this).closest('form')[0].reset();
    $('.select2').select2();
 }
 
 /**
  * Desformata o valor com mascaras
  * @param {mix} valor
  * @returns {Number}
  */
 function desformatar(valor) {
    var retorno = 0;
    if (typeof valor === 'string') {
        var removeBRFormat  = valor.replace(/[\R$.]/g, '');
        retorno = removeBRFormat.replace(/[\,]/g, '.')*1;
    }
    if (typeof valor === 'number') {
        retorno = valor;
    }

    return retorno;
 }
 
 /**
  * Quebra a data e formata para numerico sem caracteres especiais
  * @param {string} value
  * @returns {dateBrToNumber.brokenDate}
  */
 function dateBrToNumber(value){
    var brokenDate = value.split('/');
    return brokenDate[2]+brokenDate[1]+brokenDate[0];
 }
 
 /**
  * Seta uma configuração padrão para os datepicker
  * @returns {undefined}
  */
 function configDatePicker() {
    $('.date-picker').datepicker({
        format: 'dd/mm/yyyy',
        language: 'pt-BR'
    });
 }
 
 /**
  * Ajusta o confirm para padronizar os botões
  * @param {string} message
  * @param {function} callBackFunction
  * @returns {undefined}
  */
 function confirmBox(message, callBackFunction) {
    bootbox.confirm({
        message: message,
        buttons: {
            confirm: {
                label: 'Sim',
                className: 'btn-success'
            },
            cancel: {
                label: 'Não',
                className: 'btn-danger'
            }
        },
        callback: callBackFunction
    });
 }