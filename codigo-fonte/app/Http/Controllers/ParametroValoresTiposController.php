<?php
/* @var Controller $this */

namespace App\Http\Controllers;

//Base do controlador
use App\Http\Controllers\Controller; //Base do controlador
use Illuminate\Http\Request; //Controle de dados por request
use App\Http\Requests\ParametroValoresTiposFormRequest;
use App\DataTables\ParametroValoresTiposDataTable as DataTable;

//Modelo da controller
use App\Models\ParametroValoresTipos; 

use Response;

/**
 * Controlador dos Planos anuais
 * @author Thiago do Amarante Farias <thiago.farias@jointecnologia.com.br>
 */
class ParametroValoresTiposController extends Controller {
    
    /**
     * @var ParametroValoresTipos
     */
    protected $model;
    
    /**
     * @var DataTable
     */
    protected $dataTable;
    
    /**
     * ParametroValoresTiposController constructor.
     * @param ParametroValoresTipos $parametro_valores_tipos
     */
    public function __construct(ParametroValoresTipos $parametro_valores_tipos, DataTable $dataTable) {
        $this->model = $parametro_valores_tipos;
        $this->dataTable = $dataTable;
    }
    
    /**
     * Monta a listagem dos Valores dos Tipos de parâmetro
     * @param Request $request dados do formulário
     * @return Response
     */
    public function index(Request $request) {
        $this->model->setAttributes($request->all());
        
        if (app('request')->isXmlHttpRequest()) {
            $this->dataTable->model = $this->model;
            return $this->dataTable->ajax();
        }
        
        return view('parametro_valores_tipos.index', array(
            'model' => $this->model->get(),
            'dataTable' => $this->dataTable->html(),
        ));
    }
    
    /**
     * Consultar dados dos Valores dos Tipos de parâmetro para construir o datatables
     * @param Request $request
     * @return json
     */
    public function consultar(Request $request) {
        $this->model->setAttributes($request->all());
        return $this->model->consultarDataTables();
    }
    
    /**
     * Mostra o formulário para criar/editar um Valores do Tipo de parâmetro
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
                $this->setMessage('O Valores do Tipo de parâmetro não foi encontrado', 'danger');
                return redirect(url('parametroValoresTipos/index'));
            }
        }
        
        return view('parametro_valores_tipos.form', array(
            'model' => $model,
        ));
    }

    /**
     * Salva o Valores do Tipo de parâmetro
     * @param $request ajusta os dados que vem do formulário
     * @return Response
     */
    public function save(ParametroValoresTiposFormRequest $request) {
        $this->model->setAttributes($request->all());
        $this->model->formatAttributes('save');
        
        if (!empty($this->model->id)) {
            $alterar = $this->model->find($this->model->id);
            
            if (empty($alterar) || is_null($alterar)) {
                $this->setMessage('O Valores do Tipo de parâmetro a ser alterado não existe no banco de dados!', 'danger');    
            } else {
                $this->setMessage('O Valores do Tipo de parâmetro foi alterado com sucesso!', 'success');    
                $alterar->update($this->model->toArray());
            }
        } else {
            $this->model->create($this->model->toArray());
            $this->setMessage('O Valores do Tipo de parâmetro foi salvo com sucesso!', 'success');
        }
        
        return redirect(url('parametroValoresTipos/index'));
    }

    /**
     * Mostra o detalhe
     * @param  int $id Identificador do Valores do Tipo de parâmetro
     * @return Response
     */
    public function show($id) {
        $model = ParametroValoresTipos::find($id);
        $model->formatAttributes('get');
        
        if (!$model) {
            $this->setMessage('O Valores do Tipo de parâmetro não foi encontrado', 'danger');
            return redirect(url('parametroValoresTipos/index'));
        }
        return view('parametro_valores_tipos.show', ['model' => $model]);
    }

    /**
     * Ação de destruir/excluir um Valores do Tipo de parâmetro
     * @param integer $id
     * @return Response::json
     */
    public function destroy($id) {
        $model = $this->model->find($id);

        $model->findOrFail($id)->delete();
        
        return Response::json(array(
            'success' => true,
            'msg' => 'O Valores do Tipo de parâmetro foi excluido com sucesso!',
        ));
    }
}
