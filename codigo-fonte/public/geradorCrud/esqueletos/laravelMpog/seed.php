<?php echo '<?php'.PHP_EOL; ?>
use Illuminate\Database\Seeder;

class <?php echo $nomeTabelaModel; ?>Seeder extends Seeder {
    
    public function run() {
                
        <?php if($this->timestamps){ ?>$datetime = date('Y-m-d H:i:s');<?php } ?>
                
        \DB::table('<?php echo $this->nome_tabela; ?>')->insert([
            
<?php 
if(!empty($rows)) { foreach($rows as $row) { ?>
            [
<?php foreach($row as $key => $value) {?>

            '<?php print $key; ?>' => '<?php print $value; ?>', 
<?php } ?>
<?php if($this->timestamps){ ?>
            'created_at' => $datetime,
            'updated_at' => $datetime, 
<?php } ?>
            ],
<?php }} ?>
        ]);
    }
}
