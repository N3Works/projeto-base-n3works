@extends('layout.master')
@section('conteudo')
@include('layout.erros')

<?php
echo LayoutBuilder::gerarBreadCrumb(array(
        'Início' => url('default/index'),
        'Lista de Valores dos Tipos de parâmetro' => url('parametroValoresTipos/index'),
        'Visualizar Valores do Tipo de parâmetro',
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
                    <span class="caption-subject font-sharp bold uppercase">Visualizar Valores do Tipo de parâmetro</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="col-md-12">
                    <fieldset>
                            <div class="col-sm-6">
                                <div class="form-body">
                                <label class="control-label">{{ $model->labels['parametro_id'] }} </label>
                                    <div class="form-control">{{ $model->parametro_id }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-body">
                                <label class="control-label">{{ $model->labels['value'] }} </label>
                                    <div class="form-control">{{ $model->value }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-body">
                                <label class="control-label">{{ $model->labels['Header'] }} </label>
                                    <div class="form-control">{{ $model->Header }}</div>
                                </div>
                            </div>

                    </fieldset>    
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ url('parametroValoresTipos/index') }}"><button type="button" class="btn btn-default">Voltar</button></a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

