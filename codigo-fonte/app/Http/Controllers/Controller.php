<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Controller - classe de ajuda para o controllador que extende de BaseController do laravel
 * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 */
class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * Guarda as mensagens da controller
     * @var array 
     */
    public $messages = array();
    
    /**
     * Popula a array de mensagens
     * @param string $message Texto da mensagem
     * @param string $status Tipo de situação da mensagem
     * @param boolean $callMessage Trata se já salva na sessão a mensagem
     */
    public function setMessage($message, $status = 'info', $callMessage = true) {
        if (!empty(trim($message))) {            
            if ($callMessage) {
                flash($message, $status);
            }
            if ($status == 'danger') {
                $this->messages[] = $message;
            }
        }
    }
    
    /**
     * Chama o flash para multiplas mensagens
     */
    public function callFlashErrorMessage($messages = array()) {
        if (!empty($this->messages) || !empty($messages)) {
            $todasMensagens = array_merge($messages, $this->messages);
            $mensagem = '<b> Erros:</b><ul>';
            
            foreach ($todasMensagens as $message) {
                $mensagem .= '<li>'.$message.'</li>';
            }
            
            $mensagem .= '</ul>';
            flash($mensagem, 'danger');
        }
    }
}
