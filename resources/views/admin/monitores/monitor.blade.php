@extends('layouts.restrito.admin')

@section('content-page')
    <div class="px-4 container-fluid">

        {{-- Esta classe, faz com que O título fique do lado esqueerdo e o formulário do lado direito --}}
        <div class="mb-4 d-flex align-items-center justify-content-between">
            <h1 class="mt-3">Monitor</h1>
        </div>


        {{-- Inicio filtro e tabela de obras --}}
        <div class="mb-4 shadow card border-light">
            <div class="gap-2 card-header hstack">
                <span style="font-size: 15px;"><strong><i class="fa-solid fa-business-time"></i> MONITORAMENTO DO REGISTRO DE ATIVIDADES</strong></span>
                <span class="flex-row mt-1 mb-1 ms-auto d-sm-flex">
                    <label id="ocultarExibirPaineldeFiltragem" style="cursor: pointer; font-size: 17px;"><i id="iconeVisao" class="{{ $flag != '' ? 'fa-solid fa-filter' : 'fas fa-eye-slash' }}" style=" margin-right: 5px;"></i>{{ $flag != '' ? "Filtro" : "Ocultar" }}</label>
                </span>
            </div>

            {{-- INICIO PAINEL DE FILTRAGEM --}}
            <div class="mt-1 mb-4 shadow card border-light" id="formularioFiltragem" style="display: {{ $flag }}">

                <div class="card-body">
                    <form action="{{ route('monitor.index') }}" id="formfiltro">
                        <div class="mb-3 row">

                            {{-- tipoobra --}}
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="tipoobra">Tipo</label>
                                    <select name="tipoobra" id="tipoobra" class="form-control select2">
                                        <option value="">Escolha...</option>
                                        @foreach($tipoobras  as $tipoobra)
                                            <option value="{{ $tipoobra->nome }}">{{$tipoobra->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- objeto --}}
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="objeto">Objeto</label>
                                    <select name="objeto" id="objeto" class="form-control select2">
                                        <option value="">Escolha...</option>
                                        @foreach($objetos  as $objeto)
                                            <option value="{{ $objeto->nome }}">{{$objeto->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- regional --}}
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="regional">Regional</label>
                                    <select name="regional" id="regional" class="form-control select2">
                                        <option value="">Escolha...</option>
                                        @foreach($regionais  as $regional)
                                            <option value="{{ $regional->nome }}">{{$regional->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- municipio --}}
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="municipio">Município</label>
                                    <select name="municipio" id="municipio" class="form-control select2">
                                        <option value="">Escolha...</option>
                                        @foreach($municipios  as $municipio)
                                            <option value="{{ $municipio->nome }}">{{$municipio->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            {{-- user --}}
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="user">Responsável</label>
                                    <select name="user" id="user" class="form-control select2">
                                        <option value="">Escolha...</option>
                                        @foreach($users  as $user)
                                            <option value="{{ $user->nome }}">{{$user->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            {{-- estatu --}}
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="estatu">Estatus</label>
                                    <select name="estatu" id="estatu" class="form-control select2">
                                        <option value="">Escolha...</option>
                                        @foreach($estatus  as $estatu)
                                            @if($estatu->id == 1) @continue @endif
                                            <option value="{{ $estatu->nome }}">{{$estatu->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            {{-- Data inicio --}}
                            <div class="col-md-2 col-sm-12">
                                <label class="form-label" for="datainicio">Data início</label>
                                <input type="date" name="datainicio" id="datainicio" class="form-control" value="">
                            </div>

                            {{-- Data fim --}}
                            <div class="col-md-2 col-sm-12">
                                <label class="form-label" for="datafim">Data fim</label>
                                <input type="date" name="datafim" id="datafim" class="form-control" value="">
                            </div>

                            {{-- ordenacao --}}
                            <div class="col-md-1 col-sm-12 offset-md-4">
                                <div class="form-group focused">
                                    <label class="form-control-label mb-2" for="ordenacao">ordenar por</label>
                                    <select name="ordenacao" id="ordenacao" class="form-control select2">
                                        <option value="">Escolha...</option>
                                            <option value="tipoobras.nome">Tipo</option>
                                            <option value="objetos.nome">Objeto</option>
                                            <option value="regionais.nome">Regional</option>
                                            <option value="municipios.nome">Município</option>
                                            <option value="users.nome">Responsável</option>
                                            <option value="estatus.id">Estatu</option>
                                    </select>
                                </div>
                            </div>

                            {{-- sentido --}}
                            <div class="col-md-1 col-sm-12">
                                <div class="form-group focused">
                                    <label class="form-control-label mb-2" for="sentido">sentido</label>
                                    <select name="sentido" id="sentido" class="form-control select2">
                                        <option value="">Escolha...</option>
                                            <option value="asc">ascendente</option>
                                            <option value="desc">descendente</option>
                                    </select>
                                </div>
                            </div>

                            {{-- paginacao --}}
                            <div class="col-md-1 col-sm-12">
                                <div class="form-group focused">
                                    <label class="form-control-label mb-2" for="paginacao">nº registros</label>
                                    <select name="paginacao" id="sentido" class="form-control select2">
                                        <option value="">Escolha...</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="pt-3 col-md-1 col-sm-12">
                                <div style="margin-top:15px;">
                                    <button type="submit" name="pesquisar" value="stoped" id="btnpesquisar" class="btn btn-outline-secondary float-end"><i class="fa-solid fa-magnifying-glass"></i> Pesquisar</button>
                                    {{-- <button type="submit" name="pesquisar" value="stoped" id="btnpesquisarpdf" class="btn btn-outline-secondary"><i class="fa-solid fa-file-pdf"></i></button> --}}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- FIM PAINEL DE FILTRAGEM --}}


            <div class="card-body">

                <x-alert />

                {{-- Este componente será acionado sempre que houver uma erro de exceção em: store, update ou delete --}}
                <x-errorexception />

                <table class="table table-striped table-hover">
                    <thead class="table-light border">
                        <tr>
                            <th>Id</th>
                            <th>Tipo</th>
                            <th>Obra</th>
                            <th>Município</th>
                            <th>Responsáveis</th>
                            <th>Atualizado</th>
                            <th>Sinal</th>
                            <th style="width: 20%">Progresso</th>
                            <th>
                                <a href="{{ url('index-dashboard/gerarpdf?' . request()->getQueryString()) }}" class="btn btn-outline-secondary btn-sm ms-1" title="relatório PDF da pesquisa">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($obras as $obra)
                            <tr>
                                <td>{{ $obra->id }}</th>
                                <td>{{ $obra->tipo }}</th>
                                <td>{{ $obra->escola }}</td>
                                <td>{{ $obra->municipio }}</td>
                                <td>{{ $obra->responsaveiscontato }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($obra->registromaisrecente)->format('d/m/Y') }} <br> <span>há {{ mrc_calc_time_days($obra->registromaisrecente) }} dias</span>
                                </td>
                                <td>
                                    @php
                                        $signal = "";
                                        $qtdias = mrc_calc_time_days($obra->registromaisrecente);
                                        $signal = ($qtdias <= 7 ? 'lightgreen.png' : ($qtdias >= 8 && $qtdias <= 11 ? 'lightyellow.png' : 'lightred.png'));
                                    @endphp
                                    <img src="{{ asset('images/'.$signal) }}" height="35" style="margin-left: 15px;" title="há {{ $qtdias }} dias">
                                </td>
                                <td>
                                    <div class="progress border" style="height: 30px;" title="{{ $obra->nomeestatus }}">
                                        {{-- 
                                            Se a obra estiver ativa e seu status for diferente de 3(concluída), as classes "striped" e "aninmated" não são aplicadas.
                                            "animated" é para indicar que a obra está em andamento(com registro de atividade). 
                                            Se a obra está inativa(ativo == 0), ou seja PARADA e concluida (estatu == 3), não há porque manter atividade, portanto as classes "striped e animated" são suprimidas.
                                         --}}
                                        <div class="progress-bar {{ ($obra->ativo == 1 &&  $obra->estatu != 3)  ? 'progress-bar-striped progress-bar-animated' : '' }}" role="progressbar" aria-valuenow="{{ $obra->progressomaximo }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $obra->progressomaximo }}%; background-color:{{ $obra->cor }}">
                                          <strong>{{ $obra->progressomaximo }}%</strong>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align: center">
                                    <a class="btn btn-outline-secondary" href="{{ route('obra.edit', ['obra' => $obra->id]) }}" role="button" title="ativar desativar obra"><i class="fa-solid fa-circle-stop"></i></a>
                                </td>
                            </tr>
                        @empty
                            <div class="alert alert-danger" role="alert">Nenhuma OBRA encontrada!</div>
                        @endforelse
                    </tbody>
                </table>

                {{-- $obras->links() --}}
                {{ $obras->appends(request()->all())->onEachSide(0)->links() }}
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
            $("#tipoobra_id").val("");
            $("#data_cadastro_inicio").val("");
            $("#data_cadastro_fim").val("");
        }

        // $("#btnpesquisarpdf").click(function() {
        //     alert("Submeter o formulario para a rota de GERAR PDF");
        //     $("#formfiltro").prop("action", "{{ route('dashboard.gerarpdf') }}");
        //     $("#formfiltro").submit();
        // });
    </script>
@endsection
