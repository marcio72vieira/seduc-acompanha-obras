@extends('layouts.restrito.admin')

@section('content-page')
    <div class="px-4 container-fluid">

        <div class="mb-4 d-sm-flex align-items-center justify-content-between">
            <h1 class="mt-3">Dashboard</h1>

            @can("onlyAdm")
                {{-- inicio formulario baixar arquivo excel csv--}}
                <div class="col-md-5">
                    <form action="{{ route('dashboard.gerarexcel') }}"  method="GET" class="form-inline" style="border-radius: 5px; margin-bottom: -15px;">
                        
                        <div class="row">
                            <div class="col-md-2" style="margin-left: 180px;">
                                <select id="selectMesExcel" name="mesexcel"  class="form-control col-form-label-sm" style="margin-left: 5px;">
                                    <option value="0">Mês...</option>
                                    @foreach($mesespesquisa as $key => $value)
                                        <option value="{{ $key }}" {{date('n') == $key ? 'selected' : ''}} class="optionMesPesquisa"> {{ $value }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <select id="selectAnoExcel"  name="anoexcel" class="form-control col-form-label-sm" style="margin-left: 5px;">
                                    <option value="0" selected disabled>Ano...</option>
                                    @foreach($anospesquisa as $value)
                                        <option value="{{ $value }}" {{date('Y') == $value ? 'selected' : ''}} class="optionAnoPesquisa"> {{ $value }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <select id="selectTipoExcelCsv"  name="tipoexcelcsv" class="form-control" style="margin-left: 5px;">
                                    <option value="0" selected>Tipo...</option>
                                    <option value="1" class="optionAnoPesquisa"><b>EXCEL</b> </option>
                                    <option value="2" class="optionAnoPesquisa"><b>CSV</b> </option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <button type="submit" class="mb-2 btn btn-success btn-sm form-control col-form-label-sm" style="margin-top: 3px;">
                                    <i class="fas fa-download"></i>
                                    <b>Gerar arquivo</b>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                {{--    fim formulario baixar arquivo excel csv--}}
            @endcan
        </div>

        {{-- Mensagem de error a ser exibida na geração do arquivo Excel ou CSV --}}
        <x-alert />

        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="mb-4 text-white card bg-primary">
                    <div class="card-body">Primary Card</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="text-white small stretched-link" href="#">View Details</a>
                        <div class="text-white small"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="mb-4 text-white card bg-warning">
                    <div class="card-body">Warning Card</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="text-white small stretched-link" href="#">View Details</a>
                        <div class="text-white small"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="mb-4 text-white card bg-success">
                    <div class="card-body">Success Card</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="text-white small stretched-link" href="#">View Details</a>
                        <div class="text-white small"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="mb-4 text-white card bg-danger">
                    <div class="card-body">Danger Card</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="text-white small stretched-link" href="#">View Details</a>
                        <div class="text-white small"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="mb-4 card">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Area Chart Example
                    </div>
                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="mb-4 card">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Bar Chart Example
                    </div>
                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
        </div>
        <div class="mb-4 card">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                DataTable Example
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped table-hover table-bordered display" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nome Completo</th>
                            <th>CPF</th>
                            <th>CARGO</th>
                            <th>PERFIL</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#datatablesSimple').DataTable({
            // ordering: true,  // Habilita/Desabilita a ordenação. Defult: true
            // scrollY: 300,    //Define a altura da tabela para rolagem vertical

            // Menu da quantidade de registros a serem exibidos. O valor default é 10
            // lengthMenu: [5, 10, 15, 20],
            lengthMenu: [1, 2, 3],

            // Exibe/Esconde o botão de filtro Default true
            // bFilter: true,

            language: {
                url: "https://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json"
            },

            // Indica a mensagem de processamento e que os dados virão de um servidor
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.ajaxgetusers') }}",
            columns: [
                    { data: 'id' },
                    { data: 'nomecompleto'},
                    { data: 'cpf' },
                    { data: 'cargo' },
                    { data: 'perfil' },
            ],
        });
    </script>

@endsection
