<?php echo '<?php'.PHP_EOL; ?>

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create<?php echo $nomeTabelaModel; ?>Table extends Migration {

    public function up() {
        Schema::create('<?php echo $this->nome_tabela; ?>', function (Blueprint $table) {
<?php foreach ($this->dados_modelo['tabela']['dados'] as $coluna): ?>
            $table-><?php print  Modelo::gerarBlueprint($coluna); ?>;
<?php endforeach; ?>

        <?php if($this->timestamps){ ?>$table->timestamps();<?php } ?>
        <?php if($this->softdelete){ ?>$table->softDeletes();<?php } ?>
        
<?php 
    if(isset($this->dados_modelo['relacoes'])) { 
        foreach ($this->dados_modelo['relacoes']['referencias'] as $relation) {
?>
         $table->foreign('<?php print $relation['id_referencia']; ?>')
            ->references('<?php print $relation['id_referenciado']; ?>')
                ->on('<?php print $relation['tabela']; ?>')
                    ->onDelete('cascade');
<?php }} ?>
        });
    }

    public function down() {
        Schema::drop('<?php echo $this->nome_tabela; ?>');
    }
}