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
        'password',
        'password_confirmation',
        'remember_token',
        'created_at',
        'updated_at',
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
        'password' => 'string',
        'password_confirmation' => 'string',
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
        'password_confirmation' => 'Confirmar Senha',
        'remember_token' => 'Token',
        'created_at' => 'Data de criação',
        'updated_at' => 'Data de atualização',
    ];
    
    /*
     * Busca o modelo de Permissoes
     * @return object Permissoes
    */
    public function Permissoes() {
        return $this->belongsToMany('App\Models\Permissoes', 'permissoes_users', 'user_id', 'permissao_id');
    }

    /**
     * Realiza a consulta da tabela
     * @return array
     */
    public function consultar() {
        $consulta = self::select('*')->orderBy('id', 'DESC');
        
        if ($this->cpf) {
            $consulta->where('cpf', 'like', '%'.$this->cpf.'%');
        }
        
        if ($this->nome) {
            $consulta->where('nome', 'like', '%'.$this->nome.'%');
        }
        
        if ($this->email) {
            $consulta->where('email', 'like', '%'.$this->email.'%');
        }
        
        return $consulta->get();
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'password_confirmation',
    ];
}
