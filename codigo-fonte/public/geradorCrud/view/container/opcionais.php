<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="nomeDesenv" title="Nome do desenvolvedor">Nome do Desenvolvedor</label>
            <input type="text" class="form-control" id="nomeDesenv" name="Gerador[nomeDesenv]" placeholder="Nome" value="<?php print $request['Gerador']['nomeDesenv']; ?>">
        </div>

        <div class="form-group">
            <label for="emailDesenv" title="E-mail do desenvolvedor">E-mail do Desenvolvedor</label>
            <input type="email" class="form-control" id="emailDesenv" name="Gerador[emailDesenv]" placeholder="E-mail" value="<?php print $request['Gerador']['emailDesenv']; ?>">
        </div>
    </div>
</div>