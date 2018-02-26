@extends('layout.master')
@section('conteudo')
@include('layout.erros')

<?php
echo LayoutBuilder::gerarBreadCrumb(array(
        'Início' => url('default/index'),
        'Lista de Permissões' => url('permissoes/index'),
        'Visualizar Permissão',
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
                    <span class="caption-subject font-orange-sharp bold uppercase">Visualizar Permissão</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="col-md-12">
                    <fieldset>
                            <div class="col-sm-6">
                                <div class="form-body">
                                <label class="control-label">{{ $model->labels['permissao'] }} </label>
                                    <div class="form-control">{{ $model->permissao }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-body">
                                <label class="control-label">{{ $model->labels['descricao'] }} </label>
                                    <div class="form-control">{{ $model->descricao }}</div>
                                </div>
                            </div>

                    </fieldset>    
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ url('permissoes/index') }}"><button type="button" class="btn btn-default">Voltar</button></a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

