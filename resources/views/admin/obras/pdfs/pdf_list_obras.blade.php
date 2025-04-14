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
                <td style="width: 40px;" class="dados-lista">{{$obra->id}}</td>
                <td style="width: 180px;" class="dados-lista">{{$obra->tipoobra->nome}}</td>
                <td style="width: 250px;" class="dados-lista">{{ $obra->escola->nome }}</td>
                <td style="width: 150px;" class="dados-lista">{{$obra->regional->nome}}</td>
                <td style="width: 150px;" class="dados-lista">{{$obra->municipio->nome}}</td>
                <td style="width: 140px;" class="dados-lista">{{ \Carbon\Carbon::parse($obra->data_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($obra->data_fim)->format('d/m/Y') }} </td>
                <td style="width: 170px;" class="dados-lista">
                    @foreach ($obra->objetos as $objeto )
                        <span style="font-size: 7px;"> {{ $objeto->nome }}, </span>
                    @endforeach
                </td>
            </tr>
            {{-- <tr> <td class="dados-lista"></td> <td colspan="7" class="dados-lista"> bla, bla, bla, bla </td> </tr> --}}
        @endforeach
    </table>
</body>
</html>
