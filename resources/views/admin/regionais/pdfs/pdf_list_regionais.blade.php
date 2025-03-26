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

        @foreach ($regionais as $regional)
            <tr @if($loop->even) style="background-color: #e3e3e3;" @endif>
                <td style="width: 40px;" class="dados-lista">{{ $regional->id }}</td>
                <td style="width: 690px;" class="dados-lista">{{ $regional->nome }}</td>
                <td style="width: 50px;" class="dados-lista">@if($regional->ativo == 1 ) sim @else não @endif </td>
                <td style="width: 100px;" class="dados-lista">{{ $regional->qtdmunicipiosvinc($regional->id) }}</td>
                <td style="width: 100px;" class="dados-lista">{{ $regional->qtdescolasdaregional() }}</td>
                <td style="width: 100px;" class="dados-lista">{{ \Carbon\Carbon::parse($regional->created_at)->format('d/m/Y H:i') }}</td>
            </tr>
        @endforeach

    </table>
</body>
</html>
