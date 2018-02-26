<html lang="en" id="devNull">
    <?php 
    $config = new AppConfig(); /* @var $config AppConfig */
    
    //Especifico para a tela de dashboard
    $controlClassDefaultIndex = ($_SESSION['CONTROLLER'] == 'default' && $_SESSION['ACTION'] == 'index' ? '' : 'page-sidebar-closed');
    $extraClassDefaultIndex = ($_SESSION['CONTROLLER'] == 'default' && $_SESSION['ACTION'] == 'index' ? 'extra-class' : '');
    ?>
    <head>
        @include('layout.head')
    </head>
    
    <body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo <?php echo $controlClassDefaultIndex; ?>">
        
        @include('layout.header')
        
        <div class="clearfix"> </div>
        <div class="page-container" style="min-height:600px">  
            
            <div class="page-sidebar-wrapper" >
                <div class="page-sidebar navbar-collapse collapse">
                    <?php 
                    echo $config->gerarMenus();
                    ?>
                </div>
            </div>
            <div class="page-content-wrapper">
                <div class="page-content <?php echo $extraClassDefaultIndex; ?>">
                    @yield('conteudo')
                </div>
            </div>
        </div>
        
        @include('layout.footer')
        
    </body>
</html>