<?php
namespace App\Models;

use App\Models\ModelControl;

/**
 * Class Menus
 * @package App\Models
 * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 * @version 31/05/2017
 */
class Menus extends ModelControl {
    
    public $table = 'menus';
    
    /**
     * Variaveis seguras para uso e guardar dados 
     * @var array 
     */
    public $fillable = [
        'id',
        'header',
        'controller',
        'action',
        'icon',
        'parent',
        'order',
        'permissao_id',
        'created_at',
        'updated_at',
    ];
    
    /**
     * Tipos nativos dos atributos
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'header' => 'string',
        'controller' => 'string',
        'action' => 'string',
        'icon' => 'string',
        'parent' => 'integer',
        'order' => 'integer',
        'permissao_id' => 'integer',
        'created_at' => 'data_tempo',
        'updated_at' => 'data_tempo',
    ];    
    
    /**
     * Label dos atributos
     * @var array 
     */
    public $labels = [
        'id' => 'ID',
        'header' => 'Header',
        'controller' => 'Controller',
        'action' => 'Action',
        'icon' => 'Icon',
        'parent' => 'Menu Pai',
        'order' => 'Ordem',
        'permissao_id' => 'Permissão',
        'created_at' => 'Data de criação',
        'updated_at' => 'Data de atualização',
    ];
    
    /*
     * Busca o modelo de Permissoes
     * @return object Permissoes
     */
    public function Permissao() {
        return $this->hasOne('App\Models\Permissoes', 'id', 'permissao_id');
    }
    
    /**
     * Realiza a consulta da tabela
     * @return array
     */
    public function consultar() {
        $consulta = self::select('*')->orderByRaw(' parent ASC, \'order\' ASC');
        
        if ($this->header) {
            $consulta->where('header', 'like', '%'.$this->header.'%');
        }
        
        if ($this->parent) {
            $consulta->where('parent', $this->parent);
        }
        
        return $consulta->get();
    }
    
    /**
     * Gera menus conforme banco de dados
     * @return array
     */
    public static function gerarMenu(){
        $collection = self::select('*')->orderBy('parent')->get();
        
        $mapper = [];

        if($collection->count() > 0) {
            
//            $gate = app(Gate::class);
            
            foreach($collection as $model) {
                
                $array = $model->toArray();
                
//                if(!empty($array['permission'])){
//                    
//                    if(!$gate->check($array['permission'], 'ModelPolicy')) {
//                        continue;
//                    }
//                }
//                if(!static::addRule($array)) {
//                    continue;
//                }
                
                // Filho
                if($model->parent > 0){
                    
                    if(array_key_exists($model->parent , $mapper)){
                        
                        if(array_key_exists('child' , $mapper[$model->parent])){
                            
                            $mapper[$model->parent]['child'][$model->id] = $array;
                        }
                        else {
                            $mapper[$model->parent]['child'][$model->id] = $array;
                        }
                    }
                }// Pai
                else {
                    $mapper[$model->id] = $array;
                }
            }
        }
        
        return $mapper;
    }
}