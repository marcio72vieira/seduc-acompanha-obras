@extends('layouts.restrito.admin')

@section('content-page')
    <div class="container-fluid px-4">
        <div class="mb-1 hstack gap-2">
            <h2 class="mt-3">Municípios - edição</h2>
        </div>

        <div class="card mb-4 border-light shadow">
            <div class="card-header hstack gap-2">
                <span class="small text-danger"><strong>Campo marcado com * é de preenchimento obrigatório!</strong></span>
            </div>

            <div class="card-body">

                {{-- <x-alert /> --}}

                <form action="{{ route('municipio.update', ['municipio' => $municipio->id]) }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        {{-- Nome --}}
                        <div class="col-4">
                            <div class="form-group focused">
                                <label class="form-control-label" for="nome">Nome<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $municipio->nome) }}" placeholder="Nome do Município" required >
                                @error('nome')
                                    <small style="color: red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- regional_id --}}
                        <div class="col-4">
                            <div class="form-group focused">
                                <label class="form-control-label" for="regional_id">Regional<span class="small text-danger">*</span></label>
                                <select name="regional_id" id="regional_id" class="form-control select2" required>
                                    <option value="" selected disabled>Escolha...</option>
                                    @foreach($regionais  as $regional)
                                        <option value="{{ $regional->id }}" {{ old('regional_id', $municipio->regional->id) == $regional->id ? 'selected' : ''}}>{{$regional->nome}}</option>
                                    @endforeach
                                </select>
                                @error('regional_id')
                                    <small style="color: red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- ativo --}}
                        <div class="col-2">
                            <div class="form-group focused">
                                <label class="form-control-label" for="ativo">Ativo ? <span class="small text-danger">*</span></label>
                                <div style="margin-top: 7px">
                                    <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="ativo" id="ativosim" value="1" {{old('ativo', $municipio->ativo) == '1' ? 'checked' : ''}} required>
                                        <label class="form-check-label" for="ativosim">Sim</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="ativo" id="ativonao" value="0" {{old('ativo', $municipio->ativo) == '0' ? 'checked' : ''}} required>
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
                        <div class="col-2 flex-row d-md-flex justify-content-end">
                                <div style="margin-top: 15px">
                                    <a class="btn btn-outline-secondary" href="{{ route('municipio.index')}}" role="button">Cancelar</a>
                                    <button type="submit" class="btn btn-primary" style="width: 95px;"> Salvar </button>
                                </div>
                        </div>

                    </div>
                </form>


            </div>
        </div>
    </div>
@endsection
