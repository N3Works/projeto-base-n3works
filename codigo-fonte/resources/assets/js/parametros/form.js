var ultimoId = 1; //Ultimo id inserido no dropdown

$(document).ready(function() {
    $(document).on('change', '.input_tipo', selecionarTipoParametro);
    $(document).on('click', '.cadastroLinhaDropDown', construirLinhaDropDown);
    $(document).on('click', '.salvarForm', salvarForm);
    $(document).on('click', '.destroyTr', destroyTr);
    
    ajustarFormAntesTrigger();
    
    /**
     * Preenche o label do radio por letra inserida no campo
     */
    $(document).on('keyup', '.inputLabelRadioTrue', function() {
        $('.nameLabelTrue').text($(this).val());
    });
    
    /**
     * Preenche o label do radio por letra inserida no campo
     */
    $(document).on('keyup', '.inputLabelRadioFalse', function() {
        $('.nameLabelFalse').text($(this).val());
    });
    
    /**
     * Preenche o dropdown por letra inserida no campo
     */
    $(document).on('keyup', '.inputDropdownValor', function() {
        var select = $('.input_valor_editavel');
        var inputId = $(this).closest('tr').find('.inputIdItem').val();
        select.find('#option_' + inputId).val($(this).val());
        select.select2();
    });
    
    /**
     * Preenche o dropdown por letra inserida no campo
     */
    $(document).on('keyup', '.inputDropdownNome', function() {
        var select = $('.input_valor_editavel');
        var inputId = $(this).closest('tr').find('.inputIdItem').val();
        select.find('#option_' + inputId).html($(this).val());
        select.select2();
    });
});

/**
 * Ajusta o layout de acordo com o tipo do parâmetro
 * @returns {undefined}
 */
function selecionarTipoParametro() {
    var tipo = $(this);
    var inputDefault = '<input data-required="1" aria-required="true" class="form-control input_valor_editavel" placeholder="Valor Padrão" name="valor" type="text">';
    var containerMultItem = $('.containerMultItem');
    var containerBoolean = $('.containerBoolean');
    var valorDiv = $('.inputValor');
    var valorDivBoolean = $('.inputValorBoolean');
    
    //Limpar valor e esconde containers
    valorDiv.html('');
    valorDivBoolean.hide();
    containerMultItem.hide();
    containerBoolean.hide();
    
    switch (tipo.val()) { //Valida o tipo de parâmetro passado
        case '':
            valorDiv.closest('.form-group').hide();
            break;
            
        case 'dropdown':
            containerMultItem.show(); //Mostra container de cadastrar select values
            valorDiv.closest('.form-group').show(); //Mostra a div onde está o valor
            valorDiv.append('<select name="valor" class="input_valor_editavel select2 form-control"><option value="" id="option_1"></option></select>'); //Injeta o campo de valor(input)
            //Faz o valor input virar um select
            $('.input_valor_editavel').addClass('select2').select2();
            break;
            
        case 'integer':
            valorDiv.append(inputDefault.replace('type="text"', 'type="number"'));
            valorDiv.closest('.form-group').show(); //Mostra a div onde está o valor
            break;
            
        case 'boolean':
            containerBoolean.show(); //Mostra container de cadastrar select values
            valorDiv.closest('.form-group').show(); //Mostra a div onde está o valor
            valorDivBoolean.show();
            break;
            
        case 'text':
            valorDiv.append(inputDefault);
            valorDiv.closest('.form-group').show(); //Mostra a div onde está o valor
            break;
    }
    ajustarFormPosTrigger();
}

/**
 * Constroi o formulário de dropdown
 * @returns {undefined}
 */
function construirLinhaDropDown() {
    var linhaPai = $('.linha-clone-item');
    
    ultimoId = ultimoId + 1; //Popula com o ultimo ID + 1 para cada clone
    var linhaNova = linhaPai.clone();
    linhaNova.removeClass('linha-clone-item');
    linhaNova.find('.inputPaiValor').val('').removeClass('inputPaiValor');
    linhaNova.find('.inputPaiNome').val('').removeClass('inputPaiNome');
    linhaNova.find('.inputIdItem').val(ultimoId);
    linhaNova.find('.destroyTr').show().attr('data-rel', ultimoId);
    linhaNova.find('td').attr('style', 'border-top:none; padding: 0px;');
    linhaPai.find('td').attr('style', 'padding: 0px;');
    
    //Adiciona o option mesmo vazio dentro do Valor padrão
    $('.input_valor_editavel').append($('<option>', {  
        value: '',
        text : '',
        id: 'option_'+ultimoId
    })).select2();
    
    $('.table-dropdown').append(linhaNova);
}

/**
 * Salvar Formulário ( Validações )
 * @returns {undefined}
 */
function salvarForm() {
    var msgPadrao = 'Valor Padrão é obrigatório.';
    
    if ($('.input_tipo').val() == APP.TIPO_DROPDOWN) {
        var errorInputsDropdown = false;
        
        $('.inputDropdownNome').each(function() {
            if (!trim($(this).val())) {
                errorInputsDropdown = true;
            }
        });

        $('.inputDropdownValor').each(function() {
            if (!trim($(this).val())) {
                errorInputsDropdown = true;
            }
        });

        if (errorInputsDropdown) {
            appUtil.createFlashMesseger('Após adicionar uma linha no dropdown, os valores passam a ser de preenchimento obrigatório.', 'danger');
        }
    }
    
    if ($('.input_tipo').val() == APP.TIPO_BOOLEAN) {
        if ($('#optionRadioTrue').is(":checked") === false && $('#optionRadioFalse').is(":checked") === false) {
            appUtil.createFlashMesseger(msgPadrao, 'danger');
            return;
        }
    } else {
        if (!$('.input_valor_editavel').val()) {
            appUtil.createFlashMesseger(msgPadrao, 'danger');
            return;
        }
    }
    
    $('form').submit();
}

/**
 * Remove a linha da lista e do dropdown
 * @returns {undefined}
 */
function destroyTr() {
    $(this).closest('tr').remove();
    var option = $('#option_'+$(this).attr('data-rel'));
    var select = option.closest('select');
    if (option.val() == select.val()) {
        select.val('');
    }
    option.remove();
    select.select2();
}

/**
 * Ajusta form após erro de formulário e antes da trigger de tipo
 * @returns {undefined}
 */
function ajustarFormAntesTrigger() {
    if (APP.TIPO) {
        if (APP.TIPO == APP.TIPO_BOOLEAN) {
            $('.nameLabelTrue').html($('.inputLabelRadioTrue').val());
            $('.nameLabelFalse').html($('.inputLabelRadioFalse').val());
            if (APP.VALOR == 'true') {
                $('#optionRadioTrue').closest('label').trigger('click');
            } else {
                $('#optionRadioFalse').closest('label').trigger('click');
            }
        }
        
        $('.input_tipo').val(APP.TIPO);
    }
    $('.input_tipo').trigger('change');
}

/**
 * Ajusta form após erro de formulário e apos trigger do tipo
 * @returns {undefined}
 */
function ajustarFormPosTrigger() {
    if (APP.TIPO) {
        if (APP.TIPO == APP.TIPO_DROPDOWN) {
            $('.inputIdItem').each(function() {
                var valor = $(this).closest('tr').find('.inputDropdownValor').val();
                var nome = $(this).closest('tr').find('.inputDropdownNome').val();
                if ($(this).val() == '1') {
                    $('#option_'+$(this).val()).val(valor).html(nome);
                } else {
                    $('.input_valor_editavel').append('<option id="option_'+$(this).val()+'" value="'+valor+'">'+nome+'</option>');
                }
            });

            $('.input_valor_editavel').val(APP.VALOR).select2();
        }
        
        if (APP.TIPO != APP.TIPO_DROPDOWN && APP.TIPO != APP.TIPO_BOOLEAN) {
            $('.input_valor_editavel').val(APP.VALOR);
        }
    }
}