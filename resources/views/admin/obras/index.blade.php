@extends('layouts.restrito.admin')

@section('content-page')
<div class="px-4 container-fluid">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Obras - lista</h2>
    </div>

    <div class="mb-4 shadow card border-light">
        <div class="card-header hstack gap-2">
            <span class="ms-auto d-sm-flex flex-row mt-2 mb-2">
                <a href="{{ route('obra.create') }}" class="btn btn-primary btn-sm me-1"><i class="fa-regular fa-square-plus"></i> Novo</a>
                <a href="{{ route('obra.relpdflistobras') }}" class="btn btn-secondary btn-sm me-1" target="_blank"><i class="fa-solid fa-file-pdf"></i> pdf</a>
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
                        <th>Cadastrado</th>
                        <th width="25%">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($obras as $obra)
                        <tr>
                            <td>{{ $obra->id }}</th>
                            <td>{{ $obra->nome }}</td>
                            <td>{{ $obra->ativo == 1 ? "Sim" : "Não" }}</td>
                            <td>{{ \Carbon\Carbon::parse($obra->created_at)->format('d/m/Y H:i') }}</td>
                            <td class="flex-row d-md-flex justify-content-start">

                                <a href="{{ route('obra.edit', ['obra' => $obra->id]) }}" class="mb-1 btn btn-secondary btn-sm me-1">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </a>

                                {{-- @if($obra->qtdmunicipiosvinc($obra->id) == 0) --}}
                                    <form id="formDelete{{ $obra->id }}" method="POST" action="{{ route('obra.destroy', ['obra' => $obra->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-secondary btn-sm me-1 mb-1 btnDelete" data-delete-entidade="obra" data-delete-id="{{ $obra->id }}"  data-value-record="{{ $obra->nome }}">
                                            <i class="fa-regular fa-trash-can"></i> Apagar
                                        </button>
                                    </form>
                                {{-- @else
                                    <button type="button" class="btn btn-outline-secondary btn-sm me-1 mb-1"  title="há municípios vinculados!"> <i class="fa-solid fa-ban"></i> Apagar </button>
                                @endif --}}

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

@section('scripts')

@endsection

