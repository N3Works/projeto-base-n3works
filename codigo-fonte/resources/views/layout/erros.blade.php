<?php
    Util::callFlashErrorMessage($errors->all());
    echo  Util::showMessage() ;
    //Limpar o flash message depois de mostrar a mensagem na tela
    flash()->message("");
?>