$(document).ready(function() {
    $(document).on('ifChanged', 'input[type=radio]:checked', atualizaValor);
    $(document).on('focusout', '.inputText', atualizaValor);
    $(document).on('focusout', '.inputInteger', atualizaValor);
    $(document).on('change', '.inputDropdown', atualizaValor);
});

/**
 * Atualiza o valor do parâmetro
 * @returns {undefined}
 */
function atualizaValor() {
    var valor = $(this).val();
    var id = $(this).attr('data-rel');
    
    $.ajax({
        url: APP.controller_url + '/alterarValor',
        data: { 
            id: id,
            valor: valor
        },
        method: "GET"
    }).done(function(data) {
        appUtil.createFlashMesseger(data.msg, data.success);
    });
}