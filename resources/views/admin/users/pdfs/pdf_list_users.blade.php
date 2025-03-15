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

        @foreach ($users as $user)
            <tr @if($loop->even) style="background-color: #e3e3e3;" @endif>
                <td style="width: 40px;" class="dados-lista">{{$user->id}}</td>
                <td style="width: 275px;" class="dados-lista">{{$user->nomecompleto}}</td>
                <td style="width: 100px;" class="dados-lista">
                    @if($user->perfil == 'adm') 
                        <b>ADMINISTRADOR</b> 
                    @elseif($user->perfil == 'con') 
                        <b>Consultor</b>
                    @elseif($user->perfil == 'ope') 
                        <b>Operador</b>
                    @endif 
                </td>
                <td style="width: 315px;" class="dados-lista">{{ $user->cargo }}</td>
                <td style="width: 200px;" class="dados-lista">{{ $user->email }}</td>
                <td style="width: 100px;" class="dados-lista">{{ $user->fone}} </td>
                <td style="width: 50px;" class="dados-lista">@if($user->ativo == 1 ) sim @else não @endif </td>
            </tr>
        @endforeach

    </table>
</body>
</html>
