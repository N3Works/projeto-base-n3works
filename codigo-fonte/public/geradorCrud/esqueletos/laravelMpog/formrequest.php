<?php echo '<?php'; ?>

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Controle de formulário do modelo especificado
 * @author <?php echo $this->dados_modelo['extra']['nomeDesenv']; ?> <<?php echo $this->dados_modelo['extra']['emailDesenv']; ?>>
 * @version <?php echo date('d/m/Y').PHP_EOL; ?>
 */
class <?php echo $nomeTabelaModel; ?>FormRequest extends FormRequest
{
    /**
     * Determina se o usuário pode realizar o request
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Seta os rules para cada campo
     *
     * @return array
     */
    public function rules() {
        return [
<?php foreach ($this->dados_modelo['tabela']['dados'] as $coluna) { if (!$coluna['primaria']) { ?>
            '<?php echo $coluna['nome_coluna']; ?>' => [<?php echo $this->descColumnValidation($coluna); ?>],
<?php }} ?>
        ];
    }
    
    /**
     * Mensagens caso pare nos rules atribuidos
     * @return array
     */
    public function messages() {
        return [
<?php   foreach ($this->dados_modelo['tabela']['dados'] as $coluna) { ?>
            <?php if ($coluna['obrigatorio'] && !$coluna['primaria']) { ?>'<?php echo $coluna['nome_coluna']; ?>.required' => 'O campo "<?php echo $coluna['label']; ?>" não foi preenchido.',<?php } ?>
            
            <?php if (in_array($coluna['tipo_coluna'], ['date', 'datetime'])) { ?>'<?php echo $coluna['nome_coluna']; ?>.date_format' => 'O campo "<?php echo $coluna['label']; ?>" está com a formatação inválida.',<?php } ?>
            
            <?php if ($coluna['tipo_input'] == 'cpf') { ?>'<?php echo $coluna['nome_coluna']; ?>.formato_invalido_cpf' => 'CPF inválido.',<?php } ?>
            <?php if ($coluna['tipo_input'] == 'cnpj') { ?>'<?php echo $coluna['nome_coluna']; ?>.formato_invalido_cnpj' => 'CNPJ inválido.',<?php } ?>
            <?php if ($coluna['tipo_input'] == 'cep') { ?>'<?php echo $coluna['nome_coluna']; ?>.formato_invalido_cep' => 'CEP inválido.',<?php } ?>
<?php   } ?>
        ];
    }
    
    
    /**
     * Pega a instancia de validação e adiciona o validador
     * @return type
     */
    protected function getValidatorInstance() {
        $validator = parent::getValidatorInstance();
        <?php foreach ($this->dados_modelo['tabela']['dados'] as $coluna) { ?>
        <?php 
        if (in_array($coluna['tipo_input'], ['cpf', 'cnpj'])) {
        ?>
        $validator->addImplicitExtension('formato_invalido_<?php echo $coluna['tipo_input']; ?>', function($attribute, $value, $parameters) {
            if ($value && !\App\Http\Helper\Validate::<?php echo $coluna['tipo_input']; ?>($value)) {
                return false;
            }
            return true;
        });
        <?php } ?>
        <?php } ?>
        return $validator;
    }
}