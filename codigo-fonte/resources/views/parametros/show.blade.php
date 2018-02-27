@extends('layout.master')
@section('conteudo')

<?php
echo LayoutBuilder::gerarBreadCrumb(array(
        'Início' => url('default/index'),
        'Lista de Parametros' => url('parametros/index'),
        'Visualizar Parametro',
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
                    <span class="caption-subject font-sharp bold uppercase">Visualizar Parametro</span>
                </div>
            </div>
            
            @include('layout.erros')
            
            <div class="portlet-body">
                <div class="col-md-12">
                    <fieldset>
                        <div class="col-sm-6">
                            <div class="form-body">
                                <label class="control-label">{{ $model->labels['nome'] }} </label>
                                <div class="form-control">{{ $model->nome }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-body">
                                <label class="control-label">{{ $model->labels['descricao'] }} </label>
                                <div class="form-control">{{ $model->descricao }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-body">
                                <label class="control-label">{{ $model->labels['status'] }} </label>
                                <div class="form-control">{{ $model::$status_sistem_list[$model->status] }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-body">
                                <label class="control-label">{{ $model->labels['tipo'] }} </label>
                                <div class="form-control">{{ $model::$tipos_list[$model->tipo] }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-body">
                                <label class="control-label">{{ $model->labels['valor'] }} </label>
                                <div class="form-control">{{ $model->valor }}</div>
                            </div>
                        </div>
                    </fieldset>    
                </div>
            </div>
            <div class="clearfix"></div>
            
            <hr>
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-sharp bold uppercase">Valores Disponiveis</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="col-md-4">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <th>Valor</th>
                            <th>Nome/Titulo/Label</th>
                        </thead>
                        <tbody>
                            @foreach ($model->ParametroValoresTipos as $dados)
                            <tr>
                                <td>{{ $dados->value }}</td>
                                <td>{{ $dados->header }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ url('parametros/index') }}"><button type="button" class="btn btn-default">Voltar</button></a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

