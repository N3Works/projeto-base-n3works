$(document).ready(function() {
    $(document).on('click', '.salvarSenha', alterarSenha);
});

/**
 * Alterar senha do usuário
 * @returns {undefined}
 */
function alterarSenha() {
    var nova_senha = $('.nova_senha').val();
    var nova_senha_confirmar = $('.nova_senha_confirmar').val();
    
    if (nova_senha != nova_senha_confirmar) {
        appUtil.createFlashMesseger('Senha inválida na confirmação.', false);
        return;
    }
    
    $('form').submit();
}