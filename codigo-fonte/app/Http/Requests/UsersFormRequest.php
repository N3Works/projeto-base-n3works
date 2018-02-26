<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Controle de formulário do modelo especificado
 * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 * @version 01/06/2017
 */
class UsersFormRequest extends FormRequest
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
            'cpf' => 'required',
            'nome' => 'required',
            'email' => 'required',
        ];
    }
    
    /**
     * Mensagens caso pare nos rules atribuidos
     * @return array
     */
    public function messages() {
        return [
            'id.required' => 'O campo id não foi preenchido.',
            'cpf.required' => 'O campo cpf não foi preenchido.',
            'nome.required' => 'O campo nome não foi preenchido.',
            'email.required' => 'O campo email não foi preenchido.',
        ];
    }
}