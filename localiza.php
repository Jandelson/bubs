<?
	session_start();
	require_once "js/pontos.php";
	connect();
	 $id = $_GET['id'];
	 $tipo = $_GET['tipo'];
 if($tipo==1){
 	$sql = "select 
		    	ut.id_ut id, 
		       	ut.vlr_latitude, 
		       	ut.vlr_longitude, 
				ut.nome nom_estab, 
				ut.nome_l dsc_endereco, 
				ut.bairro dsc_bairro, 
				ut.tel_1 dsc_telefone1, 
				ut.tel_2 dsc_telefone2,
				ut.e_mail dsc_email, 
				ut.muni cidade, 
				ut.uf estado,
				ut.papi,
				ut.peapi,
				ut.qual,
				ut.sexo,
				ut.modalidade_inter
				from unid_terapeuticas ut left join cep_cidades cepc on cepc.uf = ut.uf
		     	left join cep_uf cuf on cuf.id = cepc.uf_id
     			where ut.id_ut= $id";
 }else{
	 $sql = "select
			ubp.id Id,
			ubp.vlr_latitude,
			ubp.vlr_longitude,
			ubp.nom_estab,
			ubp.dsc_endereco,
			ubp.dsc_bairro,
			ubp.dsc_telefone,
			cepc.nome cidade,
			cuf.nome estado
			from ubs_pontos ubp left join cep_cidades cepc on ubp.cod_munic = cepc.cod_munic
			left join cep_uf cuf on cuf.id = cepc.uf_id
			where ubp.id = $id";
	}
	$table = mysql_query($sql) or die(mysql_error());
	while ($row = mysql_fetch_array($table))
	{
		if($tipo==1){
			$id = $dad["id_ut"];
			$cidade =  utf8_decode($row["cidade"]);
			$bairro = utf8_decode($row["dsc_bairro"]);
			$ender  = utf8_decode($row["dsc_endereco"]);
			$nome   = utf8_decode($row["nom_estab"]);
			$papi   = utf8_decode($row["papi"]);
			$peapi  = utf8_decode($row["peapi"]);
			$mod_i  = utf8_decode($row["modalidade_inter"]);
			{
			print"
			<table id=tab cellspacing=1 cellpadding=5>
				<thead>
					<tr>
						<th width=20%>Cidade</th>
						<th width=10%>Bairro</th>
						<th width=10%>Endereço</th>
						<th width=6%>UF</th>
						<th width=30%>Nome</th>
					</tr>
				<tr>
					<td>".$cidade."</td>
					<td>".$bairro."</td>
					<td>".$ender."</td>
					<td>{$row["estado"]}</td>
					<td>".$nome."</td>
				</tr>
				<tr>
						<th width=20%>Telefone1</th>
						<th width=15%>Telefone2</th>
						<th width=10%>Email</th>
						<th width=30%>Publico Atendido pela instituição</th>
						<th width=30%>Publico Específico Atendido pela instituição</th>
					</tr>
				<tr>
					<td>{$row["dsc_telefone1"]}</td>
					<td>{$row["dsc_telefone2"]}</td>
					<td>{$row["dsc_email"]}</td>
					<td>".$papi."</td>
					<td>".$peapi."</td>
				</tr>
				<tr>
						<th width=20%>Modalidade de Internação</th>
						<th width=10%>Sexo</th>
						<th width=10%></th>
						<th width=30%></th>
						<th width=30%></th>
					</tr>
				<tr>
					<td>".$mod_i."</td>
					<td>{$row["sexo"]}</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				</table>";
				break;
			}
		}else{
		$i=0;
		foreach($row as $key => $value)
		{
			if (is_string($key))
			{
				$fields[mysql_field_name($table,$i++)] = $value;
			}
		}
		$json_result[ ] =  $fields;
	 }
	}
	$JSON = json_encode($json_result);
	file_put_contents('js/ponto_localiza.json',$JSON);
?>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<meta http-equiv="content-type" content="text/html; charset="utf-8">
		<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
		<link rel="stylesheet" type="text/css" href="css/default.css">
		<link rel="stylesheet" type="text/css" href="css/960.css">
		<link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css">
		<script src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery-1.4.2.js"></script>
		<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
		<script type='text/javascript' src="js/jquery.autocomplete.js"></script>
		<script type="text/javascript" src="js/complemento.js"></script>
	</head>
<body>
<? if($tipo<>1){ ?>
<div id="map_canvas">
			<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
			<script src="js/infobox.js"></script>
			<script src="js/markerclusterer.js"></script>
			<script src="js/mapa_localiza.js"></script>
</div>
<? } ?>
</body>
</html>
