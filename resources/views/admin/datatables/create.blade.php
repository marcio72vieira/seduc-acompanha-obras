@extends('layouts.restrito.admin')

@section('content-page')
    <div class="container-fluid px-4">
        <div class="mb-1 hstack gap-2">
            <h2 class="mt-3">USUÁRIO -  cadastro</h2>
        </div>

        <div class="card mb-4 border-light shadow">
            <div class="card-header hstack gap-2">
                <span class="small text-danger p-2"><strong>Campo marcado com * é de preenchimento obrigatório!</strong></span>
            </div>

            <div class="card-body">

                {{-- Este componente será acionado sempre que houver uma erro de exceção em: store, update ou delete --}}
                <x-errorexception />

                <form action="{{ route('user.store') }}" method="POST" autocomplete="off">
                    @csrf
                    @method('POST')

                    {{-- nomecompleto --}}
                    <div class="mb-4 row">
                        <label for="nomecompleto" class="col-sm-2 col-form-label">Nome Completo <span class="small text-danger">*</span></label>
                        <div class="col-sm-10">
                          <input type="text" name="nomecompleto" value="{{ old('nomecompleto') }}" class="form-control" id="nomecompleto" placeholder="Nome completo" >
                          @error('nomecompleto')
                              <small style="color: red">{{$message}}</small>
                          @enderror
                        </div>
                    </div>


                    {{-- nome --}}
                    <div class="mb-4 row">
                        <label for="nome" class="col-sm-2 col-form-label">Usuário <span class="small text-danger">*</span></label>
                        <div class="col-sm-10">
                          <input type="text" name="nome" value="{{ old('nome') }}" class="form-control" id="nome" placeholder="Nome de usuário" >
                          @error('nome')
                              <small style="color: red">{{$message}}</small>
                          @enderror
                        </div>
                    </div>


                    {{-- cpf --}}
                    <div class="mb-4 row">
                        <label for="cpf" class="col-sm-2 col-form-label">CPF <span class="small text-danger">*</span></label>
                        <div class="col-sm-10">
                          <input type="text" name="cpf" value="{{ old('cpf') }}" class="form-control cpf" id="cpf" placeholder="CPF (só números)" >
                          @error('cpf')
                              <small style="color: red">{{$message}}</small>
                          @enderror
                        </div>
                    </div>


                    {{-- cargo --}}
                    <div class="mb-4 row">
                        <label for="cargo" class="col-sm-2 col-form-label">Cargo <span class="small text-danger">*</span></label>
                        <div class="col-sm-10">
                          <input type="text" name="cargo" value="{{ old('cargo') }}" class="form-control" id="cargo" placeholder="Digite o cargo" >
                          @error('cargo')
                              <small style="color: red">{{$message}}</small>
                          @enderror
                        </div>
                    </div>


                    {{-- fone --}}
                    <div class="mb-4 row">
                        <label for="fone" class="col-sm-2 col-form-label">Telefone <span class="small text-danger">*</span></label>
                        <div class="col-sm-10">
                          <input type="text" name="fone" value="{{ old('fone') }}" class="form-control  mask-cell" id="fone" placeholder="Telefone (só números)" >
                          @error('fone')
                              <small style="color: red">{{$message}}</small>
                          @enderror
                        </div>
                    </div>


                    {{-- perfil --}}
                    <div class="mb-4 row">
                        <label for="perfil" class="col-sm-2 col-form-label">Perfil <span class="small text-danger">*</span></label>
                        <div class="col-sm-4">
                            <select name="perfil" id="perfil" class="form-control select2" >
                                <option value="" selected disabled>Escolha...</option>
                                <option value="adm" {{old('perfil') == 'adm' ? 'selected' : ''}}>Administrador</option>
                                <option value="con" {{old('perfil') == 'con' ? 'selected' : ''}}>Consultor</option>
                                <option value="ope" {{old('perfil') == 'ope' ? 'selected' : ''}}>Operador</option>
                            </select>
                            @error('perfil')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>


                    {{-- email --}}
                    <div class="mb-4 row">
                        <label for="email" class="col-sm-2 col-form-label">E-mail <span class="small text-danger">*</span></label>
                        <div class="col-sm-10">
                          <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="email" placeholder="Melhor e-mail" >
                          @error('email')
                              <small style="color: red">{{$message}}</small>
                          @enderror
                        </div>
                    </div>


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

                    {{-- ativo --}}
                    <div class="mb-4 row">
                        <label for="ativosim" class="col-sm-2 col-form-label">Ativo ? <span class="small text-danger">*</span></label>
                        <div class="col-sm-10">
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ativo" id="ativosim" value="1" {{old('ativo') == '1' ? 'checked' : ''}} reuired>
                                    <label class="form-check-label" for="ativosim">Sim</label>

                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ativo" id="ativonao" value="0" {{old('ativo') == '0' ? 'checked' : ''}} >
                                    <label class="form-check-label" for="ativonao">Não</label>
                                </div>
                                <br>
                                @error('ativo')
                                    <small style="color: red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <div style="margin-top: 15px">
                                <a class="btn btn-outline-secondary" href="{{ route('user.index') }}" role="button">Cancelar</a>
                                <button type="submit" class="btn btn-primary" style="width: 95px;"> Salvar </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

