<?php
namespace App\DataTables;

use App\Models\Anexos;
use Yajra\Datatables\Services\DataTable;
use App\Http\Helper\Formatar;

/**
 * DataTable para o modelo de Anexos 
 * @author Ezequiel <email@email.com>
 */
class AnexosDataTable extends DataTable {
    
    /**
     * Mostra a resposta em ajax
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax() {
        $model = new Anexos();
        return $this->datatables->of($model->consultar())
            ->addColumn('acoes', function ($query) {
            return ''; //É editava via javascript no index.js
            })
            ->editColumn('updated_at', function($query) {
                return Formatar::dateDbToAll($query->updated_at, 'BR');
            })
            ->editColumn('created_at', function($query) {
                return Formatar::dateDbToAll($query->created_at, 'BR');
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
        $model = new Anexos();
        
        return [
            [
                'name' => 'id',
                'title' => $model->labels['id'],
                'style' => 'width:5%',
            ],
            [
                'name' => 'created_at',
                'title' => $model->labels['created_at'],
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
        return 'anexos_' . time();
    }
}
