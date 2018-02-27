@extends('layout.master')
@section('conteudo')

@php
echo LayoutBuilder::gerarBreadCrumb(array(
        'Início' => url('default/index'),
        'Lista de Menus' => url('menus/index'),
        'Cadastrar Menu',
    ));
@endphp

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
                    <span class="caption-subject font-sharp bold uppercase"><?php echo ($model->id ? 'Atualizar': 'Cadastrar'); ?> Menu</span>
                </div>
            </div>
            
            @include('layout.erros')
            
            <div class="portlet-body form">
                {{ Form::open(['id' => 'model_form', 'method' => 'post', 'url' => 'menus/save', 'class' => 'form-horizontal']) }}
                    <div class="form-body">
                        
                        <input type="hidden" name="id" class="model_id" value="{{ $model->id }}">
                        
                        <div class="col-md-12">
                            <fieldset>
                            <div class="col-sm-6">
                                <div class="form-body {{$errors->first("header", "has-error") }}">
                                <label class="control-label">{{ $model->labels['header'] }} <span class="request"> *</span></label>
                                    {{ Form::text('header', $model->header, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control', 'placeholder' => 'Titulo']) }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-body {{$errors->first("controller", "has-error") }}">
                                <label class="control-label">{{ $model->labels['controller'] }} <span class="request"> *</span></label>
                                    {{ Form::text('controller', $model->controller, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control', 'placeholder' => 'Controlador']) }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-body {{$errors->first("action", "has-error") }}">
                                <label class="control-label">{{ $model->labels['action'] }} </label>
                                    {{ Form::text('action', $model->action, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control', 'placeholder' => 'Ação']) }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-body {{$errors->first("icon", "has-error") }}">
                                <label class="control-label">{{ $model->labels['icon'] }} <span class="request"> *</span></label>
                                    {{ Form::text('icon', $model->icon, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control', 'placeholder' => 'Icone']) }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-body {{$errors->first("icon", "has-error") }}">
                                <label class="control-label">{{ $model->labels['order'] }} <span class="request"> *</span></label>
                                    {{ Form::number('order', $model->order, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control', 'placeholder' => 'Ordem']) }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <?php 
                                $parent =  \App\Models\Menus::where('parent', '0');
                                if ($model->id) {
                                    $parent->where('id', '<>', $model->id);
                                }
                                ?>
                                <div class="form-body {{$errors->first("parent", "has-error") }}">
                                <label class="control-label">{{ $model->labels['parent'] }} <span class="request"> *</span></label>
                                    {{ Form::select('parent', $parent->pluck('header', 'id'), $model->parent, ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control select2', 'placeholder' => 'Selecione']) }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-body {{$errors->first("permissao_id", "has-error") }}">
                                <label class="control-label">{{ $model->labels['order'] }}</label>
                                    {{ Form::select('permissao_id', \App\Models\Permissoes::pluck('permissao', 'id'), $model->permissao_id,['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control select2', 'placeholder' => 'Selecione']) }}
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
                            <a href="{{ url('menus/index') }}"><button type="button" class="btn btn-default">Cancelar</button></a>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@endsection

