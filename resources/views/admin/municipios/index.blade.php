@extends('layouts.restrito.admin')

@section('content-page')
<div class="px-4 container-fluid">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Municípios - lista</h2>
    </div>

    <div class="mb-4 shadow card border-light">
        <div class="card-header hstack gap-2">
            <span class="ms-auto d-sm-flex flex-row mt-2 mb-2">
                <a href="{{ route('municipio.create') }}" class="btn btn-primary btn-sm me-1"><i class="fa-regular fa-square-plus"></i> Novo </a>
                <a href="{{ route('municipio.pdflistmunicipios') }}" class="btn btn-secondary btn-sm me-1" target="_blank"><i class="fa-solid fa-file-pdf"></i> pdf</a>
            </span>
        </div>

        <div class="card-body">

            <x-alert />

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Regional</th>
                        <th>Ativo</th>
                        <th>Escolas</th>
                        <th>Cadastrado</th>
                        <th width="18%">Ações</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($municipios as $municipio)
                        <tr>
                            <td>{{ $municipio->id }}</th>
                            <td>{{ $municipio->nome }}</td>
                            <td>{{ $municipio->regional->nome }}</td>
                            <td>{{ $municipio->ativo == 1 ? "Sim" : "Não" }}</td>
                            <td>{{ $municipio->escolas()->count() > 0 ? $municipio->escolas()->count() : ''  }}</td>
                            <td>{{ \Carbon\Carbon::parse($municipio->created_at)->format('d/m/Y') }}</td>
                            <td class="flex-row d-md-flex justify-content-start">

                                <a href="{{ route('municipio.edit', ['municipio' => $municipio->id]) }}" class="mb-1 btn btn-secondary btn-sm me-1">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </a>

                                @if($municipio->escolas()->count() == 0)
                                    <form id="formDelete{{ $municipio->id }}" method="POST" action="{{ route('municipio.destroy', ['municipio' => $municipio->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="mb-1 btn btn-secondary btn-sm me-1  btnDelete" data-delete-entidade="Município" data-delete-id="{{ $municipio->id }}"  data-value-record="{{ $municipio->nome }}">
                                            <i class="fa-regular fa-trash-can"></i> Apagar
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-outline-secondary btn-sm me-1 mb-1"  title="há escolas vinculadas!"> <i class="fa-solid fa-ban"></i> Apagar </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <div class="alert alert-danger" role="alert">Nenhum município encontrado!</div>
                    @endforelse

                </tbody>
            </table>

            {{ $municipios->links() }}


        </div>

    </div>

</div>


@endsection

@section('scripts')

@endsection
