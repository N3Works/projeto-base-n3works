/**
 * Objeto|Classe de formatação
 * @type object
 */
var appValidation = {
    
    /**
     * valida a entrada do email
     * @param {type} str
     * @returns bool
     */
    isEmail: function($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test( $email );
    },
 
    //Verifica se é array e retorna true/false
    isArray: function(obj) {
        if (Object.prototype.toString.call(obj) === '[object Array]') {
            return true;
        } else {
            return false;
        }
    },
 
    //Verifica se é objeto e retorna true/false
    isObject: function(obj) {
        if (Object.prototype.toString.call(obj) === '[object Object]') {
            return true;
        } else {
            return false;
        }
    },
    
    //Verifica se é function e retorna true/false
    isFunction: function(obj) {
        if (typeof obj == 'function') {
            return true;
        } else {
            return false;
        }
    },
    
    //Verifica se é undefined e retorna true/false
    isUndefined: function(obj) {
        if (typeof obj == 'undefined') {
            return true;
        } else {
            return false;
        }
    },
 
    /* [INI] Testa CPF  ------------------------------------------------------------------------------------- */
    isCPF: function(cpf) {
        var cpf = cpf.replace(/[^\d]+/g, '');
        var numeros, digitos, soma, i, resultado, digitos_iguais;
        digitos_iguais = 1;
        if (cpf.length < 11) {
            return false;
        }
        for (i = 0; i < cpf.length - 1; i++) {
            if (cpf.charAt(i) != cpf.charAt(i + 1)) {
                digitos_iguais = 0;
                break;
            }
        }
        if (!digitos_iguais) {
            numeros = cpf.substring(0, 9);
            digitos = cpf.substring(9);
            soma = 0;
            for (i = 10; i > 1; i--) {
                soma += numeros.charAt(10 - i) * i;
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0)) {
                return false;
            }
            numeros = cpf.substring(0, 10);
            soma = 0;
            for (i = 11; i > 1; i--) {
                soma += numeros.charAt(11 - i) * i;
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1)) {   
                return false;
            }
            return true;
        } else {
            return false;
        }
    }
};