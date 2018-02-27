<?php
/* @var Controller $this */
namespace App\Http\Controllers;

//Base do controlador
use App\Http\Controllers\Controller; //Base do controlador
use Illuminate\Http\Request; //Controle de dados por request
use App\Http\Requests\UsersFormRequest;
use App\DataTables\UsersDataTable as DataTable;
use Response;

//Modelo da controller
use App\User;

/**
 * Controlador dos Usuários
 * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 */
class UsersController extends Controller {
    
    /**
     * @var Users
     */
    protected $model;
    
    /**
     * @var DataTable
     */
    protected $dataTable;
    
    /**
     * UsersController constructor.
     * @param Users $users
     */
    public function __construct(User $users, DataTable $dataTable) {
        $this->model = $users;
        $this->dataTable = $dataTable;
    }
    
    /**
     * Monta a listagem dos Usuários
     * @param Request $request dados do formulário
     * @return Response
     */
    public function index(Request $request) {
        $this->authorize('USERS_LISTAR', 'PermissaoPolicy');
        
        $this->model->fill($request->all());
        
        if (app('request')->isXmlHttpRequest()) {
            $this->dataTable->model = $this->model;
            return $this->dataTable->ajax();
        }
        
        return view('users.index', array(
            'perfis' => \App\Models\Perfis::pluck('nome', 'id'),
            'model' => $this->model->get(),
            'dataTable' => $this->dataTable->html(),
        ));
    }
    
    /**
     * Consultar dados dos Usuários para construir o datatables
     * @param Request $request
     * @return json
     */
    public function consultar(Request $request) {
        $this->model->fill($request->all());
        return $this->model->consultarDataTables();
    }
    
    /**
     * Mostra o formulário para criar/editar um Usuário
     * @return Response
     */
    public function form(Request $request) {
        
        $id = $request->route('id');
        $this->model->fill($request->all());
        
        $model = $this->model;
        if ($id) {
            $this->authorize('USERS_EDITAR', 'PermissaoPolicy');
            $model = $this->model->find($id);

            if (!$model) {
                $this->setMessage('O Usuário não foi encontrado', 'danger');
                return redirect(url('users/index'));
            }
        } else {
            $this->authorize('USERS_CADASTRAR', 'PermissaoPolicy');
        }
        
        return view('users.form', array(
            'model' => $model,
        ));
    }

    /**
     * Salva o Usuário
     * @param $request ajusta os dados que vem do formulário
     * @return Response
     */
    public function save(UsersFormRequest $request) {
        $this->model->fill($request->all());
        $this->model->cpf = preg_replace('/\D/', '', $this->model->cpf);
        if (!empty($this->model->id)) {
            $alterar = $this->model->find($this->model->id);
            
            if (empty($alterar) || is_null($alterar)) {
                $this->setMessage('O Usuário a ser alterado não existe no banco de dados!', 'danger');    
            } else {
                $this->setMessage('O Usuário foi alterado com sucesso!', 'success');    
                $alterar->update($this->model->toArray());
            }
        } else {
            $this->model->create($this->model->toArray());
            $this->setMessage('O Usuário foi salvo com sucesso!', 'success');
        }
        
        return redirect(url('users/index'));
    }

    /**
     * Mostra o detalhe
     * @param  int $id Identificador do Usuário
     * @return Response
     */
    public function show($id) {
        
        if (!\Auth::check() || (\Auth::check() && \Auth::user()->id != $id)) {
            $this->authorize('USERS_DETALHAR', 'PermissaoPolicy');
        }
        
        $model = User::find($id);
        
        if (!$model) {
            $this->setMessage('O Usuário não foi encontrado', 'danger');
            return redirect(url('users/index'));
        }
        
        return view('users.show', [
            'model' => $model,
        ]);
    }

    /**
     * Ação de destruir/excluir um Usuário
     * @param integer $id
     * @return Response::json
     */
    public function destroy($id) {
        $model = $this->model->find($id);

        $model->findOrFail($id)->delete();
        
        return Response::json(array(
            'success' => true,
            'msg' => 'O Usuário foi excluido com sucesso!',
        ));
    }
    
    /**
     * Ação de destruir/excluir um Usuário
     * @param object $request
     * @return Response::json
     */
    public function alterarPerfil(Request $request) {
        $data = $request->all();
        $status = true;
        $message = 'O perfil do usuário foi alterado com sucesso!';
        
        
        if (!$this->model->find($data['user_id'])->update(['perfil_id' => $data['perfil_id']])) {
            $status = false;
            $message = 'Houve um problema ao alterar o perfil';
        }
        
        return Response::json(array(
            'status' => $status,
            'message' => $message,
        ));
    }
    
    /**
     * Troca a senha do usuário
     * @return view
     */
    public function trocarSenha(Request $request) {
        $dados = $request->all();
        $id_user = $request->route('id');
        
        if ($id_user != \Auth::user()->id) {
            $this->authorize('USERS_TROCAR_SENHA', 'PermissaoPolicy');
        }

        if (!$id_user) {
            $this->setMessage('Não foi passado nenhum identificador do usuário.', 'danger');
            return redirect(url('/'));
        }
        
        $model = $this->model->find($id_user);
        
        if (!empty($dados)) {
            $model->fill($dados);
            
            $retorno = $model->trocarSenha();
            $this->setMessage($retorno['mensagem'], $retorno['tipo']);
            if ($retorno['tipo'] == 'success') {
                return redirect(url('/'));
            }
        }
        
        return view('users.trocar-senha', ['model' => $model]);
    }
    
    /**
     * Recupera a senha do usuário criando uma nova e enviando para e-mail
     * @return view
     */
    public function recuperarSenha(Request $request) {
        $dados = $request->all();
        $email = '';
        
        if (!empty($dados)) {
            $model = $this->model->fill($dados);
            
            $retorno = $model->recuperarSenha();
            $this->setMessage($retorno['mensagem'], $retorno['tipo']);
            if ($retorno['tipo'] == 'success') {
                return redirect(url('/login'));
            }
            $email = $model->email;
        }
        
        return view('users.recuperar-senha', ['email' => $email]);
    }
}
