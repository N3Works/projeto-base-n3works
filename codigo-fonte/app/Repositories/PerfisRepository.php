<?php
namespace App\Repositories;

use App\Models\Perfis;

/**
 * Repository dos usuários
 */
class PerfisRepository extends Perfis {
    
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
        $consulta = self::select('*')->orderBy('id', 'DESC');
        return $consulta->get();
    }
}