<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SEDUC - OBRA</title>
</head>

<body>
    <table style="width: 717px; border-collapse: collapse;">
        <tr>
            <td style="width: 57px;" class="label-ficha">Id</td>
            <td style="width: 180px;" class="label-ficha">Tipo</td>
            <td style="width: 280px;" class="label-ficha">Escola</td>
            <td style="width: 200px;" class="label-ficha">Data Iníco e Fim</td>
        </tr>
        <tr>
            <td style="width: 57;" class="dados-ficha">{{ $obra->id }}</td>
            <td style="width: 180px;" class="dados-ficha">{{ $obra->tipoobra->nome }}</td>
            <td style="width: 280px;" class="dados-ficha">{{ $obra->escola->nome }}</td>
            <td style="width: 200px;" class="dados-ficha">{{ \Carbon\Carbon::parse($obra->data_inicio)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($obra->data_fim)->format('d/m/Y') }}</td>
        </tr>
    </table>

    <table style="width: 717px; border-collapse: collapse;">
        <tr>
            <td style="width: 717px;" class="label-ficha">Endereço</td>
        </tr>
        <tr>
            <td style="width: 717px;" class="dados-ficha">{{ $obra->escola->endereco }}, nº {{ $obra->escola->numero }}, Complemento: {{ $obra->escola->complemento }}. Bairro: {{ $obra->escola->bairro }}. CEP: {{ $obra->escola->cep }} </td>
        </tr>
    </table>

    <table style="width: 717px; border-collapse: collapse;">
        <tr>
            <td style="width: 237px;" class="label-ficha">Município</td>
            <td style="width: 280px;" class="label-ficha">Regional</td>
            <td style="width: 50px;" class="label-ficha">Ativo</td>
            <td style="width: 150px;" class="label-ficha">Status</td>
        </tr>
        <tr>
            <td style="width: 237px" class="dados-ficha">{{ $obra->escola->municipio->nome }}</td>
            <td style="width: 280px;" class="dados-ficha">{{ $obra->escola->regional->nome }}</td>
            <td style="width: 50px;" class="dados-ficha">{{ $obra->ativo == 1 ? "Sim" : "Não" }}</td>
            <td style="width: 150px;" class="dados-ficha">{{ $obra->estatu->nome }}</td>
        </tr>
    </table>

    <table style="width: 717px; border-collapse: collapse;">
        <tr>
            <td style="width: 717px;" class="label-ficha">Objetos</td>
        </tr>
        <tr>
            <td style="width: 717px" class="dados-ficha">
                @foreach ($obra->objetos as $objeto)
                    {{ $objeto->nome }},
                @endforeach
            </td>
        </tr>
    </table>

    <table style="width: 717px; border-collapse: collapse;">
        <tr>
            <td style="width: 717px;" class="label-ficha">Responsável(is)</td>
        </tr>
        <tr>
            <td style="width: 717px" class="dados-ficha">
                @foreach ($obra->users as $user)
                    {{ $user->nomecompleto }} ({{ ($user->perfil == 'adm' ? 'Administrador' : ($user->perfil == 'con' ? 'Consultor' : 'Operador')) }})
                    <br>
                @endforeach
            </td>
        </tr>
    </table>

    <table style="width: 717px; border-collapse: collapse;">
        <tr>
            <td style="width: 717px;" class="label-ficha">Descrição</td>
        </tr>
        <tr>
            <td style="width: 717px" class="dados-ficha">
                {{ $obra->descricao }}
            </td>
        </tr>
        <tr>
            <td colspan="4" style="width:717px;" class="close-ficha"></td>
        </tr>
    </table>

    <table style="width:717px; border-collapse: collapse;">
        <tr>
            <td width="30px" class="col-header-table">Id</td>
            <td width="70px" class="col-header-table">Data</td>
            <td width="40px" class="col-header-table">Progresso</td>
            <td width="577px" class="col-header-table">Atividade</td>
        </tr>
        @foreach ($obra->atividades as $atividade )
            <tr @if($loop->even) style="background-color: #e3e3e3;" @endif>
                <td width="30px" class="dados-lista">{{ $atividade->id }}</td>
                <td width="70px" class="dados-lista">{{ \Carbon\Carbon::parse($atividade->data_registro)->format('d/m/Y') }}</td>
                <td width="40px" class="dados-lista" style="text-align: center">
                    {{ $atividade->progresso }}%
                </td>
                <td width="577px" class="dados-lista">{{ $atividade->registro }}
                    @if ($atividade->observacao != null)
                        <br><strong><sup>obs:</sup></strong>{{ $atividade->observacao }}
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>