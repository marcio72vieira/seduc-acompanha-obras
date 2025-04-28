@extends('layouts.restrito.admin')

@section('content-page')
    <div class="px-4 container-fluid">
        {{-- <div class="gap-2 mb-1 hstack"> <h2 class="mt-3">REGISTRO DE ATIVIDADES</h2> </div>
        <div class="gap-2 mb-1 hstack"> <h4 class="mt-3">{{ $obra->escola->nome }}</h4> </div> --}}
        <div class="mb-1 d-flex align-items-center justify-content-between">
            <h1 class="mt-3">Registro de Atividades</h1>
        </div>
        <div class="mb-1 d-flex align-items-center justify-content-between">
            <h6 class="mt-1">{{ $obra->escola->nome }}</h6>
        </div>

        <div class="mb-4 shadow card border-light">
            <div class="gap-2 card-header hstack">
                <span class="p-2 small text-danger"><strong>Campo com * são obrigatório!</strong></span>
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

                    {{-- obraconcluida --}}
                    <div class="mb-4 row" id="regiaoobraconcluida" style="visibility:hidden">
                        <label for="obraconcluidasim" class="col-sm-2 col-form-label">Obra Concluida ? <span class="small text-danger">*</span></label>
                        <div class="col-sm-10">
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="obraconcluida" id="obraconcluidasim" value="1" {{old('obraconcluida') == '1' ? 'checked' : ''}} reuired>
                                    <label class="form-check-label" for="obraconcluidasim">Sim</label>

                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="obraconcluida" id="obraconcluidanao" value="0" {{old('obraconcluida') == '0' ? 'checked' : ''}} >
                                    <label class="form-check-label" for="obraconcluidanao">Não</label>
                                </div>
                                <br>
                                @error('obraconcluida')
                                    <small style="color: red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- observacao --}}
                    <div class="mb-4 row">
                        <label for="observacao" class="col-sm-2 col-form-label">Observação</label>
                        <div class="col-sm-5">
                        <textarea rows="3" class="form-control" id="observacao" name="observacao" > {{ old('observacao') }} </textarea>
                          @error('observacao')
                              <small style="color: red">{{$message}}</small>
                          @enderror
                        </div>
                    </div>


                    <div class="mb-4 row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-5">
                            <div style="margin-top: 15px">
                                <div class="d-flex justify-content-end">
                                <a class="btn btn-outline-secondary" href="{{ route('atividade.index')}}" role="button">Cancelar</a>
                                <button type="submit" class="btn btn-primary" style="margin-left: 10px; width: 95px;"> Salvar </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Este teste se faz necessário, uma vez que "#regiaoobraconcluida" está "oculto" por default. Caso haja falha de validação
        // toda a div(#regiaoobraconcluida) com o respectivo erro de validação não seriam exibidos de forma apropriada para o usuário
        // final ao recarregar a página com relação aos erros.
        if($("#progresso").val() == 100){
            $("#regiaoobraconcluida").css("visibility","visible");
        }

        $("#progresso").blur(function(){
            if($(this).val() == 100) {
                $("#regiaoobraconcluida").css("visibility","visible");
                $("#obraconcluidasim").focus();
                //$("#obraconcluidasim").prop("checked", true);
            }else{
                $("#obraconcluidanao").prop("checked", true);
                $("#regiaoobraconcluida").css("visibility","hidden");
                $("#observacao").focus();
            }
        });
    </script>
@endsection
