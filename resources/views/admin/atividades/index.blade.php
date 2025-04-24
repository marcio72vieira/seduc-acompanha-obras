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
                        <th>Escola</th>
                        <th>Município</th>
                        <th style="width: 15%">Prazo</th>
                        <th>Registros</th>
                        <th>Status</th>
                        <th style="width: 15%">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($obras as $obra)
                        <tr class="align-top">
                            <td>{{ $obra->escola->nome }}</td>
                            <td>{{ $obra->municipio->nome }}</td>
                            <td>de {{ \Carbon\Carbon::parse($obra->data_inicio)->format('d-m-Y') }} a {{ \Carbon\Carbon::parse($obra->data_fim)->format('d-m-Y') }}</td>
                            <td>{{ $obra->atividades->count() > 0 ? $obra->atividades->count() : '' }}</td>
                            <td>
                                @if($obra->atividades->count() > 0 )
                                    <div style="display: inline-block; background-color: {{ $obra->estatu->cor }}; width: 2.8em; height: 2.8em; line-height: 2.8em; border-radius: 50%; text-align:center; vertical-align: middle; color: white"  title="{{ $obra->estatu->nome }}">
                                        {{ $obra->ultimoprogresso($obra->id) }}%
                                    </div>
                                @else
                                    <div style="display: inline-block; background-color: {{ $obra->estatu->cor }}; width: 2.8em; height: 2.8em; line-height: 2.8em; border-radius: 50%; text-align:center; vertical-align: middle; color: white"  title="{{ $obra->estatu->nome }}">
                                        0 %
                                    </div>
                                @endif
                            </td>
                            <td class="align-top">
                                <div class="flex-row d-md-flex justify-content-start">
                                    @if($obra->estatu_id != 3)
                                        <a href="{{ route('atividade.create', ['obra' => $obra->id]) }}" class="mb-1 btn btn-secondary btn-sm me-1" title="registrar atividades"> <i class="fa-solid fa-keyboard"></i> Registrar atividades</a>
                                    @else
                                    <a href="" class="mb-1 btn btn-outline-secondary btn-sm me-1" title="registrar atividades"> <i class="fa-solid fa-ban"></i> Registrar atividades</a>
                                    @endif
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

