<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- Inclusão do Bootstrap via Vite--}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    {{-- Link CSS do SBADMIN --}}
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

    <title>SEDUC - OBRAS</title>
    <style>
        body{
            background-image: url('{{ asset("images/background_06.png")}}');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            background-size: 100% 100%;
        }

        .card-header{
            background: url('{{ asset("images/logo_seduc2.png") }}') no-repeat center center;
            background-color: #4476ed;;
            height: 130px;
        }
    </style>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center" style="margin-top: 10%">

                        @yield('content-page')

                    </div>
                </div>
            </main>
        </div>

        {{-- footer --}}
        <div id="layoutAuthentication_footer">
            <footer class="py-4 mt-auto bg-light">
                <div class="px-4 container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; ATI {{ date('Y')}}</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>

</body>
</html>
