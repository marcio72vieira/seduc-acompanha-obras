@extends('layouts.restrito.admin')

@section('content-page')

    <div class="px-4 container-fluid">
        <div class="mb-1 hstack gap-2">
            <h2 class="mt-3">USUÁRIOS - lista</h2>
        </div>

        <div class="mb-4 shadow card border-light">
            <div class="card-header hstack gap-2">
                <span class="ms-auto d-sm-flex flex-row mt-1 mb-1">
                    <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm me-1"><i class="fa-regular fa-square-plus"></i> Novo </a>
                    <a href="{{ route('user.pdflistusers') }}" class="btn btn-secondary btn-sm me-1" target="_blank"><i class="fa-solid fa-file-pdf"></i> pdf</a>
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
                            <th>Perfil</th>
                            <th>Cargo</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Obras</th>
                            <th>Ativo</th>
                            <th width="18%">Ações</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</th>
                                <td>{{ $user->nomecompleto }}</th>
                                <td>{{ ($user->perfil == "adm" ? "ADMINISTRADOR" : ($user->perfil == "con" ? "CONSULTOR" : "OPERADOR")) }}</th>
                                <td>{{ $user->cargo }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->fone }}</td>
                                <td>{{ $user->obras()->count() > 0 ? $user->obras()->count() : '' }}</td>
                                <td>{{ $user->ativo == 1 ? "Sim" : "Não" }}</td>

                                <td class="flex-row d-md-flex justify-content-start">
                                    <a href="{{ route('user.show', ['user' => $user->id]) }}" class="mb-1 btn btn-secondary btn-sm me-1" title="visualizar"> <i class="fa-regular fa-eye"></i> visualizar </a>

                                    <a href="{{ route('user.edit', ['user' => $user->id]) }}" class="mb-1 btn btn-secondary btn-sm me-1" title="editar"> <i class="fa-solid fa-pen-to-square"></i> editar </a>

                                    {{--
                                    Envio de E-mail
                                    <a href="{{ route('user.sendemail', ['user' => $user->id]) }}" class="mb-1 btn btn-secondary btn-sm me-1" title="enviar email"> <i class="fa-solid fa-envelope"></i> e-mail </a>
                                    --}}
                                    @if ($user->obras()->count() == 0 )
                                        <form id="formDelete{{ $user->id }}" method="POST" action="{{ route('user.destroy', ['user' => $user->id]) }}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="mb-1 btn btn-secondary btn-sm me-1 btnDelete" data-delete-entidade="Usuário" data-delete-id="{{ $user->id }}"  data-value-record="{{ $user->nome }}" title="deletar">
                                                <i class="fa-regular fa-trash-can"></i> deletar
                                            </button>
                                        </form>
                                    @else
                                        <button type="button" class="btn btn-outline-secondary btn-sm me-1 mb-1"  title="há obras vinculadas!"> <i class="fa-solid fa-ban"></i> Apagar </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <div class="alert alert-danger" role="alert">Nenhum registro encontrada!</div>
                        @endforelse

                    </tbody>
                </table>

                {{ $users->links() }}


            </div>

        </div>

    </div>


@endsection

