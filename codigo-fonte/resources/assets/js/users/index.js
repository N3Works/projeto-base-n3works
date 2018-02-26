var oTable = configTable();//Seta a configuração do datatables

$(document).ready(function() {
    $(document).on('click', '.destroyTr', destroyTr);
    $('.pesquisar_form').on('click', onSearchForm);
    $('#limparFiltros').on('click', onResetForm);
});

/**
 * Destroy o item da modelo
 * @returns {undefined}
 */
function destroyTr() {
    var id = $(this).attr('data-rel');
    
    confirmBox('Deseja realmente excluir este Usuário?', function(retorno) {
        if (retorno) {
            $.ajax({
                url: APP.controller_url + '/destroy/'+id
            }).done(function(data) {
                createFlashMesseger(data.msg, '#flashMensager', data.success);
                oTable.draw();
            });
        } 
     });
}

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
            url: APP.controller_url + '/index',
            data: function (data) {
                data.nome = $('input[name=nome]').val();
                data.cpf = $('input[name=cpf]').val();
                data.email = $('select[name=email]').val();
            }
        },
        language: {
            processing: "Carregando"
        },
        processing: true,
        columns: [
            {data: 'cpf', name: 'cpf'},
            {data: 'nome', name: 'nome'},
            {data: 'email', name: 'email'},
            {data: 'created_at', name: 'created_at'},
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