<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Controle de formulário do modelo especificado
 * @author Thiago do Amarante Farias <thiago.farias@jointecnologia.com.br>
 * @version 22/06/2017
 */
class ParametroValoresTiposFormRequest extends FormRequest
{
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
            'parametro_id' => 'required',
            'value' => 'required',
        ];
    }
    
    /**
     * Mensagens caso pare nos rules atribuidos
     * @return array
     */
    public function messages() {
        return [
            'id.required' => 'O campo id não foi preenchido.',
            'parametro_id.required' => 'O campo parametro_id não foi preenchido.',
            'value.required' => 'O campo value não foi preenchido.',
        ];
    }
}