<?php
namespace App\DataTables;

use App\Models\Menus;
use Yajra\Datatables\Services\DataTable;
use App\Http\Helper\Formatar;

/**
 * DataTable para o modelo de Menus * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 */
class MenusDataTable extends DataTable {
    
    public $model;
    
    /**
     * Mostra a resposta em ajax
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax() {
        return $this->datatables->of($this->model->consultar())
            ->addColumn('acoes', function ($query) {
            return '<a  href="' . url('menus/show/' . $query->id) . '"><button class="btn btn-default"><i class="fa fa-search"></i></button></a>
                <a  href="' . url('menus/form/' . $query->id) . '"><button class="btn btn-primary"><i class="fa fa-pencil"></i></button></a>
                <a  href="#devNull" class="destroyTr" data-rel="'.$query->id.'" ><button class="btn btn-danger"><i class="fa fa-times"></i></button></a>';
            })
            ->editColumn('parent', function($query) {
                $parent = \App\Models\Menus::find($query->parent);
                $header = '';
                if ($parent) {
                    $header = $parent->header;
                }
                return $header;
            })
            ->editColumn('updated_at', function($query) {
                return Formatar::dateDbToAll($query->updated_at, 'BR');
            })
            ->make(true);
    }

    /**
     * Pega a consulta em objeto para ser processada pelo DataTables
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query() {} //Não está sendo utilizado pela necessidade dos filtros

    /**
     * Método opcional se você quiser usar o construtor de HTML
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html() {
    return $this->builder()
                ->columns($this->getColumns())
                ->ajax('')
                ->parameters($this->getBuilderParameters());
    }

    /**
     * Pega as colunas
     * @return array
     */
    protected function getColumns() {
        $model = new Menus();
        
        return [
            [
                'name' => 'header',
                'title' => $model->labels['header'],
            ],
            [
                'name' => 'parent',
                'title' => $model->labels['parent'],
            ],
            [
                'name' => 'order',
                'title' => $model->labels['order'],
                'style' => 'width:5%',
            ],
            [
                'name' => 'updated_at',
                'title' => $model->labels['updated_at'],
            ],
            [
                'name' => 'acoes',
                'title' => 'Ações',
                'style' => 'width:15%',
            ],
            // Adicione as colunas aqui!
        ];
    }

    /**
     * Pega o nome do arquivo para exportanção
     * @return string
     */
    protected function filename() {
        return 'menus_' . time();
    }
}
