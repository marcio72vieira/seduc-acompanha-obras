<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>

        {{-- Link CSS do SBADMIN --}}
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

        {{-- Link do estilo CSS do datatable via CDN --}}
        {{-- <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" /> --}}

        {{-- Link do estilo CSS do datatable local padrão --}}
        {{-- <link href="{{ asset('css/datatable/datatable_padrao.css') }}" rel="stylesheet" /> --}}

        {{-- Link do estilo CSS do datatable local bootstrap5 --}}
        <link href="{{ asset('css/datatable/datatable_bootstrap5.css') }}" rel="stylesheet" />


        {{-- Inlcuindo o css e js do SELECT2 via CDN Obs: o jquery, deve ficar antes do JS do select2 --}}
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        {{-- Incluindo fontawesome --}}
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

        {{-- Incluindo o SweeterAlert2 --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>
    <body class="sb-nav-fixed">
        {{-- TopBar--}}
        @include('layouts.restrito.topbar')

        <div id="layoutSidenav">
            {{-- SideBar --}}
            @include('layouts.restrito.sidebar')

            <div id="layoutSidenav_content">
                <main>

                    {{-- CONTENT's --}}
                    @yield('content-page')

                </main>

                {{-- Footer --}}
                @include('layouts.restrito.footer')
            </div>
        </div>


        {{-- Bootstrap --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>

        {{-- ChartJS --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        {{-- <script src="assets/demo/chart-area-demo.js"></script> --}}
        {{-- <script src="assets/demo/chart-bar-demo.js"></script> --}}


        {{-- Link do script JS do datatable via CDN --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>

        {{-- Link do script JS do datatable local padrão --}}
        {{-- <script src="{{ asset('js/datatable/datatable_padrao.js') }}"></script> --}}

        {{-- Link do script JS do datatable local bootstrap5 --}}
        <script src="{{ asset('js/datatable/datatable_bootstrap5a.js') }}"></script>
        <script src="{{ asset('js/datatable/datatable_bootstrap5b.js') }}"></script>


        <!--Plugin jQuery para máscaras de campos -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

        <!-- Scripts Customizados, criados por mim mesmo ou para configuração de outras bibliotecas e plugins -->
        <script src="{{ asset('js/scriptsmrc.js') }}"></script>

        {{-- Scripts a serem colocados no final do Conteúdo das páginas quando necessário --}}
        @yield('scripts')

    </body>
</html>
