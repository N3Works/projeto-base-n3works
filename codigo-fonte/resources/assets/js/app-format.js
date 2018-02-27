/**
 * Objeto|Classe de formatação
 * @type object
 */
var appFormat = {
    value: '', /* Valor para ser utilizado entro das funções */
    
    /**
     * Desformata numeros.
     * @param {string|integer} newValue
     * @returns {Number|formatApp.desformatar.valor|String}
     */
    desformatar: function(newValue) {
        var valor = this.value;
        if (!validationApp.isUndefined(newValue)) {
            valor = newValue;
        }
        
        var retorno = 0;
        if (typeof valor === 'string') {
            var removeBRFormat  = valor.replace(/[\R$.]/g, '');
            retorno = removeBRFormat.replace(/[\,]/g, '.')*1;
        }
        if (typeof valor === 'number') {
            retorno = valor;
        }

        if (this.value) {
            this.value = retorno;       
        }
        
        return retorno;
    },
    
    /**
     * Quebra a data e formata para numerico sem caracteres especiais
     * @param {string} newValue
     * @returns {formatApp.dateBrToNumber.brokenDate|Array}
     */
    dateBrToNumber: function(newValue){
        var value = this.value;
        if (!validationApp.isUndefined(newValue)) {
            value = newValue;
        }
        
        var brokenDate = value.split('/');
        var retorno = brokenDate[2]+brokenDate[1]+brokenDate[0];
                
        if (this.value) {
            this.value = retorno;       
        }
        
        return retorno;
    },
    
    /**
     * Corta os espaços antes de depois de uma string
     * @param {string} str
     * @param {string} charlist
     * @returns {String}
     */
    trim: function(str, charlist) {
        var value = this.value;
        if (!validationApp.isUndefined(str)) {
            value = str;
        }
        
        //   example 1: trim('    Kevin van Zonneveld    ')
        //   returns 1: 'Kevin van Zonneveld'
        //   example 2: trim('Hello World', 'Hdle')
        //   returns 2: 'o Wor'
        //   example 3: trim(16, 1)
        //   returns 3: '6'
        var whitespace = [
            ' ', '\n', '\r', '\t', '\f',
            '\x0b', '\xa0', '\u2000', '\u2001',
            '\u2002', '\u2003', '\u2004', '\u2005',
            '\u2006', '\u2007', '\u2008', '\u2009',
            '\u200a', '\u200b', '\u2028', '\u2029',
            '\u3000'
        ].join('');
        var l = 0;
        var i = 0;
        value += '';
        if (charlist) {
            whitespace = (charlist + '').replace(/([[\]().?/*{}+$^:])/g, '$1');
        }
        l = value.length;
        for (i = 0; i < l; i++) {
            if (whitespace.indexOf(value.charAt(i)) === -1) {
                value = value.substring(i);
                break
            }
        }
        l = value.length;
        for (i = l - 1; i >= 0; i--) {
            if (whitespace.indexOf(value.charAt(i)) === -1) {
                value = value.substring(0, i + 1);
                break;
            }
        }
        
        var retorno = whitespace.indexOf(value.charAt(0)) === -1 ? value : '';
                
        if (this.value) {
            this.value = retorno;       
        }
        
        return retorno;
    },
    
    /**
     * Formata numero para o formato desejado
     * @param {integer} newValue Valor novo
     * @param {integer} casa Numero de Casas
     * @param {string} centena Separador
     * @param {string} decimal Separador
     * @returns {String}
     */
    formatMoney: function(casa, centena, decimal, newValue) {
        var value = this.value;
        if (!validationApp.isUndefined(newValue)) {
            value = newValue;
        }
        
        var casa = isNaN(casa = Math.abs(casa)) ? 2 : casa, 
            centena = centena == undefined ? "." : centena, 
            decimal = decimal == undefined ? "," : decimal, 
            s = value < 0 ? "-" : "", 
            i = String(parseInt(value = Math.abs(Number(value) || 0).toFixed(casa))), 
            j = (j = i.length) > 3 ? j % 3 : 0;
    
        var retorno = s + (j ? i.substr(0, j) + decimal : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + decimal) + (casa ? centena + Math.abs(value - i).toFixed(casa).slice(2) : "");
                
        if (this.value) {
            this.value = retorno;       
        }
        
        return retorno;
    }
};