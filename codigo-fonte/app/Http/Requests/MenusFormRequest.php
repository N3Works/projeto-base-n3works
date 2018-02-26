<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Controle de formulário do modelo especificado
 * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 * @version 31/05/2017
 */
class MenusFormRequest extends FormRequest {
    
    /**
     * Determina se o usuário pode realizar o request
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Seta os rules para cada campo
     *
     * @return array
     */
    public function rules() {
        return [
            'header' => 'required',
            'controller' => 'required',
            'icon' => 'required',
            'order' => 'required',
        ];
    }
    
    /**
     * Mensagens caso pare nos rules atribuidos
     * @return array
     */
    public function messages() {
        return [
            'id.required' => 'O campo ID não foi preenchido.',
            'header.required' => 'O campo Header não foi preenchido.',
            'controller.required' => 'O campo Controlador não foi preenchido.',
            'icon.required' => 'O campo Icone não foi preenchido.',
            'order.required' => 'O campo Ordem não foi preenchido.',
        ];
    }
}