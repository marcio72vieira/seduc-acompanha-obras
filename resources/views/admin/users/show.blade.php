@extends('layouts.restrito.admin')

@section('content-page')
    <div class="container-fluid px-4">
        <div class="mb-1 hstack gap-2">
            <h2 class="mt-3">USUÁRIO -  visualizar</h2>
        </div>

        <div class="card mb-4 border-light shadow">
            <div class="card-header hstack gap-2">
                <span class="small p-2"><strong> Detalhes </strong></span>
            </div>

            <div class="card-body">

                <dl class="row">

                    <dt class="col-sm-2">Id</dt>
                    <dd class="col-sm-10">{{ $user->id }}</dd>

                    <dt class="col-sm-2">Nome Completo</dt>
                    <dd class="col-sm-10">{{ $user->nomecompleto }}</dd>

                    <dt class="col-sm-2">Nome</dt>
                    <dd class="col-sm-10">{{ $user->nome }}</dd>

                    <dt class="col-sm-2">CPF</dt>
                    <dd class="col-sm-10">{{ $user->cpf }}</dd>

                    <dt class="col-sm-2">Cargo</dt>
                    <dd class="col-sm-10">{{ $user->cargo }}</dd>

                    <dt class="col-sm-2">Telefone</dt>
                    <dd class="col-sm-10">{{ $user->fone }}</dd>

                    <dt class="col-sm-2">Perfil</dt>
                    {{-- <dd class="col-sm-10">{{ ($user->perfil == "adm" ? "Administrador" : ($user->perfil == "srv" ? "Servidor" : "Assistente Social")) }}</dd> --}}
                    <dd class="col-sm-10">{{ ($user->perfil == "adm" ? "Administrador" : ($user->perfil == "con" ? "Consultor" : "Operador")) }}</dd>

                    <dt class="col-sm-2">E-mail</dt>
                    <dd class="col-sm-10">{{ $user->email }}</dd>

                    <dt class="col-sm-2">Ativo</dt>
                    <dd class="col-sm-10">{{ $user->ativo == 1 ? "Sim" : "Não" }}</dd>

                </dl>

                <dl class="row">
                    <dt class="col-sm-2"></dt>
                    <dd class="col-sm-10">
                        <a class="btn btn-outline-secondary" href="{{ route('user.index')}}" role="button">Retornar</a>
                    </dd>
                </dl>

            </div>
        </div>
    </div>
@endsection
