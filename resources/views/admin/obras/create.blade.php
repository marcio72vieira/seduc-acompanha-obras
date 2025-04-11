@extends('layouts.restrito.admin')

@section('content-page')
    <div class="container-fluid px-4">
        <div class="mb-1 hstack gap-2">
            <h2 class="mt-3">Obras - cadastro</h2>
        </div>

        <div class="card mb-4 border-light shadow">
            <div class="card-header hstack gap-2">
                <span class="small text-danger p-3"><strong>Campo marcado com * é de preenchimento obrigatório!</strong></span>
            </div>

            <div class="card-body">

                {{-- <x-alert /> --}}

                <form action="{{ route('obra.store') }}" method="POST" autocomplete="off">
                    @csrf
                    @method('POST')

                    <div class="row mb-3">
                        {{-- descricao --}}
                        <div class="col-6">
                            <div class="form-group focused">
                                <label class="form-control-label" for="descricao">Descricao<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control" id="descricao" name="descricao" value="{{old('descricao')}}"  >
                                @error('descricao')
                                    <small style="color: red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- escola_id --}}
                        <div class="col-6">
                            <div class="form-group focused">
                                <label class="form-control-label" for="escola_id">Escola<span class="small text-danger">*</span></label>
                                <select name="escola_id" id="escola_id" class="form-control select2" >
                                    <option value="" selected disabled>Escolha...</option>
                                    @foreach($escolas  as $escola)
                                        <option value="{{$escola->id}}" {{old('escola_id') == $escola->id ? 'selected' : ''}}>{{$escola->nome}}</option>
                                    @endforeach
                                </select>
                                @error('escola_id')
                                    <small style="color: red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row  mb-3">
                        {{-- data_inicio --}}
                        <div class="col-2">
                            <div class="form-group focused">
                                <label class="form-control-label" for="data_inicio">Data Inicial<span class="small text-danger">*</span></label>
                                <input type="date" id="data_inicio" class="form-control" name="data_inicio" value="{{old('data_inicio')}}" >
                                @error('data_inicio')
                                    <small style="color: red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- data_fim --}}
                        <div class="col-2">
                            <div class="form-group focused">
                                <label class="form-control-label" for="data_fim">Data Final<span class="small text-danger">*</span></label>
                                <input type="date" id="data_fim" class="form-control" name="data_fim" value="{{old('data_fim')}}" >
                                @error('data_fim')
                                    <small style="color: red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- ativo --}}
                        <div class="col-2">
                            <div class="form-group focused"  style="margin-left: 40px;">
                                <label class="form-control-label" for="ativo">Ativo ? <span class="small text-danger">*</span></label>
                                <div style="margin-top: 5px">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="ativo" id="ativosim" value="1" {{old('ativo') == '1' ? 'checked' : ''}} >
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
                    </div>

                    <!-- Buttons -->
                    <div class="row">
                        <div class="d-flex flex-row-reverse col-12">
                            <div style="margin-top: 15px">
                                <a class="btn btn-outline-secondary" href="{{ route('obra.index')}}" role="button">Cancelar</a>
                                <button type="submit" class="btn btn-primary" style="width: 95px;"> Salvar </button>
                            </div>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
@endsection
