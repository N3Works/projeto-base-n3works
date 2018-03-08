@extends('layout.master')
@section('conteudo')

@php
echo LayoutBuilder::gerarBreadCrumb([
    'Início' => url('/'),
    'Trocar Senha',
]);
@endphp

@section('javascript')
{!!Html::script('resources/assets/js/users/trocar-senha.js')!!}
@stop

<style>
    .error-text {
        display: none;
    }
    .new-content-error:after {
        content: 'Campos obrigatórios:';
    }
</style>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-blue-steel bold uppercase">Trocar Senha</span>
                </div>
            </div>
            
            @include('layout.erros')
            
            <div class="portlet-body form">
                {{ Form::open(['id' => 'model_form', 'method' => 'post', 'url' => 'users/trocarSenha/'.$model->id, 'class' => 'form-horizontal']) }}
                    
                    {{ Form::text('id', $model->id, ['style' => 'display: none;', 'data-required' => 1, 'aria-required' => 'true', 'class' => 'form-control id_user']) }}
                    {{ Form::text('cenario', $model->cenario, ['style' => 'display: none;', 'data-required' => 1, 'aria-required' => 'true', 'class' => 'form-control cenario']) }}
                    
                    <div class="form-body">
                        <div class="col-md-8">
                            
                            <div class="form-group {{ $errors->has('password_atual') ? 'has-error' : '' }}">
                                <label class="col-md-5 control-label"><b class="labelSenha">{{ $model->labels['password_atual'] }}:</b><span class="request"> *</span></label>
                                <div class="col-md-7">
                                    {{ Form::password('password_atual', ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control senha_atual', 'placeholder' => 'Senha Antiga', 'maxlength' => 50]) }}
                                </div>
                            </div>
                            
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                <label class="col-md-5 control-label"><b class="labelSenha">Nova Senha:</b><span class="request"> *</span></label>
                                <div class="col-md-7">
                                    {{ Form::password('password', ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control nova_senha password_strength', 'placeholder' => 'Nova Senha', 'maxlength' => 50]) }}
                                </div>
                            </div>


                            <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                                <label class="col-md-5 control-label"><b>{{ $model->labels['password_confirmation'] }}:</b><span class="request"> *</span></label>
                                <div class="col-md-7">
                                    {{ Form::password('password_confirmation', ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control nova_senha_confirmar', 'placeholder' => 'Confirmar Nova Senha', 'maxlength' => 50]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                
                <div class="clearfix"></div>
                <hr>
                <div class="row left">
                    <div class="col-md-12">
                        {{ Form::button('Salvar', ['class' => 'btn blue salvarSenha']) }}
                        <a href="{{ url('/') }}"><button type="button" class="btn btn-default">Cancelar</button></a>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@endsection