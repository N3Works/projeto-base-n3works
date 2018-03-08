var oTable = configTable();//Seta a configuração do datatables
var permissaoAtiva = '<a href="javascript:void(0)" class="permissao" data-rel="ativo" data-rel-id=""><i class="fa fa-check-square fa-2x"></i></a>';
var permissaoInativa = '<a href="javascript:void(0)" class="permissao" data-rel="inativo" data-rel-id=""><i class="fa fa-square fa-2x"></i></a>';

$(document).ready(function() {
    $(document).on('click', '.permissao', selecionarPermissao);
    $(document).on('click', '.pesquisar_form', onSearchForm);
    $(document).on('click', '#limparFiltros',  onResetForm);
    $(document).on('click', '.salvarPermissoes', salvarPermissoes);
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
 * Seleciona a nova permissao
 * @returns {undefined}
 */
function selecionarPermissao() {
    var id = $(this).attr('data-rel-id');
    var situacao = $(this).attr('data-rel');
    var father = $(this).parent();
    $(this).remove();
    father.append((situacao == 'ativo' ? permissaoInativa : permissaoAtiva));
    father.find('.permissao').attr('data-rel-id', id);
}

/**
 * Seta a permissão para o usuário
 * @returns {undefined}
 */
function salvarPermissoes() {
    var permissoes = [];
    permissoes.ids = new Array();
    permissoes.permissoes = new Array();
    
    $('.permissao').each(function() {
        permissoes.ids.push($(this).attr('data-rel-id'));
        permissoes.permissoes.push($(this).attr('data-rel'));
    });
    
    appUtil.confirmBox('Deseja realmente atualizar as permissões?', function(retorno) {
        if (retorno) {
            $.ajax({
                url: APP.base_url + '/permissoes/salvarPermissoes',
                data: { 
                    perfil_id: $('.perfil_id').val(),
                    permissoes_ids: permissoes.ids,
                    permissoes: permissoes.permissoes
                },
                method: "GET"
            }).done(function(data) {
                appUtil.createFlashMesseger(data.msg, data.success);
                oTable.draw();
            });
        }
    });
}