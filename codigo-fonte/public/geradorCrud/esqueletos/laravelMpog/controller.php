<?php echo '<?php'.PHP_EOL; ?>
/* @var Controller $this */
namespace App\Http\Controllers;

//Base do controlador
use App\Http\Controllers\Controller;
use App\Http\Requests\<?php echo $nomeTabelaModel; ?>FormRequest;
use App\DataTables\<?php echo $nomeTabelaModel; ?>DataTable as DataTable;
use Illuminate\Http\Request;
use Response;

//Modelo da controller
use App\Models\<?php echo $nomeTabelaModel; ?>; 

/**
 * Controlador <?php echo $this->dados_modelo['tabela']['nome_singular'].PHP_EOL; ?>
 *
 * @author <?php echo $this->dados_modelo['extra']['nomeDesenv']; ?> <<?php echo $this->dados_modelo['extra']['emailDesenv']; ?>>
 */
class <?php echo $nomeTabelaModel; ?>Controller extends Controller {

    /**
     * @var Model <?php echo $nomeTabelaModel.PHP_EOL; ?>
     */
    protected $model;
    
    /**
     * @var DataTable
     */
    protected $dataTable;
    
    /**
     * <?php echo $nomeTabelaModel; ?>Controller constructor.
     * @param <?php echo $nomeTabelaModel; ?> $<?php echo $this->nome_tabela.PHP_EOL; ?>
     */
    public function __construct(<?php echo $nomeTabelaModel; ?> $<?php echo $this->nome_tabela; ?>, DataTable $dataTable) {
        $this->model = $<?php echo $this->nome_tabela; ?>;
        $this->dataTable = $dataTable;
    }
    
    /**
     * Monta a listagem d<?php $this->chamaGeneroMsg(); ?>s <?php echo $this->dados_modelo['tabela']['nome_singular'].PHP_EOL; ?>
     * @param Request $request dados do formulário
     * @return Response
     */
    public function index(Request $request) {
        $this->authorize('<?php echo strtoupper($this->nome_tabela); ?>_LISTAR', 'PermissaoPolicy');
        $this->model->fill($request->all());
        $this->dataTable->model = $this->model;
        
        if (app('request')->isXmlHttpRequest()) {
            return $this->dataTable->ajax();
        }
        
        return view('<?php echo $this->nome_tabela; ?>.index', array(
            'model' => $this->model,
            'dataTable' => $this->dataTable->html(),
        ));
    }
        
    /**
     * Consultar dados d<?php $this->chamaGeneroMsg(); ?>s <?php echo $this->dados_modelo['tabela']['nome_plural']; ?> para construir o datatables
     * @param Request $request
     * @return json
     */
    public function consultar(Request $request) {
        $this->model->fill($request->all());
        return $this->model->consultarDataTables();
    }
        
    /**
     * Mostra o formulário para criar/editar <?php $this->chamaGeneroMsg('um', 'uma'); ?> <?php echo $this->dados_modelo['tabela']['nome_singular'].PHP_EOL; ?>
     * @return Response
     */    
    public function form(Request $request) {
        $id = $request->route('id');
        $this->model->setAttributes($request->all()); 
        $model = $this->model;
        
        if ($id) {
            $this->authorize('<?php echo strtoupper($this->nome_tabela); ?>_EDITAR', 'PermissaoPolicy');
            $model = $this->model->find($id);
            $model->formatAttributes('get');
        
            if (!$model) {
                $this->setMessage('<?php $this->chamaGeneroMsg('O', 'A'); ?> <?php echo $this->dados_modelo['tabela']['nome_singular']; ?> não foi encontrad<?php $this->chamaGeneroMsg(); ?>', 'danger');
                return redirect(url('<?php echo $nomeTabelaModel; ?>/index'));
            }
        } else {
            $this->authorize('<?php echo strtoupper($this->nome_tabela); ?>_CADASTRAR', 'PermissaoPolicy');
        }
        
        return view('<?php echo $this->nome_tabela; ?>.form', array(
            'model' => $model,
        ));
    }
    
    /**
     * Salva <?php $this->chamaGeneroMsg(); ?> <?php echo $this->dados_modelo['tabela']['nome_singular']; ?>
     * @param $request ajusta os dados que vem do formulário
     * @return Response
     */
    public function save(<?php echo $nomeTabelaModel; ?>FormRequest $request) {
        $this->model->fill($request->all());
        
<?php foreach ($this->dados_modelo['tabela']['dados'] as $coluna) { ?>
<?php if ($coluna['tipo_coluna'] == 'date') { ?>
        $this->model-><?php echo $coluna['nome_coluna']; ?> = !$this->model-><?php echo $coluna['nome_coluna']; ?> ? null : \App\Http\Helper\Formatar::dateBrToAll($this->model-><?php echo $coluna['nome_coluna']; ?>, 'DB');
<?php } ?>
<?php if ($coluna['tipo_coluna'] == 'datetime') { ?>
        $this->model-><?php echo $coluna['nome_coluna']; ?> = !$this->model-><?php echo $coluna['nome_coluna']; ?> ? null : \App\Http\Helper\Formatar::dateBrToAll($this->model-><?php echo $coluna['nome_coluna']; ?>, 'DB', true, true);
<?php } ?>
<?php if ($coluna['tipo_input'] == 'porcentual') { ?>
        if ($this->model-><?php echo $coluna['nome_coluna']; ?>) {
            $this->model-><?php echo $coluna['nome_coluna']; ?> = str_replace('%', '', \App\Http\Helper\Formatar::number($this->model-><?php echo $coluna['nome_coluna']; ?>, 'DB', 2));
        }
<?php } ?>
<?php } ?>
        
        if (!empty($this->model->id)) {
            $alterar = $this->model->find($this->model->id);
    
            if (empty($alterar) || is_null($alterar)) {
                $this->setMessage('<?php $this->chamaGeneroMsg('O', 'A'); ?> <?php echo $this->dados_modelo['tabela']['nome_singular']; ?> a ser alterad<?php $this->chamaGeneroMsg(); ?> não existe no banco de dados!', 'danger');    
            } else {
                $this->setMessage('<?php $this->chamaGeneroMsg('O', 'A'); ?> <?php echo $this->dados_modelo['tabela']['nome_singular']; ?> foi alterad<?php $this->chamaGeneroMsg(); ?> com sucesso!', 'success');    
                $alterar->update($this->model->toArray());
            }
        } else {
            $this->model->create($this->model->toArray());
            $this->setMessage('<?php $this->chamaGeneroMsg('O', 'A'); ?> <?php echo $this->dados_modelo['tabela']['nome_singular']; ?> foi salv<?php $this->chamaGeneroMsg(); ?> com sucesso!', 'success');
        }
        
        return redirect(url('<?php echo $nomeTabelaModel; ?>/index'));
    }
    
    /**
     * Mostra o detalhe d<?php $this->chamaGeneroMsg(); ?> <?php echo $this->dados_modelo['tabela']['nome_singular']; ?>
     * @param  int $id Identificador
     * @return Response
     */
    public function show($id) {
        $this->authorize('<?php echo strtoupper($this->nome_tabela); ?>_DETALHAR', 'PermissaoPolicy');
        $model = $this->model->find($id);
        
        if (!$model) {
            $this->setMessage('<?php $this->chamaGeneroMsg('O', 'A'); ?> <?php echo $this->dados_modelo['tabela']['nome_singular']; ?> não foi encontrad<?php $this->chamaGeneroMsg(); ?>', 'danger');
            return redirect(url('<?php echo $nomeTabelaModel; ?>/index'));
        }
        
        return view('<?php echo $this->nome_tabela; ?>.show', [
            'model' => $model,
        ]);
    }

    /**
     * Ação de destruir/excluir <?php $this->chamaGeneroMsg('um', 'uma'); ?> <?php echo $this->dados_modelo['tabela']['nome_singular'].PHP_EOL; ?>
     *
     * @param integer $id
     * @return Response::json
     */
    public function destroy($id) {
        $model = $this->model->find($id);

        $model->findOrFail($id)->delete();
        
        return Response::json(array(
            'success' => true,
            'msg' => '<?php $this->chamaGeneroMsg('O', 'A'); ?> <?php echo $this->dados_modelo['tabela']['nome_singular']; ?> foi excluido com sucesso!',
        ));
    }
}
