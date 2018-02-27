@extends('layout.master')
@section('conteudo')
@include('layout.erros')

<?php
echo LayoutBuilder::gerarBreadCrumb(array(
        'Início' => url('default/index'),
        'Lista de Anexos' => url('anexos/index'),
        'Visualizar Anexo',
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
                    <span class="caption-subject font-orange-sharp bold uppercase">Visualizar Anexo</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="col-md-12">
                    <fieldset>
                            <div class="col-sm-6">
                                <div class="form-body">
                                <label class="control-label">{{ $model->labels['filename'] }} </label>
                                    <div class="form-control">{{ $model->filename }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-body">
                                <label class="control-label">{{ $model->labels['name'] }} </label>
                                    <div class="form-control">{{ $model->name }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-body">
                                <label class="control-label">{{ $model->labels['size'] }} </label>
                                    <div class="form-control">{{ $model->size }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-body">
                                <label class="control-label">{{ $model->labels['mime_type'] }} </label>
                                    <div class="form-control">{{ $model->mime_type }}</div>
                                </div>
                            </div>

                    </fieldset>    
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ url('anexos/index') }}"><button type="button" class="btn btn-default">Voltar</button></a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

