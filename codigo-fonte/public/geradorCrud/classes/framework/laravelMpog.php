<?php

/**
 * Classe para funcionalidades especificas do framework
 */
class laravelMpog extends Modelo {
    
    public $dados_modelo;
    public $nome_tabela;
    public $metodosAdicionais;
    public $dados;
    
    /**
     * Serve para inserir o menu com ou sem permissão
     * @var boolean
     */
    protected $tem_permissoes = false;

    public function __construct($dadosModelo, $nomeTabela, $metodosAdicionais, $dadosAdicionais) {
        $this->dados_modelo = $dadosModelo;
        $this->nome_tabela = $nomeTabela;
        $this->metodos_adicionais = $metodosAdicionais;
        $this->dados = $dadosAdicionais;
    }
    
    public function gerarPermissoesMPOG() {
        list($nomeTabelaRender, $nomeTabelaModel) = $this->nomeTabela($this->nome_tabela);
        $arquivo = date('Y_m_d').'_'.substr(time(), 3).'_insert_permissoes_'.$this->nome_tabela.'_table.php';
        $caminho = $this->montarCaminho('migration') .'/'. $arquivo;
                
        $generoModel = $this->dados_modelo['tabela']['genero_entidade'];
        
        ob_start();
        include 'esqueletos/laravelMpog/insert-permissoes.php';
        file_put_contents($caminho, ob_get_clean());
        
        //Executa o migration
        shell_exec('artisan migrate');
    }
    
    public function gerarMenuMPOG() {
        list($nomeTabelaRender, $nomeTabelaModel) = $this->nomeTabela($this->nome_tabela);
        $arquivo = date('Y_m_d').'_'.substr(time(), 3).'0_insert_menu_'.$this->nome_tabela.'_table.php';
        $caminho = $this->montarCaminho('migration') .'/'. $arquivo;
                
        $generoModel = $this->dados_modelo['tabela']['genero_entidade'];
        
        if (isset($this->metodosAdicionais['gerarPermissoesMPOG']) && $this->metodosAdicionais['gerarPermissoesMPOG']) {
            $this->tem_permissoes = true;
        }
        
        ob_start();
        include 'esqueletos/laravelMpog/insert-menu.php';
        file_put_contents($caminho, ob_get_clean());
        
        //Executa o migration
        shell_exec('artisan migrate');
    }
}
