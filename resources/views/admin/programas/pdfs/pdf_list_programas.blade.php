<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SEDUC - Programa</title>
</head>

<body>
    <table style="width: 1080px; border-collapse: collapse;">

        @foreach ($programas as $programa)
            <tr @if($loop->even) style="background-color: #e3e3e3;" @endif>
                <td style="width: 40px;" class="dados-lista">{{ $programa->id }}</td>
                <td style="width: 890px;" class="dados-lista">{{ $programa->nome }}</td>
                <td style="width: 50px;" class="dados-lista">@if($programa->ativo == 1 ) sim @else não @endif </td>
                <td style="width: 100px;" class="dados-lista">{{ \Carbon\Carbon::parse($programa->created_at)->format('d/m/Y H:i') }}</td>
            </tr>
        @endforeach

    </table>
</body>
</html>
