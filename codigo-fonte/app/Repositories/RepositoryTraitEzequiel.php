<?php
namespace App\Repositories;

/**
 * Trait de funções básicas sem regra de negócio
 * @author Ezequiel Zik
 */
trait RepositoryTraitEzequiel {
    
     /**
     * Deleta por ID
     * @param integer $id
     */
    public function deletar($id) {
        $model = $this->findOrFail($id);
        if ($model) {
            $model->delete($id);
            return true;
        }
        return false;
    }
    
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
     * Atualiza por ID
     * @param integer $id
     * @param array $data
     */
    public function atualizar($id, $data = []) {
        $model = $this->findOrFail($id);
        if ($model) {
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
     *
     * @param array $filter
     * @return \Illuminate\Support\Collection
     */
    public function consultar(array $filter = [], $expression = '*') {
        if(empty($filter)) {
            $filter = $this->toArray();
        }
        $builder = self::selectRaw($expression);
        $builder->orderBy('id', 'DESC');
        return $builder->get();
    }
    
    /**
     * Retorna tudo
     * @return collective
     */
    public function buscarTodos() {
        return $this->get();
    }
}