<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller; //Base do controlador
use Response;

/**
 * Controlador Default
 * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 */
class DefaultController extends Controller {

    /**
     * Tela inicial do sistema
     * @return Response
     */
    public function index() {
        return view('default.index');
    }
}
