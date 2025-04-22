@extends('layouts.restrito.admin')

@section('content-page')
<div class="px-4 container-fluid">
    <div class="gap-2 mb-1 hstack">
        <h2 class="mt-3">REGISTRO DE ATIVIDADES POR OBRAS - lista</h2>
    </div>

    <div class="mb-4 shadow card border-light">
        <div class="gap-2 card-header hstack">
            <span class="flex-row mt-2 mb-2 ms-auto d-sm-flex">
                {{--
                <a href="{{ route('obra.create') }}" class="btn btn-primary btn-sm me-1"><i class="fa-regular fa-square-plus"></i> Novo</a>
                <a href="{{ route('obra.relpdflistobras') }}" class="btn btn-secondary btn-sm me-1" target="_blank"><i class="fa-solid fa-file-pdf"></i> pdf</a>
                --}}
            </span>
        </div>

        <div class="card-body">

            <x-alert />

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>TIPO</th>
                        <th>Escola</th>
                        <th>Município</th>
                        <th style="width: 15%">Datas de Inicio e Fim</th>
                        <th>Status</th>
                        <th style="width: 15%">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($obras as $obra)
                        <tr class="align-top">
                            <td>{{ $obra->id }}</th>
                            <td>{{ $obra->tipoobra->nome }}</th>
                            <td>{{ $obra->escola->nome }}</td>
                            <td>{{ $obra->municipio->nome }}</td>
                            <td>{{ \Carbon\Carbon::parse($obra->data_inicio)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($obra->data_fim)->format('d/m/Y') }}</td>
                            <td>
                                <div style="margin-left: 15px; width: 25px; height: 25px; border: 1px solid {{ $obra->estatu->cor }}; border-radius: 50px; background: {{ $obra->estatu->cor }}" title="{{ $obra->estatu->nome }}"></div>
                            </td>
                            <td class="align-top">
                                <div class="flex-row d-md-flex justify-content-start">
                                    <a href="{{ route('atividade.create', ['obra' => $obra->id]) }}" class="mb-1 btn btn-secondary btn-sm me-1" title="registrar atividades"> <i class="fa-solid fa-keyboard"></i> Registrar atividades</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <div class="alert alert-danger" role="alert">Nenhum registro encontrado!</div>
                    @endforelse
                </tbody>
            </table>

            {{ $obras->links() }}

        </div>

    </div>

</div>


@endsection

