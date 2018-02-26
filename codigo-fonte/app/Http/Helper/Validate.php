<?php
namespace App\Http\Helper;

class Validate {

    public static function cpf($cpf) {
        /*
         * Salva em $cpf apenas numeros, isso permite receber o cpf em diferentes formatos,
         * como "000.000.000-00", "00000000000", "000 000 000 00"
         */
        $cpf = preg_replace('/\D/', '', $cpf);
        $num = array();

        /* Cria um array com os valores */
        for ($i = 0; $i < (strlen($cpf)); $i++) {

            $num[] = $cpf[$i];
        }

        if (count($num) != 11) {
            return false;
        } else {
            /*
              Combinações como 00000000000 e 22222222222 embora
              não sejam cpfs reais resultariam em cpfs
              válidos após o calculo dos dígitos verificares e
              por isso precisam ser filtradas nesta parte.
             */
            for ($i = 0; $i < 10; $i++) {
                if ($num[0] == $i && $num[1] == $i && $num[2] == $i && $num[3] == $i && $num[4] == $i && $num[5] == $i && $num[6] == $i && $num[7] == $i && $num[8] == $i) {
                    return false;
                    break;
                }
            }
        }
        /*
          Calcula e compara o
          primeiro dígito verificador.
         */
        $j = 10;
        for ($i = 0; $i < 9; $i++) {
            $multiplica[$i] = $num[$i] * $j;
            $j--;
        }
        $soma = array_sum($multiplica);
        $resto = $soma % 11;
        if ($resto < 2) {
            $dg = 0;
        } else {
            $dg = 11 - $resto;
        }
        if ($dg != $num[9]) {
            return false;
        }
        /*
          Calcula e compara o
          segundo dígito verificador.
         */
        $j = 11;
        for ($i = 0; $i < 10; $i++) {
            $multiplica[$i] = $num[$i] * $j;
            $j--;
        }
        $$soma = array_sum($multiplica);
        $resto = $$soma % 11;
        if ($resto < 2) {
            $dg = 0;
        } else {
            $dg = 11 - $resto;
        }
        if ($dg != $num[10]) {
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * Valida o CNPJ
     * @param string $cnpj
     * @return boolean
     */
    public static function cnpj($cnpj) {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
        
        // Valida tamanho
        if (strlen($cnpj) != 14) {
            return false;
        }
        
        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        
        $resto = $soma % 11;
        if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto)) {   
            return false;
        }
        
        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
                $soma += $cnpj{$i} * $j;
                $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
    }
}
