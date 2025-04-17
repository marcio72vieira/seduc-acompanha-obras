@extends('layouts.restrito.admin')

@section('content-page')
    <div class="px-4 container-fluid">
        <div class="gap-2 mb-1 hstack">
            <h2 class="mt-3">OBRA -  visualizar</h2>
        </div>

        <div class="mb-4 shadow card border-light">
            <div class="gap-2 card-header hstack">
                <span class="p-2 small"><strong> Detalhes </strong></span>
            </div>

            <div class="card-body">

                <dl class="row">

                    <dt class="col-sm-2">Id</dt>
                    <dd class="col-sm-10">{{ $obra->id }}</dd>

                    <dt class="col-sm-2">Tipo</dt>
                    <dd class="col-sm-10" style="margin-bottom: 30px;">{{ $obra->tipoobra->nome }}</dd>

                    <dt class="col-sm-2">Escola</dt>
                    <dd class="col-sm-10">{{ $obra->escola->nome }}</dd>

                    <dt class="col-sm-2"></dt>
                    <dd class="col-sm-10">{{ $obra->escola->endereco }}, nº {{ $obra->escola->numero }}. Complemento: {{ $obra->escola->complemento }}. Bairro: {{ $obra->escola->bairro }}. CEP: {{ $obra->escola->cep }} </dd>

                    <dt class="col-sm-2"></dt>
                    <dd class="col-sm-10">Fone: {{ $obra->escola->fone }}</dd>

                    <dt class="col-sm-2"></dt>
                    <dd class="col-sm-10">Município: {{ $obra->escola->municipio->nome }}</dd>

                    <dt class="col-sm-2"></dt>
                    <dd class="col-sm-10" style="margin-bottom: 50px;">Regional: {{ $obra->escola->regional->nome }}</dd>

                    <dt class="col-sm-2">Data Inío e FIm</dt>
                    <dd class="col-sm-10">{{ \Carbon\Carbon::parse($obra->data_inicio)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($obra->data_fim)->format('d/m/Y') }}</dd>

                    <dt class="col-sm-2">Objetos</dt>
                    <dd class="col-sm-10" style="margin-bottom: 20px;">
                        @foreach ($obra->objetos as $objeto)
                            {{ $objeto->nome }},
                        @endforeach
                    </dd>

                    <dt class="col-sm-2">Descrição</dt>
                    <dd class="col-sm-10" style="margin-bottom: 50px;">{{ $obra->descricao }}</dd>

                    <dt class="col-sm-2">Responsável(is)</dt>
                    <dd class="col-sm-10" style="margin-bottom: 50px;">
                        @foreach ($obra->users as $user)
                            {{ $user->nomecompleto }} ({{ ($user->perfil == 'adm' ? 'Administrador' : ($user->perfil == 'con' ? 'Consultor' : 'Operador')) }})
                            <br>
                        @endforeach
                    </dd>

                    <dt class="col-sm-2">Ativo</dt>
                    <dd class="col-sm-10">{{ $obra->ativo == 1 ? 'Sim' : 'Não' }}</dd>
                    
                    <dt class="col-sm-2">Status</dt>
                    <dd class="col-sm-10">{{ $obra->estatus == 1 ? '0% Criada' : 'Iniciada'}}</dd>
                </dl>

                <dl class="row">
                    <dt class="col-sm-2"></dt>
                    <dd class="col-sm-10">
                        <a class="btn btn-outline-secondary" href="{{ route('obra.index')}}" role="button">Listar</a>
                        <a class="btn btn-outline-secondary" href="{{ route('obra.relpdfobra', ['obra' => $obra->id]) }}" role="button" target="_blank">pdf</a>
                    </dd>
                </dl>

            </div>
        </div>
    </div>
@endsection
