<style>
    .select2-container {
       width: 100% !important;
    }
</style>
<div class="portlet-body">
    <div class="tab-pane active">
        <div class="portlet box blue ">
            <div class="portlet-title pesquisa-avancada" onclick="document.getElementById('conteinerCollapse').click()">
                <div class="caption">
                    <i class="fa fa-search"></i>Filtrar </div>
                <div class="tools">
                    <a style="color: white; font-size: 12px;">Clique para expandir <i class="fa fa-hand-pointer-o"></i></a>
                    <a href="javascript:;" style="display: none;" class="expand" id="conteinerCollapse" data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body" style="display: none;">
                {{ Form::open(['method' => 'get', 'action' => '','url' => 'menus/index', 'class' => 'item_form form-horizontal']) }}
                    <div class="form-body">
                        <div class="col-md-12">
                            
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-md-4 col-sm-4 control-label">Header:</label>
                                    <div class="col-md-4 col-sm-4">
                                        {{ Form::text('header', '', ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control', 'placeholder' => 'Header']) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-sm-4 control-label">Menu Pai:</label>
                                    <div class="col-md-4 col-sm-4">
                                        {{ Form::select('parent', $menusPais, '', ['data-required' => 1,'aria-required' => 'true' ,'class' => 'form-control select2', 'placeholder' => 'Selecione']) }}
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="form-actions left">
                        <button type="button" class="pesquisar_form btn sbold orange"><i class="fa fa-search"></i> Pesquisar</button>
                        <button type="button" id="limparFiltros" class="limpar btn btn-default"><i class="fa fa-eraser"></i> Limpar</button>
                    </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

