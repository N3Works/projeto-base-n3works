<?php
namespace App\Models;

use App\Models\ModelControl;

/**
 * Class PermissoesPerfis
 * @package App\Models
 * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 * @version 31/05/2017
 */
class PermissoesPerfis extends ModelControl {
    
    public $table = 'permissoes_perfis';
    
    /**
     * Variaveis seguras para uso e guardar dados 
     * @var array 
     */
    public $fillable = [
        'id',
        'permissao_id',
        'perfil_id',
    ];
    
    /**
     * Tipos nativos dos atributos
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'permissao_id' => 'integer',
        'perfil_id' => 'integer',
    ];    
    
    /**
     * Label dos atributos
     * @var array 
     */
    public $labels = [
        'id' => 'ID',
        'permissao_id' => 'Permissão',
        'perfil_id' => 'Perfil',
    ];
    
    /*
     * Busca o modelo de perfis
     * @return object perfis
    */
    public function Perfis() {
        return $this->belongsTo('App\Models\Perfis', 'id', 'perfil_id');
    }

    /*
     * Busca o modelo de permissoes
     * @return object permissoes
    */
    public function Permissoes() {
        return $this->belongsTo('App\Models\Permissoes', 'permissao_id', 'id');
    }
    
    /**
     * Atribui permissão ao usuário
     * @param integer $id
     * @param string $permissao
     * @param integer $perfil_id
     * @return string
     */
    public function atribuirPermissao($id, $permissao, $perfil_id) {
        $permissoes = $this->where('perfil_id', $perfil_id)
                ->where('permissao_id', $id);
        $msg = '';
        
        if ($permissao == 'ativo') {
            if (!$permissoes->count()) {
                $permissoes->insert([
                    'permissao_id' => $id, 
                    'perfil_id' => $perfil_id
                ]);
            }
        } else {
            if ($permissoes->count()) {
                $permissoes->delete();
            }
        }
        
        self::setar(); //Seta as novas permissões na sessão
        return 'As permissões foram salvas com sucesso!';
    }
    
    /**
     * Seta as permissões do usuário na sessão
     */
    public static function setar() {
        $permissoes = self::join('permissoes', 'permissoes.id', '=', 'permissoes_perfis.permissao_id')
            ->select('permissoes.permissao')
            ->where('permissoes_perfis.perfil_id', \Auth::user()->perfil_id)
            ->pluck('permissao');
        
        $session = app('session.store');
        $session->set('permissoes', $permissoes->toArray());
    }
}