<?php
/* @var Controller $this */

namespace App\Http\Controllers;

//Base do controlador
use App\Http\Controllers\Controller; //Base do controlador
use Illuminate\Http\Request; //Controle de dados por request
use App\Http\Requests\MenusFormRequest;
use App\DataTables\MenusDataTable as DataTable;

//Modelo da controller
use App\Models\Menus; 

use Response;

/**
 * Controlador dos Planos anuais
 * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 */
class MenusController extends Controller {
    
    /**
     * @var Menus
     */
    protected $model;
    
    /**
     * @var DataTable
     */
    protected $dataTable;
    
    /**
     * MenusController constructor.
     * @param Menus $menus
     */
    public function __construct(Menus $menus, DataTable $dataTable) {
        $this->model = $menus;
        $this->dataTable = $dataTable;
    }
    
    /**
     * Monta a listagem dos Menus
     * @param Request $request dados do formulário
     * @return Response
     */
    public function index(Request $request) {
        $this->authorize('MENUS_LISTAR', 'PermissaoPolicy');
        
        $this->model->setAttributes($request->all());
        
        if (app('request')->isXmlHttpRequest()) {
            $this->dataTable->model = $this->model;
            return $this->dataTable->ajax();
        }
        
        $menusPais = \App\Models\Menus::where('parent', 0)->pluck('header', 'id');
        
        return view('menus.index', array(
            'model' => $this->model->get(),
            'menusPais' => $menusPais,
            'dataTable' => $this->dataTable->html(),
        ));
    }
    
    /**
     * Consultar dados dos Menus para construir o datatables
     * @param Request $request
     * @return json
     */
    public function consultar(Request $request) {
        $this->model->setAttributes($request->all());
        return $this->model->consultarDataTables();
    }
    
    /**
     * Mostra o formulário para criar/editar um Menu
     * @return Response
     */
    public function form(Request $request) {
        $id = $request->route('id');
        $this->model->setAttributes($request->all());
        
        $model = $this->model;
        
        if ($id) {
            $this->authorize('MENUS_EDITAR', 'PermissaoPolicy');
            $model = $this->model->find($id);
            $model->formatAttributes('get');

            if (!$model) {
                $this->setMessage('O Menu não foi encontrado', 'danger');
                return redirect(url('menus/index'));
            }
        } else {
            $this->authorize('MENUS_CADASTRAR', 'PermissaoPolicy');
        }
        
        return view('menus.form', array(
            'model' => $model,
        ));
    }

    /**
     * Salva o Menu
     * @param $request ajusta os dados que vem do formulário
     * @return Response
     */
    public function save(MenusFormRequest $request) {
        $this->model->setAttributes($request->all());
        $this->model->formatAttributes('save');
        
        $this->model->parent = (empty($this->model->parent) ? 0 : $this->model->parent);
        
        if (!empty($this->model->id)) {
            $alterar = $this->model->find($this->model->id);
            
            if (empty($alterar) || is_null($alterar)) {
                $this->setMessage('O Menu a ser alterado não existe no banco de dados!', 'danger');    
            } else {
                $this->setMessage('O Menu foi alterado com sucesso!', 'success');    
                $alterar->update($this->model->toArray());
            }
        } else {
            $this->model->create($this->model->toArray());
            $this->setMessage('O Menu foi salvo com sucesso!', 'success');
        }
        
        $session = app('session.store');
        $session->remove('menus');
        
        return redirect(url('menus/index'));
    }

    /**
     * Mostra o detalhe
     * @param  int $id Identificador do Menu
     * @return Response
     */
    public function show($id) {
        $this->authorize('MENUS_DETALHAR', 'PermissaoPolicy');
        $model = Menus::find($id);
        $model->formatAttributes('get');
        
        if (!$model) {
            $this->setMessage('O Menu não foi encontrado', 'danger');
            return redirect(url('menus/index'));
        }
        return view('menus.show', ['model' => $model]);
    }

    /**
     * Ação de destruir/excluir um Menu
     * @param integer $id
     * @return Response::json
     */
    public function destroy($id) {
        $model = $this->model->find($id);

        $model->findOrFail($id)->delete();
        
        return Response::json(array(
            'success' => true,
            'msg' => 'O Menu foi excluido com sucesso!',
        ));
    }
}
