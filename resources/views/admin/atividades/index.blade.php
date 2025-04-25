@extends('layouts.restrito.admin')

@section('content-page')
<div class="px-4 container-fluid">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <h1 class="mt-3">Registro de Atividades</h1>
    </div>

    <div class="row mt-4 ">
        <div class="col-xl-3 col-md-6">
            @forelse ($obras as $obra)
                <div class="card bg-primary text-white mb-4" style="background: {{ $obra->estatu->cor }}">
                    <div class="card-header">
                        <h6>{{ $obra->escola->nome }}</h6>
                    </div>
                    <div class="card-body">
                        Tipo: {{ Str::lower($obra->tipoobra->nome) }}
                        <br>
                        Prazo: de {{ \Carbon\Carbon::parse($obra->data_inicio)->format('d-m-Y') }} a {{ \Carbon\Carbon::parse($obra->data_fim)->format('d-m-Y') }}
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="#">Tipo: {{ Str::lower($obra->tipoobra->nome) }}</a>
                        <a href="{{ route('atividade.create', ['obra' => $obra->id]) }}" class="mb-1 btn btn-secondary btn-sm me-1" title="registrar atividades"> <i class="fa-solid fa-keyboard"></i> Registrar</a>
                        {{-- <div class="small text-white"><i class="fas fa-angle-right"></i></div> --}}
                    </div>
                </div>
            @empty
                <div class="alert alert-danger" role="alert">Sem obras para registrar atividades!</div>
            @endforelse

        </div>
    </div>
</div>


@endsection

