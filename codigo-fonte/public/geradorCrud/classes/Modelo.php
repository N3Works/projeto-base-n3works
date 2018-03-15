<?php
include_once('Banco.php');

class Modelo extends Banco {
    
    public $dados_modelo = array();
    
    protected $timestamps = false; //Coisa do Pedrotti -> Por isso ta aqui...
    protected $softdelete = false; //Coisa do Pedrotti -> Por isso ta aqui...
    
    /**
     * Retorna o caminho completo até os controllers.
     * 
     * @return string
     */
    public function montarCaminho($tipo) {
        $caminho = '/var/www/html';
        
        switch($tipo) {
            
            case 'assets':
                $caminhoTipo = $caminho.'/resources/assets/js/'.$this->nome_tabela;
                break; 
            
            case 'request':
                $caminhoTipo = $caminho.'/app/Http/Requests';
                break;
                
            case 'datatables':
                $caminhoTipo = $caminho.'/app/DataTables';
                break;
            
            case 'controller':
                $caminhoTipo = $caminho.'/app/Http/Controllers';
                break;

            case 'view':
                $caminhoTipo = $caminho.'/resources/views/'.$this->nome_tabela;
                break;
            
            case 'search':
                $caminhoTipo = $caminho.'/resources/views/'.$this->nome_tabela.'/index';
                break;
                
            case 'model':
                $caminhoTipo = $caminho.'/app/Models';
                break; 
            
            case 'repository':
                $caminhoTipo = $caminho.'/app/Repositories';
                break; 

            case 'migration':
                $caminhoTipo = $caminho.'/database/migrations';
                break;
            
            case 'seed':
                $caminhoTipo = $caminho.'/database/seeds';
                break;
        }
        
        if (!is_dir($caminhoTipo)) {
            mkdir($caminhoTipo);
        }

        return $caminhoTipo;
    }
    
    public function getPrimaryId(){
        
        $string = 'id';
        
        foreach($this->dados_modelo['tabela']['dados'] as $coluna) {
            
            if($coluna['primaria']) {        
                $string = $coluna['nome_coluna'];
                break;
            } 
        }
        
        return $string;
    }
    
    /**
     * Gera dados do modelo
     * @param array $gerador Contem os dados para achar o modelo e configuralo
     * @param array $options Todos os campos configurados pelo usuário.
     */
    public function gerarDadosDoModelo($gerador, $options = []) {
        $this->nome_tabela = $gerador['nomeTabela']; //Traz nome da tabela. ex: (tipo_projeto)
        $dados = $this->buscarDadosTabela($this->nome_tabela, $options);        
        list($referenciado, $referencias, $referenciasAvancadas) = $this->gerarRelacoes();
        
        $this->dados_modelo['tabela'] = array(
            'dados' => $dados, //Seta os dados da tabela (Colunas)
            'nome_plural' => $gerador['entidadePlural'], //Seta nome no plural
            'nome_singular' => $gerador['entidadeSingular'], //Seta nome no singular
            'genero_entidade' => $gerador['generoEntidade'], //Seta o genero da entidade
        );
        
        $this->dados_modelo['extra'] = array(
            'nomeDesenv' => ($gerador['nomeDesenv'] ? $gerador['nomeDesenv'] : 'desenvolvedor'), //Seta nome do desenvolvedor para comentários
            'emailDesenv' => ($gerador['emailDesenv'] ? $gerador['emailDesenv'] : 'email@email.com'), //Seta o email do desenvolvedor para comentários
        );
        
        $this->dados_modelo['relacoes'] = array( //Seta os dados das relações
            'referenciado' => $referenciado,
            'referencias' => $referencias,
            'referencias_avancadas' => $referenciasAvancadas,
        );
    }
    
    /**
     * Monta o nome da tabela formatado
     * @return type
     */
    public function nomeTabela($name) {
        $quebrado = explode('_', $name);
        $quebradoNformatado = $quebrado;
        foreach ($quebrado as $chave => $peca) {
            $quebrado[$chave] = ucfirst($peca);
        }
        return array(lcfirst(implode('', $quebrado)),implode('', $quebrado), $quebradoNformatado);
    }
    
    /**
     * Verifica se existe algum campo descritivo
     * @param string
     */
    public function buscarCampoDescritivo($dados) {
        foreach ($dados['colunas'] as $coluna => $value) {
            if ($coluna == 'name') {
                return $coluna;
            } else if ($coluna == 'nome') {
                return $coluna;
            } else if ($coluna == 'descricao') {
                return $coluna;
            } else {
                return 'id';
            }
        }
    }
    
    /**
     * Serve para chamar a mensagem no masculino ou feminino
     * @param string $masculino
     * @param string $feminino
     */
    public function chamaGeneroMsg($masculino = 'o', $feminino = 'a') {
        if ($this->dados_modelo['tabela']['genero_entidade'] == 'M') {  
            echo $masculino;
        } else {
            echo $feminino;
        }
    }
    
    /**
     * Retorna a tabulação correta.
     * 
     * @param integer $qtd
     * @return string
     */
    public static function gerarTabulacao($qtd) {
        return str_repeat('    ', $qtd);
    }
  
    public function criarRelacao($coluna, $relacoes = []){

        $model = '';
        
        if(array_key_exists('referencias', $relacoes) && is_array($relacoes['referencias'])){
            foreach($relacoes['referencias'] as $referencia) {
                
                if($referencia['id_referencia'] == $coluna['nome_coluna']) {

                    list($nomeTabelaRender, $nomeTabelaModel) = $this->nomeTabela($referencia['tabela']);

                    $path = $this->montarCaminho('model').'/'. $nomeTabelaModel . '.php';
                    
                    $model = sprintf("\App\Models\%s::getModel()->consultar()->pluck('%s', '%s')->prepend('Selecione', '')->toArray()", 
                        $nomeTabelaModel,
                        $coluna['colunas_relacao_selecionada'],
                        $referencia['id_referenciado']
                    );
                    
                    // Caso a model não existir então gera a model
                    if(!file_exists($path)) {
                    
                        $labels = [];

                        foreach($referencia['colunas'] as $col) {
                            $labels[$col['nome_coluna']] = $col['label'];
                        }

                        $gerador = new Gerador();
                        $gerador->gerarModelos([
                            'Gerador' => [
                                'nomeDesenv' => $this->dados_modelo['extra']['nomeDesenv'],
                                'emailDesenv' => $this->dados_modelo['extra']['emailDesenv'],
                                'nomeTabela' => $this->nome_tabela,
                                'generoEntidade' => $this->dados_modelo['tabela']['genero_entidade'],
                                'entidadePlural' => $this->dados_modelo['tabela']['nome_plural'],
                                'entidadeSingular' => $this->dados_modelo['tabela']['nome_singular'],
                            ],
                            'gerarModel' => 1,
                            'Labels' => $labels
                        ]);
                    }
                    
                    break;
                }
            }
        }
        
        return $model;
    }
    
    /**
     * Gera o campo do form
     * @param array $coluna
     * @param array $relacoes
     * @param string $rule De onde vem a regra de criação do input
     * @return string
     */
    public function gerarCampoForm($coluna, $relacoes = [], $rule) {
        
        $string = '';
        $nomesRetirados = array('id', 'created_at', 'updated_at');
        
        if (!in_array($coluna['nome_coluna'], $nomesRetirados)) {
            
            //Tratamento especial em casos de dropdowns criados no gerador
            $dropdownList = $this->tratamentoParaDropdown($coluna, $rule);
            if ($dropdownList) {
                return $dropdownList;
            }
            
            switch ($coluna['tipo_coluna']) {
                case 'date':
                    $string = 'Form::text(\''.$coluna['nome_coluna'].'\', $model->'.$coluna['nome_coluna'].', [\'placeholder\' => \'dd/mm/aaaa\', \'data-required\' => 1,\'aria-required\' => \'true\' ,\'class\' => \'form-control maskDate date-picker\'])';
                    break;
                case 'datetime':
                    $string = 'Form::text(\''.$coluna['nome_coluna'].'\', $model->'.$coluna['nome_coluna'].', [\'placeholder\' => \'dd/mm/aaaa 00:00:00\', \'data-required\' => 1,\'aria-required\' => \'true\' ,\'class\' => \'form-control maskDateTime datetime-picker\'])';
                    break;
                case 'int':
                    $model = $this->criarRelacao($coluna, $relacoes);
                    $tipo = $coluna['tipo_input'];
                    if(!empty($model)) {
                        $string = 'Form::select(\''.$coluna['nome_coluna'].'\', '.$model.', $model->'.$coluna['nome_coluna'].', [\'data-required\' => 1,\'aria-required\' => \'true\' ,\'class\' => \'form-control select2\'])';
                    } else if ($tipo == 'situacao') {
                        $string = 'Form::select(\''.$coluna['nome_coluna'].'\', $model::$status_sistem_list, $model->'.$coluna['nome_coluna'].', [\'data-required\' => 1, \'aria-required\' => \'true\' ,\'class\' => \'form-control select2\'' . ($rule == 'search' ? ', \'placeholder\' => \'Selecione\' ' : '') . '])';
                    } else {   
                        $string = 'Form::number(\''.$coluna['nome_coluna'].'\', $model->'.$coluna['nome_coluna'].', [\'data-required\' => 1,\'aria-required\' => \'true\' ,\'class\' => \'form-control\', \'placeholder\' => \'\'])';  
                    }
                    
                    break;
                case 'longtext':
                    $string = 'Form::textarea(\''.$coluna['nome_coluna'].'\', $model->'.$coluna['nome_coluna'].', [\'data-required\' => 1,\'aria-required\' => \'true\' ,\'class\' => \'form-control\', \'placeholder\' => \'\'])';
                    break;
                case 'float':
                case 'decimal':
                    $string = 'Form::text(\''.$coluna['nome_coluna'].'\', $model->'.$coluna['nome_coluna'].', [\'data-required\' => 1,\'aria-required\' => \'true\' ,\'class\' => \'maskMoney form-control\', \'placeholder\' => \'\'])';
                    break;
                default:
                    
                    //Extra caso mais simples. (Outras formatações)
                    $classFormating = '';
                    $tipo = $coluna['tipo_input'];
                    
                    if (in_array($tipo, ['cep', 'cpf', 'cnpj', 'telefone', 'telefoneUs', 'ipAddress', 'money', 'porcentual', 'number'])) {
                        $classFormating = $this->buscarClassInputFormatacao($tipo);
                    }
                    
                    $string = 'Form::text(\''.$coluna['nome_coluna'].'\', $model->'.$coluna['nome_coluna'].', [\'data-required\' => 1,\'aria-required\' => \'true\' ,\'class\' => \'form-control '.$classFormating.' \', \'placeholder\' => \'\'])';
                    break;
            }
            
        }
        
        return $string;
    }
    
    public function gerarBlueprint($coluna){
        
        $string = '';

        switch ($coluna['tipo_coluna']) {
            
            case 'datetime':
            case 'date':
                $string = 'timestamp("'.$coluna['nome_coluna'].'")';
                break;
            
            case 'char':
                $string = 'char("'.$coluna['nome_coluna'].'", '.$coluna['tamanho'].')';
                break;
            
            case 'varchar':
                $string = 'string("'.$coluna['nome_coluna'].'", '.$coluna['tamanho'].')';
                break;
            
            case 'int':
                if(empty($coluna['primaria'])) {
                    
                    $string = 'integer("'.$coluna['nome_coluna'].'")->unsigned()';
                }
                else {
                    
                    $string = 'increments("'.$coluna['nome_coluna'].'")'; 
                }
                break;
            
            case 'text':
                $string = 'text("'.$coluna['nome_coluna'].'")';
                break;
                
            case 'longtext':
                $string = 'longText("'.$coluna['nome_coluna'].'")';
                break;
            
            case 'float':
            case 'decimal':
                $string = 'decimal("'.$coluna['nome_coluna'].'", 8, 2)';
                break;
            
            default:
                $string = 'string("'.$coluna['nome_coluna'].'")';
        }
        
//        if(empty($coluna['obrigatorio'])) {
//            $string .= '->nullable()';                
//        }
        
        return $string;
    }
    
    public function descColumnValidation($coluna){
        
        // 'email' => 'required|unique:users,email,'.app('request')->route('id'),
        $array = [];
        
        if($coluna['obrigatorio']) {
            $array[] = "'required'";
        }
        
        switch($coluna['tipo_coluna']) {
            
            case 'datetime':
            case 'timestamp':
                $array[] = "'date_format:d/m/Y H:i:s'";
                break;
            
            case 'date':
                $array[] = "'date_format:d/m/Y'";
                break;
            
        }
        
        switch($coluna['tipo_input']) {
            case 'cpf':
                $array[] = "'formato_invalido_cpf'";
                break;
            case 'cnpj':
                $array[] = "'formato_invalido_cnpj'";
                break;
//            case 'cep':
//                $array[] = "'formato_invalido_cep'";
//                break;
        }
        
        return implode(',', $array);
    }
    
    /**
     * Trata os tipos das colunas
     * @param string $tipo
     * @return string
     */
    public function tratarTipoColuna($tipo) {
        switch ($tipo) {
            case 'int':
                return 'integer';
            case 'float':
            case 'decimal':
                return 'decimal';
            case 'timestamp':
            case 'datetime':
                return 'data_tempo';
            case 'date':
                return 'data';
            case 'char':
            case 'varchar':
            case 'longtext':
                return 'string';
            case 'double':
                return 'double';
            default:
                return $tipo;
        }
    }
    
    /**
     * Busca o tipo da formatação do campo, para por no js e formatar automaticamente.
     * @param string $tipo
     * @return string
     */
    public function buscarClassInputFormatacao($tipo) {
        if (!empty($tipo)) {
            return 'mask'.ucfirst($tipo);
        }
        return '';
    }
    
    /**
     * Tratamento em caso de ser uma dropdownlist
     * @param array $coluna
     * @param string $rule
     * @return string Input
     */
    public function tratamentoParaDropdown($coluna, $rule) {
        if (!empty($coluna['options'])) {
            return 'Form::select(\''.$coluna['nome_coluna'].'\', $model::$'.$coluna['options']['label'].', $model->'.$coluna['nome_coluna'].', [\'data-required\' => 1, \'aria-required\' => \'true\' ,\'class\' => \'form-control select2\'' . ($rule == 'search' ? ', \'placeholder\' => \'Selecione\' ' : '') . '])';
        }
        return '';
    }
}