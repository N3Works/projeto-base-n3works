<div class="row">
    <div class="col-md-12">
        
        @include('permissoes.index.search')
        <a href="javascript:void(0)" class="salvarPermissoes btn btn-success"><i class="fa fa-checked"></i> Salvar Permissoes</a>
        <div class="portlet-body">
            {!! $dataTable->table(['class' => 'table table-striped table-bordered table-hover order-column', 'id' => 'data_table']) !!}
        </div>
        <a href="javascript:void(0)" class="salvarPermissoes btn btn-success"><i class="fa fa-checked"></i> Salvar Permissoes</a>
            
    </div>
</div>