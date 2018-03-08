@extends('layout.master')
@section('conteudo')

@php
echo LayoutBuilder::gerarBreadCrumb(array(
        'Início' => url('default/index'),
        'Lista de Usuários' => url('users/index'),
        'Visualizar Usuário',
    ));
@endphp

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-sharp bold uppercase">Visualizar Usuário</span>
                </div>
            </div>
            
            @include('layout.erros')
            
            <div class="portlet-body">
                <div class="col-md-12">
                    <fieldset>
                        <div class="col-sm-6">
                            <div class="form-body">
                            <label class="control-label">{{ $model->labels['cpf'] }} </label>
                                <div class="form-control">{{ $model->cpf }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-body">
                            <label class="control-label">{{ $model->labels['nome'] }} </label>
                                <div class="form-control">{{ $model->nome }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-body">
                            <label class="control-label">{{ $model->labels['email'] }} </label>
                                <div class="form-control">{{ $model->email }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-body">
                            <label class="control-label">{{ $model->labels['perfil_id'] }} </label>
                                <div class="form-control">{{ ($model->Perfil ? $model->Perfil->nome : '') }}</div>
                            </div>
                        </div>

                    </fieldset>    
                </div>
            </div>
            
            <div class="clearfix"></div><br>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ url('users/index') }}"><button type="button" class="btn btn-default">Voltar</button></a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

