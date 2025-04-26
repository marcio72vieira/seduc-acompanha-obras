@extends('layouts.restrito.admin')

@section('content-page')
<div class="px-4 container-fluid">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <h1 class="mt-3">Lista de Atividades</h1>
    </div>
    <div class="mb-1 d-flex align-items-center justify-content-between">
        {{-- 
            Acessando modelos relacionados sem a necessidade de foreach. 
            Obs, Como o relacionamento de obra, escola são do tipo tem um, não há a necessidade de colocarmos 
            ['obra'][0]['escola']['nome'], pois para o conjunto de atividades[0] exite apenas uma obra e para
            cada obra existe apenas uma escola 
        --}}
        <h6 class="mt-1"> {{ $atividades[0]['obra']['escola']['nome'] }}</h6>
    </div>

    <div class="row mt-4 ">
        <div class="col-xl-3 col-md-6">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Atividade</th>
                    <th scope="col">Apagar</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ($atividades as $atividade)
                    <tr>
                        <td>
                            {{ \Carbon\Carbon::parse($atividade->data_registro)->format('d-m-Y') }}
                            &nbsp;({{ $atividade->progresso }}%)
                            &nbsp;{{ $atividade->registro }}
                        </td>
                        <td>
                            <form id="formDelete{{ $atividade->id }}" method="POST" action="{{ route('atividade.destroy', ['atividade' => $atividade->id]) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="mb-1 btn btn-secondary btn-sm me-1  btnDelete" data-delete-entidade="Atividade" data-delete-id="{{ $atividade->id }}"  data-value-record="{{ $atividade->data_registro }}">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <div class="alert alert-danger" role="alert">Sem obras para registrar atividades!</div>
                    @endforelse
                </tbody>
              </table>
        </div>
    </div>
</div>


@endsection

