<html lang="en" id="devNull">
    @php
    //Especifico para a tela de dashboard
    $controlClassDefaultIndex = ($_SESSION['CONTROLLER'] == 'default' && $_SESSION['ACTION'] == 'index' ? '' : 'page-sidebar-closed');
    $extraClassDefaultIndex = ($_SESSION['CONTROLLER'] == 'default' && $_SESSION['ACTION'] == 'index' ? 'extra-class' : '');
    @endphp
    <head>
        @include('layout.head')
    </head>
    
    <body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo {{ $controlClassDefaultIndex }}">
        
        @include('layout.header')
        
        <div class="clearfix"> </div>
        
        <div class="page-sidebar-wrapper" >
            <div class="page-sidebar navbar-collapse collapse">
                {!! app('AppConfig')->gerarMenus() !!}
            </div>
        </div>
        
        <div class="page-container" style="min-height:600px">  
            
            <div class="page-content-wrapper">
                <div class="page-content {{ $extraClassDefaultIndex }}">
                    @yield('conteudo')
                </div>
            </div>
        </div>
        
        @php $layoutSistema = app('AppConfig')->getParam('LAYOUT_SISTEMA'); @endphp
        @if ($layoutSistema == 'PORTAL_AZUL' || $layoutSistema == 'PORTAL_GOLD')
            <div class="footer-logos bg-yellow-gold">
                <div class="container">
                    <a href="http://www.acessoainformacao.gov.br/" class="logo-acesso pull-left" alt="Acesso a Informação"></a>                                        
                    <span class="hide">&nbsp;</span>
                    <a href="http://www.brasil.gov.br/" class="brasil pull-right"></a>
                </div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>

        @else

            <div class="page-footer">
                <div class="page-footer-inner">
                    <div class="page-footer-container">
                        <span>{!! app('AppConfig')->getParam('RODAPE_TEXTO_PROJETO') !!}</span>
                    </div>
                </div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>

        @endif
        
        @include('layout.footer')
        
    </body>
</html>