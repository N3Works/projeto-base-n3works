<?php
namespace App\DataTables;

use App\Models\Permissoes;
use Yajra\Datatables\Services\DataTable;

/**
 * DataTable para o modelo de Permissoes * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 */
class PermissoesDataTable extends DataTable {
    
    public $model;
    
    //Monta lista de permissão com base nos usuários
    public $permissaoPerfilList = false;
    public $perfil_id;
    
    /**
     * Mostra a resposta em ajax
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax() {
        
        return $this->datatables->of($this->model->consultar())
            ->addColumn('acoes', function ($query) {
                
                if (!$this->permissaoPerfilList) {
                    $columns['show'] = '<a  href="' . url('permissoes/show/' . $query->id) . '"><button class="btn btn-default"><i class="fa fa-search"></i></button></a>';

                    if (!$query->permanente) {
                        $columns['edit'] = '<a  href="' . url('permissoes/form/' . $query->id) . '"><button class="btn btn-primary"><i class="fa fa-pencil"></i></button></a>';
                        $columns['delete'] = '<a  href="#devNull" class="destroyTr" data-rel="'.$query->id.'" ><button class="btn btn-danger"><i class="fa fa-times"></i></button></a>';
                    }
                } else {
                    $permissao = \Illuminate\Support\Facades\DB::table('permissoes_perfis')->where(['perfil_id' => $this->perfil_id, 'permissao_id' => $query->id])->count();
                    
                    if (!$permissao) {
                        $columns['inativo'] = '<a href="javascript:void(0)" class="setarPermissao" data-rel="inativo" data-rel-id="'.$query->id.'"><i class="fa fa-square fa-2x"></i></a>';
                    } else {
                        $columns['ativo'] = '<a href="javascript:void(0)" class="setarPermissao" data-rel="ativo" data-rel-id="'.$query->id.'"><i class="fa fa-check-square fa-2x"></i></a>';
                    }
                }

                return implode('', $columns);
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
        $model = new Permissoes();
        
        $styleWidth = 'width:15%;';
        if ($this->permissaoPerfilList) {
            $styleWidth = 'width:5%;';
        }

        return [
            [
                'name' => 'permissao',
                'title' => $model->labels['permissao'],
                'style' => 'width:25%'
            ],
            [
                'name' => 'descricao',
                'title' => $model->labels['descricao'],
            ],
            [
                'name' => 'acoes',
                'title' => 'Ativar',
                'style' => $styleWidth,
            ],
            // Adicione as colunas aqui!
        ];
    }

    /**
     * Pega o nome do arquivo para exportanção
     * @return string
     */
    protected function filename() {
        return 'permissoes_' . time();
    }
}
