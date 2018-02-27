<?php
namespace App\Models;

use App\Models\ModelControl;

/**
 * Class Permissoes
 * @package App\Models
 * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 * @version 31/05/2017
 */
class Permissoes extends ModelControl {
    
    public $table = 'permissoes';
    public $timestamps = false;
    
    /**
     * Variaveis seguras para uso e guardar dados 
     * @var array 
     */
    public $fillable = [
        'id',
        'permissao',
        'descricao',
    ];
    
    /**
     * Tipos nativos dos atributos
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'permissao' => 'string',
        'descricao' => 'string',
    ];    
    
    /**
     * Label dos atributos
     * @var array 
     */
    public $labels = [
        'id' => 'ID',
        'permissao' => 'Permissão',
        'descricao' => 'Descrição',
    ];
    
    /*
     * Busca o modelo de perfis
     * @return object perfis
    */
    public function Perfis() {
        return $this->belongsToMany('App\Models\Perfis', 'permissoes_perfis', 'permissao_id', 'perfil_id');
    }

    /**
     * Realiza a consulta da tabela
     * @return array
     */
    public function consultar() {
        $consulta = self::select('*')->orderBy('permissao', 'ASC');
        
        if ($this->permissao) {
            $consulta->where('permissao', 'like', '%'.$this->permissao.'%');
        }
        
        if ($this->descricao) {
            $consulta->where('descricao', 'like', '%'.$this->descricao.'%');
        }
        
        return $consulta->get();
    }
}