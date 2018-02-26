<?php
namespace App\Http\Helper;

/**
 * Classe de utilitários para o sistema
 * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 */
class Util {
    
     /**
     * Guarda as mensagens da controller
     * @var array 
     */
    public static $messages = array();
    
    /**
     * Popula a array de mensagens
     * @param string $message Texto da mensagem
     * @param string $status Tipo de situação da mensagem
     * @param boolean $callMessage Trata se já salva na sessão a mensagem
     */
    public static function setMessage($message, $status = 'info', $callMessage = true) {
        if (!empty(trim($message))) {            
            if ($callMessage) {
                flash($message, $status);
            }
            if ($status == 'danger') {
                static::$messages[] = $message;
            }
        }
    }
    
    /**
     * Chama o flash para multiplas mensagens
     * @param array $messages
     */
    public static function callFlashErrorMessage($messages = array()) {
        if (!empty(static::$messages) || !empty($messages)) {
            flash(static::formatMessages($messages), 'danger');
        }
    }
    
    /**
     * Formata o html das mensagens
     * @param string $messages
     * @return string
     */
    public static function formatMessages($messages = []) {
        $todasMensagens = array_merge($messages, static::$messages);
        $mensagem = '<b> Erros:</b><ul>';

        foreach ($todasMensagens as $message) {
            $mensagem .= '<li>'.$message.'</li>';
        }

        $mensagem .= '</ul>';
        
        return $mensagem;
    }


    /**
     * Mostra a mensagem com html pronto.
     * @return string
     */
    public static function showMessage($messageBag = null) {
        $html = '<div id="flashMensager">';
        
        if($messageBag instanceof  \Illuminate\Support\MessageBag) {
            $status = 'danger';
            $message = static::formatMessages($messageBag->all());
        } else {
            $status = session('flash_notification.level');
            $message = session('flash_notification.message');
        }
        
        if ($message) {
            
            switch ($status) {
                case 'danger':
                    $fa = 'times';
                    break;
                case 'success':
                    $fa = 'check';
                    break;
                case 'warning':
                    $fa = 'warning';
                    break;
                default:
                    $fa = 'info';
                    break;
            }
            
            $html .= '
                <div class="alert alert-'.$status.'">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="fa fa-'.$fa.'"></i> '.$message.'
                </div>
            ';
        }
        
        return $html . '</div>';
    }
    
    /**
     * Verificar permissionamento
     * @param string $permissao
     * @return boolean
     */
    public static function verificarPermissao($permissao) {
        $sessao = app('session.store');
        $permissoes = $sessao->get('permissoes');
        
        if (in_array($permissao, $permissoes)) {
            return true;
        }
        return false;
    }
}
