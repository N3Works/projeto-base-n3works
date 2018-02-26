<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Controle de formulário do modelo especificado
 * @author Thiago do Amarante Farias <thiago.farias@jointecnologia.com.br>
 */
class FakesFormRequest extends FormRequest
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
     * @return array
     */
    public function rules() {
        return [
            'nome' => 'required',
            'data' => array('required', 'date_format:d/m/Y'),
            'valor' => 'required',
        ];
    }
    
    /**
     * Mensagens caso pare nos rules atribuidos
     * @return array
     */
    public function messages() {
        return [
            'id.required' => 'O campo id não foi preenchido.',
            'nome.required' => 'O campo nome não foi preenchido.',
            'data.required' => 'O campo data não foi preenchido.',
            'valor.required' => 'O campo valor não foi preenchido.',
            'data.date_format' => 'O campo data está com a formatação inválida.',
        ];
    }
    
    /**
     * Pega a instancia de validação e adiciona o validador
     * @return type
     */
    protected function getValidatorInstance() {
        
        $validator = parent::getValidatorInstance();
        $validator->addImplicitExtension('formato_invalido_cpf', function($attribute, $value, $parameters) {
            if (!\App\Http\Helper\Validate::cpf($value)) {
                return false;
            }
            return true;
        });

        return $validator;
    }
}