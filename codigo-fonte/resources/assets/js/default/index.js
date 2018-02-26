$(document).ready(function() {
   $(document).on('click', '.entrarPlanoAnual', entrarPlanoAnual);
   changeUasg();
   $(document).on('change', '.id_uasg', changeUasg);
});

/**
 * Entra no plano anual vinculado ao plano e à uasg
 * @returns {undefined}
 */
function entrarPlanoAnual() {
    
    var id_plano = $(this).attr('data-rel');
    var id_uasg = $('.id_uasg').val();
    var botaoHtml = $(this).html();
    
    if (!id_uasg) {
        createFlashMesseger('Nenhuma Uasg foi selecionada.', '#flashMensager', false);
        return;
    }
    
    var botao = $(this);
    botao.attr('disabled', 'disabled');
    botao.html('Carregando...');
    
    $.ajax({
        url: APP.controller_url + '/entrarPlanoAnual',
        data: { id_plano_anual: id_plano, id_uasg: id_uasg },
        method: 'GET'
    }).done(function() {
        botao.removeAttr('disabled');
        botao.html(botaoHtml);
        window.location = APP.base_url+'itens/index';
    });
}

/**
 * Aciona quando troca a uasg
 * @returns {undefined}
 */
function changeUasg() {
    var uasg = $('.id_uasg').val();
    
    if (uasg) {
        $('.entrarPlanoAnual').removeAttr('disabled');
    } else {
        $('.entrarPlanoAnual').attr('disabled', 'disabled');
    }
}