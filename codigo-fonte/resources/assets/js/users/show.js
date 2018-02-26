var oTable = configTable();//Seta a configuração do datatables

$(document).ready(function() {
    $(document).on('click', '.pesquisar_form', onSearchForm);
    $(document).on('click', '#limparFiltros',  onResetForm);
    $(document).on('click', '.setarPermissao', setarPermissao);
});

/**
 * Monta config do DataTables
 * @returns {unresolved}
 */
function configTable() {
    return $('#data_table').DataTable({
        dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>" +
             "<'row'<'col-xs-12't>>" +
             "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
        ajax: {
            url: APP.controller_url + '/listarPermissoes',
            data: function (data) {
                data.permissao = $('input[name=permissao]').val();
                data.descricao = $('select[name=descricao]').val();
                data.id_user = $('.id_user').val();
            }
        },
        language: {
            processing: "Carregando"
        },
        processing: true,
        paginate: true,
        columns: [
            {data: 'permissao', name: 'permissao'},
            {data: 'descricao', name: 'descricao'},
            {data: 'acoes', name: 'botoes'}
        ]
    });
}

/**
 * Reseta o formulário de pesquisa
 * @param event Evento
 */
function onResetForm(e) {
    $(this).closest('form')[0].reset();
    $(this).closest('form').find('select').select2();
    oTable.draw();
}

/**
 * Realiza o ajax do datatable em seguida atualiza o datatables da tela
 * @param event Evento
 */
function onSearchForm(e){
    oTable.draw();
}

/**
 * Seta a permissão para o usuário
 * @returns {undefined}
 */
function setarPermissao() {
    var status = $(this).attr('data-rel');
    var permissao_id = $(this).attr('data-rel-id');
    
    var msg = 'Deseja realmente atribuir esta permissão?';
    if (status == 'ativo') {
        msg = 'Deseja realmente remover esta permissão?';
    }
    
    confirmBox(msg, function(retorno) {
        if (retorno) {
            $.ajax({
                url: APP.base_url + '/permissoes/atribuirPermissao',
                data: { 
                    user_id: $('.id_user').val(),
                    permissao_id: permissao_id,
                    status: status
                },
                method: "GET"
            }).done(function(data) {
                createFlashMesseger(data.msg, '#flashMensager', data.success);
                oTable.draw();
            });
        }
    });
}