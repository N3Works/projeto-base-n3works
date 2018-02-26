var oTable = configTable();//Seta a configuração do datatables

$(document).ready(function() {
    $(document).on('click', '.destroyTr', destroyTr);
});

/**
 * Destroy o item da modelo
 * @returns {undefined}
 */
function destroyTr() {
    var id = $(this).attr('data-rel');
    
    confirmBox('Deseja realmente excluir este Fake?', function(retorno) {
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
            url: APP.controller_url + '/index'
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'data', name: 'data'},
            {data: 'valor', name: 'valor'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'acoes', name: 'botoes'}
        ]
    });
}