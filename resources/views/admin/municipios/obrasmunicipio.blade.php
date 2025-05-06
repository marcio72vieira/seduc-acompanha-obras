@extends('layouts.restrito.admin')

@section('content-page')
<div class="px-4 container-fluid">
    <div class="mb-1 hstack gap-2">
    <h2 class="mt-3">Obras do Municipio: {{ $municipio->nome }}</h2>
    </div>

    <div class="mb-4 shadow card border-light">
        <div class="card-header hstack gap-2">
            <span class="ms-auto d-sm-flex flex-row mt-2 mb-2">
                <a href="{{ url()->previous() }}" class="btn  btn-outline-secondary btn-sm me-1">Retornar</a>
                <a href="{{ route('municipio.relpdflistobrasmunicipio', ['municipio' => $municipio->id]) }}" class="btn btn-secondary btn-sm me-1" target="_blank"><i class="fa-solid fa-file-pdf"></i> pdf</a>
            </span>
        </div>

        <div class="card-body">

            <x-alert />

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tipo</th>
                        <th>Escola</th>
                        <th>Regional</th>
                        <th>Datas de Iníco e Fim</th>
                        <th>Objetos</th>
                        <th>Responsáveis</th>
                        <th>Registros</th>
                        <th>Progresso</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($obras as $obra)
                        <tr>
                            <td>{{ $obra->escola->id }}</th>
                            <td>{{ $obra->tipoobra->nome }}</td>
                            <td>{{ $obra->escola->nome }}</td>
                            <td>{{ $obra->escola->regional->nome }}</td>
                            <td>{{ \Carbon\Carbon::parse($obra->data_inicio)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($obra->data_fim)->format('d/m/Y') }}</td>
                            <td>@foreach ($obra->objetos as $objeto) {{ $objeto->nome }} @endforeach </td>
                            <td>@foreach ($obra->users as $user) {{ $user->nome}} @endforeach </td>
                            <td>{{ $obra->atividades->count() > 0 ? $obra->atividades->count() : '' }}</td>
                            <td>
                                <div style="margin-left: 20px; display: inline-block; background-color: {{ $obra->estatu->cor }}; width: 2.8em; height: 2.8em; line-height: 2.8em; border-radius: 50%; text-align:center; vertical-align: middle; color: white"  title="{{ $obra->estatu->nome }}">
                                    {{ $obra->progressomaximo($obra->id) }}%
                                </div>
                            </td>
                        </tr>
                    @empty
                        <div class="alert alert-danger" role="alert">Nenhuma obra encontrada!</div>
                    @endforelse
                </tbody>
            </table>

            {{ $obras->links() }}


        </div>

    </div>

</div>


@endsection

@section('scripts')

@endsection
