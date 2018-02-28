<div id="modalDropdown" class="modal fade" role="dialog"  >
    <div class="modal-dialog modal-md" style="background-color: darkblue;">
        <!-- Modal content-->
        <div class="modal-content" style="background-color: snow;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center">Utilizar DropDown</h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <input class="inputNameCampoModal" value="" type="hidden" >
                    <!--<div class="form-body">-->
                    Selecionar um existente?<br>
                    <select class="form-control select-dropdownlist select2" >
                        <option value>Selecione</option>
                        <?php foreach ($_SESSION['dropdownlist'] as $key => $data) { ?>
                            <?php echo '<option value="' . $key . '">' . $data['label'] . '</option>'; ?>
                        <?php } ?>
                    </select>
                    <div class="clearfix"></div>
                    <br>
                    <span>Deseja criar um novo? <a href="javascript:void(0)" class="btn btn-success criarNovoDropdown">Criar</a></span>
                    
                    <hr>
                    <div class="cadastrarDropDown">
                        <h5 class="titulo" style="text-align: center;">Cadastro de Dropdown</h5>
                        <hr>
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="labelDropdown" title="Label do DropDown">Label do DropDown</label>
                                <input type="text" class="form-control" id="labelDropdown" name="CriarDropdown[labelDropdown]" placeholder="Exemplo" value="">
                            </div>
                        </div>

                        <!-- Linha de da Label -->
                        <div class="col-md-5 col-sm-5 ajusteLabelDropdown">
                            <div class="form-group">
                                <label title="Chave do Option" style="text-align: center;">Chave</label>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5 ajusteLabelDropdown">
                            <div class="form-group">
                                <label title="Valor do Option" style="text-align: center;">Valor</label>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <div class="form-group">
                                <label title="Ações"><a href="javascript:void(0)" class="adicionarOption btn btn-primary"><i class="fa fa-plus"></i></a></label>
                            </div>
                        </div>
                        
                        <!-- Linha da option a ser cadastrada -->
                        <div class="insertLineOption">
                            <div class="col-md-5 col-sm-5">
                                <div class="form-group">
                                    <input type="text" class="form-control chaveOption" name="CriarDropdown[chaveOption][]" placeholder="chave" value="">
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-5">
                                <div class="form-group">
                                    <input type="text" class="form-control valorOption" name="CriarDropdown[valorOption][]" placeholder="valor" value="">
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <div class="form-group">
                                    <a href="javascript:void(0)" class="removerOption btn btn-danger"><i class="fa fa-trash"></i></a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botão de finalizar -->
                        <div class="col-md-12 col-sm-12">
                            <a href="javascript:void(0)" class="btn btn-success finalizarCadastroDropdown"><i class="fa fa-check"></i> Finalizar</a>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
            </div>
        </div>
    </div>
</div>