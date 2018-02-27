<?php
namespace App\Models;

use App\Models\ModelControl;

/**
 * Class Anexos
 * @package App\Models
 * @author Ezequiel <email@email.com>
 * @version 04/07/2017
 */
class Anexos extends ModelControl {
    
    public $table = 'anexos';
    
    /**
     * Variaveis seguras para uso e guardar dados 
     * @var array 
     */
    public $fillable = [
        'id',
        'filename',
        'name',
        'size',
        'mime_type',
        'created_at',
        'updated_at',
        'nome_fantasia',
        'descricao',
    ];
    
    /**
     * Tipos nativos dos atributos
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'filename' => 'string',
        'name' => 'string',
        'size' => 'bigint',
        'mime_type' => 'string',
        'created_at' => 'data_tempo',
        'updated_at' => 'data_tempo',
        'nome_fantasia' => 'string',
        'descricao' => 'string',
    ];    
    
    /**
     * Label dos atributos
     * @var array 
     */
    public $labels = [
        'id' => 'ID',
        'filename' => 'Caminho',
        'name' => 'Arquivo',
        'size' => 'Tamanho',
        'mime_type' => 'Tipo',
        'created_at' => 'Data de criação',
        'updated_at' => 'Data de atualização',
        'descricao' => 'Descrição',
        'nome_fantasia' => 'Nome',
    ];
    
    /**
     * Realiza a consulta da tabela
     * @return array
     */
    public function consultar() {
        $consulta = self::select('*')->orderBy('id', 'DESC');
        return $consulta->get();
    }
}