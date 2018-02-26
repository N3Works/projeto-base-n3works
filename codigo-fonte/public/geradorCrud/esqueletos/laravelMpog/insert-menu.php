<?php echo '<?php'.PHP_EOL; ?>

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertMenu<?php echo $nomeTabelaModel; ?>Table extends Migration {

    public function up() {
        $datetime = date('Y-m-d H:i:s');
        $id = DB::table('permissoes')->where('permissao', '<?php echo strtoupper($this->nome_tabela); ?>_LISTAR')->first()->id;
        
        DB::table('menus')->insert([
            [
                'header' => '<?php echo $this->dados_modelo['tabela']['nome_singular']; ?>', 
                'controller' => '<?php echo $nomeTabelaModel; ?>',
                'action' => 'index',
                'icon' => '<?php echo (isset($this->dados['icone']) ? $this->dados['icone'] : 'cogs') ?>',
                'parent' => '0',
                'order' => 2,
                'permissao_id' => $id,
                'created_at' => $datetime,
                'updated_at' => $datetime, 
            ],
        ]);
    }
}