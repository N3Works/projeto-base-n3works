@extends('layout.master')
@section('conteudo')

@php
echo LayoutBuilder::gerarBreadCrumb(array(
        'InÃ­cio' => url('default/index'),
        'Lista de Parametros' => url('parametros/index'),
        'Cadastrar Parametro',
    ));
    
$model->parametro_editavel = ($model->parametro_editavel ? $model->parametro_editavel : $model::SIM);
@endphp

@if($errors->all())
    @foreach ($errors->keys() as $key)
        <?php
            ${$key} = "has-error";
        ?>
    @endforeach
@endif

@section('javascript')
{!!Html::script('resources/assets/js/parametros/form.js')!!}
@stop
<link href="{{ asset('resources/assets/css/parametros/form.css') }}" rel="stylesheet" type="text/css" >

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-sharp bold uppercase">{{ ($model->id ? 'Atualizar': 'Cadastrar') }} Parametro</span>
                </div>
            </div>
            
            @include('layout.erros')
            
            <div class="portlet-body form">
                {{ Form::open(['id' => 'model_form', 'method' => 'post', 'url' => 'parametros/save', 'class' => 'form-horizontal']) }}
                    <div class="form-body">
                        
                        <input type="hidden" name="id" class="model_id" value="{{ $model->id }}">
                        
                        <div class="col-md-8">
                            
                            <div class="form-group {{$errors->first('nome', 'has-error') }}">
                                <label class="col-md-3 control-label"><b>{{ $model->labels['nome'] }}:</b><span class="request"> *</span></label>
                                <div class="col-md-6">                                    
                                    {{ Form::text('nome', $model->nome, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control', 'placeholder' => 'Nome do parÃ¢metro', 'style' => 'text-transform: uppercase;' ]) }}
                                </div>
                            </div>
                            
                            <div class="form-group {{$errors->first('descricao', 'has-error') }}">
                                <label class="col-md-3 control-label"><b>{{ $model->labels['descricao'] }}:</b></label>
                                <div class="col-md-6">                                    
                                    {{ Form::textarea('descricao', $model->nome, ['raw' => 3, 'data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control', 'placeholder' => 'DescriÃ§Ã£o detalhada do parÃ¢metro' ]) }}
                                </div>
                            </div>
                            
                            <div class="form-group {{$errors->first('status', 'has-error') }}">
                                <label class="col-md-3 control-label"><b>{{ $model->labels['status'] }}:</b><span class="request"> *</span></label>
                                <div class="col-md-6">                                    
                                    {{ Form::select('status', $model::$status_sistem_list, $model->status, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control select2']) }}
                                </div>
                            </div>
                            
                            @if (\Auth::user()->verificarPermissao('PARAMETROS_EDITAR'))
                            <div class="form-group {{$errors->first('parametro_editavel', 'has-error') }}">
                                <label class="col-md-3 control-label"><b>{{ $model->labels['parametro_editavel'] }}:</b><span class="request"> *</span></label>
                                <div class="col-md-6">                                    
                                    {{ Form::select('parametro_editavel', $model::$sim_nao_sistem_list, $model->parametro_editavel, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control select2']) }}
                                </div>
                            </div>
                            @else
                                {{ Form::hidden('parametro_editavel', $model->parametro_editavel, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control']) }}
                            @endif
                            
                            <div class="form-group {{$errors->first('tipo', 'has-error') }}">
                                <label class="col-md-3 control-label"><b>{{ $model->labels['tipo'] }}:</b><span class="request"> *</span></label>
                                <div class="col-md-6">                                    
                                    {{ Form::select('tipo', $model::$tipos_list, $model->tipo, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control select2 input_tipo', 'placeholder' => 'Selecione o tipo do parÃ¢metro']) }}
                                </div>
                            </div>
                            
                            <div class=" containerMultItem" style="display: none;">
                                <div class="col-md-3"></div>
                                <div class="col-md-8">
                                    <table class="table table-dropdown">
                                        <tr>
                                            <th class="th-itens">Valor</th>
                                            <th class="th-itens">Nome</th>
                                            <th class="th-itens-btn"><a href="javascript:void(0)" class="btn btn-primary cadastroLinhaDropDown"><i class="fa fa-plus"></i></a></th>
                                        </tr>
                                        <tr class="linha-clone-item">
                                            <td style="padding: 0px;">
                                                <div class="form-group form-md-line-input">
                                                    <input type="hidden" value="1" class="inputIdItem" />
                                                    <input type="text" name="dropdownValor[]" value="{{ (!empty($dados['dropdownValor']) ? $dados['dropdownValor'][0] : '') }}" class="form-control inputDropdownValor inputPaiValor" placeholder="Preencha com o valor">
                                                    <span class="help-block">Chave para o item</span>
                                                </div>
                                            </td>
                                            <td style=" padding: 0px;">
                                                <div class="form-group form-md-line-input">
                                                    <input type="text" name="dropdownNome[]" value="{{ (!empty($dados['dropdownNome']) ? $dados['dropdownNome'][0] : '') }}" class="form-control inputDropdownNome inputPaiNome" placeholder="Preencha com o nome">
                                                    <span class="help-block">Nome que irÃ¡ ser mostrado.</span>
                                                </div>
                                            </td>
                                            <td style="padding: 0px;">
                                                <a  href="javascript:void(0)" class="destroyTr btn btn-danger" style="display: none;" data-rel="1" ><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                        @if (!empty($dados['dropdownValor']))
                                            @php $count = 2; @endphp
                                            @foreach ($dados['dropdownValor'] as $key => $valor)
                                                @if ($key !== 0)
                                                    <tr>
                                                        <td style="border-top:none; padding: 0px;">
                                                            <div class="form-group form-md-line-input">
                                                                <input type="hidden" value="{{ $count }}" class="inputIdItem" />
                                                                <input type="text" name="dropdownValor[]" value="{{ $valor }}" class="form-control inputDropdownValor" placeholder="Preencha com o valor">
                                                                <span class="help-block">Chave para o item</span>
                                                            </div>
                                                        </td>
                                                        <td style="border-top:none; padding: 0px;">
                                                            <div class="form-group form-md-line-input">
                                                                <input type="text" name="dropdownNome[]" value="{{ $dados['dropdownNome'][$key] }}" class="form-control inputDropdownNome" placeholder="Preencha com o nome">
                                                                <span class="help-block">Nome que irÃ¡ ser mostrado.</span>
                                                            </div>
                                                        </td>
                                                        <td style="border-top:none; padding: 0px;">
                                                            <a  href="javascript:void(0)" class="destroyTr btn btn-danger" data-rel="{{ $count }}" ><i class="fa fa-times"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                @php $count++; @endphp
                                            @endforeach
                                        @endif
                                        
                                    </table>
                                </div>
                            </div>
                            
                            <div class="containerBoolean" style="display: none;">
                                <div class="col-md-3">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="form-group form-md-line-input">
                                        <input type="text" name="inputLabelRadioTrue" value="{{ $dados['inputLabelRadioTrue'] ? $dados['inputLabelRadioTrue'] : '' }}" class="form-control inputLabelRadioTrue" placeholder="Label True">
                                        <span class="help-block">Label do radio TRUE</span>
                                    </div>
                                    <div class="form-group form-md-line-input">
                                        <input type="text" name="inputLabelRadioFalse" value="{{ $dados['inputLabelRadioFalse'] ? $dados['inputLabelRadioFalse'] : '' }}" class="form-control inputLabelRadioFalse" placeholder="Label False">
                                        <span class="help-block">Label do radio FALSE</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="clearfix"></div><br>
                            
                            <div class="form-group {{$errors->first('valor', 'has-error') }}" style="display: none;">
                                <label class="col-md-3 control-label"><b>Valor Padrão:</b><span class="request"> *</span></label>
                                <div class="col-md-6">  
                                    <div class="inputValor"></div>
                                    <div class="inputValorBoolean" style="display: none;">
                                        <div class="icheck-inline">
                                            <label>
                                                <div class="iradio_minimal-grey">
                                                     <input type="radio" name="valor" id="optionRadioTrue" value="true" class="icheck">
                                                </div> <span class="nameLabelTrue">Label True</span>
                                            </label>
                                            <label>
                                                <div class="iradio_minimal-grey">
                                                    <input type="radio" name="valor" id="optionRadioFalse" value="false" class="icheck">
                                                </div> <span class="nameLabelFalse">Label False</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                                              
                            </fieldset>    
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            {{ Form::button('Salvar', ['type' => 'button','class' => 'btn blue salvarForm']) }}
                            <a href="{{ url('parametros/index') }}"><button type="button" class="btn btn-default">Cancelar</button></a>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@endsection

