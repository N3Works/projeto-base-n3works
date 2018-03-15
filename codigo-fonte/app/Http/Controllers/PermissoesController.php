<?php
/* @var Controller $this */

namespace App\Http\Controllers;

//Base do controlador
use App\Http\Controllers\Controller; //Base do controlador
use Illuminate\Http\Request; //Controle de dados por request
use App\Http\Requests\PermissoesFormRequest;
use App\DataTables\PermissoesDataTable as DataTable;
use Response;

//Repository->Model da controller
use App\Repositories\PerfisRepository; 

//Seta repository->Model referenciadas
use App\Repositories\PermissoesPerfisRepository;

/**
 * Controlador dos Planos anuais
 * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 */
class PermissoesController extends Controller {
    
    /**
     * @var Permissoes
     */
    protected $repository;
    
    /**
     * @var DataTable
     */
    protected $dataTable;
    
    /**
     * PermissoesController constructor.
     * @param Permissoes $permissoes
     */
    public function __construct(PerfisRepository $repository, DataTable $dataTable) {
        $this->repository = $repository;
        $this->dataTable = $dataTable;
    }
    
    /**
     * Monta a listagem dos Permissões
     * @param Request $request dados do formulário
     * @return Response
     */
    public function index(Request $request) {
        $this->authorize('PERMISSOES_LISTAR', 'PermissaoPolicy');
        
        $this->repository->fill($request->all());
        
        if (app('request')->isXmlHttpRequest()) {
            $this->dataTable->model = $this->repository;
            return $this->dataTable->ajax();
        }
        
        return view('permissoes.index', array(
            'model' => $this->repository->get(),
            'dataTable' => $this->dataTable->html(),
        ));
    }
    
    /**
     * Consultar dados dos Permissões para construir o datatables
     * @param Request $request
     * @return json
     */
    public function consultar(Request $request) {
        $this->repository->fill($request->all());
        return $this->repository->consultarDataTables();
    }
    
    /**
     * Mostra o formulário para criar/editar um Permissão
     * @return Response
     */
    public function form(Request $request) {
        
        $id = $request->route('id');
        $this->repository->fill($request->all());
        
        $model = $this->repository;
        
        if ($id) {
            $this->authorize('PERMISSOES_EDITAR', 'PermissaoPolicy');
            $model = $this->repository->buscarPorID($id);

            if (!$model) {
                $this->setMessage('O Permissão não foi encontrado', 'danger');
                return redirect(url('permissoes/index'));
            }
        } else {
            $this->authorize('PERMISSOES_CADASTRAR', 'PermissaoPolicy');
        }
        
        return view('permissoes.form', array(
            'model' => $model,
        ));
    }

    /**
     * Salva o Permissão
     * @param $request ajusta os dados que vem do formulário
     * @return Response
     */
    public function save(PermissoesFormRequest $request) {
        if (!empty($request->get('id'))) {
            if ($this->repository->atualizar($request->get('id'), $request->all())) {
                $this->setMessage('O Permissão foi alterado com sucesso!', 'success');
            } else {
                $this->setMessage('O Permissão a ser alterado não existe no banco de dados!', 'danger');
            }
        } else {
            $this->repository->cadastrar($request->all());
            $this->setMessage('O Permissão foi salvo com sucesso!', 'success');
        }
        
        return redirect(url('permissoes/index'));
    }

    /**
     * Mostra o detalhe
     * @param  int $id Identificador do Permissão
     * @return Response
     */
    public function show($id) {
        $this->authorize('PERMISSOES_DETALHAR', 'PermissaoPolicy');
        $model = $this->repository->buscarPorID($id);
        
        if (!$model) {
            $this->setMessage('O Permissão não foi encontrado', 'danger');
            return redirect(url('permissoes/index'));
        }
        return view('permissoes.show', ['model' => $model]);
    }

    /**
     * Ação de destruir/excluir um Permissão
     * @param integer $id
     * @return Response::json
     */
    public function destroy($id) {
        $bol = $this->repository->deletar($id);
        $msg = 'A permissão foi excluida com sucesso!';
        if (!$bol) {
            $msg = 'Permissão não encontrada.';
        }
        return Response::json(array(
            'success' => $bol,
            'msg' => $msg,
        ));
    }
    
    /**
     * Atribui a permissão ao funcionário
     * @param Request $request
     */
    public function salvarPermissoes(Request $request) {
        $data = $request->all();
        $repository = new PermissoesPerfisRepository();
        $success = true;
        $msg = '';
        
        if (isset($data['permissoes_ids']) && count($data['permissoes_ids']) > 0) {
            foreach ($data['permissoes_ids'] as $key => $id) {
                $msg = $repository->atribuirPermissao($id, $data['permissoes'][$key], $data['perfil_id']);
            }
        } else {
            $msg = 'Falha ao inserir as permissões.';
            $success = false;
        }
        
        return Response::json(array(
            'success' => $success,
            'msg' => $msg,
        ));
    }
}
