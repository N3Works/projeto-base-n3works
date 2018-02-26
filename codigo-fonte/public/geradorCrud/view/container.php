
<div class="header clearfix">
    <div class="row">
        <div class="col-md-6">                        
            <h3 class="titulo">Gerador de Código</h3>
        </div>
        <div class="col-md-6 titulo_logo">
            <img src="img/logo.png" class="titulo_img">
        </div>
    </div>
    <hr>

    <div class="alert alert-danger" style="display: none;" role="alert"> <strong>Erro: </strong> Por favor preencher os campos destacados em vermelho. </div>
    <?php if(isset($response)) : ?>
        <div class="alert alert-<?php print ($response->success) ? 'success' : 'danger' ;?>" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <span><?php print $response->msg; ?></span>
        </div>
    <?php endif; ?>
</div>            

<form method="post" action="" id="form_gerador">
    <div class="content">
        <div class="row">    
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Gerador_framework" title="Framework">Framework</label>
                    <select name="Gerador[framework]" id="Gerador_framework" class="select2 form-control" >
                        <option value="">Selecione um Framework</option>
                        <option value="laravelMpog" selected="selected" >Laravel 5.3 (MPOG)</option>
                        <option value="teste" >Teste</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="tabs-gerador">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#conteudo" aria-controls="conteudo" role="tab" data-toggle="tab">Conteúdo</a></li>
                <li role="presentation"><a href="#config" aria-controls="config" role="tab" data-toggle="tab">Configuração</a></li>
                <li role="presentation"><a href="#opcionais" aria-controls="opcionais" role="tab" data-toggle="tab">Opcionais</a></li>
            </ul>
            <div class="tab-content">
                
                <div role="tabpanel" class="tab-pane active" id="conteudo">
                    <?php include_once('container/conteudo.php'); ?>
                </div>

                <div role="tabpanel" class="tab-pane" id="config">
                    <?php include_once('container/config.php'); ?>
                </div>

                <div role="tabpanel" class="tab-pane" id="opcionais">
                    <?php include_once('container/opcionais.php'); ?>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-success" id="gerador" >Gerar Modelos</button>
    <br><br><br>

    <!-- BEGIN Modals  -->
    <?php include_once('modals/modalLabels.php'); ?>
    <?php include_once('modals/modalDropdown.php'); ?>
    
</form>