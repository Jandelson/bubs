<!DOCTYPE html>

<html>

	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<meta http-equiv="content-type" content="text/html; charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/default.css">
		<link rel="stylesheet" type="text/css" href="css/960.css">
	</head>

	<body>
		<div id="cab" align="left">

			<?
			require_once "cab.php";
			?>
			</div>
			<br>
			<div id="container">
				<form action="mail.php" method="post">
					<div id="cabecalho">
						<h1>
							Deixe-nos sua mensagem:
						</h1>
					</div>
					<div id="conteudo">
						<label for="name">Nome:</label>
						<input type="text" class="email" name="nome" id="nome" placeholder="Escreva seu Nome" required="true">

						<label for="email">Email:</label>
						<input type="email" class="email" id="email" name="email" placeholder="Digite seu endereço de email" required="true">

						<label for="message">Menssagem:</label>
						<textarea class="email textarea" name="msg" id="menssagem" placeholder="Escreva sua mensagem"></textarea>

						<input type="submit" class="botao_mail" value="Enviar">

					</div>
				</form>
			</div>
			<br><br>
			<? require_once "rodape.php"; ?>
		</body>
	</html>