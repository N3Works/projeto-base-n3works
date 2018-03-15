<?php
namespace App\Models;

use App\Models\ModelControl;

/**
 * Class Perfis
 * @package App\Models
 * @author Thiago do Amarante Farias <thiago.farias@jointecnologia.com.br>
 * @version 29/06/2017
 */
class Perfis extends ModelControl {
    
    public $table = 'perfis';
    public $timestamps = false;
    
    /**
     * Variaveis seguras para uso e guardar dados 
     * @var array 
     */
    public $fillable = [
        'id',
        'nome',
    ];
    
    /**
     * Tipos nativos dos atributos
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nome' => 'string',
    ];    
    
    /**
     * Label dos atributos
     * @var array 
     */
    public $labels = [
        'id' => 'ID',
        'nome' => 'Nome',
    ];
    
    /*
     * Busca o modelo de users
     * @return object users
    */
    public function Users() {
        return $this->hasMany('App\Models\Users', 'perfil_id', 'id');
    }

    /*
     * Busca o modelo de Permissoes
     * @return object Permissoes
    */
    public function Permissoes() {
        return $this->belongsToMany('App\Models\Permissoes', 'permissoes_users', 'perfil_id', 'permissao_id');
    }
}