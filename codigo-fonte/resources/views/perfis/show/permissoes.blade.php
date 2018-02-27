<div class="row">
    <div class="col-md-12">
        
        @include('permissoes.index.search')
            
        <div class="portlet-body">
            {!! $dataTable->table(['class' => 'table table-striped table-bordered table-hover order-column', 'id' => 'data_table']) !!}
        </div>
            
    </div>
</div>