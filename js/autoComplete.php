<?
	require_once "pontos.php";
	connect();
	$q = strtolower($_GET["q"]);
	if (!$q) return;
	
	$sql = "select DISTINCT dsc_endereco from ubs_pontos where dsc_endereco LIKE '%$q%'";
	$rsd = mysql_query($sql);
	while($rs = mysql_fetch_array($rsd)) {
		$cname = $rs['dsc_endereco'];
		echo "$cname\n";
	}
?>