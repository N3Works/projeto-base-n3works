<?php echo '<?php'.PHP_EOL; ?>
/* @var Controller $this */
namespace App\Http\Controllers;

//Base do controlador
use App\Http\Controllers\Controller;
use App\Http\Requests\<?php echo $nomeTabelaModel; ?>FormRequest;
use App\DataTables\<?php echo $nomeTabelaModel; ?>DataTable as DataTable;
use Illuminate\Http\Request;
use Response;

//Repository->model da controller
use App\Repositories\<?php echo $nomeTabelaModel; ?>Repository; 

/**
 * Controlador <?php echo $this->dados_modelo['tabela']['nome_singular'].PHP_EOL; ?>
 *
 * @author <?php echo $this->dados_modelo['extra']['nomeDesenv']; ?> <<?php echo $this->dados_modelo['extra']['emailDesenv']; ?>>
 */
class <?php echo $nomeTabelaModel; ?>Controller extends Controller {

    /**
     * @var Model <?php echo $nomeTabelaModel.PHP_EOL; ?>
     */
    protected $repository;
    
    /**
     * @var DataTable
     */
    protected $dataTable;
    
    /**
     * <?php echo $nomeTabelaModel; ?>Controller constructor.
     * @param <?php echo $nomeTabelaModel; ?> $<?php echo $this->nome_tabela.PHP_EOL; ?>
     */
    public function __construct(<?php echo $nomeTabelaModel; ?>Repository $<?php echo $this->nome_tabela; ?>, DataTable $dataTable) {
        $this->repository = $<?php echo $this->nome_tabela; ?>;
        $this->dataTable = $dataTable;
    }
    
    /**
     * Monta a listagem d<?php $this->chamaGeneroMsg(); ?>s <?php echo $this->dados_modelo['tabela']['nome_singular'].PHP_EOL; ?>
     * @param Request $request dados do formulário
     * @return Response
     */
    public function index(Request $request) {
        $this->authorize('<?php echo strtoupper($this->nome_tabela); ?>_LISTAR', 'PermissaoPolicy');
        $this->repository->fill($request->all());
        $this->dataTable->model = $this->repository;
        
        if (app('request')->isXmlHttpRequest()) {
            return $this->dataTable->ajax();
        }
        
        return view('<?php echo $this->nome_tabela; ?>.index', array(
            'model' => $this->repository,
            'dataTable' => $this->dataTable->html(),
        ));
    }
        
    /**
     * Consultar dados d<?php $this->chamaGeneroMsg(); ?>s <?php echo $this->dados_modelo['tabela']['nome_plural']; ?> para construir o datatables
     * @param Request $request
     * @return json
     */
    public function consultar(Request $request) {
        $this->repository->fill($request->all());
        return $this->repository->consultarDataTables();
    }
        
    /**
     * Mostra o formulário para criar/editar <?php $this->chamaGeneroMsg('um', 'uma'); ?> <?php echo $this->dados_modelo['tabela']['nome_singular'].PHP_EOL; ?>
     * @return Response
     */    
    public function form(Request $request) {
        $id = $request->route('id');
        $this->repository->fill($request->all()); 
        $model = $this->repository;
        
        if ($id) {
            $this->authorize('<?php echo strtoupper($this->nome_tabela); ?>_EDITAR', 'PermissaoPolicy');
            $model = $this->repository->buscarPorID($id);
        
            if (!$model) {
                $this->setMessage('<?php $this->chamaGeneroMsg('O', 'A'); ?> <?php echo $this->dados_modelo['tabela']['nome_singular']; ?> não foi encontrad<?php $this->chamaGeneroMsg(); ?>', 'danger');
                return redirect(url('<?php echo strtolower($nomeTabelaModel); ?>/index'));
            }
        } else {
            $this->authorize('<?php echo strtoupper($this->nome_tabela); ?>_CADASTRAR', 'PermissaoPolicy');
        }
        
        return view('<?php echo $this->nome_tabela; ?>.form', array(
            'model' => $model,
        ));
    }
    
    /**
     * Salva <?php $this->chamaGeneroMsg(); ?> <?php echo $this->dados_modelo['tabela']['nome_singular'].PHP_EOL; ?>
     * @param $request ajusta os dados que vem do formulário
     * @return Response
     */
    public function save(<?php echo $nomeTabelaModel; ?>FormRequest $request) {
        if (!empty($request->get('id'))) {
            if ($this->repository->atualizar($request->get('id'), $request->all())) {
                $this->setMessage('<?php $this->chamaGeneroMsg('O', 'A'); ?> <?php echo $this->dados_modelo['tabela']['nome_singular']; ?> foi alterad<?php $this->chamaGeneroMsg(); ?> com sucesso!', 'success');    
            } else {
                $this->setMessage('<?php $this->chamaGeneroMsg('O', 'A'); ?> <?php echo $this->dados_modelo['tabela']['nome_singular']; ?> a ser alterad<?php $this->chamaGeneroMsg(); ?> não existe no banco de dados!', 'danger');
            }
        } else {
            $this->repository->cadastrar($request->all());
            $this->setMessage('<?php $this->chamaGeneroMsg('O', 'A'); ?> <?php echo $this->dados_modelo['tabela']['nome_singular']; ?> foi salv<?php $this->chamaGeneroMsg(); ?> com sucesso!', 'success');
        }
        
        return redirect(url('<?php echo strtolower($nomeTabelaModel); ?>/index'));
    }
    
    /**
     * Mostra o detalhe d<?php $this->chamaGeneroMsg(); ?> <?php echo $this->dados_modelo['tabela']['nome_singular']; ?>
     * @param  int $id Identificador
     * @return Response
     */
    public function show($id) {
        $this->authorize('<?php echo strtoupper($this->nome_tabela); ?>_DETALHAR', 'PermissaoPolicy');
        $model = $this->repository->find($id);
        
        if (!$model) {
            $this->setMessage('<?php $this->chamaGeneroMsg('O', 'A'); ?> <?php echo $this->dados_modelo['tabela']['nome_singular']; ?> não foi encontrad<?php $this->chamaGeneroMsg(); ?>', 'danger');
            return redirect(url('<?php echo strtolower($nomeTabelaModel); ?>/index'));
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
        $msg = '<?php echo $this->chamaGeneroMsg('O', 'A'); ?> <?php echo $this->dados_modelo['tabela']['nome_singular']; ?> foi excluido com sucesso!';
        if (!$this->repository->deletar($id)) {
            $msg = 'Falha ao excluir <?php echo $this->chamaGeneroMsg(); ?> <?php echo $this->dados_modelo['tabela']['nome_singular']; ?>';
        }
        return Response::json(array(
            'success' => true,
            'msg' => $msg,
        ));
    }
}
