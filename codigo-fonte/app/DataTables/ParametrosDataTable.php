<?php
namespace App\DataTables;

use App\Models\Parametros;
use Yajra\Datatables\Services\DataTable;
use App\Http\Helper\Formatar;

/**
 * DataTable para o modelo de Parametros * @author Thiago do Amarante Farias <thiago.farias@jointecnologia.com.br>
 */
class ParametrosDataTable extends DataTable {
    
    /**
     * Mostra a resposta em ajax
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax() {
        $model = new Parametros();
        return $this->datatables->of($model->consultar())
            ->addColumn('acoes', function ($query) {
            return '<a  href="' . url('parametros/show/' . $query->id) . '"><button class="btn btn-default"><i class="fa fa-search"></i></button></a>
                <a  href="' . url('parametros/form/' . $query->id) . '"><button class="btn btn-primary"><i class="fa fa-pencil"></i></button></a>
                <a  href="#devNull" class="destroyTr" data-rel="'.$query->id.'" ><button class="btn btn-danger"><i class="fa fa-times"></i></button></a>';
            })
            ->editColumn('tipo', function($query) {
                return $query::$tipos_list[$query->tipo];
            })
            ->editColumn('status', function($query) {
                return $query::$status_sistem_list[$query->status];
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
        $model = new Parametros();
        
        return [
            [
                'name' => 'nome',
                'title' => $model->labels['nome'],
            ],
            [
                'name' => 'tipo',
                'title' => $model->labels['tipo'],
            ],
            [
                'name' => 'status',
                'title' => $model->labels['status'],
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
        return 'parametros_' . time();
    }
}
