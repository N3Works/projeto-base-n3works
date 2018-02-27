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
        ajax: {
            url: APP.controller_url + '/listarPermissoes',
            data: function (data) {
                data.permissao = $('input[name=permissao]').val();
                data.descricao = $('select[name=descricao]').val();
                data.perfil_id = $('.perfil_id').val();
            }
        },
        "drawCallback": function ( settings ) {
            var api  = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last = null;
 
            api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                var groupBroken = group.split('_');
                group = groupBroken[0];
                
                if ( last !== group ) {
                    
                    $(rows).eq( i ).before(
                        '<tr class="group-tr-datatable"><td colspan="5">'+group+'</td></tr>'
                    );
 
                    last = group;
                }
            } );
        },
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
    
    appUtil.confirmBox(msg, function(retorno) {
        if (retorno) {
            $.ajax({
                url: APP.base_url + '/permissoes/atribuirPermissao',
                data: { 
                    perfil_id: $('.perfil_id').val(),
                    permissao_id: permissao_id,
                    status: status
                },
                method: "GET"
            }).done(function(data) {
                appUtil.createFlashMesseger(data.msg, data.success);
                oTable.draw();
            });
        }
    });
}