@extends('layout.master')
@section('conteudo')
@include('layout.erros')

<?php
echo LayoutBuilder::gerarBreadCrumb(array(
        'Início' => url('default/index'),
        'Lista de Usuários' => url('users/index'),
        'Visualizar Usuário',
    ));
?>

@section('javascript')
{!!Html::script('resources/assets/js/users/show.js')!!}
@stop

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        
        <?php echo Util::showMessage(); ?>
        
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-orange-sharp bold uppercase">Visualizar Usuário</span>
                </div>
            </div>
            <input type="hidden" value="{{$model->id}}" class="id_user" />
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

                    </fieldset>    
                </div>
            </div>
            
            <div class="clearfix"></div><br>
            
            
            <div class="portlet-body">
                <div class="tabbable-custom ">
                    <ul class="nav nav-tabs ">
                        <li class="active">
                            <a href="#tab_1_1_1" data-toggle="tab" aria-expanded="true"> Permissões </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_1_1">
                            @include('users.show.permissoes')
                        </div>
                    </div>
                </div>
            
            </div>
            
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

