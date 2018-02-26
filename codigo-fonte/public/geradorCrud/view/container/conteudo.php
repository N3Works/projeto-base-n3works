<div class="row">
    <div class="col-md-6">
        <h5 class="titulo">Gerações Básicas</h5>
        <ul class="list-group mb-3">

            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <label class="checkbox-inline">
                        <input type="checkbox" checked="checked" name="gerarView" id="Gerador_gerarView" value="1"> Gerar Views
                    </label>

                    <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <label class="checkbox-inline">
                        <input type="checkbox" checked="checked" name="gerarDatatable" id="Gerador_gerarDatatable" value="1"> Gerar Datatable
                    </label>

                </div>
            </li>

            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <label class="checkbox-inline">
                        <input type="checkbox" checked="checked" name="gerarModel" id="Gerador_gerarModel" value="1"> Gerar Model
                    </label>

<!--                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Tabulação dos checkbox !
                    <label class="checkbox-inline">
                        <input type="checkbox" checked="checked" name="model_timestamps" value="1"> <small>Timestamps</small>
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" checked="checked" name="model_softdelete" value="1"> <small>SoftDelete</small>
                    </label>-->
                </div>
            </li>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <label class="checkbox-inline">
                        <input type="checkbox" checked="checked" name="gerarFormRequest" id="Gerador_gerarFormRequest" value="1"> Gerar FormRequest
                    </label>
                </div>
            </li>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <label class="checkbox-inline">
                        <input type="checkbox" checked="checked" name="gerarController" id="Gerador_gerarController" value="1"> Gerar Controller
                    </label>
                </div>
            </li>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <label class="checkbox-inline">
                        <input type="checkbox" name="gerarMigration" id="Gerador_gerarMigration" value="1"> Gerar Migration <span style="color: red;"><small>Beta</small></span>
                    </label>
                </div>
            </li>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <label class="checkbox-inline">
                        <input type="checkbox" name="gerarSeed" id="Gerador_gerarSeed" value="1"> Gerar Seed <span style="color: red;"><small>Alpha</small></span>
                    </label>
                </div>
            </li>
        </ul>
    </div>

    <div class="col-md-6">
        <div class="adicionais_laravelMpog">
            <h5 class="titulo">Gerações Adicionais</h5>
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <label class="checkbox-inline">
                            <input type="checkbox" checked="checked" name="Adicionais[gerarPermissoesMPOG]" class="adicionais_laravelMpog_input" id="Gerador_gerarPermissoesMPOG" value="1"> Gerar Permissões (MPOG)
                        </label>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-condensed">

                    <div class="form-group">
                        <label class="checkbox-inline">
                            <input type="checkbox" checked="checked" name="Adicionais[gerarMenuMPOG]" class="adicionais_laravelMpog_input" id="Gerador_gerarMenuMPOG" value="1"> Gerar Menu (MPOG)
                        </label>
                    </div>
                    <small><i>Selecione um icone para o menu:</i></small>
                    <div class="form-group">
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="cog"><i class="fa fa-cog"></i></label>
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="cogs"><i class="fa fa-cogs"></i></label>
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="user"><i class="fa fa-user"></i></label>
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="users"><i class="fa fa-users"></i></label>
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="list"><i class="fa fa-list"></i></label>
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="paperclip"><i class="fa fa-paperclip"></i></label>
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="link"><i class="fa fa-link"></i></label>
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="tag"><i class="fa fa-tag"></i></label>
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="tags"><i class="fa fa-tags"></i></label>
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="book"><i class="fa fa-book"></i></label>
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="balance-scale"><i class="fa fa-balance-scale"></i></label>
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="bookmark"><i class="fa fa-bookmark"></i></label>
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="plus"><i class="fa fa-plus"></i></label>
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="minus"><i class="fa fa-minus"></i></label>
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="star"><i class="fa fa-star"></i></label>
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="tasks"><i class="fa fa-tasks"></i></label>
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="folder"><i class="fa fa-folder"></i></label>
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="inbox"><i class="fa fa-inbox"></i></label>
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="map"><i class="fa fa-map"></i></label>
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="question"><i class="fa fa-question"></i></label>
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="reply"><i class="fa fa-reply"></i></label>
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="share"><i class="fa fa-share"></i></label>
                        <label class="radio-icon"><input type="radio" class="form-request" name="Adicionais[dados][icone]" value="adjust"><i class="fa fa-adjust"></i></label>
                    </div>    
                </li>
            </ul>
        </div>
    </div>
</div>