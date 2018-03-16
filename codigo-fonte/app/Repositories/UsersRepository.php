<?php
namespace App\Repositories;

use App\User;

/**
 * Repository dos usuários
 */
class UsersRepository extends User {
    
    use RepositoryTraitEzequiel;
    
    /**
     * Atualiza por ID
     * @param integer $id
     * @param array $data
     */
    public function atualizar($id, $data = []) {
        $model = $this->findOrFail($id);
        if ($model) {
            if (count($data)) {
                $model->fill($data);
            }
            unset($model->cenario);
            $model->password = md5($model->password);
            
            $model->update($this->toArray());
            return true;
        }
        return false;
    }
    
    /**
     * Cadastro/Registrar na tabela
     * @param array $data
     * @return integer ID
     */
    public function cadastrar($data = []) {
        if (count($data)) {
            $this->fill($data);
        }
        unset($this->cenario);
        $this->password = md5($this->password);
        return $this->insertGetId($this->toArray());
    }
    
    /**
     * Realiza a consulta da tabela
     * @return array
     */
    public function consultar() {
        $consulta = self::select('*')->orderBy('id', 'DESC');
        
        if ($this->cpf) {
            $consulta->where('cpf', 'LIKE', '%'.$this->cpf.'%');
        }
        
        if ($this->nome) {
            $consulta->where('nome', 'LIKE', '%'.$this->nome.'%');
        }
        
        if ($this->email) {
            $consulta->where('email', 'LIKE', '%'.$this->email.'%');
        }
        
        return $consulta->get();
    }
    
    /**
     * Trocar a senha atual por uma nova
     * @return array
     */
    public function trocarSenha($dados) {
        
        if (!empty($dados)) {
            $this->fill($dados);
        }
        
        $dadosRequest = array_map('trim', $this->attributes);
        
        unset($this->attributes['remember_token']);
        unset($dadosRequest['remember_token']);
        
        $count = count($dadosRequest);
        
        if (count(array_filter($dadosRequest)) != $count) {
            return ['mensagem' => 'Todos os campos são de preenchimento obrigatório', 'tipo' => 'danger'];
        }
        
        $user = $this->where('id', $dadosRequest['id'])
            ->where('password', md5($dadosRequest['password_atual']));
        
        if ($user->count() < 1) {
            return ['mensagem' => 'A senha atual é inválida.', 'tipo' => 'danger'];
        }

        $user->update(['password' => md5($dadosRequest['password'])]);
        
        return ['mensagem' => 'Senha alterada com sucesso.', 'tipo' => 'success'];
    }
    
    /**
     * Recupera a senha do usuário e envia um e-mail com a nova
     * @return array
     */
    public function recuperarSenha($dados) {
        if (!empty($dados)) {
            $this->fill($dados);
        }
        $user = $this->where('email', $this->email);
        if ($user->count() < 1) {
            return ['mensagem' => 'Este e-mail não existe na base.', 'tipo' => 'danger'];
        }
        
        $codigo = Http\Helper\Util::gerarCodigo();
        $user->update(['password' => md5($codigo)]);
        
        Http\Helper\SendMail::simpleEmailSending($user->first(), 'Recuperar Senha', 'users.mail.recuperar-senha', ['password' => $codigo]);
        
        return ['mensagem' => 'Foi enviado um e-mail com a nova senha.', 'tipo' => 'success'];
    }
}