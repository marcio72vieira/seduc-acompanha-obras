@extends('layouts.restrito.admin')

@section('content-page')
<div class="px-4 container-fluid">
    <div class="gap-2 mb-1 hstack">
        <h2 class="mt-3">ESTATUS - lista</h2>
    </div>

    <div class="mb-4 shadow card border-light">
        <div class="gap-2 card-header hstack">
            <span class="flex-row mt-1 mb-1 ms-auto d-sm-flex">
                <a href="{{ route('estatu.create') }}" class="btn btn-primary btn-sm me-1"><i class="fa-regular fa-square-plus"></i> Novo </a>
                <a href="{{ route('estatu.pdflistestatus') }}" class="btn btn-secondary btn-sm me-1" target="_blank"><i class="fa-solid fa-file-pdf"></i> pdf</a>
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
                        <th>Tipo</th>
                        <th>Nome</th>
                        <th>Cor</th>
                        <th>Obras</th>
                        <th>Ativo</th>
                        <th>Cadastrado</th>
                        <th width="18%">Ações</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($estatus as $estatu)
                        <tr>
                            <td>{{ $estatu->id }}</th>
                            <td>{{ $estatu->tipo }}</th>
                            <td>{{ $estatu->nome }}</td>
                            <td>
                                @if ($estatu->tipo == "informativo")
                                    <div class="d-flex justify-content-between align-items-center" style="width: 200px; height: 40px; border: 1px solid rgb(218, 213, 213); border-radius: 7px; background: {{ $estatu->cor }}">
                                        &nbsp;
                                    </div>
                                @else
                                    <div class="d-flex justify-content-between align-items-center" style="width: 200px; height: 40px; border: 1px solid rgb(218, 213, 213); border-radius: 7px; background: {{ $estatu->cor }}">
                                        <span style="padding-left: 10px; padding-right:10px; color: white">{{ $estatu->valormin }}%</span> <span style="padding-left: 10px; padding-right:10px; color: white"> a </span>  <span style="padding-left: 10px; padding-right:10px; color: white">{{ $estatu->valormax }}%</span>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $estatu->obras->count() > 0 ? $estatu->obras->count() : '' }}</td>
                            <td>{{ $estatu->ativo == 1 ? "Sim" : "Não" }}</td>
                            <td>{{ \Carbon\Carbon::parse($estatu->created_at)->format('d/m/Y') }}</td>
                            <td class="flex-row d-md-flex justify-content-start">
                                <a href="{{ route('estatu.show', ['estatu' => $estatu->id]) }}" class="mb-1 btn btn-secondary btn-sm me-1">
                                    <i class="fa-regular fa-eye"></i> Visualizar
                                </a>

                                <a href="{{ route('estatu.edit', ['estatu' => $estatu->id]) }}" class="mb-1 btn btn-secondary btn-sm me-1">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </a>

                                @if($estatu->obras->count() == 0)
                                    <form id="formDelete{{ $estatu->id }}" method="POST" action="{{ route('estatu.destroy', ['estatu' => $estatu->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="mb-1 btn btn-secondary btn-sm me-1 btnDelete" data-delete-entidade="estatus" data-delete-id="{{ $estatu->id }}"  data-value-record="{{ $estatu->nome }}">
                                            <i class="fa-regular fa-trash-can"></i> Apagar
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="mb-1 btn btn-outline-secondary btn-sm me-1"  title="há obras vinculadas!"> <i class="fa-solid fa-ban"></i> Apagar </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <div class="alert alert-danger" role="alert">Nenhum registro encontrado!</div>
                    @endforelse

                </tbody>
            </table>

            {{ $estatus->links() }}


        </div>

    </div>

</div>


@endsection

@section('scripts')

@endsection
