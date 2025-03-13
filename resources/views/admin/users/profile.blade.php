@extends('layouts.restrito.admin')

@section('content-page')
    <div class="container-fluid px-4">
        <div class="mb-1 hstack gap-2">
            <h2 class="mt-3">USUÁRIO -  editar perfil</h2>
        </div>

        <div class="card mb-4 border-light shadow">
            <div class="card-header hstack gap-2">
                <span class="small text-danger p-2"><strong>Campo marcado com * é de preenchimento obrigatório!</strong></span>
            </div>

            <div class="card-body">

                {{-- Este componente será acionado sempre que houver uma erro de exceção em: store, update ou delete --}}
                <x-errorexception />

                <x-alert />

                <form action="{{ route('user.updateprofile', ['user' => $user->id]) }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')

                    {{-- preservando os valores dos campos que não podem ser alterados pelo usuário --}}
                    <input type="hidden" name="old_perfil_hidden" value="{{ $user->perfil }}">
                    <input type="hidden" name="old_ativo_hidden" value="{{ $user->ativo }}">

                    {{-- preservando a antiga senha do usuario --}}
                    <input type="hidden" name="old_password_hidden" value="{{ $user->password }}">


                    {{-- nomecompleto --}}
                    <div class="mb-4 row">
                        <label for="nomecompleto" class="col-sm-2 col-form-label">Nome Completo <span class="small text-danger">*</span></label>
                        <div class="col-sm-10">
                          <input type="text" name="nomecompleto" value="{{ old('nomecompleto', $user->nomecompleto) }}" class="form-control" id="nomecompleto" placeholder="Nome completo" >
                          @error('nomecompleto')
                              <small style="color: red">{{$message}}</small>
                          @enderror
                        </div>
                    </div>


                    {{-- nome --}}
                    <div class="mb-4 row">
                        <label for="nome" class="col-sm-2 col-form-label">Usuário <span class="small text-danger">*</span></label>
                        <div class="col-sm-10">
                          <input type="text" name="nome" value="{{ old('nome', $user->nome) }}" class="form-control" id="nome" placeholder="Nome de usuário" >
                          @error('nome')
                              <small style="color: red">{{$message}}</small>
                          @enderror
                        </div>
                    </div>


                    {{-- cpf --}}
                    <div class="mb-4 row">
                        <label for="cpf" class="col-sm-2 col-form-label">CPF <span class="small text-danger">*</span></label>
                        <div class="col-sm-10">
                          <input type="text" name="cpf" value="{{ old('cpf', $user->cpf) }}" class="form-control cpf" id="cpf" placeholder="CPF (só números)" >
                          @error('cpf')
                              <small style="color: red">{{$message}}</small>
                          @enderror
                        </div>
                    </div>


                    {{-- cargo --}}
                    <div class="mb-4 row">
                        <label for="cargo" class="col-sm-2 col-form-label">Cargo <span class="small text-danger">*</span></label>
                        <div class="col-sm-10">
                          <input type="text" name="cargo" value="{{ old('cargo', $user->cargo) }}" class="form-control" id="cargo" placeholder="Digite o cargo" >
                          @error('cargo')
                              <small style="color: red">{{$message}}</small>
                          @enderror
                        </div>
                    </div>


                    {{-- fone --}}
                    <div class="mb-4 row">
                        <label for="fone" class="col-sm-2 col-form-label">Telefone <span class="small text-danger">*</span></label>
                        <div class="col-sm-10">
                          <input type="text" name="fone" value="{{ old('fone', $user->fone) }}" class="form-control  mask-cell" id="fone" placeholder="Telefone (só números)" >
                          @error('fone')
                              <small style="color: red">{{$message}}</small>
                          @enderror
                        </div>
                    </div>


                    {{-- email --}}
                    <div class="mb-4 row">
                        <label for="email" class="col-sm-2 col-form-label">E-mail <span class="small text-danger">*</span></label>
                        <div class="col-sm-10">
                          <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" id="email" placeholder="Melhor e-mail" >
                          @error('email')
                              <small style="color: red">{{$message}}</small>
                          @enderror
                        </div>
                    </div>

                    <br><hr><br>

                    {{-- password --}}
                    <div class="mb-4 row">
                        <label for="password" class="col-sm-2 col-form-label">Senha <span class="small text-danger">*</span></label>
                        <div class="col-sm-10">
                          <input type="password" name="password" value="{{ old('password') }}" class="form-control" id="password" placeholder="Senha" >
                          @error('password')
                              <small style="color: red">{{$message}}</small>
                          @enderror
                        </div>
                    </div>


                    {{-- password_confirmation --}}
                    <div class="mb-4 row">
                        <label for="password_confirmation" class="col-sm-2 col-form-label">Confirmar Senha <span class="small text-danger">*</span></label>
                        <div class="col-sm-10">
                          <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" class="form-control" id="password_confirmation" placeholder="Confirme a senha" >
                          @error('password_confirmation')
                              <small style="color: red">{{$message}}</small>
                          @enderror
                        </div>
                    </div>


                    <div class="mb-4 row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <div style="margin-top: 15px">
                                <a class="btn btn-outline-secondary" href="{{ route('user.index')}}" role="button">Cancelar</a>
                                <button type="submit" class="btn btn-primary" style="width: 95px;"> Salvar </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
