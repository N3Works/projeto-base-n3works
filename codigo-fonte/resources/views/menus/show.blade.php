@extends('layout.master')
@section('conteudo')

<?php
echo LayoutBuilder::gerarBreadCrumb(array(
        'Início' => url('default/index'),
        'Lista de Menus' => url('menus/index'),
        'Visualizar Menu',
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
                    <span class="caption-subject font-sharp bold uppercase">Visualizar Menu</span>
                </div>
            </div>
            
            @include('layout.erros')
            
            <div class="portlet-body">
                <div class="col-md-12">
                    <fieldset>
                        <div class="col-sm-6">
                            <div class="form-body">
                            <label class="control-label">{{ $model->labels['header'] }} </label>
                                <div class="form-control">{{ $model->header }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-body">
                            <label class="control-label">{{ $model->labels['controller'] }} </label>
                                <div class="form-control">{{ $model->controller }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-body">
                            <label class="control-label">{{ $model->labels['action'] }} </label>
                                <div class="form-control">{{ $model->action }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-body">
                            <label class="control-label">{{ $model->labels['icon'] }} </label>
                                <div class="form-control">{{ $model->icon }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-body">
                            <label class="control-label">{{ $model->labels['order'] }} </label>
                                <div class="form-control">{{ $model->order }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <?php 
                            $parent = \App\Models\Menus::find($model->parent);
                            $header = '';

                            if ($parent) {
                                $header = $parent->header;
                            }
                            ?>
                            <div class="form-body">
                            <label class="control-label">{{ $model->labels['parent'] }} </label>
                                <div class="form-control">{{ $header }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-body">
                            <label class="control-label">{{ $model->labels['permissao_id'] }} </label>
                                <div class="form-control">{{ $model->permissao_id ? $model->Permissao->permissao : '' }}</div>
                            </div>
                        </div>
                    </fieldset>    
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ url('menus/index') }}"><button type="button" class="btn btn-default">Voltar</button></a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

