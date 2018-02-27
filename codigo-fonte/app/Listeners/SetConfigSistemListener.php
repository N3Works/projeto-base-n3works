<?php
namespace App\Listeners;

use App\Events\Handlers\SetConfigSistem;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \Laracasts\Utilities\JavaScript\JavaScriptFacade as Javascript;

class SetConfigSistemListener {
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Handle the event.
     *
     * @param  SetConfigSistem  $event
     * @return void
     */
    public function handle() {
        $this->setConfigJavascriptVariables();
    }
    
    /**
     * Set variables on javascript
     */
    public function setConfigJavascriptVariables() {
        Javascript::put([ //Set on default namespace = APP
            'base_url' => asset('/'),
            'action' => $_SESSION['ACTION'],
            'controller' => $_SESSION['CONTROLLER'],
            'action_url' => asset('/') . $_SESSION['CONTROLLER'] . '/' . $_SESSION['ACTION'] . ($_SESSION['KEY'] ? '/' . $_SESSION['KEY'] : ''),
            'controller_url' => asset('/') . $_SESSION['CONTROLLER'],
            'key' => $_SESSION['KEY'],
            'token' => csrf_token(),
            'resultados_datatable' => app('AppConfig')->getParam('RESULTADOS_DATATABLE'),
        ]);    
    }
}
