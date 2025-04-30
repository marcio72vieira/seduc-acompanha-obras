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

        @foreach ($obras as $obra)
            <tr @if($loop->even) style="background-color: #e3e3e3;" @endif>
                <td style="width: 40px;" class="dados-lista">{{ $obra->id }}</td>
                <td style="width: 190px;" class="dados-lista">{{ $obra->tipoobra->nome }}</td>
                <td style="width: 275px;" class="dados-lista">{{ $obra->escola->nome }}</td>
                <td style="width: 275px;" class="dados-lista">@foreach($obra->objetos as $objeto) {{ $objeto->nome }}, @endforeach</td>
                <td style="width: 150px;" class="dados-lista">{{ $obra->escola->municipio->nome }}</td>
                <td style="width: 50px;" class="dados-lista">@if($obra->ativo == 1 ) sim @else não @endif </td>
                <td style="width: 100px;" class="dados-lista">{{ \Carbon\Carbon::parse($obra->created_at)->format('d/m/Y H:i') }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
