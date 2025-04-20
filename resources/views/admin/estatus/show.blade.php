@extends('layouts.restrito.admin')

@section('content-page')
    <div class="px-4 container-fluid">
        <div class="gap-2 mb-1 hstack">
            <h2 class="mt-3">ESCOLA -  visualizar</h2>
        </div>

        <div class="mb-4 shadow card border-light">
            <div class="gap-2 card-header hstack">
                <span class="p-2 small"><strong> Detalhes </strong></span>
            </div>

            <div class="card-body">

                <dl class="row">

                    <dt class="col-sm-2">Id</dt>
                    <dd class="col-sm-10">{{ $escola->id }}</dd>

                    <dt class="col-sm-2">Nome</dt>
                    <dd class="col-sm-10">{{ $escola->nome }}</dd>

                    <dt class="col-sm-2">Endereço</dt>
                    <dd class="col-sm-10">{{ $escola->endereco }}</dd>

                    <dt class="col-sm-2">Nº</dt>
                    <dd class="col-sm-10">{{ $escola->numero }}</dd>

                    <dt class="col-sm-2">Complemento</dt>
                    <dd class="col-sm-10">{{ $escola->complemento }}</dd>

                    <dt class="col-sm-2">Bairro</dt>
                    <dd class="col-sm-10">{{ $escola->bairro }}</dd>

                    <dt class="col-sm-2">CEP</dt>
                    <dd class="col-sm-10">{{ $escola->cep }}</dd>

                    <dt class="col-sm-2">Telefone</dt>
                    <dd class="col-sm-10">{{ $escola->fone }}</dd>

                    <dt class="col-sm-2">Regional</dt>
                    <dd class="col-sm-10">{{ $escola->regional->nome }}</dd>

                    <dt class="col-sm-2">Município</dt>
                    <dd class="col-sm-10">{{ $escola->municipio->nome }}</dd>

                    <dt class="col-sm-2">Ativo</dt>
                    <dd class="col-sm-10">{{ $escola->ativo == 1 ? 'Sim' : 'Não' }}</dd>

                </dl>

                <dl class="row">
                    <dt class="col-sm-2"></dt>
                    <dd class="col-sm-10">
                        <a class="btn btn-outline-secondary" href="{{ route('escola.index')}}" role="button">Listar</a>
                    </dd>
                </dl>

            </div>
        </div>
    </div>
@endsection
