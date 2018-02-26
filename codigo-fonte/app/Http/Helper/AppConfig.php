<?php
namespace App\Http\Helper;

/**
 * Arquivo de configuração do projeto
 * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 */
class AppConfig {
    
    /**
     * Monta o titulo do projeto
     * @var string 
     */
    public $titulo_projeto = 'Projetos Base';
    
    /**
     * Monta o titulo do projeto
     * @var string 
     */
    public $texto_rodape = '&lt;Nome da Secretaria responsavel pelo Sistema&gt;-&lt;Sigla da Secretaria&gt;-&lt;Nome do Ministério&gt; | &lt;Endereco&gt;';
    
    /**
     * Cria a array de menus do projeto
     * @var type 
     */
    public $menus = array();
    
    /**
     * Gera os menus do projeto
     * @return string
     */
    public function gerarMenus() {
        $session = app('session.store');
        if(!$session->has('menus')) {
            $session->set('menus', \App\Models\Menus::gerarMenu());
        }
        return LayoutBuilder::montarHtmlMenus($session->get('menus'));
    }
}
