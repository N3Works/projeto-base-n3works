<?php
namespace App\Repositories;

use App\Models\PermissoesPerfis;

/**
 * Repository dos usuários
 */
class PermissoesPerfisRepository extends PermissoesPerfis {
    
    /**
     * Busca por ID
     * @param integer $id
     */
    public function buscarPorID($id) {
        $model = $this->findOrFail($id);
        if (!$model) {
            return false;
        }
        return $model;
    }

    /**
     * Deleta por ID
     * @param integer $id
     */
    public function deletar($id) {
        $model = $this->findOrFail($id);
        if ($this->findOrFail($id)) {
            $model->delete($id);
            return true;
        }
        return false;
    }
    
    /**
     * Atualiza por ID
     * @param integer $id
     * @param array $data
     */
    public function atualizar($id, $data = []) {
        $model = $this->findOrFail($id);
        if ($this->findOrFail($id)) {
            if (count($data)) {
                $model->fill($data);
            }
            $model->update($this->toArray());
            return true;
        }
        return false;
    }
    
    /**
     * Cadastro/Registrar na tabela
     * @param array $data
     * @return integer ID
     */
    public function cadastrar($data = []) {
        if (count($data)) {
            $this->fill($data);
        }
        return $this->insertGetId($this->toArray());
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