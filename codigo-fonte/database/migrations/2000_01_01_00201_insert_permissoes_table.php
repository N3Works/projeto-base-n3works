<?php
use Illuminate\Database\Migrations\Migration;

class InsertPermissoesTable extends Migration {

    public function up() {
        DB::table('permissoes')->insert([
            [
                'id' => 1, 
                'permanente' => 1,
                'permissao' => 'PERMISSOES_LISTAR',
                'descricao' => 'Acessar a lista de permissões',
            ],
            [
                'id' => 2, 
                'permanente' => 1,
                'permissao' => 'USERS_LISTAR',
                'descricao' => 'Acessar a lista de usuários',
            ],
            [
                'id' => 3, 
                'permanente' => 1,
                'permissao' => 'PERFIS_DETALHE_PERMISSAO',
                'descricao' => 'Mostrar a lista de Permissões no detalhe do perfil',
            ],
            [
                'id' => 4, 
                'permanente' => 1,
                'permissao' => 'USERS_DETALHAR',
                'descricao' => 'Acessar o detalhe dos usuários',
            ],
            [
                'id' => 5, 
                'permanente' => 1,
                'permissao' => 'USERS_CADASTRAR',
                'descricao' => 'Acessar a tela de cadastro dos usuários',
            ],
            [
                'id' => 6, 
                'permanente' => 1,
                'permissao' => 'USERS_EDITAR',
                'descricao' => 'Acessar a tela de edição dos usuários',
            ],
            [
                'id' => 7, 
                'permanente' => 1,
                'permissao' => 'PERMISSOES_DETALHAR',
                'descricao' => 'Acessar a tela de detalhe das permissões',
            ],
            [
                'id' => 8, 
                'permanente' => 1,
                'permissao' => 'PERMISSOES_CADASTRAR',
                'descricao' => 'Acessar a tela de cadastro das permissões',
            ],
            [
                'id' => 9, 
                'permanente' => 1,
                'permissao' => 'PERMISSOES_EDITAR',
                'descricao' => 'Acessar a tela de edição das permissões',
            ],
            [
                'id' => 10, 
                'permanente' => 1,
                'permissao' => 'PARAMETROS_CADASTRO_PARAMETRO_EDITAVEL',
                'descricao' => 'Visualizar o campo parametro_editavel no cadastro dos Parâmetros',
            ],
            [
                'id' => 11, 
                'permanente' => 1,
                'permissao' => 'PARAMETROS_LISTA_MODIFICACAO',
                'descricao' => 'Visualizar a lista para modificação de valor dos parâmetros',
            ],
            [
                'id' => 12, 
                'permanente' => '1',
                'permissao' => 'MENUS_CONFIGURACAO',
                'descricao' => 'Visualizar o menu de configuração',
            ],
            [
                'id' => 13, 
                'permanente' => 1,
                'permissao' => 'PERFIS_EDITAR',
                'descricao' => 'Acessar a tela de edição dos perfis',
            ],
            [
                'id' => 14, 
                'permanente' => 1,
                'permissao' => 'PERFIS_CADASTRAR',
                'descricao' => 'Acessar a tela de cadastro dos perfis',
            ],
            [
                'id' => 15, 
                'permanente' => 1,
                'permissao' => 'PERFIS_DETALHAR',
                'descricao' => 'Acessar a tela de detalhe dos perfis',
            ],
            [
                'id' => 16, 
                'permanente' => 1,
                'permissao' => 'PERFIS_LISTAR',
                'descricao' => 'Acessar a tela de listagem dos perfis',
            ],
            [
                'id' => 17, 
                'permanente' => 1,
                'permissao' => 'USERS_LISTAR_BTN_PERFIL',
                'descricao' => 'Mostrar o botão de alterar perfil na listagem',
            ],
            [
                'id' => 18, 
                'permanente' => '1',
                'permissao' => 'MENUS_USERS',
                'descricao' => 'Mostrar menu de usuários',
            ],
            [
                'id' => 19, 
                'permanente' => '1',
                'permissao' => 'MENUS_PARAMETROS',
                'descricao' => 'Mostrar menu de parâmetros',
            ],
            [
                'id' => 20, 
                'permanente' => '1',
                'permissao' => 'MENUS_PERFIS',
                'descricao' => 'Mostrar menu de perfis',
            ],
            [
                'id' => 21, 
                'permanente' => '1',
                'permissao' => 'USERS_TROCAR_SENHA',
                'descricao' => 'Acessar tela de trocar senha de outros usuários.',
            ],
            [
                'id' => 22, 
                'permanente' => '1',
                'permissao' => 'ANEXOS_CADASTRAR',
                'descricao' => 'Acessar a tela de cadastro dos anexos.',
            ],
            [
                'id' => 23, 
                'permanente' => '1',
                'permissao' => 'ANEXOS_DETALHAR',
                'descricao' => 'Acessar a tela de detalhe dos anexos.',
            ],
            [
                'id' => 24, 
                'permanente' => '1',
                'permissao' => 'ANEXOS_EDITAR',
                'descricao' => 'Acessar a tela de edição dos anexos.',
            ],
            [
                'id' => 25, 
                'permanente' => '1',
                'permissao' => 'ANEXOS_LISTAR',
                'descricao' => 'Acessar a tela de listagem|menu dos anexos.',
            ],
        ]);
    }
}
