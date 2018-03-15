<?php
defined('ROOT_PATH_LARAVEL') or define('ROOT_PATH_LARAVEL', realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'). DIRECTORY_SEPARATOR);
include_once('Modelo.php');
include_once('framework/laravelMpog.php');

/**
 * Classe que realiza a geração de código.
 * 
 * @author Thiago do Amarante Farias <thiago.farias@jointecnologia.com.br>
 */
class Gerador extends Modelo {
        
    public function gerarModelos($request = []) {
              
        $output = (object)['success' => false, 'msg' => ''];
        
        try {
            $gerador = $request['Gerador'];
            $options = $request['LabelsOptions'];
            
            $this->labels = $request['Labels'];
            
            if(array_key_exists('model_timestamps', $request)) $this->timestamps = true; //Coisa do Pedrotti -> Por isso ta aqui...
            if(array_key_exists('model_softdelete', $request)) $this->softdelete = true; //Coisa do Pedrotti -> Por isso ta aqui...

            $this->gerarDadosDoModelo($gerador, $options); //Gera os dados sobre o modelo
            
            $methods = [
                'gerarController', 
                'gerarModel', 
                'gerarFormRequest',
                'gerarDatatable',
                'gerarView',
                'gerarMigration',
                'gerarSeed'
            ];
            
            //Valida se existe métodos adicionais selecionados para o framework
            if (isset($request['Adicionais'])) {
                $metodosAdicionais = $request['Adicionais'];
                $dadosAdicionais = [];

                if (isset($request['Adicionais']['dados'])) {
                    $dadosAdicionais = $request['Adicionais']['dados'];
                    unset($request['Adicionais']['dados']);
                }
                
                //Pega a classe do framework, setando os dados no __construct
                $frameworkAdicionais = new $request['Gerador']['framework'](
                    $this->dados_modelo,
                    $this->nome_tabela,
                    $metodosAdicionais,
                    $dadosAdicionais);
                
                foreach ($metodosAdicionais as $metodo => $valor) {
                    if ($valor) {
                        if (method_exists($frameworkAdicionais, $metodo)) {
                            //Chama o método dinamicamente
                            $frameworkAdicionais->$metodo(); 
                        }
                    }
                }
            }
            
            foreach($methods as $method) {
                if(array_key_exists($method, $request) && ! empty($request[$method])) {
                    $this->{$method}();
                } 
            }
            
            $output->success = true;
            $output->msg = 'Código gerado com sucesso';
        } 
        catch(\Exception $e) {
            $output->msg = $e->getMessage();
        }
        
        return $output;
    }
    
    public function gerarDatatable(){
        
        list($nomeTabelaRender, $nomeTabelaModel) = $this->nomeTabela($this->nome_tabela);
        
        $path = $this->montarCaminho('datatables');
        
        ob_start();
        include 'esqueletos/laravelMpog/datatable.php';
        file_put_contents($path .'/'. $nomeTabelaModel . 'DataTable.php', ob_get_clean());
    }
    
    public function gerarFormRequest(){
        
        list($nomeTabelaRender, $nomeTabelaModel) = $this->nomeTabela($this->nome_tabela);
        
        $path = $this->montarCaminho('request');
        
        ob_start();
        include 'esqueletos/laravelMpog/formrequest.php';
        file_put_contents($path .'/'. $nomeTabelaModel . 'FormRequest.php', ob_get_clean());
    }
    
    public function gerarController() {
        
        list($nomeTabelaRender, $nomeTabelaModel) = $this->nomeTabela($this->nome_tabela);
        
        $path = $this->montarCaminho('controller');
        
        ob_start();
        include 'esqueletos/laravelMpog/controller.php';
        file_put_contents($path .'/'. $nomeTabelaModel . 'Controller.php', ob_get_clean());
    }
    
    public function gerarModel() {
        list($nomeTabelaRender, $nomeTabelaModel) = $this->nomeTabela($this->nome_tabela);
        
        $pathModel = $this->montarCaminho('model');
        ob_start();
        include 'esqueletos/laravelMpog/model.php';
        file_put_contents($pathModel .'/'. $nomeTabelaModel . '.php', ob_get_clean());
        
        $pathRepository = $this->montarCaminho('repository');
        ob_start();
        include 'esqueletos/laravelMpog/repository.php';
        file_put_contents($pathRepository .'/'. $nomeTabelaModel . 'Repository.php', ob_get_clean());
    }
    
    public function gerarView() {
        
        $relacoes = $this->dados_modelo['relacoes'];
        list($nomeTabelaRender, $nomeTabelaModel) = $this->nomeTabela($this->nome_tabela);
        
        $path = $this->montarCaminho('view');
        ob_start();
        include 'esqueletos/laravelMpog/index.php';
        file_put_contents($path .'/index.blade.php', ob_get_clean());
        
        ob_start();
        include 'esqueletos/laravelMpog/form.php';
        file_put_contents($path .'/form.blade.php', ob_get_clean());
        
        ob_start();
        include 'esqueletos/laravelMpog/show.php';
        file_put_contents($path .'/show.blade.php', ob_get_clean());
        
        $path = $this->montarCaminho('search');
        ob_start();
        include 'esqueletos/laravelMpog/search.php';
        file_put_contents($path .'/search.blade.php', ob_get_clean());
        
        $path = $this->montarCaminho('assets');
        ob_start();
        include 'esqueletos/laravelMpog/index-js.php';
        file_put_contents($path .'/index.js', ob_get_clean());

        ob_start();
        include 'esqueletos/laravelMpog/form-js.php';
        file_put_contents($path .'/form.js', ob_get_clean());
        
        ob_start();
        include 'esqueletos/laravelMpog/show-js.php';
        file_put_contents($path .'/show.js', ob_get_clean());
    }
    
    public function gerarMigration(){
       
        $relacoes = $this->dados_modelo['relacoes'];
        list($nomeTabelaRender, $nomeTabelaModel) = $this->nomeTabela($this->nome_tabela);
        
        $filename = $this->montarCaminho('migration') .'/'. date('Y_m_d').'_'.substr(time(), 3).'_create_'.$this->nome_tabela.'_table.php';
                
        ob_start();
        include 'esqueletos/laravelMpog/migration.php';
        file_put_contents($filename, ob_get_clean());
    }
    
    public function gerarSeed(){
        
        
        $relacoes = $this->dados_modelo['relacoes'];
        list($nomeTabelaRender, $nomeTabelaModel) = $this->nomeTabela($this->nome_tabela);
        
                
        $statement = $this->getConnection()->query('SELECT * FROM '.$this->nome_tabela);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $tabelas = $statement->fetchAll();

        $filename = $this->montarCaminho('seed') .'/'. $nomeTabelaModel . 'Seeder.php';
        
        ob_start();
        include 'esqueletos/laravelMpog/seed.php';
        $content = ob_get_clean();
        
        file_put_contents($filename, $content);
    }
}