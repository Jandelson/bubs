<?
	session_start();
	require_once "js/pontos.php";
	connect();
	$cid = $_POST['cidades'];
	$end = $_POST['end'];
	$estado = $_POST['estados'];
	$ap_estado = $_POST['ap_estado'];
	$ap_estrutura = $_POST['ap_estrutura'];
	$ut = $_POST['ut'];
	cid($cid,$end,$estado,$ap_estado);
	//header("Content-type: text/html;charset=utf-8");
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
		<script language="JavaScript">
			/*map*/
			function abrir(URL) {
			 
			  var width = 950;
			  var height = 500;
			 
			  var left = 160;
			  var top = 130;
			 
			  window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', left='+left+', scrollbars=no, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
			}
			/*dados*/
			function abrir_dados(URL) {			 
			  window.open(URL,'janela', 'width=1120, height=250, top=230, left=80, scrollbars=no, status=no, toolbar=no, location=yes, directories=yes, menubar=no, resizable=no, fullscreen=no');
			}
		</script>
		<!-- <script type="text/javascript" src="js/complemento.js"></script> -->
	</head>

	<body>
		<? include_once("analyticstracking.php") ?>
		<div id="cab" align="left">
			<?
			require_once "cab.php";
			?>
		</div>
		<br>
		<div id="texto">
			<p>
				<i>
					As Unidades Básicas de Saúde (UBS) são a porta de entrada preferencial do Sistema Único de Saúde (SUS). O objetivo desses postos é atender até 80% dos problemas de saúde da população, sem que haja a necessidade de encaminhamento para hospitais.
				</i>
			</p>
		</div>
		<div style="float:right;margin-right:125px;">
			<i>Dados Abertos:<a href="http://dados.gov.br/dados-abertos/" target="_new" title="O que são dados abertos?">Portal Brasileiro de Dados Abertos</a></i>
		</div>

		<? /*retorna no form_p.php*/ require_once "form_p.php"; retorna_e($estado,$cid,$ap_estado,$ap_estrutura,$ut);?>
		<br>
		<? if($ap_estrutura<>1 and $ut<>1){ ?>
		<div id="map_canvas">
			<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
			<script src="js/infobox.js"></script>
			<script src="js/markerclusterer.js"></script>
			<script src="js/mapa.js"></script>
		</div>
		<? } if($ap_estrutura==1 and $ut<>1){ ?>
		<div style="margin-top:150px;" id="tab">
		<div align="center">
			<table>
				<tr>
					<th><img src="img/cla_o.png" width="30">Desempenho muito acima da média</th>
					<th><img src="img/cla_b.png" width="30">Desempenho acima da média</th>
					<th><img src="img/cla_r.png" width="30">Desempenho mediano ou um pouco abaixo da média</th>
				</tr>
			</table>
		</div>
			<table id="tab" cellspacing="1" cellpadding="5">
				<thead>
					<tr>
						<th width="20%">Cidade</th>
						<th width="30%">Nome</th>
						<th align="center" width="17%">Estrutura Física do Ambiente</th>
						<th align="center" width="17%">Adaptação p/ Deficiêntes Físicos e Idosos</th>
						<th align="center" width="17%">Equipamentos da Unidade</th>
						<th align="center" width="17%">Medicamentos da Unidade</th>
						<th align="center" width="17%">Localizar</th>
					</tr>
				</thead>
				<tbody>
					<?
					if($cid<>0 or $estado<>0){
						$where = array();
						
						if($ap_estado<>1){
							if($cid<>0)
								$where[] = "cepc.id = $cid";
						}
						
						if($estado<>0)
							$where[] = "cepc.uf_id = $estado";
																	
						$where = " where ".implode(" and ", $where);		
						
						$sql = mysql_query("
						select 
							ubp.id id,
							ubp.nom_estab nome,
							cepc.uf estado,
							concat(ubp.dsc_cidade,' - ',cepc.uf) cid_est,
							ubp.dsc_estrut_fisic_ambiencia,
							ubp.dsc_adap_defic_fisic_idosos,
							ubp.dsc_equipamentos,
							ubp.dsc_medicamentos
						from 
							ubs_pontos ubp left join cep_cidades cepc on ubp.cod_munic = cepc.cod_munic
						$where 
							order by cid_est");
						
					}
					while($dad = mysql_fetch_array($sql)){
						$id = $dad["id"];
						
						$estr_f_a = $dad["dsc_estrut_fisic_ambiencia"];
						if($estr_f_a=='Desempenho muito acima da média')
							$estr_f_a = "<img src=img/cla_o.png width=30 title='Desempenho muito acima da média'>";
						elseif($estr_f_a=='Desempenho acima da média')
							$estr_f_a = "<img src=img/cla_b.png width=30 title='Desempenho acima da média'>";
						else $estr_f_a="<img src=img/cla_r.png width=30  title='Desempenho mediano ou um pouco abaixo da média'>";
						
						$estr_d_i = $dad["dsc_adap_defic_fisic_idosos"];
						if($estr_d_i=='Desempenho muito acima da média')
							$estr_d_i = "<img src=img/cla_o.png width=30 title='Desempenho muito acima da média'>";               
						elseif($estr_d_i=='Desempenho acima da média')                                                          
							$estr_d_i = "<img src=img/cla_b.png width=30 title='Desempenho acima da média'>";                    
						else $estr_d_i="<img src=img/cla_r.png width=30  title='Desempenho mediano ou um pouco abaixo da média'>";

						$estr_eq  = $dad["dsc_equipamentos"];
						if($estr_eq=='Desempenho muito acima da média')
							$estr_eq = "<img src=img/cla_o.png width=30 title='Desempenho muito acima da média'>";               
						elseif($estr_eq=='Desempenho acima da média')                                                           
							$estr_eq = "<img src=img/cla_b.png width=30 title='Desempenho acima da média'>";                    
						else $estr_eq="<img src=img/cla_r.png width=30  title='Desempenho mediano ou um pouco abaixo da média'>";

						$estr_m = $dad["dsc_medicamentos"];
						if($estr_m=='Desempenho muito acima da média')
							$estr_m = "<img src=img/cla_o.png width=30 title='Desempenho muito acima da média'>";               
						elseif($estr_m=='Desempenho acima da média')                                                           
							$estr_m = "<img src=img/cla_b.png width=30 title='Desempenho acima da média'>";                    
						else $estr_m="<img src=img/cla_r.png width=30  title='Desempenho mediano ou um pouco abaixo da média'>";

						print"
						<tr>
							<td>{$dad["cid_est"]}</td>
							<td>{$dad["nome"]}</td>
							<td align=center>".$estr_f_a."</td>
							<td align=center>".$estr_d_i."</td>
							<td align=center>".$estr_eq."</td>
							<td align=center>".$estr_m."</td>
							<td align=center><p><a href=javascript:abrir('localiza.php?id=$id');><img src=img/localiza.png width=30></a></p></td>
						</tr>";
					}
					$nr = mysql_num_rows($sql);
					if(trim($nr)==0)
						print "<script>alert('Desculpe-nos, mais segundo dados do site: dados.gov.br não temos ubs nessa localidade!');</script>";
					?>
				</tbody>
				<tfoot>
				</tfoot>
			</table>
			<script>
				function AdicionarFiltro(tabela, coluna) {
					var cols = $("#" + tabela + " thead tr:first-child th").length;
					if ($("#" + tabela + " thead tr").length == 1) {
						var linhaFiltro = "<tr>";
						for (var i = 0; i < cols; i++) {
							linhaFiltro += "<th></th>";
						}
						linhaFiltro += "</tr>";

						$("#" + tabela + " thead").append(linhaFiltro);
					}

					var colFiltrar = $("#" + tabela + " thead tr:nth-child(2) th:nth-child(" + coluna + ")");

					$(colFiltrar).html("<select id='filtroColuna_" + coluna.toString() + "'  class='filtroColuna'> </select>");

					var valores = new Array();

					$("#" + tabela + " tbody tr").each(function () {
						var txt = $(this).children("td:nth-child(" + coluna + ")").text();
						if (valores.indexOf(txt) < 0) {
							valores.push(txt);
						}
					});
					$("#filtroColuna_" + coluna.toString()).append("<option>TODOS</option>")
					for (elemento in valores) {
						$("#filtroColuna_" + coluna.toString()).append("<option>" + valores[elemento] + "</option>");
					}

					$("#filtroColuna_" + coluna.toString()).change(function () {
						var filtro = $(this).val();
						$("#" + tabela + " tbody tr").show();
						if (filtro != "TODOS") {
							$("#" + tabela + " tbody tr").each(function () {
								var txt = $(this).children("td:nth-child(" + coluna + ")").text();
								if (txt != filtro) {
									$(this).hide();
								}
							});
						}
					});

				};

				AdicionarFiltro("tab", 1);
				AdicionarFiltro("tab", 2);
			</script>
		</div>
		<? } if($ut==1 and $ap_estrutura<>1){ $height==300;?>
		<div style="margin-top:150px;" id="tab">
			<br><br>
			<p align="center">
				<b>
					Comunidades terapêuticas são entidades privadas, sem fins lucrativos,
					<br>
					que realizam acolhimento de pessoas com transtornos decorrentes do uso, 
					abuso ou dependência de substâncias psicoativas.
				</b>
			</p>
			<table id="tab" cellspacing="1" cellpadding="5">
				<thead>
					<tr>
						<th width="18%">Cidade</th>
						<th width="18%">Bairro</th>
						<th width="18%">Endereço</th>
						<th width="6%">UF</th>
						<th width="25%">Nome</th>
						<th align="center" width="25%">Dados da Unidade</th>
					</tr>
				</thead>
				<tbody>
					<?
					if($estado<>0){
						$where = array();
						$where[] = "cepc.uf_id = $estado";
						
						if($cid<>0)
							$where[] = "ut.muni like CONCAT('%',(select  nome from cep_cidades where id = $cid group by 1),'%')";
																	
						$where = " where ".implode(" and ", $where);		
						
						$sql = mysql_query("
						select 
		       			ut.id_ut, 
		       			ut.vlr_latitude, 
		       			ut.vlr_longitude, 
				        ut.nome nome, 
				        ut.nome_l ender, 
				        ut.bairro bairro, 
				        ut.tel_1, 
				        ut.muni cidade, 
				        ut.uf estado
					    from unid_terapeuticas ut left join cep_cidades cepc on cepc.uf = ut.uf
		     		    left join cep_uf cuf on cuf.id = cepc.uf_id
     				    $where limit 0,20");
						
					}
					while($dad = mysql_fetch_array($sql)){
						$id = $dad["id_ut"];
						$cidade =  utf8_decode($dad["cidade"]);
						$bairro = utf8_decode($dad["bairro"]);
						$ender  = utf8_decode($dad["ender"]);
						$nome   = utf8_decode($dad["nome"]);
					print"
						<tr>
							<td>".$cidade."</td>
							<td>".$bairro."</td>
							<td>".$ender."</td>
							<td>{$dad["estado"]}</td>
							<td>".$nome."</td>
							<td align=center><p><a href=Javascript:abrir_dados('localiza.php?id=$id&tipo=1');><img src=img/dados.png width=30></a></p></td>
						</tr>";
					}
					$nr = mysql_num_rows($sql);
					if(trim($nr)==0)
						print "<script>alert('Desculpe-nos, mais segundo dados do site: dados.gov.br não temos Comunidades terapêuticas nessa localidade, amplie sua busca tente verificar unidades apenas por estado usando a opção Filtrar somento pelo Estado!');</script>";
					?>
				</tbody>
				<tfoot>
				</tfoot>
			</table>
			<script>
				function AdicionarFiltro(tabela, coluna) {
					var cols = $("#" + tabela + " thead tr:first-child th").length;
					if ($("#" + tabela + " thead tr").length == 1) {
						var linhaFiltro = "<tr>";
						for (var i = 0; i < cols; i++) {
							linhaFiltro += "<th></th>";
						}
						linhaFiltro += "</tr>";

						$("#" + tabela + " thead").append(linhaFiltro);
					}

					var colFiltrar = $("#" + tabela + " thead tr:nth-child(2) th:nth-child(" + coluna + ")");

					$(colFiltrar).html("<select id='filtroColuna_" + coluna.toString() + "'  class='filtroColuna'> </select>");

					var valores = new Array();

					$("#" + tabela + " tbody tr").each(function () {
						var txt = $(this).children("td:nth-child(" + coluna + ")").text();
						if (valores.indexOf(txt) < 0) {
							valores.push(txt);
						}
					});
					$("#filtroColuna_" + coluna.toString()).append("<option>TODOS</option>")
					for (elemento in valores) {
						$("#filtroColuna_" + coluna.toString()).append("<option>" + valores[elemento] + "</option>");
					}

					$("#filtroColuna_" + coluna.toString()).change(function () {
						var filtro = $(this).val();
						$("#" + tabela + " tbody tr").show();
						if (filtro != "TODOS") {
							$("#" + tabela + " tbody tr").each(function () {
								var txt = $(this).children("td:nth-child(" + coluna + ")").text();
								if (txt != filtro) {
									$(this).hide();
								}
							});
						}
					});

				};

				AdicionarFiltro("tab", 1);
				AdicionarFiltro("tab", 2);
			</script>
		</div>
		<? } ?>
		<? require_once "rodape.php"; ?>
	</body>
</html>