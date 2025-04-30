@extends('layouts.restrito.admin')

@section('content-page')
<div class="px-4 container-fluid">
    <div class="mb-1 hstack gap-2">
    <h2 class="mt-3">Obras da Regional: {{ $regional->nome }}</h2>
    </div>

    <div class="mb-4 shadow card border-light">
        <div class="card-header hstack gap-2">
            <span class="ms-auto d-sm-flex flex-row mt-2 mb-2">
                <a href="{{ route('regional.index') }}" class="btn  btn-outline-secondary btn-sm me-1">Retornar</a>
                <a href="{{ route('regional.relpdflistobrasregional', ['regional' => $regional->id]) }}" class="btn btn-secondary btn-sm me-1" target="_blank"><i class="fa-solid fa-file-pdf"></i> pdf</a>
            </span>
        </div>

        <div class="card-body">

            <x-alert />

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Escola</th>
                        <th>Objetos</th>
                        <th>Município</th>
                        <th>Ativo</th>
                        {{-- <th style="width: 300px;">Estatus</th> --}}
                        <th>Cadastro</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @forelse ($regional->escolasDaRegional as $escola) --}}
                    @forelse ($obras as $obra)
                        <tr>
                            <td>{{ $obra->id }}</th>
                            <td>{{ $obra->tipoobra->nome }}</td>
                            <td>{{ $obra->escola->nome }}</td>
                            <td>@foreach ($obra->objetos as $objeto ) <span style="font-size: 12px;">{{ $objeto->nome }}, </span>,  @endforeach</td>
                            <td>{{ $obra->escola->municipio->nome }}</td>
                            <td>{{ $obra->ativo == 1 ? "Sim" : "Não" }}</td>
                            {{-- <td>
                                <div class="progress border" style="height:30px">
                                    <div class="progress-bar {{ $obra->ativo == 1 ? 'bg-white' : 'bg-danger' }}" style="width:80%">{{ $obra->estatus == 1 ? 'criada': 'iniciada'}}</div>
                                </div> 
                            </td> --}}
                            <td>{{ \Carbon\Carbon::parse($obra->created_at)->format('d/m/Y H:i') }}</td>
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
