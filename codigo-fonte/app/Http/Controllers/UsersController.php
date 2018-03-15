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
use App\Repositories\UsersRepository;

/**
 * Controlador dos Usuários
 * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 */
class UsersController extends Controller {
    
    /**
     * @var Users
     */
    protected $repository;
    
    /**
     * @var DataTable
     */
    protected $dataTable;
    
    /**
     * UsersController constructor.
     * @param Users $users
     */
    public function __construct(UsersRepository $repository, DataTable $dataTable) {
        $this->repository = $repository;
        $this->dataTable = $dataTable;
    }
    
    /**
     * Monta a listagem dos Usuários
     * @param Request $request dados do formulário
     * @return Response
     */
    public function index(Request $request) {
        $this->authorize('USERS_LISTAR', 'PermissaoPolicy');
        
        $this->repository->fill($request->all());
        
        if (app('request')->isXmlHttpRequest()) {
            $this->dataTable->model = $this->repository;
            return $this->dataTable->ajax();
        }
        
        return view('users.index', array(
            'perfis' => \App\Models\Perfis::pluck('nome', 'id'),
            'model' => $this->repository->get(),
            'dataTable' => $this->dataTable->html(),
        ));
    }
    
    /**
     * Consultar dados dos Usuários para construir o datatables
     * @param Request $request
     * @return json
     */
    public function consultar(Request $request) {
        $this->repository->fill($request->all());
        return $this->repository->consultarDataTables();
    }
    
    /**
     * Mostra o formulário para criar/editar um Usuário
     * @return Response
     */
    public function form(Request $request) {
        
        $id = $request->route('id');
        $this->repository->fill($request->all());
        
        $model = $this->repository;
        if ($id) {
            $this->authorize('USERS_EDITAR', 'PermissaoPolicy');
            $model = $this->repository->buscarPorID($id);
            $model->cenario = 'editar';

            if (!$model) {
                $this->setMessage('O Usuário não foi encontrado', 'danger');
                return redirect(url('users/index'));
            }
        } else {
            $this->authorize('USERS_CADASTRAR', 'PermissaoPolicy');
            $model->cenario = 'cadastrar';
        }
        return view('users.form', array(
            'model' => $model,
            'perfis' => \App\Models\Perfis::get()->pluck( 'nome','id'),
        ));
    }

    /**
     * Salva o Usuário
     * @param $request ajusta os dados que vem do formulário
     * @return Response
     */
    public function save(UsersFormRequest $request) {
        if (!empty($request->get('id'))) {
            if ($this->repository->atualizar($request->get('id'), $request->all())) {
                $this->setMessage('O Usuário foi alterado com sucesso!', 'success'); 
            } else {
                $this->setMessage('O Usuário a ser alterado não existe no banco de dados!', 'danger');
            }
        } else {
            $this->repository->cadastrar($request->all());
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
        
        $model = $this->repository->buscarPorID($id);
        
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
        $msg = 'O usuário foi excluido com sucesso!';
        if (!$this->repository->deletar($id)) {
            $msg = 'Falha ao excluir o usuário';
        }
        return Response::json(array(
            'success' => true,
            'msg' => $msg,
        ));
    }
    
    /**
     * Ação de alterar perfil de um Usuário
     * @param object $request
     * @return Response::json
     */
    public function alterarPerfil(Request $request) {
        $data = $request->all();
        $status = true;
        $message = 'O perfil do usuário foi alterado com sucesso!';
        
        if (!$this->repository->atualizar($data['user_id'], ['perfil_id' => $data['perfil_id']])) {
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
        $id = $request->route('id');
        
        if ($id != \Auth::user()->id) {
            $this->authorize('USERS_TROCAR_SENHA', 'PermissaoPolicy');
        }

        if (!$id) {
            $this->setMessage('Não foi passado nenhum identificador do usuário.', 'danger');
            return redirect(url('/'));
        }
        
        $model = $this->repository->buscarPorID($id);
        /* @var $model User */
        
        $model->cenario = 'senha';
        if (!empty($dados)) {
            $retorno = $model->trocarSenha($dados);
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
            $retorno = $this->repository->recuperarSenha($dados);
            $this->setMessage($retorno['mensagem'], $retorno['tipo']);
            if ($retorno['tipo'] == 'success') {
                return redirect(url('/login'));
            }
            $email = $this->repository->email;
        }
        
        return view('users.recuperar-senha', ['email' => $email]);
    }
}
