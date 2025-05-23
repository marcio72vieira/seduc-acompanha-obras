<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                {{-- Garante o acesso apenas de quem é Administrador --}}
                @can("onlyAdm")
                    <div class="sb-sidenav-menu-heading">Menu</div>
                    <a class="nav-link" href="{{ route('dashboard.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>

                    <a class="nav-link" href="{{ route('monitor.index') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-calendar-days"></i></div>
                        Monitor
                    </a>

                    {{--
                    <div class="sb-sidenav-menu-heading">Interface</div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Layouts
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="layout-static.html">Static Navigation</a>
                            <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                        <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                        Pages
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                Authentication
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="login.html">Login</a>
                                    <a class="nav-link" href="register.html">Register</a>
                                    <a class="nav-link" href="password.html">Forgot Password</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                Error
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="401.html">401 Page</a>
                                    <a class="nav-link" href="404.html">404 Page</a>
                                    <a class="nav-link" href="500.html">500 Page</a>
                                </nav>
                            </div>
                        </nav>
                    </div>
                    --}}

                    <div class="sb-sidenav-menu-heading">Administração</div>

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-gears"></i></div>
                        Configurações
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('regional.index') }}"><i class="fa-solid fa-globe" style="margin-right:7px;"></i>Regionais</a>
                            <a class="nav-link" href="{{ route('municipio.index') }}"><i class="fa-solid fa-location-dot" style="margin-right:7px;"></i>Municípios</a>
                            <a class="nav-link" href="{{ route('escola.index') }}"><i class="fa-solid fa-school" style="margin-right:7px;"></i>Escolas</a>
                            <a class="nav-link" href="{{ route('objeto.index') }}"><i class="fa-regular fa-object-group" style="margin-right:7px;"></i>Objetos</a>
                            <a class="nav-link" href="{{ route('tipoobra.index') }}"><i class="fa-solid fa-list" style="margin-right:7px;"></i>Tipos de Obra</a>
                            <a class="nav-link" href="{{ route('estatu.index') }}"><i class="fa-solid fa-bars-progress" style="margin-right:7px;"></i>Status</a>
                            {{-- <a class="nav-link" href="{{ route('programa.index') }}">Programas</a> --}}
                        </nav>
                    </div>

                    <a class="nav-link" href="{{ route('obra.index')}}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-person-digging"></i></div>
                        Obras
                    </a>

                    <a class="nav-link" href="{{ route('user.index')}}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                        Usuários
                    </a>
                @endcan


                <a class="nav-link" href="{{ route('atividade.index')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-pen-to-square"></i></div>
                    Atividades
                </a>

                <a class="nav-link" href="{{ route('login.logout') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-arrow-right-from-bracket"></i></div>
                    Sair
                </a>

                {{--
                <a class="nav-link" href="{{ route('datatable.index')}}"> <div class="sb-nav-link-icon"><i class="fas fa-table me-1"></i></div> DataTable </a> --}}
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Perfil: {{ (Auth::user()->perfil == "adm" ? "ADMINISTRADOR" : (Auth::user()->perfil == "con" ? "CONSULTOR" : "OPERADOR")) }}</div>
        </div>
    </nav>
</div>
