<?php
namespace App\Repositories;

use App\Models\Permissoes;

/**
 * Repository dos usuários
 */
class PermissoesRepository extends Permissoes {
    
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