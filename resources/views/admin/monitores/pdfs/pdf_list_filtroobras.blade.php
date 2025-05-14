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
                <td style="width: 110px;" class="dados-lista">{{ $obra->tipo }}</td>
                <td style="width: 250px;" class="dados-lista">{{ $obra->escola }} </td>
                <td style="width: 170px;" class="dados-lista"><span style="font-size: 6px;">{{ $obra->objetos }}</span></td>
                <td style="width: 100px;" class="dados-lista">{{ $obra->regional }}</td>
                <td style="width: 100px;" class="dados-lista">{{ $obra->municipio }}</td>
                <td style="width: 100px;" class="dados-lista"><span style="font-size: 6px;">{{ $obra->responsaveis }}</span></td>
                <td style="width: 140px;" class="dados-lista">{{ \Carbon\Carbon::parse($obra->datainicio)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($obra->datafim)->format('d/m/Y') }}</td>
                <td style="width: 70px;" class="dados-lista"><span style="font-size: 6px;">{{ $obra->nomeestatus }} </span> <br> ({{ $obra->progressomaximo }}%)</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
