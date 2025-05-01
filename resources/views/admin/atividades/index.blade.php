@extends('layouts.restrito.admin')

@section('content-page')
<div class="px-4 container-fluid">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <h1 class="mt-3">Registro de Atividades</h1>
    </div>

    <div class="mt-4 row ">
        <div class="col-xl-3 col-md-6">
            @forelse ($obras as $obra)
                <div class="mb-4 text-white card bg-primary" style="background: {{ $obra->estatu->cor }}">
                    <div class="card-header">
                        <h6>{{ $obra->escola->nome }} ({{ $obra->escola->municipio->nome }})</h6>
                    </div>
                    <div class="card-body">
                        Tipo: {{ Str::lower($obra->tipoobra->nome) }}
                        <br>
                        Prazo: de {{ \Carbon\Carbon::parse($obra->data_inicio)->format('d-m-Y') }} a {{ \Carbon\Carbon::parse($obra->data_fim)->format('d-m-Y') }}
                        <br>
                        Reponsável: {{ Auth::user()->nome }}
                        {{-- <br>Comentário: <i class="fa-solid fa-comment"></i> --}}
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <span>Nº atividades: {{ $obra->atividades->count() }}</span>
                        {{-- <div class="card-footer d-flex align-items-center justify-content-end"> --}}
                        {{-- <a href="{{ route('obra.relpdfobraatividade', ['obra' => $obra->id]) }}" class="mb-1 btn btn-light btn-sm me-1">pdf</a> --}}
                        <a href="{{ route('atividade.indexregistros', ['obra' => $obra->id]) }}" class="mb-1 btn btn-light btn-sm me-1" title="listar atividades"> <i class="fa-solid fa-list"></i> Listar</a>

                        {{-- Se o estatu da obra for concluída, o usuário não poderá mais registrar atividades, só alterar e apagar, e alterando, poderá reverter o status da mesma --}}
                        @if($obra->estatu->id == 3)
                            <a href="" class="mb-1 btn btn-light btn-sm me-1" title="registrar atividades"> <i class="fa-solid fa-ban"></i> Registrar</a>
                        @else
                            <a href="{{ route('atividade.create', ['obra' => $obra->id]) }}" class="mb-1 btn btn-light btn-sm me-1" title="registrar atividades"> <i class="fa-solid fa-keyboard"></i> Registrar</a>
                        @endif
                        {{-- <div class="text-white small"><i class="fas fa-angle-right"></i></div> --}}
                    </div>
                </div>
            @empty
                <div class="alert alert-danger" role="alert">Sem obras para registrar atividades!</div>
            @endforelse
        </div>
    </div>
</div>


@endsection

