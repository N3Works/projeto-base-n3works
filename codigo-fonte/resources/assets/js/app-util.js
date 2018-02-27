/**
 * Objeto|Classe de utilidades
 * @type object
 */
var appUtil = {
    
    /**
     * Mensagens do sistema ( Erro, Sucesso, Infomação )
     * @param {string} message
     * @param {string} target
     * @param {string} tipo
     * @returns {undefined}
     */
    createFlashMesseger: function(message, tipo, target) {
        var css = '';
        var icon = '';
        if (tipo == 'success' || tipo === true || tipo == 'true') {
            css  = 'success';
            icon = 'check';
        }

        if (tipo == 'danger' || tipo === false || tipo == 'false') {
            css  = 'danger';
            icon = 'remove';
        }

        if (tipo == 'info') {
            css  = 'info';
            icon = 'info';
        }
        
        if (appValidation.isUndefined(target)) {
            target = '#flashMensager';
        }
        
        var container = $(target);

        container.append($.parseHTML(
            '<div class="alert alert-' + css +'">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
            '<i class="fa fa-' + icon +'"></i> ' + message +
            '</div>'
        ));

        var position = container.position();

        window.scrollTo(parseInt(position.top), 0);
    },
    
    /**
     * Ajusta o confirm para padronizar os botões
     * @param {string} message
     * @param {function} callBackFunction
     * @returns {undefined}
     */
    confirmBox: function(message, callBackFunction) {
       bootbox.confirm({
           message: message,
           buttons: {
               confirm: {
                   label: 'Sim',
                   className: 'btn-success'
               },
               cancel: {
                   label: 'Não',
                   className: 'btn-danger'
               }
           },
           callback: callBackFunction
       });
    },
    
    /**
     * Limpa o cookie por nome
     * @param {string} name
     * @returns {undefined}
     */
    limparCookie: function(name) {
        createCookie(name,"",-1);
    },
    
    /**
     * Função para fazer o sistema mimi
     * @param {integer} delay
     * @returns {undefined}
     */
    sleep: function(delay) {
        var start = new Date().getTime();
        while (new Date().getTime() < start + delay);
    }
}