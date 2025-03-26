@extends('layouts.restrito.admin')

@section('content-page')
<div class="px-4 container-fluid">
    <div class="gap-2 mb-1 hstack">
        <h2 class="mt-3">ESCOLA - lista</h2>
    </div>

    <div class="mb-4 shadow card border-light">
        <div class="gap-2 card-header hstack">
            <span class="flex-row mt-1 mb-1 ms-auto d-sm-flex"> 
                <a href="{{ route('escola.create') }}" class="btn btn-primary btn-sm me-1"><i class="fa-regular fa-square-plus"></i> Novo </a>
                <a href="{{ route('escola.pdflistescolas') }}" class="btn btn-secondary btn-sm me-1" target="_blank"><i class="fa-solid fa-file-pdf"></i> pdf</a>
            </span>
        </div>

        <div class="card-body">

            <x-alert />

            {{-- Este componente será acionado sempre que houver uma erro de exceção em: store, update ou delete --}}
            <x-errorexception />

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Regional</th>
                        <th>Município</th>
                        <th>Ativo</th>
                        <th>Cadastrado</th>
                        <th width="18%">Ações</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($escolas as $escola)
                        <tr>
                            <td>{{ $escola->id }}</th>
                            <td>{{ $escola->nome }}</td>
                            <td>{{ $escola->regional->nome }}</td>
                            <td>{{ $escola->municipio->nome }}</td>
                            <td>{{ $escola->ativo == 1 ? "Sim" : "Não" }}</td>
                            <td>{{ \Carbon\Carbon::parse($escola->created_at)->format('d/m/Y') }}</td>
                            <td class="flex-row d-md-flex justify-content-start">
                                <a href="{{ route('escola.show', ['escola' => $escola->id]) }}" class="mb-1 btn btn-secondary btn-sm me-1">
                                    <i class="fa-regular fa-eye"></i> Visualizar 
                                </a>

                                <a href="{{ route('escola.edit', ['escola' => $escola->id]) }}" class="mb-1 btn btn-secondary btn-sm me-1">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </a>

                                {{-- @if($unidadeatendimento->qtdusuariosdaunidade($unidadeatendimento->id) == 0) --}}
                                    <form id="formDelete{{ $escola->id }}" method="POST" action="{{ route('escola.destroy', ['escola' => $escola->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="mb-1 btn btn-secondary btn-sm me-1 btnDelete" data-delete-entidade="Escola" data-delete-id="{{ $escola->id }}"  data-value-record="{{ $escola->nome }}">
                                            <i class="fa-regular fa-trash-can"></i> Apagar
                                        </button>
                                    </form>
                                {{-- @else
                                    <button type="button" class="mb-1 btn btn-outline-secondary btn-sm me-1"  title="há usuários vinculados!"> <i class="fa-solid fa-ban"></i> Apagar </button>
                                @endif --}}
                            </td>
                        </tr>
                    @empty
                        <div class="alert alert-danger" role="alert">Nenhum Escola encontrada!</div>
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
