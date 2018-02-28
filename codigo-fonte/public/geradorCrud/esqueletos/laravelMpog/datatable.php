<?php echo '<?php'.PHP_EOL; ?>
namespace App\DataTables;

use App\Models\<?php echo $nomeTabelaModel; ?>;
use App\Http\Helper\Formatar;
//use App\Http\Helper\Util;
use Yajra\Datatables\Services\DataTable;
/**
 * DataTable para o modelo de <?php echo $nomeTabelaModel; ?>
 * @author <?php echo $this->dados_modelo['extra']['nomeDesenv']; ?> <<?php echo $this->dados_modelo['extra']['emailDesenv']; ?>>
 */
class <?php echo $nomeTabelaModel; ?>DataTable extends DataTable {
    
    public $model;

    /**
     * Mostra a resposta em ajax
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax() {

        return $this->datatables->of($this->model->consultar())
            ->addColumn('acoes', function ($query) {
                $botoes = [];
                
                if (\Auth::user()->verificarPermissao('<?php echo strtoupper($this->nome_tabela); ?>_DETALHAR')) {
                    $botoes[] = '<a  href="' . url('<?php echo $nomeTabelaRender; ?>/show', ['id' => $query->id]) . '"><button class="btn btn-default"><i class="fa fa-search"></i></button></a>';
                }
                
                if (\Auth::user()->verificarPermissao('<?php echo strtoupper($this->nome_tabela); ?>_EDITAR')) {
                    $botoes[] = '<a  href="' . url('<?php echo $nomeTabelaRender; ?>/form', ['id' => $query->id]) . '"><button class="btn btn-primary"><i class="fa fa-pencil"></i></button></a>';
                }
                    
                if (\Auth::user()->verificarPermissao('<?php echo strtoupper($this->nome_tabela); ?>_EXCLUIR')) {
                    $botoes[] = '<a  href="#devNull" class="destroyTr" data-rel="' . $query->id . '" ><button class="btn btn-danger"><i class="fa fa-times"></i></button></a>';
                }
                
                return implode('', $botoes);
            })
<?php if (!empty($this->dados_modelo['relacoes']['referencias'])) { ?>
<?php foreach ($this->dados_modelo['relacoes']['referencias'] as $relacao_referenciada) { ?>
    <?php 
    foreach ($this->dados_modelo['tabela']['dados'] as $coluna) {
        if ($coluna['colunas_relacao_selecionada']) {
            ?>
            ->editColumn('<?php echo $relacao_referenciada['id_referencia']; ?>', function ($query) {
                return !empty($query-><?php echo $relacao_referenciada['tabela_formatada'][1]; ?>) ? $query-><?php echo $relacao_referenciada['tabela_formatada'][1]; ?>-><?php echo $coluna['colunas_relacao_selecionada']; ?> : '';
            })
            <?php
        }
    }
    ?>
                
<?php } ?>
<?php } ?>
            
<?php foreach ($this->dados_modelo['tabela']['dados'] as $coluna) { ?>
<?php if ($coluna['tipo_input'] == 'situacao') { ?>
            ->editColumn('<?php echo $coluna['nome_coluna']; ?>', function ($query) {
                return $query::$status_sistem_list[$query-><?php echo $coluna['nome_coluna']; ?>];
            })
<?php } ?>
<?php if (!empty($coluna['options'])) { ?>
            ->editColumn('<?php echo $coluna['nome_coluna']; ?>', function ($query) {
                return ($query-><?php echo $coluna['nome_coluna']; ?> ? $query::$<?php echo $coluna['options']['label']; ?>[$query-><?php echo $coluna['nome_coluna']; ?>] : '');
            })
<?php } ?>
<?php if ($coluna['tipo_coluna'] == 'date') { ?>
            ->editColumn('<?php echo $coluna['nome_coluna']; ?>', function ($query) {
                return $query-><?php echo $coluna['nome_coluna']; ?> =  \App\Http\Helper\Formatar::dateDbToAll($query-><?php echo $coluna['nome_coluna']; ?>, 'BR');
            })
<?php } ?>
<?php if ($coluna['tipo_coluna'] == 'datetime') { ?>
        ->editColumn('<?php echo $coluna['nome_coluna']; ?>', function ($query) {
            return $query-><?php echo $coluna['nome_coluna']; ?> =  \App\Http\Helper\Formatar::dateDbToAll($query-><?php echo $coluna['nome_coluna']; ?>, 'BR', true, true);
        })
<?php } ?>
<?php if ($coluna['tipo_input'] == 'porcentual') { ?>
        ->editColumn('<?php echo $coluna['nome_coluna']; ?>', function ($query) {
            $value = ($query-><?php echo $coluna['nome_coluna']; ?> ? \App\Http\Helper\Formatar::number($query-><?php echo $coluna['nome_coluna']; ?>, 'BR', 2, 2). '%' : '');
            return $value;
        })
<?php } ?>
<?php } ?>
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
                ->ajax([])
                ->parameters($this->getBuilderParameters());
    }

    /**
     * Pega as colunas
     * @return array
     */
    protected function getColumns() {
    
        return [
<?php
        
        $with = round(100 / (count($this->dados_modelo['tabela']['dados']) + 1));


        foreach ($this->dados_modelo['tabela']['dados'] as $coluna) {
                if ($coluna['mostrar_listagem']) {
?>
            [
                'name' => '<?php print $coluna['nome_coluna']; ?>',
                'title' => $this->model->labels['<?php print $coluna['nome_coluna']; ?>'],
                'style' => 'width:<?php print $with ;?>%',
            ],
<?php
                }
            }
?>
            [
                'name' => 'acoes',
                'title' => 'Ações',
                'style' => 'width:<?php print $with ;?>%',
            ]
        ];
    }

    /**
     * Pega o nome do arquivo para exportanção
     * @return string
     */
    protected function filename() {
        return '<?php echo $this->nome_tabela; ?>_' . time();
    }
}
