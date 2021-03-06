<?php
namespace App\Repositories;

use App\Models\Parametros;

/**
 * Repository dos usuários
 */
class ParametrosRepository extends Parametros {
    
    use RepositoryTraitEzequiel;
    
    /**
     * Trata e depois salva os dados no banco
     */
    public function salvar($data) {
        if (!empty($data)) {
            $this->fill($data);
        } else {
            return [
                'status' => 'danger',
                'msg' => 'Nenhum dado foi passado.',
            ];
        }
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
    public function buscarValorPorTipo($model) {
        if ($model->tipo == self::TIPO_BOOLEAN || $model->tipo == self::TIPO_DROPDOWN) {
            $query = ParametroValoresTipos::where('parametro_id', $this->id)
                ->where('value', (self::TIPO_BOOLEAN ? ($model->valor == 'true' ? true : false) : $model->valor))
                    ->first();
            
            $model->valor = $query->header;
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