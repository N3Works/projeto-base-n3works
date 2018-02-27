<?php 
$layoutSistema = app('AppConfig')->getParam('LAYOUT_SISTEMA');
if ($layoutSistema == 'PORTAL_AZUL' || $layoutSistema == 'PORTAL_GOLD') {
    ?>
    <html lang="en">
        <div class="menu-toggler sidebar-toggler"></div>
        <head>
            @include('layoutLogin.head')
        </head>

        <body class="login">
            <div id="barra-brasil">
                <div id="wrapper-barra-brasil">
                    <div class="brasil-flag">
                        <a href="http://brasil.gov.br" class="link-barra">Brasil</a>
                    </div>
                    <span class="acesso-info">
                        <a href="http://www.servicos.gov.br/?pk_campaign=barrabrasil" class="link-barra" id="barra-brasil-orgao">Serviços</a>
                    </span>
                    <nav>
                        <ul class="list">
                            <li>
                                <a href="#" id="menu-icon"></a>
                            </li>
                            <li class="list-item first">
                                <a href="http://brasil.gov.br/barra#participe" class="link-barra">Participe</a>
                            </li>
                            <li class="list-item">
                                <a href="http://brasil.gov.br/barra#acesso-informacao" class="link-barra">Acesso à informação</a>
                            </li>
                            <li class="list-item">
                                <a href="http://www.planalto.gov.br/legislacao" class="link-barra">Legislação</a>
                            </li>
                            <li class="list-item last last-item">
                                <a href="http://brasil.gov.br/barra#orgaos-atuacao-canais" class="link-barra">Canais</a>
                            </li>
                        </ul>
                    </nav>
                    <a class="logo-vlibras" href="http://www.vlibras.gov.br/" aria-label="Acessível em Libras"></a>
                </div>
            </div>
            <div id="auth-header" role="banner">
                <div>
                   <div id="auth-logo">
                        <h2 class="portal-title">Portal de Autenticação</h2>
                        <h6 class="portal-description">Ministério do Planejamento, Desenvolvimento e Gestão</h6>
                        <div class="clear"></div>
                   </div>
                </div>
                <div id="sobre"></div>
            </div>

            @yield('conteudo')

            <footer id="footer" class="footer text-muted">
                <div class="container">
                    <p>
                        <br>
                    </p>
                </div>
            </footer>
            <div id="footer-brasil">
                <div id="wrapper-footer-brasil">
                    <a href="http://www.acessoainformacao.gov.br/">
                        <span class="logo-acesso-footer"></span>
                    </a>
                    <a href="http://www.brasil.gov.br/">
                        <span class="logo-brasil-footer"></span>
                    </a>
                </div>
            </div> 

            @include('layoutLogin.footer')
        </body>
    </html>

<?php } else { ?>

    <html lang="en">
        <div class="menu-toggler sidebar-toggler"></div>
        <head>
            @include('layoutLogin.head')
        </head>

        <body class="login">

            <div class="logo">
                <h3 class="page-titulo" style="color: antiquewhite;"> {!! app('AppConfig')->getParam('CABECALHO_NOME_PROJETO') !!}</h3>
            </div>

            @yield('conteudo')

            @include('layoutLogin.footer')
        </body>
    </html>

<?php } ?>