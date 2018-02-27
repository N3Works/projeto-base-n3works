var oTable = configTable();//Seta a configuração do datatables

$(document).ready(function() {
    $(document).on('click', '.destroyTr', destroyTr);
    initGridRemoteStoreform();
});

/**
 * Destroy o item da modelo
 * @returns {undefined}
 */
function destroyTr() {
    var id = $(this).attr('data-rel');

    appUtil.confirmBox('Deseja realmente excluir este Anexo?', function(retorno) {
        if (retorno) {
            $.ajax({
                url: APP.controller_url + '/destroy/'+id
            }).done(function(data) {
                appUtil.createFlashMesseger(data.msg, '#flashMensager', data.success);
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
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'acoes', name: 'botoes'}
        ]
    });
}

function initGridRemoteStoreform(){

    jQuery("#pb-attach-table").DataTable({

        "ajax":APP.controller_url + '/attachlist',
        "ordering": false,
        "bFilter" : false,
        "bPaginate": false,
        "processing": true,
        "serverSide": true,
        "order": [],
        "language": {
            processing:"Carregando",
            "emptyTable": "Nenhum anexo foi adicionado",
            "sInfo": "",
            zeroRecords:"Nenhum anexo foi adicionado"
        },
        "columnDefs": [
            {
                "targets":  -1,
                "render": function ( value, type, data ) {
                    //data[3] ID do objeto
                    return '<a href="javascript:;" data-action="remove" data-storage="'+ data[6] +'" class="btn btn-danger btn-sm btn-outline sbold uppercase">' +
                        '<i class="fa fa-remove"></i>' +
                        '</a>' +
                        '<a href="javascript:;"" data-action="download" data-storage="'+ data[6] +'" class="btn btn-success btn-sm btn-outline sbold uppercase">' +
                        '<i class="fa fa-download"></i>' +
                        '</a>';
                }
            }

        ]
    });

    jQuery("#pb-attach-table").delegate('a[data-action=remove]', 'click', function(e){

        var filename = jQuery(this).parents('tr:first').find('td').first().text();
        
        var objtRemover = $(this);

        appUtil.confirmBox('Deseja excluir o arquivo "' + filename + '" ?', function( retorno ) {
            if (retorno) {
                jQuery.ajax({
                    type:"POST",
                    url:APP.controller_url + '/attachdelete',
                    dataType:"json",
                    data:{
                        'id':objtRemover.attr('data-storage')
                    },
                    headers: {
                        'X-CSRF-TOKEN':APP.token
                    }
                }).done(function(data, textStatus, jqXHR ){

                    if(textStatus === 'success') {

                        if(data.success) {
                            // mensagem de remover a row
                            // atualizar a grade
                            appUtil.createFlashMesseger(data.message, true);
                            jQuery("#pb-attach-table").DataTable().ajax.reload();
                        }
                        else {

                            appUtil.createFlashMesseger(data.message, false);
                        }
                    }
                });
            } 
        });
    });

    jQuery("#pb-attach-table").delegate('a[data-action=download]', 'click', function(e){
        window.location = APP.controller_url + '/attachdownload?id=' + jQuery(this).attr('data-storage');
    });
}