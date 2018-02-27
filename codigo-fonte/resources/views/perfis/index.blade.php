@extends('layout.master')
@section('conteudo')

<?php
echo LayoutBuilder::gerarBreadCrumb(array(
    'Início' => url('perfis/index'),
    'Lista de Perfis',
));
?>
@section('javascript')
{!!Html::script('resources/assets/js/perfis/index.js')!!}
@stop

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        
        <?php echo Util::showMessage(); ?>        
        <div class="portlet light bordered">
            
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-sharp bold uppercase">Listar Perfil</span>
                </div>
            </div>

            <div class="table-toolbar">
                <div class="row">
                    <div class="col-md-6">
                        <div class="btn-group" >
                            <a href="{{ url('perfis/form') }}">
                                <button class="btn sbold layoutBtnColor"> Adicionar
                                    <i class="fa fa-plus"></i>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="portlet-body">
                {!! $dataTable->table(['class' => 'table table-striped table-bordered table-hover order-column', 'id' => 'data_table']) !!}
            </div>
        </div>
    </div>
</div>

@stop
