<?php
use Illuminate\Database\Migrations\Migration;

class InsertParametrosTable extends Migration {

    public function up() {
        DB::table('parametros')->insert([
            [
                'id' => '1', 
                'nome' => 'CABECALHO_NOME_PROJETO',
                'parametro_editavel' => 1,
                'tipo' => 'text',
                'descricao' => 'Nome do Projeto que mostra no cabeçalho',
                'status' => 1,
                'valor' => 'Projeto Base',
            ],
            [
                'id' => '2', 
                'nome' => 'RODAPE_TEXTO_PROJETO',
                'parametro_editavel' => 1,
                'tipo' => 'text',
                'descricao' => 'Rodapé do Projeto',
                'status' => 1,
                'valor' => '&lt;Nome da Secretaria responsavel pelo Sistema&gt;-&lt;Sigla da Secretaria&gt;-&lt;Nome do Ministério&gt; | &lt;Endereco&gt;',
            ],
            [
                'id' => '3', 
                'nome' => 'CABECALHO_SUBTITULO',
                'parametro_editavel' => 1,
                'tipo' => 'text',
                'descricao' => 'Subtitulo que mostra no cabeçalho',
                'status' => 1,
                'valor' => 'Subtitulo',
            ],
            [
                'id' => '4', 
                'nome' => 'LAYOUT_SISTEMA',
                'parametro_editavel' => 1,
                'tipo' => 'dropdown',
                'descricao' => 'Layout geral do sistema',
                'status' => 1,
                'valor' => 'PADRAO',
            ],
            [
                'id' => '5', 
                'nome' => 'RESULTADOS_DATATABLE',
                'parametro_editavel' => 1,
                'tipo' => 'dropdown',
                'descricao' => 'Número de resultados padrão por página das tabelas.',
                'status' => 1,
                'valor' => 50,
            ],
        ]);
    }
}
