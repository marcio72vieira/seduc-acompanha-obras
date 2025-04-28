@extends('layouts.restrito.admin')

@section('content-page')
    <div class="px-4 container-fluid">

        {{-- Esta classe, faz com que O título fique do lado esqueerdo e o formulário do lado direito --}}
        <div class="mb-4 d-flex align-items-center justify-content-between">
            <h1 class="mt-3">Dashboard</h1>

            @can("onlyAdm")
                {{-- inicio formulario baixar arquivo excel csv--}}

                <form action="{{ route('dashboard.gerarexcel') }}"  method="GET" class="form-inline" style="border-radius: 5px; margin-bottom: -15px;">

                    {{-- Esta classe, aplicada e esta DIV, faz com que os botões fiquem um ao lado do outro --}}
                    <div class="d-flex align-items-center justify-content-between">

                        <div style="margin-right: 10px;">
                            <select id="selectMesExcel" name="mesexcel"  class="form-control col-form-label-sm">
                                <option value="0">Mês...</option>
                                @foreach($mesespesquisa as $key => $value)
                                    <option value="{{ $key }}" {{date('n') == $key ? 'selected' : ''}} class="optionMesPesquisa"> {{ $value }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div style="margin-right: 10px;">
                            <select id="selectAnoExcel"  name="anoexcel" class="form-control col-form-label-sm">
                                <option value="0" selected disabled>Ano...</option>
                                @foreach($anospesquisa as $value)
                                    <option value="{{ $value }}" {{date('Y') == $value ? 'selected' : ''}} class="optionAnoPesquisa"> {{ $value }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div style="margin-right: 10px;">
                            <select id="selectTipoExcelCsv"  name="tipoexcelcsv" class="form-control">
                                <option value="0" selected>Tipo...</option>
                                <option value="1" class="optionAnoPesquisa"><b>EXCEL</b> </option>
                                <option value="2" class="optionAnoPesquisa"><b>CSV</b> </option>
                            </select>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-success form-control col-form-label-sm">
                                <i class="fas fa-download"></i>
                                <b>Baixar arquivo</b>
                            </button>
                        </div>
                    </div>

                </form>
                {{--    fim formulario baixar arquivo excel csv--}}
            @endcan
        </div>

        {{-- Mensagem de error a ser exibida na geração do arquivo Excel ou CSV --}}
        <x-alert />

        {{-- Área de cards de Estatus --}}
        <div class="row">
            @foreach ($estatus as $estatu )
                {{-- Se a iteração é a primeira, (id = 1) ignora-a com a diretiva (@continue) soltando par a próxima --}}
                @if($estatu->id == 1) @continue @endif

                <div class="col-xl-2 col-md-2">
                    <div class="mb-4 text-white card" style="background: {{ $estatu->cor }}">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div><i class="fa-solid fa-person-digging"></i> {{ $estatu->nome }}</div>
                            {{-- recupera todas as obras cujo estatus seja igual ao status do "id" atual --}}
                            <div class="text-white small"><strong>{{ $estatu->obras->count() > 0 ? $estatu->obras->count() : "" }}</strong></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{--
        <div class="mb-4 card">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Usuários
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
                            <th>CONTATO</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        --}}

        {{-- Inicio filtro e tabela de obras --}}
        <div class="mb-4 shadow card border-light">
            <div class="gap-2 card-header hstack">
                <span>Criar um campo na tabela obras, que registre o progresso mais alto da tabela atividades</span>
                <span class="flex-row mt-1 mb-1 ms-auto d-sm-flex">
                    <label id="ocultarExibirPaineldeFiltragem" style="cursor: pointer; font-size: 17px;"><i id="iconeVisao" class="{{ $flag != '' ? 'fa-solid fa-filter' : 'fas fa-eye-slash' }}" style=" margin-right: 5px;"></i>{{ $flag != '' ? "Filtro" : "Ocultar" }}</label>
                </span>
            </div>

            {{-- inicio painel de filtragem --}}
            <div class="mt-1 mb-4 shadow card border-light" id="formularioFiltragem" style="display: {{ $flag }}">

                <div class="card-body">
                    <form action="{{ route('dashboard.index') }}">
                        <div class="mb-3 row">
                            {{-- Colunas, quando for dispositivos médios(md) ocupe 4 grids e quando for dispositivos pequenos(sm) ocupe 12 grids--}}
                            <div class="col-md-2 col-sm-12">
                                <label class="form-label" for="name">Requerente</label>
                                <input type="text" name="requerente" id="requerente" class="form-control" value="" placeholder="Nome da requerente">
                            </div>

                            <div class="col-md-2 col-sm-12">
                                <label class="form-label" for="role">Regional</label>
                                <input type="text" name="regional" id="regional" class="form-control" value="" placeholder="Regional da unidade">
                            </div>

                            <div class="col-md-2 col-sm-12">
                                <label class="form-label" for="municipio">Município</label>
                                <input type="text" name="municipio" id="municipio" class="form-control" value="" placeholder="Município da unidade">
                            </div>

                            <div class="col-md-1 col-sm-12">
                                <label class="form-label" for="role">Tipo</label>
                                <input type="text" name="tipounidade" id="tipounidade" class="form-control" value="" placeholder="Tipo unidade">
                            </div>

                            <div class="col-md-2 col-sm-12">
                                <label class="form-label" for="role">Unidade</label>
                                <input type="text" name="unidade" id="unidade" class="form-control" value="" placeholder="Unidade de atendimento">
                            </div>

                            <div class="col-md-2 col-sm-12">
                                <label class="form-label" for="role">Analista</label>
                                <input type="text" name="analista" id="analista" class="form-control" value=""  placeholder="Analista">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-2 col-sm-12">
                                <label class="form-label" for="data_cadastro_inicio">Data cadastro início</label>
                                <input type="date" name="data_cadastro_inicio" id="data_cadastro_inicio" class="form-control" value="">
                            </div>

                            <div class="col-md-2 col-sm-12">
                                <label class="form-label" for="data_cadastro_fim">Data cadastro fim</label>
                                <input type="date" name="data_cadastro_fim" id="data_cadastro_fim" class="form-control" value="">
                            </div>

                            <div class="pt-3 col-md-2 col-sm-12">
                                <div style="margin-top:20px;">
                                    <button type="submit" name="pesquisar" value="stoped" id="btnpesquisar" class="btn btn-info btn-sm"><i class="fa-solid fa-magnifying-glass"></i> Pesquisar</button>
                                    <button type="button" class="btn btn-warning btn-sm" id="btnlimpar"><i class="fa-solid fa-trash"></i> Limpar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- fim painel de filtragem--}}


            <div class="card-body">

                <x-alert />

                {{-- Este componente será acionado sempre que houver uma erro de exceção em: store, update ou delete --}}
                <x-errorexception />

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Tipo</th>
                            <th>Obra</th>
                            <th>Município</th>
                            <th>Status</th>
                            <th>Progresso</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($obras as $obra)
                            <tr>
                                <td>{{ $obra->id }}</th>
                                <td>{{ $obra->tipo }}</th>
                                <td>{{ $obra->escola }}</td>
                                <td>{{ $obra->municipio }}</td>
                                <td>{{ $obra->nomeestatus }}</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">
                                          70%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <div class="alert alert-danger" role="alert">Nenhuma OBRA encontrada!</div>
                        @endforelse
                    </tbody>
                </table>

                {{ $obras->links() }}


            </div>

        </div>
        {{-- Fim filtro e tabela de obras --}}



    </div>
@endsection


@section('scripts')
    <script>
        // Esconde/Exibe painel de filtragem
        $("#ocultarExibirPaineldeFiltragem").click(function(){
            if($(this).text() == "Ocultar"){
                //$(this).text("Exibir");
                $("#ocultarExibirPaineldeFiltragem").html("<i id='iconeVisao' class='fa-solid fa-filter' style='margin-right: 5px;'></i>Filtro");
                limparCampos();
            }else {
                //$(this).text("Ocultar");
                $("#ocultarExibirPaineldeFiltragem").html("<i id='iconeVisao' class='fas fa-eye-slash' style='margin-right: 5px;'></i>Ocultar");
            }

            $("#formularioFiltragem").toggle();
            //$("#iconeVisao", this).toggleClass("fas fa-eye-slash fas fa-eye");
        });

        $("#btnpesquisar").on('click', function(){
            $(this).attr('value', 'started');
        });

        // "Limpa campos de pesquisa"
        $("#btnlimpar").on('click', function(){
            limparCampos();
        })

        function limparCampos(){
            $("#requerente").val("");
            $("#regional").val("");
            $("#municipio").val("");
            $("#unidade").val("");
            $("#estatus").val("");
            $("#tipounidade").val("");
            $("#data_cadastro_inicio").val("");
            $("#data_cadastro_fim").val("");
        }
    </script>
@endsection
