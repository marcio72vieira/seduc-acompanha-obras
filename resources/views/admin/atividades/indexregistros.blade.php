@extends('layouts.restrito.admin')

{{-- 
    Acessando modelos relacionados sem a necessidade de foreach. 
    Obs, Como o relacionamento de obra, escola são do tipo tem um, não há a necessidade de colocarmos 
    ['obra'][0]['escola']['nome'], pois para o conjunto de atividades[0] exite apenas uma obra e para
    cada obra existe apenas uma escola.
    <h6 class="mt-1"> {{ $atividades[0]['obra']['escola']['nome'] }}</h6>
    <a class="btn btn-primary ms-1" href="{{ route('atividade.create', ['obra' => $atividades[0]['obra']['id']]) }}" role="button">Registrar</a>
--}}

@section('content-page')
<div class="px-4 container-fluid">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <h1 class="mt-3">Lista de Atividades</h1>
    </div>
    <div class="mb-1 d-flex align-items-center justify-content-between">
        <h6 class="mt-1"> {{ $obra->escola->nome }}</h6>
        <div>
            <a class="btn btn-outline-secondary" href="{{ route('atividade.index')}}" role="button"><i class="fa-solid fa-rotate-left"></i></a>
            <a class="btn btn-outline-secondary" href="{{ route('atividade.relpdfatividade', ['obra' => $obra->id]) }}" role="button"><i class="fa-regular fa-file-pdf"></i></a>
            {{-- Se o estatu da obra for concluída, o usuário não poderá mais registrar atividades, só alterar e apagar, e alterando, poderá reverter o status da mesma --}}
            @if($obra->estatu->id == 3)
                <a href="" class="btn btn-secondary" title="registrar atividades"> <i class="fa-solid fa-ban"></i></a>
            @else
                <a class="btn btn-primary ms-1" href="{{ route('atividade.create', ['obra' => $obra->id]) }}" role="button"> <i class="fa-solid fa-keyboard"></i></a>
            @endif
        </div>
    </div>

    <div class="mt-4 row ">
        <div class="col-xl-12 col-md-12">
            
            <x-alert />
            
            <table class="table" style="width: 100%">
                <thead>
                  <tr>
                    <th scope="col">Atividade</th>
                    <th scope="col">Ações</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ($atividades as $atividade)
                    <tr @if($loop->even) style="background-color: #e3e3e3;" @endif style="background-color: {{ $atividade->obraconcluida == 1 ? '#0bda51' : '' }}">
                        <td>
                            {{ \Carbon\Carbon::parse($atividade->data_registro)->format('d-m-Y') }}
                            &nbsp;({{ $atividade->progresso }}%)
                            &nbsp;{{ $atividade->registro }}
                            @if ($atividade->observacao != null)
                                <br><strong><sup>obs: </sup></strong>{{ $atividade->observacao }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('atividade.edit', ['atividade' => $atividade->id]) }}" class="mb-1 mb-4 btn btn-secondary btn-sm me-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>

                            <form id="formDelete{{ $atividade->id }}" method="POST" action="{{ route('atividade.destroy', ['atividade' => $atividade->id]) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="mb-1 btn btn-danger btn-sm me-1 btnDelete" data-delete-entidade="Atividade" data-delete-id="{{ $atividade->id }}"  data-value-record="{{ $atividade->data_registro }}">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <div class="alert alert-danger" role="alert">Sem registros de atividades!</div>
                    @endforelse
                </tbody>
              </table>
        </div>
    </div>
</div>


@endsection

