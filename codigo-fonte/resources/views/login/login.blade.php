@extends('layoutLogin.master')

@section('conteudo')
<div class="content">
    @include('layout.erros')
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" action="login" method="post" novalidate="novalidate">
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span> Preencha com CPF e Senha. </span>
        </div>
        <div class="form-group has-error">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">CPF</label>
            <input class="form-control form-control-solid placeholder-no-fix valid maskCpf" type="text" autocomplete="off" placeholder="000.000.000-00" name="login[cpf]" aria-required="true" aria-invalid="true" aria-describedby="cpf-error"> 
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Senha</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Senha" name="login[senha]"> 
        </div>
        <!--<div class="row text-right"><a href="<?php // echo app('request')->root().'/users/recuperarSenha'; ?>"><b style="padding-right: 16px;">Esqueci minha senha</b></a></div>-->
        <div class="form-actions">
            <button type="submit" class="btn green uppercase">Entrar</button>
        </div>
    </form>
</div>
@endsection
