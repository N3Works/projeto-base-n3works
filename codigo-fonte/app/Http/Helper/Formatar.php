<?php
namespace App\Http\Helper;

use DateTime;
use Carbon\Carbon;

/**
 * Classe de formatação dos valores do sistema
 * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 */
class Formatar {
    
	/**
     * DateTime formatar nomeclatura ( Dias da semana )
     * @var array 
     */
    public static $semana = [
        'Sun' => 'Domingo', 
        'Mon' => 'Segunda-Feira',
        'Tue' => 'Terca-Feira',
        'Wed' => 'Quarta-Feira',
        'Thu' => 'Quinta-Feira',
        'Fri' => 'Sexta-Feira',
        'Sat' => 'Sábado'
    ];
    
    /**
     * DateTime formatar nomeclatura ( Meses )
     * @var array 
     */
    public static $mes_extenso = [
        'Jan' => 'Janeiro',
        'Feb' => 'Fevereiro',
        'Mar' => 'Marco',
        'Apr' => 'Abril',
        'May' => 'Maio',
        'Jun' => 'Junho',
        'Jul' => 'Julho',
        'Aug' => 'Agosto',
        'Nov' => 'Novembro',
        'Sep' => 'Setembro',
        'Oct' => 'Outubro',
        'Dec' => 'Dezembro'
    ];
	
    /**
     * Formata numero
     * @param string  $number         Numero a ser formatado
     * @param string  $type           Tipo de Mascara ( DataBase, Brasileira)
     * @param integer $decimals       Quantos decimais deve aparecer
     * @param string  $dec_point      Qual ponteiro o decimal deve mostrar
     * @param string  $thousands_sep  Qual ponteiro o milhar deve mostrar
     * @return string
     */
    public static function number($number, $type = null, $decimals = 2, $dec_point = ',', $thousands_sep = '.') {
        
        $verifyNumber = str_replace(array('.', ','), array('', ''), $number);
        
        if (empty(trim($number)) && is_numeric($verifyNumber)) {
            return 'NaN';
        }
        
        if ($type == 'BR') {
            return number_format($number, '2', ',', '.');
            
        } else if ($type == 'DB') {
            return str_replace(array('.', ','), array('', '.'),$number);
        } else {
            return number_format($number, $decimals, $dec_point, $thousands_sep);
        }
    }
    
    /**
     * Formata a data passada
     * @param string  $date     Data
     * @param string  $type     Tipo de Data ( DataBase, Brasileira, Estados Unidos)
     * @param boolean $seconds  Se deve mostrar os segundos 00:00
     * @param boolean $time     Se deve mostrar o tempo 00:00:00
     * @return string
     */
    public static function dateDbToAll($date, $type = 'BR', $seconds = true, $time = false) {
        
        if (empty($date)) {
            return null;
        }
        $dateTime = new DateTime($date);
        
        $time = ($time ? 'H:i' . ($seconds ? ':s' : '') : '');

        if ($type == 'BR') {
            return $dateTime->format('d/m/Y ' . $time);
            
        } else if ($type == 'US') {
            return $dateTime->format('m/d/Y ' . $time);
        }
    }
    
    /**
     * Formata a data Brasileira para o tipo passado
     * @param string  $date     Data
     * @param string  $type     Tipo de Data ( DataBase, Estados Unidos)
     * @param boolean $seconds  Se deve mostrar os segundos 00:00
     * @param boolean $time     Se deve mostrar o tempo 00:00:00
     * @return string
     */
    public static function dateBrToAll($date, $type = 'DB', $seconds = true, $time = false) {
        if (empty($date)) {
            return null;
        }
        
        $time = ($time ? ' H:i' . ($seconds ? ':s' : '') : '');
        
        $dateTime = DateTime::createFromFormat('d/m/Y'.$time, $date);
        
        if ($type == 'US') {
            return $dateTime->format('d/m/Y' . $time);
        } else if ($type == 'DB') {
            return $dateTime->format('Y-m-d' . $time);
        }
    }
    
    /**
     * Coloca uma mascara no valor passado com (#)
     * @param string $val
     * @param string $mask
     * @return string
     */
    public static function mask($val, $mask) {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k]))
                    $maskared .= $val[$k++];
            }
            else {
                if (isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }
    
    /**
     * Formatação de Data pelo carbon
     * @param string $string
     * @param string $input Formato Atual
     * @param string $output Formato Novo
     * @return string
     */
    public static function carbon($string, $input, $output) {
        
        if(empty($string)) return '';
        
        $carbon = Carbon::createFromFormat($input, $string);
        
        return ($carbon->timestamp > 0) ?  $carbon->format($output) : '';
    }
    
    /**
     * Formata bytes conforme tamanhos
     * @param integer $bytes
     * @param integer $precision
     * @return string
     */
    public static function formatBytes($bytes, $precision = 2) { 
        $unidades = ['B', 'KB', 'MB', 'GB', 'TB']; 

        $bytes = max($bytes, 0); 
        $rest = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $rest = min($rest, count($unidades) - 1); 

        return round($bytes, $precision) . ' ' . $unidades[$rest]; 
    } 
    
    /**
     * Formata bytes conforme tamanhos
     * @param integer $tamanho
     * @return string
     */
    public static function bytes($tamanho) {
        $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $tamanho > 0 ? floor(log($tamanho, 1024)) : 0;
        return number_format($tamanho / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }
}
