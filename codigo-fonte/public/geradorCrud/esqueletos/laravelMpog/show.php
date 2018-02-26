@extends('layout.master')
@section('conteudo')
@include('layout.erros')

{!! LayoutBuilder::gerarBreadCrumb([
    'Início' => url('default/index'),
    'Lista de <?php echo $this->dados_modelo['tabela']['nome_plural']; ?>' => url('<?php echo $nomeTabelaRender; ?>/index'),
    'Visualizar <?php echo $this->dados_modelo['tabela']['nome_singular']; ?>'
]) !!}

@section('javascript')
{!! Html::script('resources/assets/js/<?php echo $this->nome_tabela; ?>/show.js') !!}
@stop

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        
        @include('layout.erros')
        
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-sharp bold uppercase">Visualizar <?php echo $this->dados_modelo['tabela']['nome_singular']; ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="col-md-12">
                    <fieldset>
<?php 
foreach ($this->dados_modelo['tabela']['dados'] as $coluna) { 
if (!$coluna['primaria']) {
?>      
                        <div class="col-sm-6">
                            <div class="form-body">
                                <label class="control-label">{{ $model->labels['<?php echo $coluna['nome_coluna']; ?>'] }}</label>
<?php if ($coluna['tipo_coluna'] == 'date') { ?>
        <div class="form-control">{{ $model-><?php echo $coluna['nome_coluna']; ?> = \App\Http\Helper\Formatar::dateDbToAll($model-><?php echo $coluna['nome_coluna']; ?>, 'BR') }}</div>
<?php } else if ($coluna['tipo_coluna'] == 'datetime') { ?>
        <div class="form-control">{{ $model-><?php echo $coluna['nome_coluna']; ?> = \App\Http\Helper\Formatar::dateDbToAll($model-><?php echo $coluna['nome_coluna']; ?>, 'BR', true, true) }}</div>
<?php } else { ?>
        <div class="form-control">{{ $model-><?php echo $coluna['nome_coluna']; ?> }}</div>
<?php } ?>
                                
                            </div>
                        </div>
<?php }} ?>

                    </fieldset>    
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ url('<?php echo $nomeTabelaRender; ?>/index') }}"><button type="button" class="btn btn-default">Voltar</button></a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
