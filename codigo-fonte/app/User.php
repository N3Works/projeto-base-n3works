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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token', 'password_confirmation',
    ];
    
    /**
     * Verificar permissionamento (Utilizada por causa do \Auth::user())
     * @param string $permissao
     * @return boolean
     */
    public static function verificarPermissao($permissao) {
        
        /*!!!! Nunca Tirar daqui essa função !!!! */
        
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
}
