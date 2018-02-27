@extends('layout.master')
@section('conteudo')

<?php
echo LayoutBuilder::gerarBreadCrumb(array(
    'Início' => url('anexos/index'),
    'Lista de Anexos',
));
?>

@section('javascript')
{!!Html::script('resources/assets/js/anexos/index.js')!!}
@stop

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">

        <div class="portlet light bordered">

            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-orange-sharp bold uppercase">Listar Anexo</span>
                </div>
            </div>
            
            <?php echo Util::showMessage(); ?>
            
            <div class="portlet-body form">
                
                    <div id="pb-upload-messager" class="col-md-12"></div>
                    
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group" >
                                    <a href="{{ url('anexos/form') }}">
                                        <button class="btn sbold orange"> Adicionar
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="portlet-body">
                            <table id="pb-attach-table" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Arquivo</th>
                                    <th>Tipo</th>
                                    <th>Tamanho</th>
                                    <th>Data de inclusão</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>


                <div class="clearfix"></div>
                <hr>
                <div class="row left">
                    <div class="col-md-12">
                        <a href="javascript:history.back()"><button type="button" class="btn btn-default">Cancelar</button></a>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

@stop
