@extends('layouts.restrito.admin')

@section('content-page')
    <div class="px-4 container-fluid">
        <div class="gap-2 mb-1 hstack">
            <h2 class="mt-3">Obras - edição</h2>
        </div>

        <div class="mb-4 shadow card border-light">
            <div class="gap-2 card-header hstack">
                <span class="p-3 small text-danger"><strong>Campo marcado com * é de preenchimento obrigatório!</strong></span>
            </div>

            <div class="card-body">

                {{-- <x-alert /> --}}

                <form action="{{ route('obra.update', ['obra' => $obra->id]) }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')

                    <div class="mb-3 row">
                        {{-- tipoobra_id --}}
                        <div class="col-2">
                            <div class="form-group focused">
                                <label class="form-control-label" for="tipoobra_id">Tipo<span class="small text-danger">*</span></label>
                                <select name="tipoobra_id" id="tipoobra_id" class="form-control select2" required>
                                    <option value="" selected disabled>Escolha...</option>
                                    @foreach($tipoobras  as $tipoobra)
                                        <option value="{{ $tipoobra->id }}" {{old('tipoobra_id', $obra->tipoobra->id) == $tipoobra->id ? 'selected' : ''}}>{{$tipoobra->nome}}</option>
                                    @endforeach
                                </select>
                                @error('tipoobra_id')
                                    <small style="color: red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- escola_id --}}
                        <div class="col-4">
                            <div class="form-group focused">
                                <label class="form-control-label" for="escola_id">Escola<span class="small text-danger">*</span></label>
                                <select name="escola_id" id="escola_id" class="form-control select2" required>
                                    <option value="" selected disabled>Escolha...</option>
                                    @foreach($escolas  as $escola)
                                        <option value="{{ $escola->id }}" {{old('escola_id', $obra->escola->id) == $escola->id ? 'selected' : ''}}>{{$escola->nome}}</option>
                                    @endforeach
                                </select>
                                @error('escola_id')
                                    <small style="color: red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- data_inicio --}}
                        <div class="col-2">
                            <div class="form-group focused">
                                <label class="form-control-label" for="data_inicio">Data Inicial<span class="small text-danger">*</span></label>
                                <input type="date" id="data_inicio" class="form-control" name="data_inicio" value="{{ old('data_inicio', $obra->data_inicio) }}" required >
                                @error('data_inicio')
                                    <small style="color: red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- data_fim --}}
                        <div class="col-2">
                            <div class="form-group focused">
                                <label class="form-control-label" for="data_fim">Data Final<span class="small text-danger">*</span></label>
                                <input type="date" id="data_fim" class="form-control" name="data_fim" value="{{ old('data_fim', $obra->data_fim) }}" required>
                                @error('data_fim')
                                    <small style="color: red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- ativo --}}
                        <div class="col-2">
                            <div class="form-group focused"  style="margin-left: 120px;">
                                <label class="form-control-label" for="ativo">Ativo ? <span class="small text-danger">*</span></label>
                                <div style="margin-top: 5px">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="ativo" id="ativosim" value="1" {{old('ativo', $obra->ativo) == '1' ? 'checked' : ''}} required>
                                        <label class="form-check-label" for="ativosim">Sim</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="ativo" id="ativonao" value="0" {{old('ativo', $obra->ativo) == '0' ? 'checked' : ''}} required>
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

                    <div class="mb-3 row">
                        {{-- descricao --}}
                        <div class="col-12">
                            <div class="form-group focused">
                                <label class="form-control-label" for="descricao">Descricao<span class="small text-danger">*</span></label>
                                <textarea class="form-control" id="descricao" name="descricao" required>{{ old('descricao', $obra->descricao) }}</textarea>
                                @error('descricao')
                                    <small style="color: red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- objetos_id--}}
                    <fieldset style="margin-top: 40px; border: 1px solid #dddbdb; padding: 5px; border-radius: 7px;">
                        @error('objetos') <small style="color: red">{{$message}}</small> @enderror
                        <legend style="text-align: center; background: #e9e5e5; margin-bottom: 30px;">
                            OBJETOS
                        </legend>
                        <div class="mb-3 row">
                                @foreach ($objetos as $objeto)
                                    <div class="col-lg-3" style="padding-bottom: 10px;">
                                        <div>
                                            <input type="checkbox" id="objeto_{{$objeto->id}}" name="objetos[]" value="{{$objeto->id}}"
                                            @if(old('objetos'))
                                                {{-- Verifica se o id do objeto atual(do loop atual, está dentro do array de objetos retornado pela diretriz old('objetos'),
                                                     estando, ele faz o 'checked' --}}
                                                {{ in_array($objeto->id, old('objetos')) ? 'checked' : '' }}
                                            @else
                                                {{ $obra->objetos->contains($objeto->id) ? 'checked' : '' }}
                                            @endif
                                            >
                                            <label for="objeto_{{$objeto->id}}">{{$objeto->nome}}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                    </fieldset>


                    <!-- Buttons -->
                    <div class="row">
                        <div class="flex-row-reverse d-flex col-12">
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
