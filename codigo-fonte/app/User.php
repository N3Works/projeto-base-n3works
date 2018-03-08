<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    
    protected $table = 'users'; //Seta o nome da tabela no banco
    public $dataAcessos = array(); //Guarda os dados recebidos do acessos
    
    use Notifiable;

    /**
     * Variaveis seguras para uso e guardar dados 
     * @var array 
     */
    public $fillable = [
        'id',
        'cpf',
        'nome',
        'email',
        'perfil_id',
        'password',
        'password_confirmation',
        'password_atual',
        'remember_token',
        'created_at',
        'updated_at',
        'cenario', //Utilizado no FormRequest
    ];
    
    /**
     * Tipos nativos dos atributos
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'cpf' => 'string',
        'nome' => 'string',
        'email' => 'string',
        'perfil_id' => 'integer',
        'password' => 'string',
        'password_confirmation' => 'string',
        'password_atual' => 'string',
        'remember_token' => 'string',
        'created_at' => 'data_tempo',
        'updated_at' => 'data_tempo',
    ];
    
    /**
     * Label dos atributos
     * @var array 
     */
    public $labels = [
        'id' => 'ID',
        'cpf' => 'CPF',
        'nome' => 'Nome',
        'email' => 'Email',
        'password' => 'Senha',
        'perfil_id' => 'Perfil',
        'remember_token' => 'Token',
        'created_at' => 'Data de criação',
        'password_atual' => 'Senha Atual',
        'updated_at' => 'Data de Atualização',
        'password_confirmation' => 'Confirmar Senha Nova',
    ];
    
    /*
     * Busca o modelo de Permissoes
     * @return object Permissoes
    */
    public function Perfil() {
        return $this->hasOne('App\Models\Perfis', 'id', 'perfil_id');
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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token', 'password_confirmation',
    ];
    
    /**
     * Verificar permissionamento
     * @param string $permissao
     * @return boolean
     */
    public static function verificarPermissao($permissao) {
        $sessao = app('session.store');
        $permissoes = [];
        
        if ($sessao->has('permissoes')) {
            $permissoes = $sessao->get('permissoes');
        }
        
        if (in_array($permissao, $permissoes)) {
            return true;
        }
        return false;
    }
    
    /**
     * Trocar a senha atual por uma nova
     * @return array
     */
    public function trocarSenha() {
        $dadosRequest = array_map('trim', $this->attributes);
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
    public function recuperarSenha() {
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
