<?php
namespace App\Models;

use App\Models\ModelControl;

/**
 * Class Parametros
 * @package App\Models
 * @author Thiago do Amarante Farias <thiago.farias@jointecnologia.com.br>
 * @version 22/06/2017
 */
class Parametros extends ModelControl {
    
    public $table = 'parametros'; //Nome da tabela
    public $timestamps = false; //Remover os timestamps
    
    // Constantes da colna "tipo"
    const TIPO_DROPDOWN = 'dropdown';
    const TIPO_TEXT = 'text';
    const TIPO_INTEGER = 'integer';
    const TIPO_BOOLEAN = 'boolean';
    
    /**
     * Array Estática com valores da coluna "tipo"
     * @var array 
     */
    public static $tipos_list = [
        self::TIPO_DROPDOWN => 'DropDown',
        self::TIPO_TEXT => 'Texto',
        self::TIPO_INTEGER => 'Inteiro',
        self::TIPO_BOOLEAN => 'Boolean',
    ];
            
    /**
     * Variaveis seguras para uso e guardar dados 
     * @var array 
     */
    public $fillable = [
        'id',
        'nome',
        'parametro_editavel',
        'descricao',
        'status',
        'tipo',
        'valor',
        'dropdownValor',
        'dropdownNome',
        'inputLabelRadioTrue',
        'inputLabelRadioFalse',
    ];
    
    /**
     * Tipos nativos dos atributos
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nome' => 'string',
        'parametro_editavel' => 'integer',
        'descricao' => 'tinytext',
        'status' => 'integer',
        'tipo' => 'enum',
        'valor' => 'string',
    ];    
    
    /**
     * Label dos atributos
     * @var array 
     */
    public $labels = [
        'id' => 'ID',
        'nome' => 'Nome',
        'parametro_editavel' => 'Tipo Editável?',
        'descricao' => 'Descrição',
        'status' => 'Status',
        'tipo' => 'Tipo do Parâmetro',
        'valor' => 'Valor',
    ];
    
    /*
     * Busca o modelo de parametro_valores_tipos
     * @return object parametro_valores_tipos
    */
    public function ParametroValoresTipos() {
        return $this->hasMany('App\Models\ParametroValoresTipos', 'parametro_id', 'id');
    }
}