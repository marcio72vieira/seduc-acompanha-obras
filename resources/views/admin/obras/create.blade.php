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

                    <div class="row">
                        {{-- descricao --}}
                        <div class="col-6">
                            <div class="form-group focused">
                                <label class="form-control-label" for="descricao">Descricao<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control" id="descricao" name="descricao" value="{{old('descricao')}}" required >
                                @error('descricao')
                                    <small style="color: red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- data_ini --}}
                        <div class="col-2">
                            <div class="form-group focused">
                                <label class="form-control-label" for="data_ini">Data Inicial<span class="small text-danger">*</span></label>
                                <input type="date" id="data_ini" class="form-control" name="data_ini" value="{{old('data_ini')}}" required>
                                <input type="hidden" name="data_ini_hidden" id="data_ini_hidden"  value="">
                                @error('data_ini')
                                    <small style="color: red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- data_fin --}}
                        <div class="col-2">
                            <div class="form-group focused">
                                <label class="form-control-label" for="data_fin">Data Final<span class="small text-danger">*</span></label>
                                <input type="date" id="data_fin" class="form-control" name="data_fin" value="{{old('data_fin')}}" required>
                                <input type="hidden" name="data_fin_hidden" id="data_fin_hidden"  value="">
                                @error('data_fin')
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
                        <div class="row">
                            <div class="d-flex flex-row-reverse col-12">
                                <div style="margin-top: 15px">
                                    <a class="btn btn-outline-secondary" href="{{ route('obra.index')}}" role="button">Cancelar</a>
                                    <button type="submit" class="btn btn-primary" style="width: 95px;"> Salvar </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>


            </div>
        </div>
    </div>
@endsection
