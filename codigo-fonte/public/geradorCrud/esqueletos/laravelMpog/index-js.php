var oTable = configTable();//Seta a configuração do datatables

$(document).ready(function() {

    $(document).on('click', '.destroyTr', destroyTr);
    $('.pesquisar_form').on('click', onSearchForm);
    $('#limparFiltros').on('click', onResetForm);
    
    $('#data_table_filter').find('select').change(function(e){    
        var table = $('#data_table').DataTable().draw();
    });
});

/**
 * Destroy o item da modelo
 * @returns {undefined}
 */
function destroyTr() {
    var id = $(this).attr('data-rel');
    
    appUtil.confirmBox('Deseja realmente excluir este <?php echo $this->dados_modelo['tabela']['nome_singular']; ?>?', function(retorno) {
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
 * Monta config do DataTables
 * @returns {unresolved}
 */
function configTable() {
    return $('#data_table').DataTable({
        ajax: {
            url: APP.controller_url + '/index',
            data: function (data) {
                
                $.each($('.search_form').serializeArray(), function(index, obj){
                    data[obj.name] = obj.value;
                });
            }
        },
        columns: [
<?php
        foreach ($this->dados_modelo['tabela']['dados'] as $coluna) {
            if ($coluna['mostrar_listagem']) {
                if(!in_array($coluna['nome_coluna'], array('created_at', 'updated_at', 'deleted_at'))) {
?>        
            {data:'<?php print $coluna['nome_coluna']; ?>', name:'<?php print $coluna['nome_coluna']; ?>', className:'text-left'},
<?php
                }
            }
        }
?>
            {data:'acoes', name:'botoes', className:'text-center'}
        ]
    });
}