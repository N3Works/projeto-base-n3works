@extends('layoutLogin.master')

@section('conteudo')
<div class="content">
    @include('layout.erros')
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" action="recuperarSenha" method="post" novalidate="novalidate">
        <h3 class="form-title" style="color:#2c66ce !important">Recuperar Senha</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span> Coloque seu e-mail para receber uma nova senha. </span>
        </div>
        <div class="form-group has-error">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">E-mail</label>
            <input class="form-control form-control-solid placeholder-no-fix valid" type="text" autocomplete="off" placeholder="exemplo@exemplo.com" name="email" aria-required="true" aria-invalid="true" aria-describedby="email-error" value="{{ $email }}"> 
        </div>
        <div class="row text-right"><a href="<?php echo app('request')->root().'/login'; ?>"><b style="padding-right: 16px;">Voltar para login</b></a></div>
        <div class="form-actions" style="padding: 0px 30px !important;">
            <button type="submit" class="btn green uppercase">Enviar</button>
        </div>
    </form>
</div>
@endsection
