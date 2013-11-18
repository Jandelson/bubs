<?
session_start();
// Verifica o tipo de requisi��o e se tem a vari�vel 'code' na url
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['code'])){
  // Informe o id da app
  $appId = '527052634053384';
  // Senha da app
  $appSecret = '113c85a387f63ad4441ba91fb81da00d';
  // Url informada no campo "Site URL"
  $redirectUri = urlencode('http://bubs.com.br/cadastro.php/');
  // Obt�m o c�digo da query string
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
 
      // Obt�m dados atrav�s do token de acesso
      $user = json_decode(file_get_contents($graph_url));
		 print $user;
      // Se obteve os dados necess�rios
      if(isset($user->email) && $user->email){
        /*
        * Autentica��o feita com sucesso. 
        * Loga usu�rio na sess�o. Substitua as linhas abaixo pelo seu c�digo de registro de usu�rios logados
        */
        $_SESSION['email'] = $user->email;
        $_SESSION['nome'] = $user->name;
        $_SESSION['uid_facebook'] = $user->id;
        $_SESSION['user_facebook'] = $user->username;
        $_SESSION['link_facebook'] = $user->link;
 
        /*
        * Aqui voc� pode adicionar um c�digo que cadastra o email do usu�rio no banco de dados
        * A cada requisi��o feita em p�ginas de �rea restrita voc� verifica se o email
        * que est� na sess�o � um email cadastrado no banco
        */
      }
 
    }else{
      $_SESSION['fb_login_error'] = 'Falha ao logar no Facebook';
    }
 
  }else{
    $_SESSION['fb_login_error'] = 'Falha ao logar no Facebook';
  }
 
}else if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['error'])){
  $_SESSION['fb_login_error'] = 'Permiss�o n�o concedida';
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