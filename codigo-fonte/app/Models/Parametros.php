<?php
namespace App\Models;

use App\Models\ModelControl;

/**
 * Class Parametros
 * @package App\Models
 * @author Thiago do Amarante Farias <thiago.farias@jointecnologia.com.br>
 * @version 22/06/2017
 */
class Parametros extends ModelControl {
    
    public $table = 'parametros'; //Nome da tabela
    public $timestamps = false; //Remover os timestamps
    
    // Constantes da colna "tipo"
    const TIPO_DROPDOWN = 'dropdown';
    const TIPO_TEXT = 'text';
    const TIPO_INTEGER = 'integer';
    const TIPO_BOOLEAN = 'boolean';
    
    /**
     * Array Estática com valores da coluna "tipo"
     * @var array 
     */
    public static $tipos_list = [
        self::TIPO_DROPDOWN => 'DropDown',
        self::TIPO_TEXT => 'Texto',
        self::TIPO_INTEGER => 'Inteiro',
        self::TIPO_BOOLEAN => 'Boolean',
    ];
            
    /**
     * Variaveis seguras para uso e guardar dados 
     * @var array 
     */
    public $fillable = [
        'id',
        'nome',
        'parametro_editavel',
        'descricao',
        'status',
        'tipo',
        'valor',
        'dropdownValor',
        'dropdownNome',
        'inputLabelRadioTrue',
        'inputLabelRadioFalse',
    ];
    
    /**
     * Tipos nativos dos atributos
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nome' => 'string',
        'parametro_editavel' => 'integer',
        'descricao' => 'tinytext',
        'status' => 'integer',
        'tipo' => 'enum',
        'valor' => 'string',
    ];    
    
    /**
     * Label dos atributos
     * @var array 
     */
    public $labels = [
        'id' => 'ID',
        'nome' => 'Nome',
        'parametro_editavel' => 'Tipo Editável?',
        'descricao' => 'Descrição',
        'status' => 'Status',
        'tipo' => 'Tipo do Parâmetro',
        'valor' => 'Valor',
    ];
    
    /*
     * Busca o modelo de parametro_valores_tipos
     * @return object parametro_valores_tipos
    */
    public function ParametroValoresTipos() {
        return $this->hasMany('App\Models\ParametroValoresTipos', 'parametro_id', 'id');
    }

    /**
     * Realiza a consulta da tabela
     * @return array
     */
    public function consultar() {
        $consulta = self::select('*')->orderBy('id', 'DESC');
        return $consulta->get();
    }
    
    /**
     * Trata e depois salva os dados no banco
     */
    public function salvar() {
        $dados = $this->getAttributes();
        $status = 'success';
        $mensagem = '';
        
        \DB::beginTransaction();
        
        $dadosParametros = [ //Atribui os valores
            'nome' => strtoupper($dados['nome']),
            'descricao' => $dados['descricao'],
            'status' => $dados['status'],
            'parametro_editavel' => $dados['parametro_editavel'],
            'tipo' => $dados['tipo'],
            'valor' => $dados['valor'],
        ];
        
        try {
            $id = $this->id;
            
            if ($id) { //Caso de edição
                $this->find($id)->update($dadosParametros);
                
                if ($this->tipo == self::TIPO_DROPDOWN || $this->tipo == self::TIPO_BOOLEAN) {
                    ParametroValoresTipos::where('parametro_id', $id)->delete();
                }
                
                $mensagem = 'O Parametro foi alterado com sucesso!';
            } else { //Caso de cadastro
                $id = $this->insertGetId($dadosParametros);
                $mensagem = 'O Parametro foi salvo com sucesso!';
            }
            
            if ($this->tipo == self::TIPO_DROPDOWN) { //Salva da forma DROPDOWN
                foreach ($dados['dropdownValor'] as $key => $valor) {
                    ParametroValoresTipos::create([
                        'parametro_id' => $id,
                        'value' => $valor,
                        'header' => $dados['dropdownNome'][$key],
                    ]);
                }
            }
            
            if ($this->tipo == self::TIPO_BOOLEAN) { //Salva da forma BOOLEAN
                ParametroValoresTipos::create([
                        'parametro_id' => $id,
                        'value' => true,
                        'header' => $dados['inputLabelRadioTrue'],
                ]);
                ParametroValoresTipos::create([
                        'parametro_id' => $id,
                        'value' => false,
                        'header' => $dados['inputLabelRadioFalse'],
                ]);
            }
            
        } catch (Exception $exc) {
            \DB::rollBack();
            return [
                'status' => 'danger',
                'msg' => $exc->getMessage(),
            ];
        }

        \DB::commit();
        
        return [
            'msg' => $mensagem,
            'status' => $status,
        ];
    }
    
    /**
     * Busca valor conforme tipo de parametro
     */
    public function buscarValorPorTipo() {
        if ($this->tipo == self::TIPO_BOOLEAN || $this->tipo == self::TIPO_DROPDOWN) {
            $query = ParametroValoresTipos::where('parametro_id', $this->id)
                ->where('value', (self::TIPO_BOOLEAN ? ($this->valor == 'true' ? true : false) : $this->valor))
                    ->first();
            
            $this->valor = $query->header;
        }
    }
    
    /**
     * Popula os dados para preencher o formulário
     * @param array $dadosFormulario
     * @return array
     */
    public function popularDadosFormulario($dadosFormulario) {
        
        if (empty($dadosFormulario)) {
            $dadosFormulario = [
                'valor' => $this->valor,
                'tipo' => $this->tipo,
                'inputLabelRadioTrue' => '',
                'inputLabelRadioFalse' => '',
                'dropdownValor' => [],
                'dropdownNome' => [],
            ];
            
            if ($this->tipo == self::TIPO_BOOLEAN) {
                $dadosFormulario['inputLabelRadioTrue'] = $this->ParametroValoresTipos->where('value', true)->first()->header;
                $dadosFormulario['inputLabelRadioFalse'] = $this->ParametroValoresTipos->where('value', false)->first()->header;
            }
            if ($this->tipo == self::TIPO_DROPDOWN) {
                foreach ($this->ParametroValoresTipos as $dados) {
                    $dadosFormulario['dropdownValor'][] = $dados->value;
                    $dadosFormulario['dropdownNome'][] = $dados->header;
                }
            }

        } 
        
        return $dadosFormulario;
    }
}