@extends('layout.master')
@section('conteudo')

@php
echo LayoutBuilder::gerarBreadCrumb(array(
        'Início' => url('default/index'),
        'Lista de Usuários' => url('users/index'),
        'Cadastrar Usuário',
    ));
@endphp
@if($errors->all())
    @foreach ($errors->keys() as $key)
        @php
            ${$key} = "has-error";
        @endphp
    @endforeach
@endif

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-sharp bold uppercase"><?php echo ($model->id ? 'Atualizar': 'Cadastrar'); ?> Usuário</span>
                </div>
            </div>
            
            @include('layout.erros')
            
            <div class="portlet-body form">
                {{ Form::open(['id' => 'model_form', 'method' => 'post', 'url' => 'users/save', 'class' => 'form-horizontal']) }}
                    {{ Form::text('id', $model->id, ['style' => 'display: none;', 'data-required' => 1, 'aria-required' => 'true', 'class' => 'form-control id_user']) }}
                    {{ Form::text('cenario', $model->cenario, ['style' => 'display: none;', 'data-required' => 1, 'aria-required' => 'true', 'class' => 'form-control cenario']) }}
                    
                    <div class="form-body">
                        <div class="col-md-8">
                            
                            <div class="form-group {{$errors->first("cpf", "has-error") }}">
                                <label class="col-md-3 control-label"><b>{{ $model->labels['cpf'] }}:</b><span class="request"> *</span></label>
                                <div class="col-md-6">
                                    @if($model->id)
                                        {{ Form::text('cpf', $model->cpf, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control cpf_user maskCpf', 'placeholder' => '000.000.000-00', 'readonly' => 'true' ]) }}
                                    @else
                                        {{ Form::text('cpf', $model->cpf, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control cpf_user maskCpf', 'placeholder' => '000.000.000-00' ]) }}
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group {{ $errors->has('nome') ? 'has-error' : '' }}">
                                <label class="col-md-3 control-label"><b>{{ $model->labels['nome'] }}:</b><span class="request"> *</span></label>
                                <div class="col-md-6">
                                    {{ Form::text('nome', $model->nome, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control', 'placeholder' => 'Nome Completo', 'maxlength' => 255]) }}
                                </div>
                            </div>
                            
                            <div class="form-group {{ $errors->has('perfil_id') ? 'has-error' : '' }}">
                                <label class="col-md-3 control-label"><b>{{ $model->labels['perfil_id'] }}:</b><span class="request"> *</span></label>
                                <div class="col-md-6">
                                    {{ Form::select('perfil_id', $perfis, $model->perfil_id, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control', 'placeholder' => 'Selecione']) }}
                                </div>
                            </div>
                            
                            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                <label class="col-md-3 control-label"><b>{{ $model->labels['email'] }}:</b><span class="request"> *</span></label>
                                <div class="col-md-6">
                                    {{ Form::text('email', $model->email, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control', 'placeholder' => 'exemplo@exemplo.com', 'maxlength' => 255]) }}
                                </div>
                            </div>
                            
                            <?php if (!$model->id) { //Em caso de edição não pedirá autenticação nem captcha ?>
                            
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                <label class="col-md-3 control-label"><b class="labelSenha">{{ $model->labels['password'] }}:</b><span class="request"> *</span></label>
                                <div class="col-md-6">
                                    {{ Form::password('password', ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control user_password password_strength', 'placeholder' => 'Senha', 'maxlength' => 50]) }}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                                <label class="col-md-3 control-label"><b>{{ $model->labels['password_confirmation'] }}:</b><span class="request"> *</span></label>
                                <div class="col-md-6">
                                    {{ Form::password('password_confirmation', ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control user_password_confirmation', 'placeholder' => 'Confirmar Senha', 'maxlength' => 50]) }}
                                </div>
                            </div>
                            
                            <?php } ?>

                        </div>
                    </div>
                    
                    <div class="clearfix"></div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            {{ Form::button('Salvar', ['type' => 'submit','class' => 'btn blue salvarForm']) }}
                            <a href="{{ url('users/index') }}"><button type="button" class="btn btn-default">Cancelar</button></a>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@endsection

