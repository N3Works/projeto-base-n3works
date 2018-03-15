<?php echo '<?php'.PHP_EOL; ?>
namespace App\Repositories;

use App\Models\<?php echo $nomeTabelaModel; ?>;

/**
 * Class <?php echo $nomeTabelaModel.'Repository'.PHP_EOL; ?>
 * @package App\Models
 * @author <?php echo $this->dados_modelo['extra']['nomeDesenv']; ?> <<?php echo $this->dados_modelo['extra']['emailDesenv'].PHP_EOL; ?>>
 * @version <?php echo date('d/m/Y').PHP_EOL; ?>
 */
class <?php echo $nomeTabelaModel; ?>Repository extends <?php echo $nomeTabelaModel; ?> {
    
    /**
     * Busca por ID
     * @param integer $id
     */
    public function buscarPorID($id) {
        $model = $this->findOrFail($id);
        if ($model) {
            return false;
        }
        
<?php foreach ($this->dados_modelo['tabela']['dados'] as $coluna) { ?>
<?php if ($coluna['tipo_coluna'] == 'date') { ?>
        $model-><?php echo $coluna['nome_coluna']; ?> = !$model-><?php echo $coluna['nome_coluna']; ?> ? null : \App\Http\Helper\Formatar::dateDbToAll($model-><?php echo $coluna['nome_coluna']; ?>, 'BR');
<?php } ?>
<?php if ($coluna['tipo_coluna'] == 'datetime') { ?>
        $model-><?php echo $coluna['nome_coluna']; ?> = !$model-><?php echo $coluna['nome_coluna']; ?> ? null : \App\Http\Helper\Formatar::dateDbToAll($model-><?php echo $coluna['nome_coluna']; ?>, 'BR', true, true);
<?php } ?>
<?php if ($coluna['tipo_input'] == 'porcentual') { ?>
        $model-><?php echo $coluna['nome_coluna']; ?> = ($query-><?php echo $coluna['nome_coluna']; ?> ? \App\Http\Helper\Formatar::number($query-><?php echo $coluna['nome_coluna']; ?>, 'BR', 2, 2). '%' : '');
<?php } ?>
<?php } ?>
        
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
            
<?php foreach ($this->dados_modelo['tabela']['dados'] as $coluna) { ?>
<?php if ($coluna['tipo_coluna'] == 'date') { ?>
        $model-><?php echo $coluna['nome_coluna']; ?> = !$model-><?php echo $coluna['nome_coluna']; ?> ? null : \App\Http\Helper\Formatar::dateBrToAll($model-><?php echo $coluna['nome_coluna']; ?>, 'DB');
<?php } ?>
<?php if ($coluna['tipo_coluna'] == 'datetime') { ?>
        $model-><?php echo $coluna['nome_coluna']; ?> = !$model-><?php echo $coluna['nome_coluna']; ?> ? null : \App\Http\Helper\Formatar::dateBrToAll($model-><?php echo $coluna['nome_coluna']; ?>, 'DB', true, true);
<?php } ?>
<?php if ($coluna['tipo_input'] == 'porcentual') { ?>
        if ($model-><?php echo $coluna['nome_coluna']; ?>) {
            $model-><?php echo $coluna['nome_coluna']; ?> = str_replace('%', '', \App\Http\Helper\Formatar::number($model-><?php echo $coluna['nome_coluna']; ?>, 'DB', 2));
        }
<?php } ?>
<?php } ?>
        
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
        
<?php foreach ($this->dados_modelo['tabela']['dados'] as $coluna) { ?>
<?php if ($coluna['tipo_coluna'] == 'date') { ?>
        $this-><?php echo $coluna['nome_coluna']; ?> = !$this-><?php echo $coluna['nome_coluna']; ?> ? null : \App\Http\Helper\Formatar::dateBrToAll($this-><?php echo $coluna['nome_coluna']; ?>, 'DB');
<?php } ?>
<?php if ($coluna['tipo_coluna'] == 'datetime') { ?>
        $this-><?php echo $coluna['nome_coluna']; ?> = !$this-><?php echo $coluna['nome_coluna']; ?> ? null : \App\Http\Helper\Formatar::dateBrToAll($this-><?php echo $coluna['nome_coluna']; ?>, 'DB', true, true);
<?php } ?>
<?php if ($coluna['tipo_input'] == 'porcentual') { ?>
        if ($this-><?php echo $coluna['nome_coluna']; ?>) {
            $this-><?php echo $coluna['nome_coluna']; ?> = str_replace('%', '', \App\Http\Helper\Formatar::number($this-><?php echo $coluna['nome_coluna']; ?>, 'DB', 2));
        }
<?php } ?>
<?php } ?>
        
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

<?php foreach ($this->dados_modelo['tabela']['dados'] as $coluna) { ?> 
        
<?php if (in_array($coluna['nome_coluna'], ['nome', 'name', 'descricao', 'detalhe', 'observacao', 'cpf', 'cnpj'])) { ?>
        if($this-><?php print $coluna['nome_coluna']; ?>) {
            $builder->where('<?php print $coluna['nome_coluna']; ?>', 'like', '%'.$this-><?php print $coluna['nome_coluna']; ?>.'%');
        }
<?php } else if($coluna['tipo_input'] == 'situacao') { ?>
        if($this-><?php print $coluna['nome_coluna']; ?> != null) {
            $builder->where('<?php print $coluna['nome_coluna']; ?>', $this-><?php print $coluna['nome_coluna']; ?>);
        }
<?php } else { ?>
                    
        if($this-><?php print $coluna['nome_coluna']; ?>) {
<?php if ($coluna['tipo_coluna'] == 'date') { ?>
                $this-><?php echo $coluna['nome_coluna']; ?> =  \App\Http\Helper\Formatar::dateBrToAll($this-><?php echo $coluna['nome_coluna']; ?>, 'DB');
<?php } else if ($coluna['tipo_coluna'] == 'datetime') { ?>
                $this-><?php echo $coluna['nome_coluna']; ?> =  \App\Http\Helper\Formatar::dateBrToAll($this-><?php echo $coluna['nome_coluna']; ?>, 'DB', true, true);
<?php } ?>
            $builder->where('<?php print $coluna['nome_coluna']; ?>', $this-><?php print $coluna['nome_coluna']; ?>);
        }
<?php } ?>
        
<?php } ?>        

        $builder->orderBy('id', 'DESC');

        return $builder->get();
    }
}