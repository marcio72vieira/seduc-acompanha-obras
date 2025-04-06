@extends('layouts.restrito.admin')

@section('content-page')

    <div class="px-4 container-fluid">
        <div class="mb-1 hstack gap-2">
            <h2 class="mt-3"> DATATABLE USUÁRIOS - lista</h2>
        </div>

        <div class="mb-4 shadow card border-light">
            <div class="card-header hstack gap-2">
                <span class="ms-auto d-sm-flex flex-row mt-1 mb-1">
                    <!-- Button disparar modal CadastrarUsuario -->
                    <button type="button" class="btn btn-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modalCadastrarUsuario">
                        <i class="fa-regular fa-square-plus"></i> Novo Usuário
                    </button>
                    <a href="{{ route('user.pdflistusers') }}" class="btn btn-secondary btn-sm me-1" target="_blank"><i class="fa-solid fa-file-pdf"></i> pdf</a>
                </span>
            </div>

            <div class="card-body">
                
                {{-- Aler de Sucesso --}}
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="visibility:hidden">
                    <span id="msg_success"></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

                <table id="datatablesUsers" class="table table-striped table-hover table-bordered display" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nome Completo</th>
                            <th>CPF</th>
                            <th>CARGO</th>
                            <th>PERFIL</th>
                            <th>CONTATO</th>
                        </tr>
                    </thead>
                </table>

            </div>

            <!-- Inicio Modal CadastrarUsuario -->
            <form id="formCadastrarUsuario" action="{{ route('user.store') }}" method="POST" autocomplete="off">
            @csrf
            @method('POST')
                <div class="modal fade" id="modalCadastrarUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCadastrarUsuarioLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCadastrarUsuarioLabel">CADASTRAR USUÁRIO</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                {{-- inicio dos campos do formulário de cadastro de usuário  --}}
                                {{-- Este componente será acionado sempre que houver uma erro de exceção em: store, update ou delete --}}
                                <x-errorexception />

                                    {{-- nomecompleto --}}
                                    <div class="mb-4 row">
                                        <label for="nomecompleto" class="col-sm-2 col-form-label">Nome Completo <span class="small text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="nomecompleto" value="{{ old('nomecompleto') }}" class="form-control" id="nomecompleto" placeholder="Nome completo" >
                                            {{-- <small id="nomecompleto_error" style="color: red"></small> --}}
                                            <span class="text-danger error-text nomecompleto_error"></span>
                                        </div>
                                    </div>


                                    {{-- nome --}}
                                    <div class="mb-4 row">
                                        <label for="nome" class="col-sm-2 col-form-label">Usuário <span class="small text-danger">*</span></label>
                                        <div class="col-sm-10">
                                        <input type="text" name="nome" value="{{ old('nome') }}" class="form-control" id="nome" placeholder="Nome de usuário" >
                                        <span class="text-danger error-text nome_error"></span>
                                        
                                        </div>
                                    </div>


                                    {{-- cpf --}}
                                    <div class="mb-4 row">
                                        <label for="cpf" class="col-sm-2 col-form-label">CPF <span class="small text-danger">*</span></label>
                                        <div class="col-sm-10">
                                        <input type="text" name="cpf" value="{{ old('cpf') }}" class="form-control cpf" id="cpf" placeholder="CPF (só números)" >
                                        <span class="text-danger error-text cpf_error"></span>
                                        </div>
                                    </div>


                                    {{-- cargo --}}
                                    <div class="mb-4 row">
                                        <label for="cargo" class="col-sm-2 col-form-label">Cargo <span class="small text-danger">*</span></label>
                                        <div class="col-sm-10">
                                        <input type="text" name="cargo" value="{{ old('cargo') }}" class="form-control" id="cargo" placeholder="Digite o cargo" >
                                        <span class="text-danger error-text cargo_error"></span>
                                        </div>
                                    </div>


                                    {{-- fone --}}
                                    <div class="mb-4 row">
                                        <label for="fone" class="col-sm-2 col-form-label">Telefone <span class="small text-danger">*</span></label>
                                        <div class="col-sm-10">
                                        <input type="text" name="fone" value="{{ old('fone') }}" class="form-control  mask-cell" id="fone" placeholder="Telefone (só números)" >
                                        <span class="text-danger error-text fone_error"></span>
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
                                            <span class="text-danger error-text perfil_error"></span>
                                        </div>
                                    </div>


                                    {{-- email --}}
                                    <div class="mb-4 row">
                                        <label for="email" class="col-sm-2 col-form-label">E-mail <span class="small text-danger">*</span></label>
                                        <div class="col-sm-10">
                                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="email" placeholder="Melhor e-mail" >
                                        <span class="text-danger error-text email_error"></span>
                                        </div>
                                    </div>


                                    {{-- password --}}
                                    <div class="mb-4 row">
                                        <label for="password" class="col-sm-2 col-form-label">Senha <span class="small text-danger">*</span></label>
                                        <div class="col-sm-10">
                                        <input type="password" name="password" value="{{ old('password') }}" class="form-control" id="password" placeholder="Senha" >
                                        <span class="text-danger error-text password_error"></span>
                                        </div>
                                    </div>


                                    {{-- password_confirmation --}}
                                    <div class="mb-4 row">
                                        <label for="password_confirmation" class="col-sm-2 col-form-label">Confirmar Senha <span class="small text-danger">*</span></label>
                                        <div class="col-sm-10">
                                        <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" class="form-control" id="password_confirmation" placeholder="Confirme a senha" >
                                        <span class="text-danger error-text password_confirmation_error"></span>
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

                                {{-- final dos campos do formulário de cadastro de usuário --}}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary" id="btnSalvarUsuario" style="width: 95px;"> Salvar </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Final Modal CadastrarUsuario -->

        </div>
    </div>


@endsection

@section('scripts')
    <script>
        $('#datatablesUsers').DataTable({
            // ordering: true,  // Habilita/Desabilita a ordenação. Defult: true
            // scrollY: 300,    //Define a altura da tabela para rolagem vertical

            // Menu da quantidade de registros a serem exibidos. O valor default é 10
            lengthMenu: [5, 10, 15, 20],


            // Exibe/Esconde o botão de filtro Default true
            // bFilter: true,

            language: {
                url: "https://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json"
            },

            // Indica a mensagem de processamento e que os dados virão de um servidor
            processing: true,
            serverSide: true,
            ajax: "{{ route('dashboard.ajaxgetusers') }}",
            columns: [
                    { data: 'id' },
                    { data: 'nomecompleto'},
                    { data: 'cpf' },
                    { data: 'cargo' },
                    { data: 'perfil' },
                    { data: 'contato' },
            ],
        });






        $(document).on('click', '#btnSalvarUsuario', function(e){
            // Evita que o formulário seja submetido
            e.preventDefault();

            // Captura dados dos campos
            var data = {
                'nomecompleto': $('#nomecompleto').val(),
                'nome': $('#nome').val(),
                'cpf': $('#cpf').val(),
                'cargo': $('#cargo').val(),
                'fone': $('#fone').val(),
                'perfil': $('#perfil').val(),
                'email': $('#email').val(),
                'password': $('#password').val(),
                'password_confirmation': $('#password_confirmation').val(),
                'ativo': $("input[name=ativo]").val(), //'ativo': $("input:radio[name=ativo]").val()
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:"{{route('datatable.store')}}",
                type: "POST",
                dataType : "json",
                data: data,
                beforeSend: function(){
                    $(document).find("span.error-text").text("");
                },
                success: function(response){
                    $('#formCadastrarUsuario').trigger("reset");
                    $('#modalCadastrarUsuario').modal('hide');
                    $("#msg_success").text(response.msg_sucesso);
                    $(".alert").css("visibility","visible");
                },
                error: function(response){
                    //console.log(response.responseJSON);
                    //console.log(response.responseJSON.message);
                    $.each(response.responseJSON.errors, function(key, value){
                        $("span."+key+"_error").text(value);
                    });
                }
            });

        });








    </script>

@endsection
