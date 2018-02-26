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

//Classes de regra de negócio
use App\Models\Permissoes;
use App\DataTables\PermissoesDataTable;

/**
 * Controlador dos Planos anuais
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
     * @var PermissoesDataTable
     */
    protected $permissoesDataTable;
    
    /**
     * UsersController constructor.
     * @param Users $users
     */
    public function __construct(User $users, DataTable $dataTable, PermissoesDataTable $dataTablePermissoes) {
        $this->model = $users;
        $this->dataTable = $dataTable;
        $this->permissoesDataTable = $dataTablePermissoes;
    }
    
    /**
     * Monta a listagem dos Usuários
     * @param Request $request dados do formulário
     * @return Response
     */
    public function index(Request $request) {
        $this->model->fill($request->all());
        
        if (app('request')->isXmlHttpRequest()) {
            $this->dataTable->model = $this->model;
            return $this->dataTable->ajax();
        }
        
        return view('users.index', array(
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
            $model = $this->model->find($id);

            if (!$model) {
                $this->setMessage('O Usuário não foi encontrado', 'danger');
                return redirect(url('users/index'));
            }
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
        $model = User::find($id);
        
        if (!$model) {
            $this->setMessage('O Usuário não foi encontrado', 'danger');
            return redirect(url('users/index'));
        }
        $dataTable = $this->permissoesDataTable;
        $dataTable->permissaoUserList = true;
        
        return view('users.show', [
            'model' => $model,
            'dataTable' => $dataTable->html(),
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
     * Retorna a lista de permissões disponiveis
     * @return type
     */
    public function listarPermissoes(Request $request) {
        $permissoes = new Permissoes();
        $data = $request->all();
        $permissoes->fill($data);
       
        $this->permissoesDataTable->model = $permissoes;
        $this->permissoesDataTable->permissaoUserList = true;
        $this->permissoesDataTable->id_user = $data['id_user'];
        
        return $this->permissoesDataTable->ajax();
    }
}
