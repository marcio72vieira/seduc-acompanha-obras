@extends('layouts.restrito.admin')

@section('content-page')
    <div class="container-fluid px-4">
        <div class="mb-1 hstack gap-2">
            <h2 class="mt-3">Programas - cadastro</h2>
        </div>

        <div class="card mb-4 border-light shadow">
            <div class="card-header hstack gap-2">
                <span class="small text-danger p-3"><strong>Campo marcado com * é de preenchimento obrigatório!</strong></span>
            </div>

            <div class="card-body">

                {{-- <x-alert /> --}}

                <form action="{{ route('programa.store') }}" method="POST" autocomplete="off">
                    @csrf
                    @method('POST')

                    <div class="row">
                        {{-- Nome --}}
                        <div class="col-6">
                            <div class="form-group focused">
                                <label class="form-control-label" for="nome">Nome<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control" id="nome" name="nome" value="{{old('nome')}}" required >
                                @error('nome')
                                    <small style="color: red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- ativo --}}
                        <div class="col-4">
                            <div class="form-group focused">
                                <label class="form-control-label" for="ativo">Ativo ? <span class="small text-danger">*</span></label>
                                <div style="margin-top: 5px">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="ativo" id="ativosim" value="1" {{old('ativo') == '1' ? 'checked' : ''}} required>
                                        <label class="form-check-label" for="ativosim">Sim</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="ativo" id="ativonao" value="0" {{old('ativo') == '0' ? 'checked' : ''}} required>
                                        <label class="form-check-label" for="ativonao">Não</label>
                                    </div>
                                    @error('ativo')
                                        <small style="color: red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="col-2 flex-row d-md-flex justify-content-end">
                            <div style="margin-top: 15px">
                                <a class="btn btn-outline-secondary" href="{{ route('programa.index')}}" role="button">Cancelar</a>
                                <button type="submit" class="btn btn-primary" style="width: 95px;"> Salvar </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
