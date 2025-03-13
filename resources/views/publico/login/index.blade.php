@extends('layouts.publico.login')

@section('content-page')
    <div class="col-lg-4">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header">
                {{-- <h3 class="text-center font-weight-light my-4">ALUGUEL MARIA DA PENHA<br>Login</h3> --}}
            </div>
            <div class="card-body">

                <x-alert />

                <h5 style="margin-left: 50px; color: #021a70; ">ACOMPANHAMENTO DE OBRAS</h4>

                <form action="{{ route('login.processalogin') }}" method="POST" style="padding: 10px;">
                    @csrf
                    @method('POST')

                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control"  style="border: 1px solid   #4476ed;" id="email" placeholder="E-mail do usuário" value="{{ old('email') }}">
                        <label for="email">E-mail</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control" style="border: 1px solid   #4476ed;" id="password" placeholder="Senha">
                        <label for="password">Senha</label>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <a href="{{ route('forgot-password.show') }}" class="small text-decoration-none">Esqueceu a senha?</a>
                        <button type="submit" class="btn btn-sm" style="background-color:  #4476ed; color: white;">Acessar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
