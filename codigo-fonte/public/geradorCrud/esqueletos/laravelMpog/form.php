@extends('layout.master')
@section('conteudo')

{!! LayoutBuilder::gerarBreadCrumb([
    'Início' => url('default/index'),
    'Lista de <?php echo $this->dados_modelo['tabela']['nome_plural']; ?>' => url('<?php echo $nomeTabelaRender; ?>/index'),
    'Cadastrar <?php echo $this->dados_modelo['tabela']['nome_singular']; ?>',
]) !!}

@section('javascript')
{!! Html::script('resources/assets/js/<?php echo $this->nome_tabela; ?>/form.js') !!}
@stop

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        
        @include('layout.erros')
        
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-sharp bold uppercase">{{ $model->id ? 'Atualizar': 'Cadastrar' }} <?php echo $this->dados_modelo['tabela']['nome_singular']; ?></span>
                </div>
            </div>
            <div class="portlet-body form">
                    {{ Form::open(['id' => 'model_form', 'method' => 'post', 'url' => url('<?php echo $nomeTabelaRender ?>/save'), 'class' => 'form-horizontal']) }}
                    <div class="form-body">
                        
                        <input type="hidden" name="id" class="model_id" value="{{ $model->id }}">
                        
                        <div class="col-md-12">
                            <fieldset>
<?php

                                foreach ($this->dados_modelo['tabela']['dados'] as $coluna) { 
                                    if (!$coluna['primaria']) {
?>
                                    <div class="col-sm-6">
                                        <div class="form-body {{ $errors->first("<?php echo $coluna['nome_coluna']; ?>", "has-error") }}">
                                            <label class="control-label">{{ $model->labels['<?php echo $coluna['nome_coluna']; ?>'] }}  <?php if($coluna['obrigatorio']) { ?><span class="request">*</span><?php } ?>:</label>
                                            {{ <?php echo Modelo::gerarCampoForm($coluna, $relacoes, 'form'); ?> }}
                                        </div>
                                    </div>
<?php 
                                    }
                                }
?>                                       
                            </fieldset>    
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            {{ Form::button('Salvar', ['type' => 'submit', 'class' => 'btn blue salvarForm']) }}
                            <a href="{{ url('<?php echo $nomeTabelaRender; ?>/index') }}"><button type="button" class="btn btn-default">Cancelar</button></a>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@endsection

