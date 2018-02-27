<div class="page-top">
    <div class="top-menu">
        <ul class="nav navbar-nav pull-right">
            <li style="margin: 17px 0 15px 10px; padding: 0; float: left;">
                <a href="{{ url('/') }}"><i class='fa fa-home fa-2x'></i></a>
            </li>
            <li class="separator hide"> </li>
            <li style="margin: 17px 0 15px 10px; padding: 0; float: left;">
                <a href="{{ url('/manual') }}"><i class='fa fa-book fa-2x'></i></a>
            </li>
            <li style="margin: 17px 0 15px 10px; padding: 0; float: left;">
                <a href="javascript:void(0)" class="dropdown-toggle top-header-menu" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false">
                    <i class='fa fa-user fa-2x'></i><div><i class="fa fa-sort-desc fa-2x"></i></div>
                </a>
                <ul class="dropdown-menu dropdown-menu-default top-menu-user-custom">
                    @if (Auth::check())
                        <li>
                            <p class="name-user">
                                {{Auth::user()->nome}} <a title="Editar Dados" href="{{ url('users/form/' . Auth::user()->id) }}"><i class="fa fa-pencil"></i></a><br>
                                <small class="small-subtitle">{{ Auth::user()->Perfil->nome }}</small>
                            </p>
                        </li>
                        <li>
                            <a href="{{ url('users/trocarSenha/' . Auth::user()->id) }}">
                                <i class="fa fa-lock"></i> Trocar Senha  
                            </a>
                        </li>
                        <li class="divider"> </li>
                        <li>
                        <a href="{{ url('login/logout') }}">
                        <i class="fa fa-sign-out"></i> Sair </a>
                        </li>
                    @else
                        <li><p style="font-size: 12px;" class="name-user">Nenhum Usuário logado no momento.</p></li>;
                    @endif
                </ul>
            </li>
        </ul>
    </div>
</div>