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
     * @param array $dados
     */
    public function atribuirPermissao($dados) {
        $permissoes = $this->where('perfil_id', $dados['perfil_id'])
                ->where('permissao_id', $dados['permissao_id']);
        $msg = '';
        
        if ($dados['status'] == 'ativo') {
            $permissoes->delete();
            $msg = 'Permissão removida com sucesso.';
        } else {
            $permissoes->insert([
                'permissao_id' => $dados['permissao_id'], 
                'perfil_id' => $dados['perfil_id']
            ]);
            $msg = 'A permissão foi atribuida com sucesso.';
        }
        
        self::setar(); //Seta as novas permissões na sessão
        return $msg;
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