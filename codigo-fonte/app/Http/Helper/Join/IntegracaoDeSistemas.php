<?php
namespace App\Http\Helper\Join;

class IntegracaoDeSistemas {
    
    /**
    * Realiza requisição de CURL para a API de usuários e órgãos
    * @param string $action Acão da API
    * @param array $data Dados para enviar via POST
    * @param boolean $search Verifica se for uma pesquisa, caso sim o retorno é uma array com os dados
    * @return array
    */
    public static function curlApi($action, $data, $search = false, $method = 'POST') {
        $config = config('joinconfig');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $config['url_userapi'] . $action);

        if ($method == 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        } else {
            curl_setopt($ch, CURLOPT_POST, 1); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $headers = array(
            'client: ' . env('APISICONV_CLIENT'),
            'secret: ' . env('APISICONV_SECRET'),
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        $httpResponse = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $tipo = 'success';
        if ($httpResponse != 200) {
            $tipo = 'danger';
        }

        $return = json_decode($result);

        curl_close($ch);

        if ($search) {
            return $return;
        }

        return array('tipo' => $tipo, 'mensagem' => $return->message);
    }
}