{{--
    <h3>CREDENCIAIS PARA ACESSAR SISTEMA</h3>
<p>
    Você foi cadastrado(a) para acessar o Sistema Aluguel Maria da Penha da Secretaria de Estado da Mulher / SEMU<br>
    <strong>Obs:</strong> Em seu primeiro acesso, por questão de segurança, será necessário redefinir a senha que lhe foi fornecida.<br><br>
    Suas credenciais:
</p>

<p>{{ $data['message'] }}</p>

<p>Acesse o Sistema, clicando <a href="{{ \Config::get('app.url'); }}"><strong> aqui! </strong></a></p>

<p>
    Se o link acima não funcionar, copie e cole o endereço abaixo em seu navegador preferido.<br>
    {{ \Config::get('app.url'); }}
</p>
--}}



<h3>CREDENCIAIS PARA ACESSAR SISTEMA</h3>
<br>

Olá {{ $dados['nome']}}!<br>
Você foi cadastrado(a) para acessar o <strong>Sistema Aluguel Maria da Penha</strong>, da Secretaria de Estado da Mulher / SEMU, com o perfil de <strong>"{{ $dados['perfil']}}"</strong> no Sistema.<br><br>
<strong>Observações Importantes:</strong><br>
1 - Efetue seu "login(acesso)" com as credenciais(e-mail e senha) fornecidas aqui. <br>
2 - Em seu primeiro acesso, por questões de segurança, você será solicitado a substituir a senha atual por uma nova senha.<br>
3 - Efetue seu login com a nova senha cadastrada.<br><br>

<strong>Segue suas credenciais:</strong><br>
<strong>E-mail:</strong> {{ $dados['email'] }}<br>
<strong>Senha:</strong> {{ $dados['senha'] }}<br><br><br>

Acesse o sistema clicando <a href="{{ \Config::get('app.url'); }}">aqui!</a>
<br><br>
Se o link acima não funcionar, copie e cole esta URL: {{ \Config::get('app.url'); }} em seu navegador preferido.<br><br>

<strong>Atenciosamente!</strong> <br>
Administrador do Sistema Aluguel Maria da Penha/SEMU.
