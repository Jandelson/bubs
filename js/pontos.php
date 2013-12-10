<?
function connect(){
	$servidor = "127.0.0.1";
	$usuario  = "root";
	$senha    = "admmysqljan";
	$db = "bubs";
	$conn = mysql_connect($servidor, $usuario, $senha);
	$db = mysql_select_db($db);
}

function cid($cid,$end,$estado,$ap_estado){
	if($cid<>0 or $end <> '' or $estado<>0){
		$where = array();
		
		if($ap_estado<>1){
			if($cid<>0)
				$where[] = "cepc.id = $cid";
		}
		
		if($estado<>0)
			$where[] = "cepc.uf_id = $estado";
		
		if($end<>'')	
			$where[] = "ubp.dsc_endereco like '%$end%'";
							
		$where = " where ".implode(" and ", $where);		
		
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
			$where";
	} else{
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
			from ubs_pontos ubp left join cep_cidades cepc on ubp.dsc_cidade = cepc.nome
			left join cep_uf cuf on cuf.id = cepc.uf_id
			limit 100";
	}
	sql($sql);
}

function sql($sql){
	$table = mysql_query($sql) or die(mysql_error());
	while ($row = mysql_fetch_array($table))
	{
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
	$JSON = json_encode($json_result);
	file_put_contents('js/pontos.json',$JSON);
}
?>
