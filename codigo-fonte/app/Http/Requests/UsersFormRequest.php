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
        $rules = [
            'nome' => 'required',
            'email' => 'required',
            'perfil_id' => 'required',
        ];
        
        if ($this->cenario == 'cadastrar') {
            $rules['password'] = [
                'compare:password_confirmation',
                'required',
            ];
            $rules['email'] = ['unico', 'required'];
            $rules['cpf'] = [
                'formato_invalido_cpf',
                'unico',
                'required'
            ];
        }
        
        if ($this->cenario == 'editar') {
            $rules['email'] = ['unico', 'required'];
        }
        
        return $rules;
    }
    
    /**
     * Mensagens caso pare nos rules atribuidos
     * @return array
     */
    public function messages() {
        return [
            'cpf.required' => 'O campo CPF não foi preenchido.',
            'nome.required' => 'O campo Nome não foi preenchido.',
            'email.required' => 'O campo E-mail não foi preenchido.',
            'perfil_id.required' => 'O campo Perfil não foi preenchido.',
            'password.required' => 'O campo Senha não foi preenchido.',
            
            //Validações extras
            'cpf.formato_invalido_cpf' => 'O campo CPF está com a formatação inválida.',
            'cpf.unico' => 'O CPF informado já existe na base de dados.',
            'password.compare' => 'As senhas não conferem uma com a outra.',
            'email.unico' => 'O E-mail informado já existe na base de dados.',
        ];
    }
    
    /**
     * Pega a instancia de validação e adiciona o validador
     * @return type
     */
    protected function getValidatorInstance() {
        $validator = parent::getValidatorInstance();
        
        //Validação da formatação do CPF
        $validator->addImplicitExtension('formato_invalido_cpf', function($attribute, $value, $parameters) {
            if (!\App\Http\Helper\Validate::cpf($value)) {
                return false;
            }
            return true;
        });
        
        //Validação de CPF unico
        $validator->addImplicitExtension('unico', function($attribute, $value, $parameters) {
            $usuario = \App\User::where($attribute, $value);
            
            if (isset($this->id) && $this->id) {
                $usuario->where('id', '<>', $this->id);
            }
            
            if ($usuario->count()) {
                return false;
            }
            
            return true;
        });
        
        //Compara a senha com outro campo
        $validator->addImplicitExtension('compare', function($attribute, $value, $parameters) {
            foreach ($parameters as $campo) {
                if ($value != $this->$campo) {
                    return false;
                }
            }
            return true;
        });

        return $validator;
    }
}