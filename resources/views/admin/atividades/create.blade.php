@extends('layouts.restrito.admin')

@section('content-page')
    <div class="px-4 container-fluid">
        <div class="gap-2 mb-1 hstack">
            <h2 class="mt-3">REGISTRO DE ATIVIDADES -  cadastro</h2>
            <h6 class="mt-3">{{ $obra->escola->nome }}</h6>
        </div>

        <div class="mb-4 shadow card border-light">
            <div class="gap-2 card-header hstack">
                <span class="p-2 small text-danger"><strong>Campo marcado com * é de preenchimento obrigatório!</strong></span>
            </div>

            <div class="card-body">

                {{-- <x-alert /> --}}

                <form action="{{ route('atividade.store') }}" method="POST" autocomplete="off">
                    @csrf
                    @method('POST')

                    {{-- Definindo o usuário e a obra atual --}}
                    <input type="hidden" name="user_hidden" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="obra_hidden" value="{{ $obra->id }}">

                    {{-- data_registro --}}
                    <div class="mb-4 row">
                        <label for="tipo" class="col-sm-2 col-form-label">Data Registro <span class="small text-danger">*</span></label>
                        <div class="col-sm-2">
                            <input type="date" id="data_registro" class="form-control" name="data_registro" value="{{old('data_registro')}}" >
                            @error('data_registro')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- registro --}}
                    <div class="mb-4 row">
                        <label for="registro" class="col-sm-2 col-form-label">Atividade <span class="small text-danger">*</span></label>
                        <div class="col-sm-5">
                        <textarea rows="3" class="form-control" id="descricao" name="registro" > {{ old('registro') }} </textarea>
                          @error('registro')
                              <small style="color: red">{{$message}}</small>
                          @enderror
                        </div>
                    </div>

                    {{-- progresso --}}
                    <div class="mb-4 row">
                        <label for="progresso" class="col-sm-2 col-form-label">Progresso <span class="small text-danger">*</span></label>
                        <div class="col-sm-2">
                            <input type="number" name="progresso" value="{{ old('progresso') }}" class="form-control" id="progresso"  min="1" max="100">
                            @error('progresso')
                              <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- observacao --}}
                    <div class="mb-4 row">
                        <label for="observacao" class="col-sm-2 col-form-label">Observação <span class="small text-danger">*</span></label>
                        <div class="col-sm-5">
                        <textarea rows="3" class="form-control" id="descricao" name="observacao" > {{ old('observacao') }} </textarea>
                          @error('observacao')
                              <small style="color: red">{{$message}}</small>
                          @enderror
                        </div>
                    </div>


                    <div class="mb-4 row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <div style="margin-top: 15px">
                                <a class="btn btn-outline-secondary" href="{{ route('atividade.index')}}" role="button">Cancelar</a>
                                <button type="submit" class="btn btn-primary" style="width: 95px;"> Salvar </button>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
