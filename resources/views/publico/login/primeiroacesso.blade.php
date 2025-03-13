@extends('layouts.publico.login')

@section('content-page')
    <div class="col-lg-7" style="margin-top: -30px">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header">
                {{-- <h3 class="text-center font-weight-light my-4">Primeiro Acesso</h3> --}}
            </div>
            <div class="card-body">

                <h3 style="margin-left: 250px; color:  #021a70; ">PRIMEIRO ACESSO</h3>
                <x-alert />

                <form action="{{ route('login.store-user') }}" method="POST">
                    @csrf
                    @method('POST')

                    <input type="hidden" name="hidden_password_atual" value="{{ $user->password }}">

                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control" id="email" placeholder="E-mail" value="{{ old('email') }}">
                        <label for="email">E-mail</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="passwordatual" class="form-control" id="passwordatual" placeholder="Senha atual" value="{{ old('passwordatual') }}">
                        <label for="passwordatual">Senha atual</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Nova senha" value="{{ old('password') }}">
                        <label for="password">Nova senha</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirme a nova senha" value="{{ old('password_confirmation') }}">
                        <label for="password_confirmation">Confirmar nova senha</label>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        {{-- <a href="#" class="small text-decoration-none">Cancelar!</a> --}}
                        <button type="submit" class="btn btn-primary btn-sm">Redefinir</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">
                <div class="small">
                    <a href="{{ route('login.index') }}" class="text-decoration-none">Clique aqui</a> para acessar
                </div>
            </div>
        </div>
    </div>
@endsection

