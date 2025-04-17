@extends('layouts.restrito.admin')

@section('content-page')
<div class="px-4 container-fluid">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">TIPOS DE OBRA - lista</h2>
    </div>

    <div class="mb-4 shadow card border-light">
        <div class="card-header hstack gap-2">
            <span class="ms-auto d-sm-flex flex-row mt-2 mb-2">
                <a href="{{ route('tipoobra.create') }}" class="btn btn-primary btn-sm me-1"><i class="fa-regular fa-square-plus"></i> Novo</a>
                <a href="{{ route('tipoobra.relpdflisttipoobras') }}" class="btn btn-secondary btn-sm me-1" target="_blank"><i class="fa-solid fa-file-pdf"></i> pdf</a>
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
                    @forelse ($tipoobras as $tipoobra)
                        <tr>
                            <td>{{ $tipoobra->id }}</th>
                            <td>{{ $tipoobra->nome }}</td>
                            <td>
                                @if ($tipoobra->obra->count() > 0)
                                    {{ $tipoobra->obra->count() }}
                                    <a href="{{ route('tipoobra.relpdflisttipoobrasespecifica', ['tipoobra' => $tipoobra->id]) }}" class="btn btn-outline-secondary btn-sm me-1" target="_blank" style="margin-left: 10px"><i class="fa-solid fa-file-pdf"></i></a>
                                @endif
                            </td>
                            <td>{{ $tipoobra->ativo == 1 ? "Sim" : "Não" }}</td>
                            <td>{{ \Carbon\Carbon::parse($tipoobra->created_at)->format('d/m/Y H:i') }}</td>
                            <td class="flex-row d-md-flex justify-content-start">

                                <a href="{{ route('tipoobra.edit', ['tipoobra' => $tipoobra->id]) }}" class="mb-1 btn btn-secondary btn-sm me-1">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </a>

                                @if($tipoobra->obra->count() == 0)
                                    <form id="formDelete{{ $tipoobra->id }}" method="POST" action="{{ route('tipoobra.destroy', ['tipoobra' => $tipoobra->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-secondary btn-sm me-1 mb-1 btnDelete" data-delete-entidade="tipo de obra" data-delete-id="{{ $tipoobra->id }}"  data-value-record="{{ $tipoobra->nome }}">
                                            <i class="fa-regular fa-trash-can"></i> Apagar
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-outline-secondary btn-sm me-1 mb-1"  title="há obras vinculadas!"> <i class="fa-solid fa-ban"></i> Apagar </button>
                                @endif
                            </td>
                            {{-- <td> @if ($tipoobra->obra->count() > 0) <a href="{{ route('tipoobra.relpdflisttipoobrasespecifica', ['tipoobra' => $tipoobra->id]) }}" class="btn btn-outline-secondary btn-sm me-1" target="_blank"><i class="fa-solid fa-file-pdf"></i></a> @endif </td>--}}
                            {{-- {{ $tipoobra->obra->count() > 0 ? $tipoobra->obra->count() : '' }} --}}
                            {{-- <td>{!! $tipoobra->obra->count() > 0 ? "<a href='' class='btn btn-outline-secondary btn-sm me-1'><i class='fa-solid fa-file-pdf'></i></a>" : "" !!}</td> --}}
                        </tr>
                    @empty
                        <div class="alert alert-danger" role="alert">Nenhum registro encontrado!</div>
                    @endforelse
                </tbody>
            </table>

            {{ $tipoobras->links() }}


        </div>

    </div>

</div>


@endsection

@section('scripts')

@endsection
