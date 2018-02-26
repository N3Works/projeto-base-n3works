<?php
/* @var Controller $this */

namespace App\Http\Controllers;

//Base do controlador
use App\Http\Controllers\Controller; //Base do controlador
use Illuminate\Http\Request; //Controle de dados por request
use App\Http\Requests\FakesFormRequest;
use App\DataTables\FakesDataTable as DataTable;

//Modelo da controller
use App\Models\Fakes; 

use Response;

/**
 * Controlador dos Planos anuais
 * @author Thiago do Amarante Farias <thiago.farias@jointecnologia.com.br>
 */
class FakesController extends Controller {
    
    /**
     * @var Fakes
     */
    protected $model;
    
    /**
     * @var DataTable
     */
    protected $dataTable;
    
    /**
     * FakesController constructor.
     * @param Fakes $fakes
     */
    public function __construct(Fakes $fakes, DataTable $dataTable) {
        $this->model = $fakes;
        $this->dataTable = $dataTable;
    }
    
    /**
     * Monta a listagem dos Fakes
     * @param Request $request dados do formulário
     * @return Response
     */
    public function index(Request $request) {
        $this->model->setAttributes($request->all());
        
        if (app('request')->isXmlHttpRequest()) {
            $this->dataTable->model = $this->model;
            return $this->dataTable->ajax();
        }
        
        return view('fakes.index', array(
            'model' => $this->model->get(),
            'dataTable' => $this->dataTable->html(),
        ));
    }
    
    /**
     * Consultar dados dos Fakes para construir o datatables
     * @param Request $request
     * @return json
     */
    public function consultar(Request $request) {
        $this->model->setAttributes($request->all());
        return $this->model->consultarDataTables();
    }
    
    /**
     * Mostra o formulário para criar/editar um Fake
     * @return Response
     */
    public function form(Request $request) {
        $id = $request->route('id');
        $this->model->setAttributes($request->all());
        
        $model = $this->model;
        
        if ($id) {
            $model = $this->model->find($id);
            $model->formatAttributes('get');

            if (!$model) {
                $this->setMessage('O Fake não foi encontrado', 'danger');
                return redirect(url('fakes/index'));
            }
        }
        
        return view('fakes.form', array(
            'model' => $model,
        ));
    }

    /**
     * Salva o Fake
     * @param $request ajusta os dados que vem do formulário
     * @return Response
     */
    public function save(FakesFormRequest $request) {
        $this->model->setAttributes($request->all());
        $this->model->formatAttributes('save');
        
        if (!empty($this->model->id)) {
            $alterar = $this->model->find($this->model->id);
            
            if (empty($alterar) || is_null($alterar)) {
                $this->setMessage('O Fake a ser alterado não existe no banco de dados!', 'danger');    
            } else {
                $this->setMessage('O Fake foi alterado com sucesso!', 'success');    
                $alterar->update($this->model->toArray());
            }
        } else {
            $this->model->create($this->model->toArray());
            $this->setMessage('O Fake foi salvo com sucesso!', 'success');
        }
        
        return redirect(url('fakes/index'));
    }

    /**
     * Mostra o detalhe
     * @param  int $id Identificador do Fake
     * @return Response
     */
    public function show($id) {
        $model = Fakes::find($id);
        $model->formatAttributes('get');
        
        if (!$model) {
            $this->setMessage('O Fake não foi encontrado', 'danger');
            return redirect(url('fakes/index'));
        }
        return view('fakes.show', ['model' => $model]);
    }

    /**
     * Ação de destruir/excluir um Fake
     * @param integer $id
     * @return Response::json
     */
    public function destroy($id) {
        $model = $this->model->find($id);

        $model->findOrFail($id)->delete();
        
        return Response::json(array(
            'success' => true,
            'msg' => 'O Fake foi excluido com sucesso!',
        ));
    }
}
