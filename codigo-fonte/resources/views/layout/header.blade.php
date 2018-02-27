@php $layoutSistema = app('AppConfig')->getParam('LAYOUT_SISTEMA'); @endphp
@if ($layoutSistema == 'PORTAL_AZUL' || $layoutSistema == 'PORTAL_GOLD')
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
    <div class="page-header navbar" >

        <div class="page-header-inner">

            <div class="menu-toggler sidebar-toggler menu-toggler-sidemenu"><i class="fa fa-navicon" style="color: white; font-size: 2.0em;"></i></div>

            <div class="page-logo keep-200">            
                <h4 class="page-titulo">{!! app('AppConfig')->getParam('CABECALHO_NOME_PROJETO') !!}</h4>
                <h6 class="portal-description">{!! app('AppConfig')->getParam('CABECALHO_SUBTITULO') !!}</h6>
            </div>

            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>

            @include('layout.topmenu')
        </div>    
        <div class="sobre"></div>
    </div>

@else
    
    <div class="page-header navbar navbar-fixed-top" >

        <div class="page-header-inner ">

            <div class="menu-toggler sidebar-toggler menu-toggler-sidemenu"></div>

            <div class="page-logo keep-200">
                <a href="#">
                    <h4 class="page-titulo" > {!! app('AppConfig')->getParam('CABECALHO_NOME_PROJETO') !!}</h4>
                </a>
            </div>

            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>

            @include('layout.topmenu')
        </div>
    </div>
    
@endif