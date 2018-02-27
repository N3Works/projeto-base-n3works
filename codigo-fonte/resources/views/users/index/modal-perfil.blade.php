<div id="modalAlterarPerfil" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <input type="hidden" class="user_id" value="">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center">Alterar Perfil - <span class="userName"></span></h4>
            </div>
            <div class="modal-body">
                <div class="form-body">
                        
                    <div class="col-md-12">
                        <fieldset>
                            
                            <div class="form-group" >
                                <div class="col-md-12">
                                    <?php echo Form::select('perfil_id', $perfis, '', array('class' => 'perfil_id form-control input-medium select2')); ?>
                                </div>
                            </div>

                        </fieldset>
                    </div>
                    
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>