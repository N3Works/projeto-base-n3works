@extends('layout.master')
@section('conteudo')
@include('layout.erros')

<?php
echo LayoutBuilder::gerarBreadCrumb(array(
        'Início' => url('default/index'),
        'Lista de Permissões' => url('permissoes/index'),
        'Cadastrar Permissão',
    ));
?>
@if($errors->all())
    @foreach ($errors->keys() as $key)
        <?php
            ${$key} = "has-error";
        ?>
    @endforeach
@endif

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-orange-sharp bold uppercase"><?php echo ($model->id ? 'Atualizar': 'Cadastrar'); ?> Permissão</span>
                </div>
            </div>
            <div class="portlet-body form">
                {{ Form::open(['id' => 'model_form', 'method' => 'post', 'url' => 'permissoes/save', 'class' => 'form-horizontal']) }}
                    <div class="form-body">
                        
                        <input type="hidden" name="id" class="model_id" value="{{ $model->id }}">
                        
                        <div class="col-md-12">
                            <fieldset>
                            <div class="col-sm-6">
                                <div class="form-body {{$errors->first("permissao", "has-error") }}">
                                <label class="control-label">{{ $model->labels['permissao'] }} <span class="request"> *</span></label>
                                    {{ Form::text('permissao', $model->permissao, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control', 'placeholder' => '']) }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-body {{$errors->first("descricao", "has-error") }}">
                                <label class="control-label">{{ $model->labels['descricao'] }} <span class="request"> *</span></label>
                                    {{ Form::text('descricao', $model->descricao, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control', 'placeholder' => '']) }}
                                </div>
                            </div>
                                                              
                            </fieldset>    
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            {{ Form::button('Salvar', ['type' => 'submit','class' => 'btn blue salvarForm']) }}
                            <a href="{{ url('permissoes/index') }}"><button type="button" class="btn btn-default">Cancelar</button></a>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@endsection

