@extends('manual.master')

@php $baseUrl = url('/'); @endphp

@section('conteudo')

<div class="panel panel-primary" id="manual-projeto"> 
    <div class="panel-heading"> 
        <h3 class="panel-title">{!! app('AppConfig')->getParam('CABECALHO_NOME_PROJETO') !!}</h3> 
    </div> 
    <div class="panel-body"> 
        @include('manual.index.projeto')
    </div> 
</div>

<div class="panel panel-primary" id="manual-lorem1"> 
    <div class="panel-heading"> 
        <h3 class="panel-title"> Lorem Ipsum: Example 1</h3> 
    </div> 
    <div class="panel-body"> 
        @include('manual.index.loren1')
    </div> 
</div>

<div class="panel panel-primary" id="manual-menus-lorem1"> 
    <div class="panel-heading"> 
        <h3 class="panel-title"> Lorem Ipsum: Example 2</h3> 
    </div> 
    <div class="panel-body"> 
        Example 2
    </div> 
</div>

<div class="panel panel-primary" id="manual-menus-lorem2"> 
    <div class="panel-heading"> 
        <h3 class="panel-title"> Lorem Ipsum: Example 3</h3> 
    </div> 
    <div class="panel-body"> 
        Example 3
    </div> 
</div>
    
@stop
