@extends('layouts.restrito.admin')

@section('content-page')
<div class="px-4 container-fluid">
    <div class="gap-2 mb-1 hstack">
        <h2 class="mt-3">Obras - lista</h2>
    </div>

    <div class="mb-4 shadow card border-light">
        <div class="gap-2 card-header hstack">
            <span class="flex-row mt-2 mb-2 ms-auto d-sm-flex">
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
                        <th>Escola/Descrição</th>
                        <th>Regional</th>
                        <th>Município</th>
                        <th>Inicio</th>
                        <th>Fim</th>
                        <th>Objetos</th>
                        <th>Status</th>
                        <th>Ativo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($obras as $obra)
                        <tr class="align-top">
                            <td>{{ $obra->id }}</th>
                            <td>{{ $obra->escola->nome }}<br>{{ $obra->descricao }}</td>
                            <td>{{ $obra->regional->nome }}</td>
                            <td>{{ $obra->municipio->nome }}</td>
                            <td>{{ \Carbon\Carbon::parse($obra->data_inicio)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($obra->data_fim)->format('d/m/Y') }}</td>
                            <td>
                                @foreach ($obra->objetos as $objeto)
                                    <span style="font-size: 12px;">{{ $objeto->nome }} </span><br>
                                @endforeach
                            </td>
                            <td>{{ $obra->estatus == 1 ? 'Criada' : 'Outro' }}</td>
                            <td>{{ $obra->ativo == 1 ? "Sim" : "Não" }}</td>
                            <td class="align-top">
                                <div class="flex-row d-md-flex justify-content-start">
                                <a href="{{ route('obra.edit', ['obra' => $obra->id]) }}" class="mb-1 btn btn-secondary btn-sm me-1">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </a>

                                @if(($obra->objetos->count() == 0) || (Auth::user()->id == 1))
                                    <form id="formDelete{{ $obra->id }}" method="POST" action="{{ route('obra.destroy', ['obra' => $obra->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="mb-1 btn btn-secondary btn-sm me-1 btnDelete" data-delete-entidade="obra" data-delete-id="{{ $obra->id }}"  data-value-record="{{ $obra->escola->nome }}">
                                            <i class="fa-regular fa-trash-can"></i> Apagar
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="mb-1 btn btn-outline-secondary btn-sm me-1"  title="há objetos vinculados!"> <i class="fa-solid fa-ban"></i> Apagar </button>
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

@section('scripts')

@endsection

