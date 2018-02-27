@extends('layout.master')
@section('conteudo')

<?php
echo LayoutBuilder::gerarBreadCrumb(array(
    'Início' => url('permissoes/index'),
    'Lista de Permissões',
));
?>
@section('javascript')
{!!Html::script('resources/assets/js/permissoes/index.js')!!}
@stop

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">    
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-sharp bold uppercase">Listar Permissão</span>
                </div>
            </div>
            
            @include('layout.erros')
            
            @include('permissoes.index.search')

            <div class="table-toolbar">
                <div class="row">
                    <div class="col-md-6">
                        <div class="btn-group" >
                            <a href="{{ url('permissoes/form') }}">
                                <button class="btn sbold orange"> Adicionar
                                    <i class="fa fa-plus"></i>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="portlet-body">
                {!! $dataTable->table(['class' => 'table table-striped table-bordered table-hover table-checkable order-column', 'id' => 'data_table']) !!}
            </div>
        </div>
    </div>
</div>

@stop
