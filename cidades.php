<?
	mb_internal_encoding("UTF-8"); 
	mb_http_output( "iso-8859-1" );  
	ob_start("mb_output_handler");   
	header("Content-Type: text/html; charset=ISO-8859-1",true);

	require_once "js/pontos.php";
	connect();
	$idestado = $_GET['estado'];
	$SQL = "select id,nome from cep_cidades where uf_id=$idestado group by nome";
	$result = mysql_query($SQL) or die(mysql_error()); 
	while($dad = mysql_fetch_array($result)){
		print "<option value=".$dad['id'].">".utf8_encode($dad['nome'])."</option>";
	}
?>