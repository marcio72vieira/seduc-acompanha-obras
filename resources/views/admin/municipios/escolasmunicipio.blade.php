@extends('layouts.restrito.admin')

@section('content-page')
<div class="px-4 container-fluid">
    <div class="mb-1 hstack gap-2">
    <h2 class="mt-3">Escolas do Municipio: {{ $municipio->nome }}</h2>
    </div>

    <div class="mb-4 shadow card border-light">
        <div class="card-header hstack gap-2">
            <span class="ms-auto d-sm-flex flex-row mt-2 mb-2">
                <a href="{{ url()->previous() }}" class="btn  btn-outline-secondary btn-sm me-1">Retornar</a>
                <a href="{{ route('municipio.relpdflistescolasmunicipio', ['municipio' => $municipio->id]) }}" class="btn btn-secondary btn-sm me-1" target="_blank"><i class="fa-solid fa-file-pdf"></i> pdf</a>
            </span>
        </div>

        <div class="card-body">

            <x-alert />

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Ativo</th>
                        <th>Endereço</th>
                        <th>Município</th>
                        <th>Regional</th>
                        <th>Cadastrado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($escolas as $escola)
                        <tr>
                            <td>{{ $escola->id }}</th>
                            <td>{{ $escola->nome }}</td>
                            <td>{{ $escola->ativo == 1 ? "Sim" : "Não" }}</td>
                            <td>{{ $escola->endereco }}, {{ $escola->numero }}, Bairro: {{ $escola->bairro }} CEP: {{ $escola->cep }} telefone: {{ $escola->fone }}</td>
                            <td>{{ $escola->municipio->nome }}</td>
                            <td>{{ $escola->municipio->regional->nome }}</td>
                            <td>{{ \Carbon\Carbon::parse($escola->created_at)->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <div class="alert alert-danger" role="alert">Nenhuma escola encontrada!</div>
                    @endforelse
                </tbody>
            </table>

            {{ $escolas->links() }}


        </div>

    </div>

</div>


@endsection

@section('scripts')

@endsection
