<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller {
    
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    */
    use AuthenticatesUsers;

    /**
     * Onde será redirecionado depois do login
     *
     * @var string
     */
    protected $redirectTo = '/';
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    /**
     * Login usuario
     * @param object $request
     * @return undefined
     */
    public function loginUser(Request $request) {
        
        $dados = $request->all();
        
        if (!empty($dados['login'])) {
            
            if(Auth::check()) {
                Auth::logout();
            }
            
            //Desformatar cpf e dar  md5($dados['senha'])
            $user = \App\User::where('cpf', preg_replace('/\D/', '', $dados['login']['cpf']))
                    ->where('password', md5($dados['login']['senha']));
            $userData = $user->first();
            
            if ($userData) {
                Auth::loginUsingId($userData->id);
                \App\Models\PermissoesPerfis::setar(); //Seta as permissões do usuário
                return redirect($this->redirectTo);
            } else {
                $this->setMessage('Usuário ou senha inválido.', 'danger');
            } 
        }
        
        return view('login.login');
    }
    
    /**
     * Desloga do sistema
     */
    public function logout() {
        Auth::logout();
        return redirect($this->redirectTo);
    }
}
