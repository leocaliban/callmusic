<?php
$usuario = 'callmusic';
$senha = 'admin';
if (
    !isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])
    || $_SERVER['PHP_AUTH_USER'] != $usuario || $_SERVER['PHP_AUTH_PW'] != $senha
) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="Guitar Wars"');
    exit('<h2>CallMusic</h2>Desculpe, você deve digitar o nome de usuário e senha válidos para acessar essa página. <a href="index.php">Voltar para página principal</a>');
}
?>
