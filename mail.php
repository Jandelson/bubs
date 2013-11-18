<?
$para = "contato@bubs.com.br";
$assunto = "Contato do site";
$nome = $_POST["nome"];
$email = $_POST["email"];
$mensagem = $_POST["msg"];

$corpo = "Nome: $nome <br>";
$corpo .= "E-mail: $email <br>Mensagem: $mensagem";

$header = "From: $nome <$para> Reply-to: $email ";
$header .= "Content-Type: text/html; charset=iso-8859-1 ";

mail($para, $assunto, $corpo, $header);
$msg = "Sua mensagem foi enviada com sucesso.";

print "<script>location.href='index.php'; alert('$msg');</script>";
?>