@extends('layout.master')
@section('conteudo')
@include('layout.erros')

<?php
echo LayoutBuilder::gerarBreadCrumb(array(
        'Início' => url('default/index'),
        'Lista de Valores dos Tipos de parâmetro' => url('parametroValoresTipos/index'),
        'Cadastrar Valores do Tipo de parâmetro',
    ));
?>
@if($errors->all())
    @foreach ($errors->keys() as $key)
        <?php
            ${$key} = "has-error";
        ?>
    @endforeach
@endif

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-sharp bold uppercase"><?php echo ($model->id ? 'Atualizar': 'Cadastrar'); ?> Valores do Tipo de parâmetro</span>
                </div>
            </div>
            <div class="portlet-body form">
                {{ Form::open(['id' => 'model_form', 'method' => 'post', 'url' => 'parametroValoresTipos/save', 'class' => 'form-horizontal']) }}
                    <div class="form-body">
                        
                        <input type="hidden" name="id" class="model_id" value="{{ $model->id }}">
                        
                        <div class="col-md-12">
                            <fieldset>
                            <div class="col-sm-6">
                                <div class="form-body {{$errors->first("parametro_id", "has-error") }}">
                                <label class="control-label">{{ $model->labels['parametro_id'] }} <span class="request"> *</span></label>
                                    {{ Form::number('parametro_id', $model->parametro_id, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control', 'placeholder' => '']) }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-body {{$errors->first("value", "has-error") }}">
                                <label class="control-label">{{ $model->labels['value'] }} <span class="request"> *</span></label>
                                    {{ Form::text('value', $model->value, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control', 'placeholder' => '']) }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-body {{$errors->first("Header", "has-error") }}">
                                <label class="control-label">{{ $model->labels['Header'] }} </label>
                                    {{ Form::text('Header', $model->Header, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control', 'placeholder' => '']) }}
                                </div>
                            </div>
                                                              
                            </fieldset>    
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            {{ Form::button('Salvar', ['type' => 'submit','class' => 'btn blue salvarForm']) }}
                            <a href="{{ url('parametroValoresTipos/index') }}"><button type="button" class="btn btn-default">Cancelar</button></a>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@endsection

