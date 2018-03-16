<?php
namespace App\Repositories;

use App\Models\Permissoes;

/**
 * Repository dos usuários
 */
class PermissoesRepository extends Permissoes {
    
    use RepositoryTraitEzequiel;
    
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