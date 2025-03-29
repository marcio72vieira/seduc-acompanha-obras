<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SEDUC - Obras</title>
</head>

<body>
    <table style="width: 1080px; border-collapse: collapse;">

        @foreach ($escolas as $escola)
            <tr @if($loop->even) style="background-color: #e3e3e3;" @endif>
                <td style="width: 40px;" class="dados-lista">{{ $escola->id }}</td>
                <td style="width: 290px;" class="dados-lista">{{ $escola->nome }}</td>
                <td style="width: 50px;" class="dados-lista">@if($escola->ativo == 1 ) sim @else não @endif </td>
                <td style="width: 400px;" class="dados-lista">{{ $escola->endereco }}, {{ $escola->numero }}, Bairro: {{ $escola->bairro }} CEP: {{ $escola->cep }} telefone: {{ $escola->fone }}</td>
                <td style="width: 100px;" class="dados-lista">{{ $escola->municipio->nome }}</td>
                <td style="width: 100px;" class="dados-lista">{{ $escola->municipio->regional->nome }}</td>
                <td style="width: 100px;" class="dados-lista">{{ \Carbon\Carbon::parse($escola->created_at)->format('d/m/Y H:i') }}</td>
            </tr>
        @endforeach

    </table>
</body>
</html>
