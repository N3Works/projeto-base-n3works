<?php
/**
 * Created by PhpStorm.
 * User: Ezequiel Lafuente
 * Date: 29/06/2017
 * Time: 10:14
 */

namespace App\Http\Helper;


use Mail;


class SendMail
{

    /**
     * primeiro parâmetro serve para passar os usuários que receberão o e-mail;
     * segundo parâmetro é o assunto do e-mail;
     * terceiro parâmetro é a view do e-mail;
     * quarto parâmetro é os dados que podem ser injetados na view;
     * */

    public static function simpleEmailSending($users , $subject , $view , $screenview =  array() ) {
        Mail::send($view , $screenview , function ($message) use ($subject,$users) {

            $config = config('mail'); // get config de email

            if (count($users) == 1) {
                $message->from($config['from']['address'], $config['from']['name']);
                $message->to($users->email, $users->nome);
                $message->subject($subject);
            } else {
                foreach($users AS $user) {
                    $message->from($config['from']['address'], $config['from']['name']);
                    $message->to($user->email, $user->nome);
                    $message->subject($subject);
                }
            }
        });
    }
}