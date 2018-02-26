<?php echo '<?php'.PHP_EOL; ?>

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertPermissoes<?php echo $nomeTabelaModel; ?>Table extends Migration {

    public function up() {
        DB::table('permissoes')->insert([
            [
                'permanente' => 1,
                'permissao' => '<?php echo strtoupper($this->nome_tabela); ?>_LISTAR',
                'descricao' => 'Acessar a lista de <?php echo $this->dados_modelo['tabela']['nome_plural']; ?>',
            ],
            [
                'permanente' => 1,
                'permissao' => '<?php echo strtoupper($this->nome_tabela); ?>_DETALHAR',
                'descricao' => 'Acessar o detalhe d<?php echo ($generoModel == 'M' ? 'o' : 'a'); ?> <?php echo $this->dados_modelo['tabela']['nome_singular']; ?>',
            ],
            [
                'permanente' => 1,
                'permissao' => '<?php echo strtoupper($this->nome_tabela); ?>_CADASTRAR',
                'descricao' => 'Acessar a tela de cadastro d<?php echo ($generoModel == 'M' ? 'o' : 'a'); ?> <?php echo $this->dados_modelo['tabela']['nome_singular']; ?>',
            ],
            [
                'permanente' => 1,
                'permissao' => '<?php echo strtoupper($this->nome_tabela); ?>_EDITAR',
                'descricao' => 'Acessar a tela de edição d<?php echo ($generoModel == 'M' ? 'o' : 'a'); ?> <?php echo $this->dados_modelo['tabela']['nome_singular']; ?>',
            ],
            [
                'permanente' => 1,
                'permissao' => '<?php echo strtoupper($this->nome_tabela); ?>_EXCLUIR',
                'descricao' => 'Você não pode excluir est<?php echo ($generoModel == 'M' ? 'e' : 'a'); ?> <?php echo $this->dados_modelo['tabela']['nome_singular']; ?>',
            ],
        ]);
    }
}