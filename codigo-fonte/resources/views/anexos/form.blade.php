@extends('layout.master')
@section('conteudo')

<?php
echo LayoutBuilder::gerarBreadCrumb(array(
        'Início' => url('default/index'),
        'Lista de Anexos' => url('anexos/index'),
        'Cadastrar Anexo',
    ));
?>
@if($errors->all())
    @foreach ($errors->keys() as $key)
        <?php
            ${$key} = "has-error";
        ?>
    @endforeach
@endif

@section('javascript')
{!!Html::script('resources/assets/js/anexos/form.js')!!}
@stop

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-orange-sharp bold uppercase"><?php echo ($model->id ? 'Atualizar': 'Cadastrar'); ?> Anexo</span>
                </div>
            </div>
            @include('layout.erros')
            <div class="portlet-body form">
                {{ Form::open(['id' => 'model_form', 'method' => 'post', 'url' => 'anexos/save', 'class' => 'form-horizontal']) }}
                    <div class="form-body">
                        
                        <input type="hidden" name="id" class="model_id" value="{{ $model->id }}">
                        <input type="hidden" name="anexado_arquivo" class="anexado_arquivo" value="false">
                        
                        <div class="col-md-6">
                            <fieldset>
                                
                                <div class="col-sm-12">
                                    <div class="form-body {{$errors->first("nome_fantasia", "has-error") }}">
                                    <label class="control-label">Nome </label>
                                        {{ Form::text('nome_fantasia', $model->nome_fantasia, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control', 'placeholder' => 'Nome']) }}
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-body {{$errors->first("descricao", "has-error") }}">
                                    <label class="control-label">Descrição </label>
                                        {{ Form::text('descricao', $model->descricao, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control', 'placeholder' => 'Descrição']) }}
                                    </div>
                                </div>
                                
                                <div class="col-sm-12">
                                    <div class="form-body {{$errors->first("descricao", "has-error") }}">
                                    <label class="control-label">Anexar </label>
                                        
                                        <div class="col-md-12" style="height: 12%;">
                                            <span class="btn btn-success fileinput-button">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <span>Anexar</span>
                                                <input id="fileupload" type="file" name="attach">
                                            </span>

                                            <div class="message-limit" style="display: none">
                                                <span class="request" id="mensagem"> </span>
                                            </div>

                                            <span class="label label-sm label-default popovers" data-html="true" data-container="body" data-trigger="hover" data-placement="bottom" data-content="Tamanho máximo de cada arquivo: 300MB<b></b>" data-original-title="" title="">
                                                <i class="fa fa-question"></i>
                                            </span>
                    <br><br>
                                            <div id="progress" class="progress">
                                                <div class="progress-bar progress-bar-success"></div>
                                            </div>
                                            <div id="files" class="files"></div>
                                        </div>
                                        
                                    </div>
                                </div>
                                                        
                            </fieldset>    
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="javascript:void(0)"class="btn blue salvarForm">Salvar</a>
                            <a href="{{ url('anexos/index') }}"><button type="button" class="btn btn-default">Cancelar</button></a>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@endsection

