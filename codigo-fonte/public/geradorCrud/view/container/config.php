<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="Gerador_nomeTabela" title="Nome da tabela">Tabela / Entidade<span class="required">*</span></label>
            <select name="Gerador[nomeTabela]" id="Gerador_nomeTabela" class="select2 form-control" >
                <option value="">Selecione</option>
                <?php
                foreach($gerador->getTables() as $modelo) { 
                ?>
                    <option value="<?php echo $modelo['value']; ?>"><?php echo $modelo['name'] . ' ( ' . $modelo['value'] . ' ) '; ?></option>
                <?php                                           
                }
                ?>
            </select>
            <a style="display: none;" href="javascript:void(0)" class="ajustarLabels"><button type="button" class="btn btn-primary ">Ajustar Labels</button></a>
        </div>

        <div class="form-group">
            <label for="entidadePlural" title="Nome do Modelo/Entidade no Plural">Nome do Modelo/Entidade no Plural <small>(Título e comentários)</small><span class="required">*</span></label>
            <input type="text" class="form-control" id="entidadePlural" name="Gerador[entidadePlural]" placeholder="Plural" value="<?php print $request['Gerador']['entidadePlural']; ?>">
        </div>

        <div class="form-group">
            <label for="entidadeSingular" title="Nome do Modelo/Entidade no Singular">Nome do Modelo/Entidade no Singular <small>(Título e comentários)</small><span class="required">*</span></label>
            <input type="text" class="form-control" id="entidadeSingular" name="Gerador[entidadeSingular]" placeholder="Singular" value="<?php print $request['Gerador']['entidadeSingular']; ?>">
        </div>

        <div class="form-group">
            <label for="generoEntidade" title="Gênero do Modelo/Entidade">Gênero do Modelo/Entidade<span class="required">*</span></label>
            <select class="form-control select2" id="generoEntidade" name="Gerador[generoEntidade]" value="<?php print $request['Gerador']['entidadeEntidade']; ?>">
                <option value="M">Masculino</option>
                <option value="F">Feminino</option>
            </select>
        </div>
    </div>
</div>