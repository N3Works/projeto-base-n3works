@extends('layout.master')
@section('conteudo')

{!! LayoutBuilder::gerarBreadCrumb([
    'Início' => url('<?php echo $nomeTabelaRender; ?>/index'),
    'Lista de <?php echo $this->dados_modelo['tabela']['nome_plural']; ?>',
]) !!}

@section('javascript')
{!!Html::script('resources/assets/js/<?php echo $this->nome_tabela; ?>/index.js')!!}
@stop

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        
        @include('layout.erros')
        
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-sharp bold uppercase">Listar <?php echo $this->dados_modelo['tabela']['nome_singular']; ?></span>
                </div>
            </div>
            
            @include('<?php echo $this->nome_tabela; ?>.index.search')
            
            <div class="table-toolbar">
                <div class="row">
                    <div class="col-md-6">
                        <div class="btn-group" >
                            <a href="{{ url('<?php echo $nomeTabelaRender; ?>/form') }}">
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
