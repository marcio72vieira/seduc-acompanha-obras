@extends('layouts.restrito.admin')

@section('content-page')
<div class="px-4 container-fluid">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Objetos - lista</h2>
    </div>

    <div class="mb-4 shadow card border-light">
        <div class="card-header hstack gap-2">
            <span class="ms-auto d-sm-flex flex-row mt-2 mb-2">
                <a href="{{ route('objeto.create') }}" class="btn btn-primary btn-sm me-1"><i class="fa-regular fa-square-plus"></i> Novo</a>
                <a href="{{ route('objeto.relpdflistobjetos') }}" class="btn btn-secondary btn-sm me-1" target="_blank"><i class="fa-solid fa-file-pdf"></i> pdf</a>
            </span>
        </div>

        <div class="card-body">

            <x-alert />

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Obras</th>
                        <th>Ativo</th>
                        <th>Cadastrado</th>
                        <th width="25%">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($objetos as $objeto)
                        <tr>
                            <td>{{ $objeto->id }}</th>
                            <td>{{ $objeto->nome }}</td>
                            <td>{{ $objeto->obras->count() > 0 ? $objeto->obras->count() : "" }}</td>
                            <td>{{ $objeto->ativo == 1 ? "Sim" : "Não" }}</td>
                            <td>{{ \Carbon\Carbon::parse($objeto->created_at)->format('d/m/Y H:i') }}</td>
                            <td class="flex-row d-md-flex justify-content-start">

                                <a href="{{ route('objeto.edit', ['objeto' => $objeto->id]) }}" class="mb-1 btn btn-secondary btn-sm me-1">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </a>

                                @if($objeto->obras->count() == 0)
                                    <form id="formDelete{{ $objeto->id }}" method="POST" action="{{ route('objeto.destroy', ['objeto' => $objeto->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-secondary btn-sm me-1 mb-1 btnDelete" data-delete-entidade="objeto" data-delete-id="{{ $objeto->id }}"  data-value-record="{{ $objeto->nome }}">
                                            <i class="fa-regular fa-trash-can"></i> Apagar
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-outline-secondary btn-sm me-1 mb-1"  title="há obras vinculadas!"> <i class="fa-solid fa-ban"></i> Apagar </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <div class="alert alert-danger" role="alert">Nenhum registro encontrado!</div>
                    @endforelse
                </tbody>
            </table>

            {{ $objetos->links() }}


        </div>

    </div>

</div>


@endsection

@section('scripts')

@endsection
