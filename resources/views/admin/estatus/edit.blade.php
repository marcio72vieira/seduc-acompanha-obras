@extends('layouts.restrito.admin')

@section('content-page')
    <div class="px-4 container-fluid">
        <div class="gap-2 mb-1 hstack">
            <h2 class="mt-3">ESTATUS -  edição</h2>
        </div>

        <div class="mb-4 shadow card border-light">
            <div class="gap-2 card-header hstack">
                <span class="p-2 small text-danger"><strong>Campo marcado com * é de preenchimento obrigatório!</strong></span>
            </div>

            <div class="card-body">

                {{-- <x-alert /> --}}

                <form action="{{ route('estatu.update', ['estatu' => $estatu->id]) }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')

                    {{-- nome --}}
                    <div class="mb-4 row">
                        <label for="nome" class="col-sm-2 col-form-label">Nome <span class="small text-danger">*</span></label>
                        <div class="col-sm-2">
                          <input type="text" name="nome" value="{{ old('nome', $estatu->nome) }}" class="form-control" id="nome" placeholder="Nome do estatus" >
                          @error('nome')
                              <small style="color: red">{{$message}}</small>
                          @enderror
                        </div>
                    </div>

                    {{-- valormin --}}
                    <div class="mb-4 row">
                        <label for="valormin" class="col-sm-2 col-form-label">Valor Mínimo <span class="small text-danger">*</span></label>
                        <div class="col-sm-2">
                            <input type="number" name="valormin" value="{{ old('valormin', $estatu->valormin) }}" class="form-control" id="valormin"  min="0" max="100">
                            @error('valormin')
                              <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- valormax --}}
                    <div class="mb-4 row">
                        <label for="valormax" class="col-sm-2 col-form-label">Valor Máximo <span class="small text-danger">*</span></label>
                        <div class="col-sm-2">
                            <input type="number" name="valormax" value="{{ old('valormax', $estatu->valormax) }}" class="form-control" id="valormax"  min="0" max="100">
                            @error('valormax')
                              <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- cor --}}
                    <div class="mb-4 row">
                        <label for="cor" class="col-sm-2 col-form-label">cor <span class="small text-danger">*</span></label>
                        <div class="col-sm-2">
                          <input type="color" name="cor" value="{{ old('cor', $estatu->cor) }}" class="form-control" id="cor">
                          @error('cor')
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
                                    <input class="form-check-input" type="radio" name="ativo" id="ativosim" value="1"  {{old('ativo', $estatu->ativo) == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="ativosim">Sim</label>

                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ativo" id="ativonao" value="0"  {{old('ativo', $estatu->ativo) == '0' ? 'checked' : ''}}>
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
                                <a class="btn btn-outline-secondary" href="{{ route('estatu.index')}}" role="button">Cancelar</a>
                                <button type="submit" class="btn btn-primary" style="width: 95px;"> Salvar </button>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
