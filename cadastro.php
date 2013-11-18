<?
session_start();
// Verifica o tipo de requisição e se tem a variável 'code' na url
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['code'])){
  // Informe o id da app
  $appId = '527052634053384';
  // Senha da app
  $appSecret = '113c85a387f63ad4441ba91fb81da00d';
  // Url informada no campo "Site URL"
  $redirectUri = urlencode('http://bubs.com.br/cadastro.php/');
  // Obtém o código da query string
  $code = $_GET['code'];
 
  // Monta a url para obter o token de acesso
  $token_url = "https://graph.facebook.com/oauth/access_token?"
  . "client_id=" . $appId . "&redirect_uri=" . $redirectUri
  . "&client_secret=" . $appSecret . "&code=" . $code;
 
  // Requisita token de acesso
  $response = @file_get_contents($token_url);
 
  if($response){
    $params = null;
    parse_str($response, $params);
 
    // Se veio o token de acesso
    if(isset($params['access_token']) && $params['access_token']){
      $graph_url = "https://graph.facebook.com/me?access_token="
      . $params['access_token'];
 
      // Obtém dados através do token de acesso
      $user = json_decode(file_get_contents($graph_url));
		 print $user;
      // Se obteve os dados necessários
      if(isset($user->email) && $user->email){
        /*
        * Autenticação feita com sucesso. 
        * Loga usuário na sessão. Substitua as linhas abaixo pelo seu código de registro de usuários logados
        */
        $_SESSION['email'] = $user->email;
        $_SESSION['nome'] = $user->name;
        $_SESSION['uid_facebook'] = $user->id;
        $_SESSION['user_facebook'] = $user->username;
        $_SESSION['link_facebook'] = $user->link;
 
        /*
        * Aqui você pode adicionar um código que cadastra o email do usuário no banco de dados
        * A cada requisição feita em páginas de área restrita você verifica se o email
        * que está na sessão é um email cadastrado no banco
        */
      }
 
    }else{
      $_SESSION['fb_login_error'] = 'Falha ao logar no Facebook';
    }
 
  }else{
    $_SESSION['fb_login_error'] = 'Falha ao logar no Facebook';
  }
 
}else if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['error'])){
  $_SESSION['fb_login_error'] = 'Permissão não concedida';
}

?>
<html>
<head>
<title>Entrar com Facebook</title>
</head>
<body>
<a href="https://www.facebook.com/dialog/oauth?client_id=527052634053384&scope=email,user_website,user_location&redirect_uri=http://bubs.com.br/cadastro.php">Entrar com Facebook</a>
<?
echo "<br><br><pre>";
print "aaaaaaaaaaaaaa";
print $user;
echo "</pre>";
?>
</body>
</html>