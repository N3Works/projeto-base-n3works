<html lang="en">
    <?php $config = new AppConfig(); /* @var $config AppConfig */ ?>
    <div class="menu-toggler sidebar-toggler"></div>
    <head>
        @include('layoutLogin.head')
    </head>
    
    <body class="login">
        
        <div class="logo">
            <h3 class="page-titulo" style="color: antiquewhite;"> {{$config->titulo_projeto}}</h3>
        </div>
        
        @yield('conteudo')
        
        @include('layoutLogin.footer')
    </body>
</html>
