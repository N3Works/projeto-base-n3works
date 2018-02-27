<?php
/* @var Controller $this */

namespace App\Http\Controllers;

//Base do controlador
use App\Http\Controllers\Controller; //Base do controlador
use Illuminate\Http\Request; //Controle de dados por request
use App\Http\Requests\PermissoesFormRequest;
use App\DataTables\PermissoesDataTable as DataTable;
use Response;

//Modelo da controller
use App\Models\Permissoes; 

//Seta models referenciadas
use App\Models\PermissoesPerfis;

/**
 * Controlador dos Planos anuais
 * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 */
class PermissoesController extends Controller {
    
    /**
     * @var Permissoes
     */
    protected $model;
    
    /**
     * @var DataTable
     */
    protected $dataTable;
    
    /**
     * PermissoesController constructor.
     * @param Permissoes $permissoes
     */
    public function __construct(Permissoes $permissoes, DataTable $dataTable) {
        $this->model = $permissoes;
        $this->dataTable = $dataTable;
    }
    
    /**
     * Monta a listagem dos Permissões
     * @param Request $request dados do formulário
     * @return Response
     */
    public function index(Request $request) {
        $this->authorize('PERMISSOES_LISTAR', 'PermissaoPolicy');
        
        $this->model->fill($request->all());
        
        if (app('request')->isXmlHttpRequest()) {
            $this->dataTable->model = $this->model;
            return $this->dataTable->ajax();
        }
        
        return view('permissoes.index', array(
            'model' => $this->model->get(),
            'dataTable' => $this->dataTable->html(),
        ));
    }
    
    /**
     * Consultar dados dos Permissões para construir o datatables
     * @param Request $request
     * @return json
     */
    public function consultar(Request $request) {
        $this->model->setAttributes($request->all());
        return $this->model->consultarDataTables();
    }
    
    /**
     * Mostra o formulário para criar/editar um Permissão
     * @return Response
     */
    public function form(Request $request) {
        
        $id = $request->route('id');
        $this->model->fill($request->all());
        
        $model = $this->model;
        
        if ($id) {
            $this->authorize('PERMISSOES_EDITAR', 'PermissaoPolicy');
            $model = $this->model->find($id);
            $model->formatAttributes('get');

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
        $this->model->setAttributes($request->all());
        $this->model->formatAttributes('save');
        
        if (!empty($this->model->id)) {
            $alterar = $this->model->find($this->model->id);
            
            if (empty($alterar) || is_null($alterar)) {
                $this->setMessage('O Permissão a ser alterado não existe no banco de dados!', 'danger');    
            } else {
                $this->setMessage('O Permissão foi alterado com sucesso!', 'success');    
                $alterar->update($this->model->toArray());
            }
        } else {
            $this->model->create($this->model->toArray());
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
        $model = Permissoes::find($id);
        $model->formatAttributes('get');
        
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
        $model = $this->model->find($id);

        $model->findOrFail($id)->delete();
        
        return Response::json(array(
            'success' => true,
            'msg' => 'O Permissão foi excluido com sucesso!',
        ));
    }
    
    /**
     * Atribui a permissão ao funcionário
     * @param Request $request
     */
    public function atribuirPermissao(Request $request) {
        $model = new PermissoesPerfis();
        $dados = $request->all();
        return Response::json(array(
            'success' => true,
            'msg' => $model->atribuirPermissao($dados),
        ));
    }
}
