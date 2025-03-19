<x-mail::message>
# Informações de Cadastro

<table style="width: 100%; border: 1px solid black; border-collapse: collapse;">
    <tr>
        <td colspan="2" style="text-align: center"><strong>DADOS CADASTRAIS</strong></td>
    </tr>
    <tr>
        <td style="width: 20%; border: 1px solid black; padding: 3px;"><strong>ID</strong></td>
        <td style="width: 80%; border: 1px solid black; padding: 3px;">{{ $dados['id']}}</td>
    </tr>
    <tr>
        <td style="width: 20%; border: 1px solid black; padding: 3px;"><strong>NOME</strong></td>
        <td style="width: 80%; border: 1px solid black; padding: 3px;">{{ $dados['nomecompleto']}}</td>
    </tr>
    <tr>
        <td style="width: 20%; border: 1px solid black; padding: 3px;"><strong>USUÁRIO</strong></td>
        <td style="width: 80%; border: 1px solid black; padding: 3px;">{{ $dados['nome']}}</td>
    </tr>
    <tr>
        <td style="width: 20%; border: 1px solid black; padding: 3px;"><strong>CPF</strong></td>
        <td style="width: 80%; border: 1px solid black; padding: 3px;">{{ $dados['cpf']}}</td>
    </tr>
    <tr>
        <td style="width: 20%; border: 1px solid black; padding: 3px;"><strong>CARGO</strong></td>
        <td style="width: 80%; border: 1px solid black; padding: 3px;">{{ $dados['cargo']}}</td>
    </tr>
    <tr>
        <td style="width: 20%; border: 1px solid black; padding: 3px;"><strong>TELEFONE</strong></td>
        <td style="width: 80%; border: 1px solid black; padding: 3px;">{{ $dados['fone']}}</td>
    </tr>
    <tr>
        <td style="width: 20%; border: 1px solid black; padding: 3px;"><strong>PEFIL</strong></td>
        <td style="width: 80%; border: 1px solid black; padding: 3px;">{{ $dados['perfil']}}</td>
    </tr>
    <tr>
        <td style="width: 20%; border: 1px solid black; padding: 3px;"><strong>E-MAIL</strong></td>
        <td style="width: 80%; border: 1px solid black; padding: 3px;">{{ $dados['email']}}</td>
    </tr>
</table>

<x-mail::panel>
    <p>Bom trabalho!</p>
</x-mail::panel>

<x-mail::button :url="Config('app.url')" color="success">
Clique para acessar a aplicação
</x-mail::button>

Obrigado,<br>
{{-- {{ config('app.name') }} --}}
Secretaria de Estado da Educação / SEDUC
</x-mail::message>
