$(document).ready(function() {
    atualizarSelect2();
    
    $('#Gerador_framework').trigger('change'); //Mandar dar trigger para carregar o layout.
    
    $(document).on('change', '.select-dropdownlist', selectDropdownList);
    $(document).on('change', '.selectTipoDeInput', selecionandoTipoDeInput);
    $(document).on('change', '#Gerador_framework', atualizaLayoutPorFramework);
    $(document).on('change', '#Gerador_gerarModel', atualizarGerarModel);
    $(document).on('change', '#Gerador_nomeTabela', mostrarBotoesModel).trigger('change');
    
    $(document).on('click', '.removerOption', removerOption);
    $(document).on('click', '.adicionarOption', adicionarOption);
    $(document).on('click', '.finalizarCadastroDropdown', finalizarCadastroDropdown);
    $(document).on('click', '.criarNovoDropdown', criarNovoDropdown);
    $(document).on('click', '#gerador', gerarCrud);
    $(document).on('click', '.addDropDown', addDropDown);
    $(document).on('click', '.ajustarLabels', function() {
        showModalLabels(true);
    });
});

/**
 * Antes de gerar o crud
 * @returns {undefined}
 */
function gerarCrud() {
    
    //Realiza a validação dos campos obrigatórios.
    if (verificarObrigatorios()) {
        $('.alert-danger').toggle();
    } else {
        if (confirm('Gerar Crud do modelo ' + $('#Gerador_nomeTabela').val())) {
            $(this).closest('form').submit();
        }
    }
}

/**
 * Realiza a atualização do select2
 * @returns {undefined}
 */
function atualizarSelect2() {
    $('.select2').select2({
        width: '100%'
    });
}

/**
 * Verifica os campos obrigatórios
 * @returns {undefined}
 */
function verificarObrigatorios() {
    var error = false;
    
    $('.selec2').removeClass('has-error');
    $('#entidadePlural').closest('.form-group').removeClass('has-error');
    $('#entidadeSingular').closest('.form-group').removeClass('has-error');
    
    if ($('#Gerador_nomeTabela').val().trim() == "") {
        $('.select2').addClass('has-error');
        error = true;
    }
    
    if ($('#entidadePlural').val().trim() == "") {
        $('#entidadePlural').closest('.form-group').addClass('has-error');
        error = true;
    }
    
    if ($('#entidadeSingular').val().trim() == "") {
        $('#entidadeSingular').closest('.form-group').addClass('has-error');
        error = true;
    }
    
    return error;
}

/**
 * Mostra os botões do modelo caso tenha algum selecionado
 * @returns {undefined}
 */
function mostrarBotoesModel() {
    if ($(this).val()) {
        showModalLabels(false);
        $('.ajustarLabels').show();
    } else {
        $('.ajustarLabels').hide();
    }
}

/**
 * Mostrar a modal de ajuste dos labels
 * @returns {undefined}
 */
function showModalLabels(show) {
    $.ajax({
        url: 'classes/requisicoes/buscarColunasAjax.php',
        data: { nome_tabela: $('#Gerador_nomeTabela').val() },
        method: "GET",
        dataType: "json"
    }).done(function(data) {
        if (show) {
            $('#modalLabels').modal('show');
        } else {
            var html = '';
            var nome_coluna = '';
            var colunas = new Array();
            
            for (var i in data) {
                var temEspecificacao = true;
                var showDropdownlist = true;
                colunas.push(data[i].nome_coluna);
                nome_coluna = recomendacaoLabel(data[i].nome_coluna);
                
                if (data[i].tipo_coluna == 'date' || data[i].tipo_coluna == 'dateTime') {
                    temEspecificacao = false;
                    showDropdownlist = false;
                }
                
                html += '<div class="row">';
                html += '<div class="row-unique">';
                
                html += '    <div class="col-md-2 col-sm-2 form-group text-right">';
                html += '      <label>'+data[i].nome_coluna+':</label>';
                html += '    </div>';
                
                html += '    <div class="col-md-4 col-sm-4 form-group">';
                html += '        <input type="text" class="form-control" name="Labels['+data[i].nome_coluna+']" value="'+nome_coluna+'" data-rel="'+data[i].nome_coluna+'">';
                html += '    </div>';
                
                html += '    <div class="col-md-1 col-sm-1 form-group">';
                html += '        <label style="margin-top: 6px;" data-toggle="tooltip" data-placement="top" title="Mostrar na listagem."><input type="checkbox" checked="checked" name="LabelsOptions[mostrarListagem]['+data[i].nome_coluna+']" value="1"> <i class="fa fa-list"></i></label>';
                html += '    </div>';
                
                html += '    <div class="col-md-1 col-sm-1 form-group">';
                html += '        <label style="margin-top: 6px;" data-toggle="tooltip" data-placement="top" title="Campo Obrigatório."><input type="checkbox" '+ ( data[i].obrigatorio ? 'checked="checked"' : '' ) +' name="LabelsOptions[campoObrigatorio]['+data[i].nome_coluna+']" value="1"><i class="fa fa-asterisk"></i></label>';
                html += '    </div>';
                
                html += '    <div class="col-md-1 col-sm-1 form-group">';
                html += '    <div class="dropdownlist_div" '+(showDropdownlist ? '' : 'style="display: none;"')+'>';
                html += '        <input type="hidden" name="LabelsOptions[campoDropdownName]['+data[i].nome_coluna+']" class="campoDropdownName_'+data[i].nome_coluna+'" value="" >';
                html += '        <label style="margin-top: 6px; cursor:pointer;" data-toggle="tooltip" data-placement="top" title="Inserir DropDown no lugar do inputText." ><small href="javascript:void(0)" class="addDropDown" data-rel="'+data[i].nome_coluna+'"><i class="fa fa-plus"></i>List</small></label>';
                html += '    </div>';
                html += '    </div>';
                
                if (data[i].colunas_relacao.length > 0) {
                    temEspecificacao = false;
                    var relacao = data[i].colunas_relacao;
                    
                    html += '<div class="col-md-3 col-sm-3 input-group" data-toggle="tooltip" data-placement="top" title="Coluna que irá aparecer no dropdown da relação nas telas." >';
                    html += '    <span class="input-group-addon"><i class="fa fa-list"></i></span>';
                    html += '    <select name="LabelsOptions[ColunaRelacao]['+data[i].nome_coluna+']" class="select2 form-control">';

                    for (var i in relacao) {
                        html += '<option value="' + relacao[i].COLUMN_NAME + '">'+ relacao[i].COLUMN_NAME +'</option>';
                    }
                    html += '    </select>';   
                    html += '</div>';
                }
                
                if (temEspecificacao) {
                    html += '<div class="col-md-3 col-sm-3 input-group" data-toggle="tooltip" data-placement="top" title="Tipo da formatação." >';
                    html += '    <span class="input-group-addon"><i class="fa fa-cog"></i></span>';
                    html += '    <select name="LabelsOptions[tipoDeInput]['+data[i].nome_coluna+']" class="select2 selectTipoDeInput form-control">';
                    html += '        <option value="">Sem Formatação</option>';
                    html += '        <option value="telefone">Telefone</option>';
                    html += '        <option value="cpf">CPF</option>';
                    html += '        <option value="cnpj">CNPJ</option>';
                    html += '        <option value="cep">CEP</option>';
                    html += '        <option value="telefone">Telefone</option>';
                    html += '        <option value="porcentual">Porcentagem</option>';
//                    html += '        <option value="money">Preço (R$)</option>';
                    html += '        <option value="dateTime">Data + Tempo</option>';
                    html += '        <option value="ipAddress">Endereço de IP</option>';
                    html += '        <option value="situacao">Ativo / Inativo</option>';
                    html += '    </select>';
                    html += '</div>';
                    
                }
                
                html += '    </div>';
                html += '</div>';
                html += '</div>';
            }
            
            $('.listagemDeLabels').html(html);
            atualizarSelect2();
        }
    });
    
}

/**
 * Recomendações para labels padrões
 * @param {string} coluna
 * @returns {String}
 */
function recomendacaoLabel(coluna) {
    var retorno = '';
    switch (coluna) {
        case 'nome':
        case 'name':
            retorno = 'Nome';
            break;
        case 'id':
            retorno = 'ID';
            break;
        case 'created_at':
            retorno = 'Data de criação';
            break;
        case 'updated_at':
            retorno = 'Data de atualização';
            break;
        case 'descricao':
            retorno = 'Descrição';
            break;
        case 'situacao':
            retorno = 'Situação';
            break;

        default:
            retorno = coluna;
            break;
    }
    return retorno;
}

/**
 * Habilita/Desabilita novas opções no gerador
 */
function atualizaLayoutPorFramework() {
    ajustarConfig('adicionais_laravelMpog', false);
    
    switch (this.value) {
        case 'laravelMpog':
            ajustarConfig('adicionais_laravelMpog', true);
            break;
    }
}

/**
 * Atualiza os checkbox filhos do Model, para desmarcalos
 */
function atualizarGerarModel() {
    var selectors = ['input[name=model_timestamps]', 'input[name=model_softdelete]'];
    if(!$(this).is(':checked')){
        $.each(selectors, function(key, selector){
            $(selector).prop('checked', false);
        });
    }  
}

/**
 * Ajusta a div das configurações e desabilita caso esconda.
 * @param string classe
 * @param boolean mostrar
 */
function ajustarConfig(classe, mostrar) {
    if (mostrar) {
        $('.'+classe).show();
        $('.'+classe+'_input').each(function() {
           $(this).removeAttr('disabled'); 
        });
    } else {
        $('.'+classe).hide();
        $('.'+classe+'_input').each(function() {
           $(this).attr('disabled', 'disabled');
        });
    }
}

/**
 * Realiza ações ao trocar tipo de input
 * @returns {undefined}
 */
function selecionandoTipoDeInput() {
    var valName = $(this).closest('.row-unique').find('input[type=text]').attr('data-rel');
    var situacaoCheck = $(this).closest('.row-unique').find('[name="LabelsOptions[campoObrigatorio]['+valName+']"]').closest('label');
    
    situacaoCheck.show();
    
    if ($(this).val() == 'situacao') {
        situacaoCheck.attr('checked', 'checked').hide();
    }
    
    if ($(this).val()) {
        $('.campoDropdownName_' + valName).val('');
        $(this).closest('.row-unique').find('.dropdownlist_div').hide();
    } else {
        $(this).closest('.row-unique').find('.dropdownlist_div').show();
    }
}

/**
 * Abre modal para criar uma dropdown list para o campo.
 * @returns {undefined}
 */
function addDropDown() {
    $('#modalDropdown').modal('show');
    $('.inputNameCampoModal').val($(this).attr('data-rel'));
    $('.select-dropdownlist').val($('.campoDropdownName_' + $(this).attr('data-rel')).val());
    atualizarSelect2();
}

/**
 * Evento Após selecionar o dropdownlist
 * @returns {undefined}
 */
function selectDropdownList() {
    var campoName = $('.campoDropdownName_' + $('.inputNameCampoModal').val());
    var rowUnique = campoName.closest('.row-unique');
    campoName.val($(this).val());
    $('#modalDropdown').modal('hide');
    $('.inputNameCampoModal').val('');
    
    if ($(this).val()) {
        rowUnique.find('.addDropDown')
            .addClass('dropdown-selecionado')
                .html('<i class="fa fa-pencil"></i>/<i class="fa fa-check"></i>')
                    .attr('title', 'Lista selecionada: '+ $(this).val());

        rowUnique.find('.selectTipoDeInput').attr('disabled', 'disabled').val('');
    } else {
        rowUnique.find('.addDropDown')
            .removeClass('dropdown-selecionado')
                .html('<i class="fa fa-plus"></i>List')
                    .removeAttr('title');
            
        rowUnique.find('.selectTipoDeInput').removeAttr('disabled').val('');
    }
    atualizarSelect2();
}

/**
 * Cria um novo dropdown
 * @returns {undefined}
 */
function criarNovoDropdown() {
    $(this).closest('span').hide();
    $('.cadastrarDropDown').show();
}

/**
 * Adiciona o option para completar o dropdown a ser cadastrado
 * @returns {undefined}
 */
function adicionarOption() {
    var clone = $('.insertLineOption:first').clone();
    clone.find('.chaveOption').val('');
    clone.find('.valorOption').val('');
    $('.insertLineOption:last').after(clone);
    $('.insertLineOption:last').find('.removerOption').show();
}

/**
 * Remove a option do cadastro da dropdown
 * @returns {undefined}
 */
function removerOption() {
    $(this).closest('.insertLineOption').remove();
}

/**
 * Finaliza o cadastro do dropdown, atualizando o dropdown selecionavel 
 * E também é salvo no session para o PHP enviar os dados para o gerador quando
 * finalizar o preenchimento dos restantes dos dados do próprio gerador.
 * @returns {undefined}
 */
function finalizarCadastroDropdown() {
    
    var formDiv = $('.cadastrarDropDown');
    var campoVazio = false;
    var options = {};
    
    formDiv.find('.insertLineOption').each(function() {
        
        //Remove caso tenha ficado algum com erro na tela
        var chave = $(this).find('.chaveOption');
        chave.closest('div').removeClass('has-error');
        if (!chave.val()) {
             campoVazio = true;
             chave.closest('div').addClass('has-error');
        }
        
        var valor = $(this).find('.valorOption');
        if (!valor.val()) {
             campoVazio = true;
             valor.closest('div').addClass('has-error');
        }
        
        if (!campoVazio) {
            options[chave.val()] = valor.val();
        }
    });
    
    if (campoVazio) {
        alert('Existem campos do dropbox que não estão preenchidos.');
        return;
    }
    
    if (confirm('Deseja enviar este Dropdown List para as opções acima?')) {
        
        $('.select-dropdownlist').append('<option value="'+formDiv.find('#labelDropdown').val()+'" >'+formDiv.find('#labelDropdown').val()+'</option>');
        atualizarSelect2();
        
        var div = $('.campoDropdownName_'+ $('.inputNameCampoModal').val()).closest('.dropdownlist_div');
        for (var key in options) {
            div.append('<input type="hidden" value="'+key+'" name="LabelsOptions[campoDropdownChave]['+formDiv.find('#labelDropdown').val()+'][]" >');
            div.append('<input type="hidden" value="'+options[key]+'" name="LabelsOptions[campoDropdownValor]['+formDiv.find('#labelDropdown').val()+'][]" >');
        }
        
        //Limpar o create do dropdown e os dados inseridos
        limpardadosDropdownCadastro();
                
        alert('Seu dropdown foi enviado para o select acima, selecione ele para continuar.');
    }
}

/**
 * Limpa todos os dados do cadastro de dropdown após a conclusão do cadastro
 * @returns {undefined}
 */
function limpardadosDropdownCadastro() {
    $('.criarNovoDropdown').closest('span').show();
    var telaCadastro = $('.cadastrarDropDown');
    telaCadastro.hide();
    telaCadastro.find('#labelDropdown').val('');
    
    var contador = 1;
    $('.chaveOption').each(function() {
        $(this).val('');
        $(this).closest('.insertLineOption').find('.valorOption').val('');
        if (contador != 1) {
            $(this).closest('.insertLineOption').remove();
        }
        contador++;
    });
}