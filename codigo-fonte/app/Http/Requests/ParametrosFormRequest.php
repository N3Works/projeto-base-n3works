<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Controle de formulário do modelo especificado
 * @author Thiago do Amarante Farias <thiago.farias@jointecnologia.com.br>
 * @version 22/06/2017
 */
class ParametrosFormRequest extends FormRequest
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
            'nome' => 'required',
            'parametro_editavel' => 'required',
            'status' => 'required',
            'tipo' => 'required',
            'valor' => 'required',
        ];
    }
    
    /**
     * Mensagens caso pare nos rules atribuidos
     * @return array
     */
    public function messages() {
        return [
            'id.required' => 'O campo ID não foi preenchido.',
            'nome.required' => 'O campo Nome não foi preenchido.',
            'parametro_editavel.required' => 'O campo Tipo Editável? não foi preenchido.',
            'status.required' => 'O campo Status não foi preenchido.',
            'tipo.required' => 'O campo Tipo não foi preenchido.',
            'valor.required' => 'O campo Valor não foi preenchido.',
        ];
    }
}