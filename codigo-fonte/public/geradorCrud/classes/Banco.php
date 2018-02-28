<?php
class Banco {
    
    private $dbname = '';
    public $nome_tabela = '';
    public $localConfig = 'config/database.php';
    public $labels = array();
    
    /**
     * Monta e retorna a conexão.
     * @return \PDO
     */
    protected function getConnection() {
        $database = include($this->localConfig);
        
        $connection = new PDO('mysql:host='.$database['host'].';dbname='.$database['dbname'], $database['user'], $database['password']);
        $this->dbname = $database['dbname'];
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $connection;
    }
    
    /**
     * Pega todas as tabelas para listar no formulário
     * @return object
     */
    public function getTables() {
        $connection = $this->getConnection();
        
        // Busca todas as tabelas do sistema
        $SQL = 'SELECT DISTINCT TABLE_NAME
                  FROM information_schema.columns
                 WHERE TABLE_SCHEMA = "'.$this->dbname.'"';
        
        $statement = $connection->query($SQL);
        $tabelas = $statement->fetchAll();
        $tabelasName = array();
        
        foreach($tabelas as $tabela) {
            $nameBreak = explode('_', $tabela['TABLE_NAME']);
            
            foreach ($nameBreak as $key => $name) {
                $nameBreak[$key] = ucfirst($name);    
            }
            
            $tabelasName[] = array(
                'value' => $tabela['TABLE_NAME'],
                'name' => implode('', $nameBreak),
            );
        }
        
        return $tabelasName;
    }
    
    /**
     * Gera todos os dados da tabela e suas colunas
     * @param string $nome_tabela Nome completo da tabela
     * @param array $options Dados setados pelo usuário
     * @return array
     */
    public function buscarDadosTabela($nome_tabela, $options = []) {
        $connection = $this->getConnection();
        
        // Busca todas as colunas da tabela
        $SQL = ' SELECT * 
                   FROM information_schema.columns
                  WHERE TABLE_SCHEMA = "'.$this->dbname.'"
                    AND TABLE_NAME = "'.$nome_tabela.'" ';
        
        $statement = $connection->query($SQL);
        $retorno = $statement->fetchAll();
        
        $colunas = array();
        
        foreach ($retorno as $coluna) {
                        
            $label = (key_exists($coluna['COLUMN_NAME'], $this->labels) ? $this->labels[$coluna['COLUMN_NAME']] : $coluna['COLUMN_NAME']);
            
            if(!in_array($coluna['COLUMN_NAME'], ['created_at', 'updated_at', 'deleted_at'])) {
                
                $obrigatorio = (isset($options['campoObrigatorio']) && isset($options['campoObrigatorio'][$coluna['COLUMN_NAME']]) ? true :  ($coluna['IS_NULLABLE'] == 'YES' ? false : true));
                $mostrarListagem = (isset($options['mostrarListagem']) && isset($options['mostrarListagem'][$coluna['COLUMN_NAME']]) ? true :  false);
                $tipoDeInput = (isset($options['tipoDeInput']) && isset($options['tipoDeInput'][$coluna['COLUMN_NAME']]) ? $options['tipoDeInput'][$coluna['COLUMN_NAME']] :  null);
                
                //Options de dropdown
                $nomeDropdown = isset($options['campoDropdownName'][$coluna['COLUMN_NAME']]) && !empty($options['campoDropdownName'][$coluna['COLUMN_NAME']]) ? $options['campoDropdownName'][$coluna['COLUMN_NAME']] : null;
                $sessaoOptions = (isset($_SESSION['dropdownlist'][$nomeDropdown]) ? $_SESSION['dropdownlist'][$nomeDropdown] : []);
                $optionsDropdown = $sessaoOptions;
                
                if (empty($optionsDropdown)) {
                    if (isset($options['campoDropdownChave']) && isset($options['campoDropdownValor'])) {
                        if (isset($options['campoDropdownChave'][$nomeDropdown]) && isset($options['campoDropdownValor'][$nomeDropdown])) {
                            $optionsDropdown['label'] = $nomeDropdown;
                            foreach ($options['campoDropdownChave'][$nomeDropdown] as $chave => $chaveOption) {
                                $optionsDropdown['data'][$chaveOption] = $options['campoDropdownValor'][$nomeDropdown][$chave];
                            }
                        }
                    }
                }

                
                if (!empty($optionsDropdown)) {
                    $optionsDropdown['label'] = str_replace([',', '-', ' ', '_', '.'], '', strtolower($optionsDropdown['label']));
                }
                
                $colunas[] = [
                    'nome_coluna' => $coluna['COLUMN_NAME'],
                    'label' => $label,
                    'obrigatorio' => $obrigatorio,
                    'tipo_coluna' => $coluna['DATA_TYPE'],
                    'tamanho' => $coluna['CHARACTER_MAXIMUM_LENGTH'],
                    'primaria' => ($coluna['COLUMN_KEY'] == 'PRI' ? true : false),
                    'mostrar_listagem' => $mostrarListagem,
                    'tipo_input' => $tipoDeInput,
                    'colunas_relacao' => $this->buscarColunasRelacao($coluna['COLUMN_NAME'], $nome_tabela),
                    'colunas_relacao_selecionada' => isset($options['ColunaRelacao'][$coluna['COLUMN_NAME']]) ? $options['ColunaRelacao'][$coluna['COLUMN_NAME']] : null,
                    'options' => $optionsDropdown,
                ];
            }
        }
        
        return $colunas;
    }
    
    /**
     * Busca as relações da tabela tando onde é referenciada como suas referencias
     * @return array
     */
    public function gerarRelacoes() {
        
        $connection = $this->getConnection();
        $relationsAvancadas = $this->buscarRelacaoAvancada();
        $tabelasReferencia = array();
        
        foreach ($relationsAvancadas as $tableRef) {
            $tabelasReferencia[$tableRef->tabela_referencia] = $tableRef;
        }
        
        $select = '
            TABLE_SCHEMA,
            TABLE_NAME,
            COLUMN_NAME,
            REFERENCED_TABLE_SCHEMA,
            REFERENCED_TABLE_NAME,
            REFERENCED_COLUMN_NAME
        ';
        
        //Busca todas as referências da tabela
        $SQL = 'SELECT ' . $select . ' FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE ';
        
        $referencedWhere = '
            WHERE TABLE_SCHEMA = "' . $this->dbname . '"
              AND REFERENCED_TABLE_NAME = "' . $this->nome_tabela . '"
        ';
        
        $tableWhere = '
            WHERE TABLE_SCHEMA = "' . $this->dbname . '"
              AND TABLE_NAME = "' . $this->nome_tabela . '"
              AND REFERENCED_TABLE_NAME IS NOT NULL
        ';
        $statementReferenced = $connection->query($SQL . $referencedWhere);
        $retornoReferenced = $statementReferenced->fetchAll();
        
        $statementTable = $connection->query($SQL . $tableWhere);
        $retornoTable = $statementTable->fetchAll();
        
        $referencias = array();
        $referenciado = array();
        $relacoesAvancadas = array();
        
        if (!empty($retornoReferenced)) {
            foreach ($retornoReferenced as $dados) {
                $dadosTabelaRelacao = $this->buscarDadosTabela($dados['TABLE_NAME']);
                
                if (key_exists($dados['TABLE_NAME'], $tabelasReferencia)) {
                    
                    $relacoesAvancadas[] = array(
                        'tabela' => $tabelasReferencia[$dados['TABLE_NAME']]->tabela_referencia,
                        'coluna_referencia' => $tabelasReferencia[$dados['TABLE_NAME']]->coluna_referencia,
                        'coluna_referenciada' => $tabelasReferencia[$dados['TABLE_NAME']]->coluna_referenciada,
                        'modelo' => ucfirst($tabelasReferencia[$dados['TABLE_NAME']]->tabela_referenciada),
                        'colunas' => $dadosTabelaRelacao,
                    );
                } else {
                    $referenciado[] = array(
                        'tabela' => $dados['TABLE_NAME'],
                        'tabela_formatada' => $this->nomeTabela($dados['TABLE_NAME']),
                        'id_referenciado' => $dados['COLUMN_NAME'],
                        'id_referencia' => $dados['REFERENCED_COLUMN_NAME'],
                        'colunas' => $dadosTabelaRelacao,
                    );
                }
            }
        }
        
        if (!empty($retornoTable)) {
            foreach ($retornoTable as $dados) {
                $dadosTabelaRelacao = $this->buscarDadosTabela($dados['REFERENCED_TABLE_NAME']);
                $referencias[] = array(
                    'tabela' => $dados['REFERENCED_TABLE_NAME'],
                    'tabela_formatada' => $this->nomeTabela($dados['REFERENCED_TABLE_NAME']),
                    'id_referenciado' => $dados['REFERENCED_COLUMN_NAME'],
                    'id_referencia' => $dados['COLUMN_NAME'],
                    'colunas' => $dadosTabelaRelacao,
                    'tipo' => $this->verificaNullable($dados['COLUMN_NAME'], $this->nome_tabela) == 'YES' ? 'hasOne' : 'belongsTo',
                );
            }
        }
        
        return array($referenciado, $referencias, $relacoesAvancadas);
    }
    
    /**
     * Busca as relações avançadas
     * @return object
     */
    public function buscarRelacaoAvancada() {
        $connection = $this->getConnection();
        //Busca todas as referências da tabela
        $SQL = 'SELECT column_info.table_name AS tabela_referencia, 
                       column_info.referenced_table_name AS tabela_referenciada,
                       column_info.column_name AS coluna_referenciada,
                       (
                          SELECT sub_column_info.column_name
                            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE as sub_column_info
                           WHERE (sub_column_info.table_name LIKE \'%_'.$this->nome_tabela.'\'
                              OR sub_column_info.table_name LIKE \''.substr($this->nome_tabela,0,-1).'_%\')
                             AND sub_column_info.table_name <> \''.$this->nome_tabela.'\'
                             AND sub_column_info.referenced_table_name = \''.$this->nome_tabela.'\'
                             AND sub_column_info.table_name = column_info.table_name
                       ) AS coluna_referencia
                  FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE  AS column_info
                 WHERE (column_info.table_name LIKE \'%_'.$this->nome_tabela.'\'
                    OR column_info.table_name LIKE \''.substr($this->nome_tabela,0,-1).'_%\')
                   AND column_info.table_name <> \''.$this->nome_tabela.'\'
                   AND column_info.referenced_table_name <> \''.$this->nome_tabela.'\'';
        
        $query = $connection->query($SQL);
        $retorno = $query->fetchAll(PDO::FETCH_OBJ);
        
        return $retorno;
    }
    
    /**
     * Verifica se coluna é nullable
     * @param string $nome_coluna
     * @param string $nome_tabela
     * @return string
     */
    public function verificaNullable($nome_coluna, $nome_tabela) {
        $connection = $this->getConnection();
        $SQL = 'SELECT IS_NULLABLE
                   FROM information_schema.columns
                  WHERE TABLE_SCHEMA = \''.$this->dbname.'\'
                    AND TABLE_NAME = \''.$nome_tabela.'\'
                    AND COLUMN_NAME = \''.$nome_coluna.'\'';
        
        $query = $connection->query($SQL);
        $obj = $query->fetch();
        
        if (!$obj) {
            return null;
        }
        
        return $obj['IS_NULLABLE'];
    }
    
    public function verificarSeExisteColuna($nome_coluna, $nome_tabela) {
        $connection = $this->getConnection();
        
        $SQLTABLE = 'SELECT count(*) as contador
                   FROM information_schema.columns
                  WHERE TABLE_SCHEMA = \''.$this->dbname.'\'
                    AND TABLE_NAME = \''.$nome_tabela.'\'';
        
        $queryTable = $connection->query($SQLTABLE);
        $objTable = $queryTable->fetch();
        
        
        if ($objTable['contador'] < 1) {
            return false;
        }
        
        $SQL = 'SELECT count(*) as contador
                   FROM information_schema.columns
                  WHERE TABLE_SCHEMA = \''.$this->dbname.'\'
                    AND TABLE_NAME = \''.$nome_tabela.'\'
                    AND COLUMN_NAME = \''.$nome_coluna.'\'';
        
        $query = $connection->query($SQL);
        $obj = $query->fetch();
        
        return ($obj['contador'] > 0 ? 'SIM': 'NAO');
    }
    
    /**
     * Busca os nomes das colunas da tabela relação.
     * @param string $column_name Nome da coluna
     * @param string $nome_tabela Nome da tabela
     * @return array
     */
    public function buscarColunasRelacao($column_name, $nome_tabela) {
        $connection = $this->getConnection();
        
        $sql = 'SELECT COLUMN_NAME
                  FROM information_schema.columns
                 WHERE TABLE_SCHEMA = \''. $this->dbname .'\' 
                   AND TABLE_NAME = (SELECT REFERENCED_TABLE_NAME
                                       FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                                      WHERE TABLE_NAME = \''.$nome_tabela.'\'
                                        AND COLUMN_NAME = \''.$column_name.'\'
                                        AND REFERENCED_TABLE_NAME IS NOT NULL
                                    );';
        
        $statement = $connection->query($sql);
        return$statement->fetchAll();
    }
}
