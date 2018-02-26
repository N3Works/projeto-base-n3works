@extends('layout.master')
@section('conteudo')

<?php
echo LayoutBuilder::gerarBreadCrumb(array(
    'Início' => url('menus/index'),
    'Lista de Menus',
));
?>
@section('javascript')
{!!Html::script('resources/assets/js/menus/index.js')!!}
@stop

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        
        <?php echo Util::showMessage(); ?>        
        <div class="portlet light bordered">
            
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-orange-sharp bold uppercase">Listar Menu</span>
                </div>
            </div>
            
            @include('menus.index.search')

            <div class="table-toolbar">
                <div class="row">
                    <div class="col-md-6">
                        <div class="btn-group" >
                            <a href="{{ url('menus/form') }}">
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
