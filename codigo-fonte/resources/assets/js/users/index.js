var oTable = configTable();//Seta a configuração do datatables

$(document).ready(function() {
    $(document).on('click', '.destroyTr', destroyTr);
    $('.pesquisar_form').on('click', onSearchForm);
    $('#limparFiltros').on('click', onResetForm);
    $(document).on('click', '.showModalAlterarPerfil', showModalAlterarPerfil);
    $(document).on('change', '.perfil_id', alterarPerfil);
});

/**
 * Destroy o item da modelo
 * @returns {undefined}
 */
function destroyTr() {
    var id = $(this).attr('data-rel');
    
    appUtil.confirmBox('Deseja realmente excluir este Usuário?', function(retorno) {
        if (retorno) {
            $.ajax({
                url: APP.controller_url + '/destroy/'+id
            }).done(function(data) {
                appUtil.createFlashMesseger(data.msg, data.success);
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
        ajax: {
            url: APP.controller_url + '/index',
            data: function (data) {
                data.nome = $('input[name=nome]').val();
                data.cpf = $('input[name=cpf]').val();
                data.email = $('input[name=email]').val();
            }
        },
        columns: [
            {data: 'cpf', name: 'cpf'},
            {data: 'nome', name: 'nome'},
            {data: 'email', name: 'email'},
            {data: 'perfil_id', name: 'perfil_id'},
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

/**
 * Mostra a modal de alterar perfil
 * @returns {undefined}
 */
function showModalAlterarPerfil() {
    var objPerfil = $(this);
    appUtil.confirmBox('Deseja realmente alterar o perfil deste usuário?', function(retorno) {
        if (retorno) {
            $('#modalAlterarPerfil').modal('show');
    
            $('.user_id').val(objPerfil.attr('data-rel-id'));
            $('.perfil_id').val(objPerfil.attr('data-rel-perfil')).select2();
            $('.userName').html(objPerfil.attr('data-rel-nome'));
        }
    });
    
}

/**
 * Altera o perfil do usuário
 * @returns {undefined}
 */
function alterarPerfil() {
    $.ajax({
        url: APP.controller_url + '/alterarPerfil',
        data: { 
            perfil_id: $(this).val(),
            user_id: $('.user_id').val()
        },
        method: "GET"
    }).done(function(data) {
        appUtil.createFlashMesseger(data.message, data.status);
        oTable.draw();
        $('#modalAlterarPerfil').modal('hide');
    });

}