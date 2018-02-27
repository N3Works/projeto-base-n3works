<?php
namespace App\DataTables;

use App\User;
use Yajra\Datatables\Services\DataTable;
use App\Http\Helper\Formatar;

/**
 * DataTable para o modelo de Users * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 */
class UsersDataTable extends DataTable {
    
    public $model;
    
    /**
     * Mostra a resposta em ajax
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax() {
        return $this->datatables->of($this->model->consultar())
            ->addColumn('acoes', function ($query) {
                $botoes = [
                    'show' => '<a  href="' . url('users/show/' . $query->id) . '" title="Detalhe"><button class="btn btn-default"><i class="fa fa-search"></i></button></a>',
                    'edit' => '<a  href="' . url('users/form/' . $query->id) . '" title="Editar" ><button class="btn btn-primary"><i class="fa fa-pencil"></i></button></a>',
                    'perfil' => '',
                    'delete' => '<a  href="#devNull" class="destroyTr" title="Excluir" data-rel="'.$query->id.'" ><button class="btn btn-danger"><i class="fa fa-times"></i></button></a>',
                ];
                
                if (\Auth::user()->verificarPermissao('USERS_LISTAR_BTN_PERFIL')) {
                    $botoes['perfil'] = '<a href="javascript:void(0)"
                                            title="Alterar Perfil" 
                                            class="showModalAlterarPerfil" 
                                            data-rel-id="' . $query->id . '"
                                            data-rel-perfil="' . $query->Perfil->id . '"
                                            data-rel-nome="' . $query->nome . '"
                                            ><button class="btn btn-primary"><i class="fa fa-user"></i></button></a>';
                }
                
                if (\Auth::user()->id == $query->id) {
                    unset($botoes['delete'], $botoes['perfil']);
                }

                return implode('', $botoes);
            })
            ->editColumn('updated_at', function($query) {
                return Formatar::dateDbToAll($query->updated_at, 'BR');
            })
            ->editColumn('created_at', function($query) {
                return Formatar::dateDbToAll($query->created_at, 'BR');
            })
            ->editColumn('perfil_id', function($query) {
                return ($query->Perfil ? $query->Perfil->nome : '');
            })
            ->editColumn('cpf', function($query) {
                return Formatar::mask($query->cpf, '###.###.###-##');
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
        $model = new User();
        
        return [
            [
                'name' => 'cpf',
                'title' => $model->labels['cpf'],
            ],
            [
                'name' => 'nome',
                'title' => $model->labels['nome'],
            ],
            [
                'name' => 'email',
                'title' => $model->labels['email'],
            ],
            [
                'name' => 'perfil_id',
                'title' => $model->labels['perfil_id'],
            ],
            [
                'name' => 'created_at',
                'title' => $model->labels['created_at'],
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
        return 'users_' . time();
    }
}
