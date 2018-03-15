<?php echo '<?php'.PHP_EOL; ?>
namespace App\Models;

use App\Models\ModelControl;
<?php if($this->softdelete){ ?>use Illuminate\Database\Eloquent\SoftDeletes;<?php } ?>

/**
 * Class <?php echo $nomeTabelaModel.PHP_EOL; ?>
 * @package App\Models
 * @author <?php echo $this->dados_modelo['extra']['nomeDesenv']; ?> <<?php echo $this->dados_modelo['extra']['emailDesenv']; ?>>
 * @version <?php echo date('d/m/Y').PHP_EOL; ?>
 */
class <?php echo $nomeTabelaModel; ?> extends ModelControl {
    
    <?php if($this->softdelete){ ?>use SoftDeletes;<?php } ?>

    protected $primaryKey = '<?php echo $this->getPrimaryId(); ?>';
    
    public $table = '<?php echo $this->nome_tabela; ?>';
    public $timestamps = <?php echo ($this->timestamps ? 'true' : 'false')?>;

<?php foreach ($this->dados_modelo['tabela']['dados'] as $colunas) { ?>
<?php if (!empty($colunas['options'])) { ?>
    public static $<?php echo $colunas['options']['label']; ?> = [
<?php foreach ($colunas['options']['data'] as $key => $valor) { ?>
        '<?php echo $key; ?>' => '<?php echo $valor ; ?>',
<?php } ?>
    ];
<?php } ?>
<?php } ?>
    
    /**
     * Variaveis seguras para uso e guardar dados 
     * @var array 
     */
    public $fillable = [
<?php foreach ($this->dados_modelo['tabela']['dados'] as $colunas) { ?>
        '<?php echo $colunas['nome_coluna'].'\','.PHP_EOL; ?>
<?php } ?>
    ];
    
    /**
     * Tipos nativos dos atributos
     * @var array
     */
    protected $casts = [
<?php foreach ($this->dados_modelo['tabela']['dados'] as $colunas) { ?>
<?php if ($colunas['tipo_input'] != 'situacao') { ?>
        '<?php echo $colunas['nome_coluna']; ?>' => '<?php echo Modelo::tratarTipoColuna($colunas['tipo_coluna']); ?>',
<?php } ?>
<?php } ?>
    ];    
    
    /**
     * Label dos atributos
     * @var array 
     */
    public $labels = [
<?php foreach ($this->dados_modelo['tabela']['dados'] as $colunas) { ?>
        '<?php echo $colunas['nome_coluna']; ?>' => '<?php echo $colunas['label']; ?>',
<?php } ?>
    ];
    
<?php foreach ($this->dados_modelo['relacoes']['referenciado'] as $relacao_referenciada) {  ?>
    /**
     * Busca o modelo de <?php echo $relacao_referenciada['tabela'].PHP_EOL; ?>
     * @return <?php echo $relacao_referenciada['tabela'].PHP_EOL; ?>
     */
    public function <?php echo $relacao_referenciada['tabela_formatada'][1]; ?>() {
        return $this->hasMany('App\Models\<?php echo $relacao_referenciada['tabela_formatada'][1]; ?>', '<?php echo $relacao_referenciada['id_referenciado']; ?>', '<?php echo $relacao_referenciada['id_referencia']; ?>');
    }
<?php } ?>

<?php foreach ($this->dados_modelo['relacoes']['referencias'] as $relacao_referenciada) { ?>
    /**
     * Busca o modelo de <?php echo $relacao_referenciada['tabela'].PHP_EOL; ?>
     * @return <?php echo $relacao_referenciada['tabela'].PHP_EOL; ?>
     */
    public function <?php echo $relacao_referenciada['tabela_formatada'][1]; ?>() {
        return $this-><?php echo $relacao_referenciada['tipo']; ?>('App\Models\<?php echo $relacao_referenciada['tabela_formatada'][1]; ?>', '<?php echo $relacao_referenciada['id_referencia']; ?>', '<?php echo $relacao_referenciada['id_referenciado']; ?>');
    }
<?php } ?>

<?php foreach ($this->dados_modelo['relacoes']['referencias_avancadas'] as $relacao_referenciada) { ?>
    /**
     * Relations com <?php echo $relacao_referenciada['modelo'].PHP_EOL; ?>
     * @return <?php echo $relacao_referenciada['modelo'].PHP_EOL; ?>
     */
    public function <?php echo $relacao_referenciada['modelo']; ?>() {
        return $this->belongsToMany('App\Models\<?php echo $relacao_referenciada['modelo']; ?>', '<?php echo $relacao_referenciada['tabela']; ?>', '<?php echo $relacao_referenciada['coluna_referencia']; ?>', '<?php echo $relacao_referenciada['coluna_referenciada']; ?>');
    }
<?php } ?>
}