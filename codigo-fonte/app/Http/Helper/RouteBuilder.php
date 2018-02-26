<?php
namespace App\Http\Helper;

use Illuminate\Support\Facades\Route;
use \Laracasts\Utilities\JavaScript\JavaScriptFacade as Javascript;

/**
 * Class de moldagem das rotas do laravel
 * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 */
class RouteBuilder {
    
    /**
     * Monta o route do laravel
     * @return array
     */
    public static function buildSmartUrl() {
        $dataUrl = self::brokenUrl();
        $routeUrl = $dataUrl['CONTROLLER'].'/'.$dataUrl['ACTION'].($dataUrl['KEY'] ? '/{id}' : '');
        $actionController = ucfirst($dataUrl['CONTROLLER']).'Controller@'.$dataUrl['ACTION'];
        
        if (empty($dataUrl['CONTROLLER']) && empty($dataUrl['ACTION'])) {
            Route::get('/', 'DefaultController@index');
            $_SESSION['ACTION'] = 'index'; $_SESSION['CONTROLLER'] = 'default'; //Seta session
        } else {
            Route::resource($routeUrl, $actionController);
        }
    }
    
    /**
     * Separa os dados da URL para retornar em array
     * @return array
     */
    private static function brokenUrl() {
        if(!empty($_SERVER) && !array_key_exists('REQUEST_URI', $_SERVER)) {
            $_SERVER['REQUEST_URI'] = '/';
        }
        
        $urlBrokenGet = explode('?', $_SERVER['REQUEST_URI']); //Separa os caminhos da url do GET
        $urlBroken = explode('/', $urlBrokenGet[0]); //Pega a url amigavel
        $count = count($urlBroken); //Seta um contador de caminhos da url
        
        $key = '';
        $action = '';
        $controller = '';
        $last = array_last($urlBroken);
        
        if (is_numeric($last)) {
            $key = $last;
            $action = $urlBroken[$count - 2];
            $controller = $urlBroken[$count - 3];
        } else {
            $action = $urlBroken[$count - 1];
            $controller = $urlBroken[$count - 2];
        }
        
        $_SESSION['ACTION']     = $action;
        $_SESSION['CONTROLLER'] = $controller;
        $_SESSION['KEY']        = $key;
        
        return array(
            'CONTROLLER' => $controller,
            'KEY' => $key,
            'ACTION' => $action,
        );
    }
}
