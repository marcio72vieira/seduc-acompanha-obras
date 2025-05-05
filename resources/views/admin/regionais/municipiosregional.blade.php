@extends('layouts.restrito.admin')

@section('content-page')
<div class="px-4 container-fluid">
    <div class="mb-1 hstack gap-2">
    <h2 class="mt-3">Municípios da Regional: {{ $regional->nome }}</h2>
    </div>

    <div class="mb-4 shadow card border-light">
        <div class="card-header hstack gap-2">
            <span class="ms-auto d-sm-flex flex-row mt-2 mb-2">
                <a href="{{ route('regional.index') }}" class="btn  btn-outline-secondary btn-sm me-1">Retornar</a>
                <a href="{{ route('regional.relpdflistmunicipiosregional', ['regional' => $regional->id]) }}" class="btn btn-secondary btn-sm me-1" target="_blank"><i class="fa-solid fa-file-pdf"></i> pdf</a>
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
                        <th>Escolas</th>
                        <th>Obras</th>
                        <th>Cadastrado</th>
                        {{-- <th width="7%">Ações</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse ($municipios as $municipio)
                        <tr>
                            <td>{{ $municipio->id }}</th>
                            <td>{{ $municipio->nome }}</td>
                            <td>{{ $municipio->ativo == 1 ? "Sim" : "Não" }}</td>
                            <td>
                                @if($municipio->escolas()->count() > 0)
                                    {{ $municipio->escolas()->count() }}
                                    <a href="{{ route('municipio.escolas', ['municipio' => $municipio->id]) }}" class="btn btn-outline-secondary btn-sm me-1" style="margin-left: 10px"><i class="fa-solid fa-school"></i></a>
                                @endif
                            </td>
                            <td>{{--  $municipio->escolas()->count() > 0 ? $municipio->escolas()->count() : '' --}}
                                @if($municipio->obrasdomunicipio()->count() > 0)
                                    {{ $municipio->obrasdomunicipio()->count() }}
                                    <a href="{{ route('municipio.obras', ['municipio' => $municipio->id]) }}" class="btn btn-outline-secondary btn-sm me-1" style="margin-left: 10px"><i class="fa-solid fa-person-digging"></i></a>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($municipio->created_at)->format('d/m/Y H:i') }}</td>
                            {{-- <td class="flex-row d-md-flex justify-content-start">
                                @if($municipio->escolas->count() != 0)
                                    <a href="{{ route('municipio.escolas', ['municipio' => $municipio->id]) }}" class="mb-1 btn btn-secondary btn-sm me-1">
                                        <i class="fa-solid fa-school"></i> Escolas
                                    </a>
                                @else
                                    <a href="" class="mb-1 btn btn-outline-secondary  btn-sm me-1"><i class="fa-solid fa-ban"></i> Escolas</a>
                                @endif
                            </td> --}}
                        </tr>
                    @empty
                        <div class="alert alert-danger" role="alert">Nenhum municipio encontrado!</div>
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
