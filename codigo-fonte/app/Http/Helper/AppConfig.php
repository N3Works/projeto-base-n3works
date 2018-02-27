<?php
namespace App\Http\Helper;

/**
 * Arquivo de configuração do projeto
 * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 */
class AppConfig {
  
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
    
    /**
     * Busca o valor do parâmetro passado
     * @param string $param Nome do parâmetro
     * @return string Valor do parâmetro
     */
    public function getParam($param) {
        $parametro = \App\Models\Parametros::where('nome', $param);
        if ($parametro->count() > 0) {
            return $parametro->first()->valor;
        } else {
            return '';
        }
    }
}
