<?php
/* @var Controller $this */
namespace App\Http\Controllers;

//Base do controlador
use App\Http\Controllers\Controller; //Base do controlador
use Illuminate\Http\Request; //Controle de dados por request
use App\Http\Requests\PerfisFormRequest;
use App\DataTables\PerfisDataTable as DataTable;

//Modelo da controller
use App\Repositories\PerfisRepository;

//Classes de regra de negócio
use App\Models\Permissoes;
use App\DataTables\PermissoesDataTable;

use Response;

/**
 * Controlador dos Planos anuais
 * @author Thiago do Amarante Farias <thiago.farias@jointecnologia.com.br>
 */
class PerfisController extends Controller {
    
    /**
     * @var Perfis
     */
    protected $repository;
    
    /**
     * @var DataTable
     */
    protected $dataTable;
    
    /**
     * @var PermissoesDataTable
     */
    protected $permissoesDataTable;
    
    /**
     * PerfisController constructor.
     * @param Perfis $perfis
     */
    public function __construct(PerfisRepository $repository, DataTable $dataTable, PermissoesDataTable $dataTablePermissoes) {
        $this->repository = $repository;
        $this->dataTable = $dataTable;
        $this->permissoesDataTable = $dataTablePermissoes;
    }
    
    /**
     * Monta a listagem dos Perfis
     * @param Request $request dados do formulário
     * @return Response
     */
    public function index(Request $request) {
        $this->authorize('PERFIS_LISTAR', 'PermissaoPolicy');
        $this->repository->fill($request->all());
        
        if (app('request')->isXmlHttpRequest()) {
            $this->dataTable->model = $this->repository;
            return $this->dataTable->ajax();
        }
        
        return view('perfis.index', array(
            'model' => $this->repository->get(),
            'dataTable' => $this->dataTable->html(),
        ));
    }
    
    /**
     * Consultar dados dos Perfis para construir o datatables
     * @param Request $request
     * @return json
     */
    public function consultar(Request $request) {
        $this->repository->fill($request->all());
        return $this->repository->consultarDataTables();
    }
    
    /**
     * Mostra o formulário para criar/editar um Perfil
     * @return Response
     */
    public function form(Request $request) {
        $id = $request->route('id');
        $this->repository->fill($request->all());
        
        $model = $this->repository;
        
        if ($id) {
            $this->authorize('PERFIS_EDITAR', 'PermissaoPolicy');
            $model = $this->repository->buscarPorID($id);

            if (!$model) {
                $this->setMessage('O Perfil não foi encontrado', 'danger');
                return redirect(url('perfis/index'));
            }
        } else {
            $this->authorize('PERFIS_CADASTRAR', 'PermissaoPolicy');
        }
        
        return view('perfis.form', array(
            'model' => $model,
        ));
    }

    /**
     * Salva o Perfil
     * @param $request ajusta os dados que vem do formulário
     * @return Response
     */
    public function save(PerfisFormRequest $request) {
        if (!empty($request->get('id'))) {
            if ($this->repository->atualizar($request->get('id'), $request->all())) {
                $this->setMessage('O Perfil foi alterado com sucesso!', 'success');    
            } else {
                $this->setMessage('O Perfil a ser alterado não existe no banco de dados!', 'danger');
            }
        } else {
            $this->repository->cadastrar($request->all());
            $this->setMessage('O Perfil foi salvo com sucesso!', 'success');
        }
        return redirect(url('perfis/index'));
    }

    /**
     * Mostra o detalhe
     * @param  int $id Identificador do Perfil
     * @return Response
     */
    public function show($id) {
        $this->authorize('PERFIS_DETALHAR', 'PermissaoPolicy');

        $model = $this->repository->buscarPorID($id);
        
        if (!$model) {
            $this->setMessage('O Perfil não foi encontrado', 'danger');
            return redirect(url('perfis/index'));
        }
        
        $dataTable = $this->permissoesDataTable;
        $dataTable->permissaoUserList = true;
        
        return view('perfis.show', [
            'model' => $model,
            'dataTable' => $dataTable->html(),
        ]);
    }

    /**
     * Ação de destruir/excluir um Perfil
     * @param integer $id
     * @return Response::json
     */
    public function destroy($id) {
        $msg = 'O perfil foi excluido com sucesso!';
        if (!$this->repository->deletar($id)) {
            $msg = 'Falha ao excluir o perfil';
        }
        return Response::json(array(
            'success' => true,
            'msg' => $msg,
        ));
    }
    
    /**
     * Retorna a lista de permissões disponiveis
     * @return type
     */
    public function listarPermissoes(Request $request) {
        $permissoes = new \App\Repositories\PermissoesRepository();
        $data = $request->all();
        $permissoes->fill($data);
       
        $this->permissoesDataTable->model = $permissoes;
        $this->permissoesDataTable->permissaoPerfilList = true;
        $this->permissoesDataTable->perfil_id = $data['perfil_id'];
        
        return $this->permissoesDataTable->ajax();
    }
}
