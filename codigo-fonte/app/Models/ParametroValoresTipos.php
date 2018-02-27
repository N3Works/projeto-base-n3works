<?php
namespace App\Models;

use App\Models\ModelControl;

/**
 * Class ParametroValoresTipos
 * @package App\Models
 * @author Thiago do Amarante Farias <thiago.farias@jointecnologia.com.br>
 * @version 22/06/2017
 */
class ParametroValoresTipos extends ModelControl {
    
    public $table = 'parametro_valores_tipos';
    public $timestamps = false;
    
    /**
     * Variaveis seguras para uso e guardar dados 
     * @var array 
     */
    public $fillable = [
        'id',
        'parametro_id',
        'value',
        'header',
    ];
    
    /**
     * Tipos nativos dos atributos
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'parametro_id' => 'integer',
        'value' => 'string',
        'header' => 'string',
    ];    
    
    /**
     * Label dos atributos
     * @var array 
     */
    public $labels = [
        'id' => 'ID',
        'parametro_id' => 'Parâmetro',
        'value' => 'Valor',
        'header' => 'Header',
    ];
    
    /*
     * Busca o modelo de parametros
     * @return object parametros
    */
    public function Parametros() {
        return $this->belongsTo('App\Models\Parametros', 'id', 'parametro_id');
    }

    /**
     * Realiza a consulta da tabela
     * @return array
     */
    public function consultar() {
        $consulta = self::select('*')->orderBy('id', 'DESC');
        return $consulta->get();
    }
}