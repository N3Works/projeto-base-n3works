<div class="page-header navbar navbar-fixed-top" >

    <div class="page-header-inner ">
        
        <div class="menu-toggler sidebar-toggler menu-toggler-sidemenu"></div>
        
        <div class="page-logo keep-200">
            <a href="#">
                <h4 class="page-titulo" > {{$config->titulo_projeto}}</h4>
            </a>
        </div>

        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>

        <div class="page-top">
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li style="margin: 17px 0 15px 10px; padding: 0; float: left;">
                        <a href="{{ url('default/index') }}"><i class='fa fa-home fa-2x'></i></a>
                    </li>
                    <li class="separator hide"> </li>
                    <li style="margin: 17px 0 15px 10px; padding: 0; float: left;">
                        <a href="{{ url('default/index') }}"><i class='fa fa-info-circle fa-2x'></i></a>
                    </li>
                    <li style="margin: 17px 0 15px 10px; padding: 0; float: left;">
                        <a href="javascript:void(0)" class="dropdown-toggle top-header-menu" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false">
                            <i class='fa fa-user fa-2x'></i><div class="page-header-top-icon"><i class="fa fa-sort-desc fa-2x"></i></div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default top-menu-user-custom">
                            <?php if (Auth::check()) { ?>
                                <li><p class="name-user">{{Auth::user()->nome}}</p></li>
                                <li class="divider"> </li>
                                <li>
                                <a href="{{ url('login/logout') }}">
                                <i class="icon-key"></i> Sair </a>
                                </li>
                            <?php } else { ?>
                                <li><p style="font-size: 12px;" class="name-user">Nenhum Usuário logado no momento.</p></li>;
                            <?php } ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>