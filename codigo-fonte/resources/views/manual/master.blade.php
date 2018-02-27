<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Manual</title>
        
        {!!Html::style('template/global/plugins/bootstrap/css/bootstrap.min.css')!!}
        {!!Html::style('resources/assets/css/manual/manual.css')!!}
        {!!Html::style('template/global/plugins/font-awesome/css/font-awesome.min.css')!!}
    </head>
            
    <body>
        <div class="nav-side-menu">
            <div class="brand">Manual do Projeto</div>
            <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
                <div class="menu-list">
                    <ul id="menu-content" class="menu-content collapse out">
                        
                        <li onclick="window.location = '#manual-projeto';">
                            <a><i class="fa fa-cube fa-lg" ></i> Projeto</a>
                        </li>
                        
                        <li onclick="window.location = '#manual-lorem1';">
                            <a><i class="fa fa-info fa-lg" ></i> Lorem Ipsum: Example 1</a>
                        </li>
                        
                        <li data-toggle="collapse" data-target="#attr-func" class="collapsed">
                          <a href="#manual-atributos-lorem"><i class="fa fa-tasks fa-lg"></i> Menu Multiplo <span class="arrow"></span></a>
                        </li>
                        <ul class="sub-menu collapse" id="attr-func">
                            <li onclick="window.location = '#manual-menus-lorem1';" ><a>Menu 1</a></li>
                            <li onclick="window.location = '#manual-menus-lorem2';" ><a>Menu 2</a></li>
                        </ul>
                        
                        <li onclick="window.location = '{{ URL::previous() }}';">
                            <a><i class="fa fa-arrow-left fa-lg" ></i> Voltar</a>
                        </li>
                    </ul>
             </div>
        </div>
        
        <div id="page-content-wrapper">
            <div class="container-fluid">
                @yield('conteudo')
            </div>
        </div>
        
        {!!Html::script('resources/assets/js/manual/jquery.min.js')!!}
        {!!Html::script('resources/assets/js/manual/bootstrap.min.js')!!}
    </body>
</html>