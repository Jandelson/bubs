<?
function retorna_e($estado,$cid,$ap_estado,$ap_estrutura,$ut){
	if($ap_estado<>0 or $ap_estrutura<>0 or $ut<>0){
		if($estado<>0 and $cid<>0){
			$sql = "select
			cu.id,cu.uf,cc.id id_c,cc.nome
			from
			cep_uf cu left join cep_cidades cc on cu.id = cc.uf_id
			where
			cu.id = $estado and cc.id = $cid";
			$result = mysql_query($sql) or die(mysql_error());
			while($dad = mysql_fetch_array($result)){
				return array($dad['id'],$dad['uf'],$dad['id_c'],$dad['nome'],$ap_estado,$ap_estrutura,$ut);
			}
		}else return array('','','','',$ap_estado,$ap_estrutura,$ut);
	}
}
$estados = (list($id,$uf,$id_c,$nome,$ap_estado) = retorna_e($estado,$cid,$ap_estado,$ap_estrutura,$ut));
$cke =  ((empty($estados[4]))? "":"checked");
$cke1 = ((empty($estados[5]))? "":"checked");
$cke2 = ((empty($estados[6]))? "":"checked");
?>
<script type="text/javascript" src="js/complemento.js"></script>
<form action="index.php" method="post" autocomplete="off">
	<div class="container_16">
		<div class="grid_16" id="div_al">
			<div class="grid_1 alpha">
				<select class="select" title="Estado" name="estados" id="estados">
					<option selected="selected" disabled>UF</option>
					<option value="<? print_r($estados[0]); ?>"><? print_r($estados[1]); ?></option>
					<?
					$sql = "select id,uf
					from cep_uf group by uf";
					$result = mysql_query($sql) or die(mysql_error());
					while($dad = mysql_fetch_array($result)){
						print "<option value=".$dad['id'].">".$dad['uf']."</option>";
					}
					?>
				</select>
			</div>
			<div class="grid_12 omega">
				<select class="select" name="cidades" id="cidades">
					<option selected="selected" disabled>Informe o Estado desejado para carregar a lista de Cidades</option>
					<option value="<? print_r($estados[2]); ?>"><? print_r($estados[3]); ?></option>
				</select>
			</div>
			<div class="grid_1 omega">
				<input type="submit" class="button" value="Buscar"/>
			</div>
			<div class="grid_16" id="cid">
				<input type="text" name="end" id="course" class="search" size="100" placeholder="Digite o endereço desejado">
				<br>
				<div class="checkboxes">
					<input type="checkbox" name="ap_estado" id="filtro_estado" value="1" <? print $cke ?> ><label for="filtro_estado" class="highlight">Filtrar somento pelo Estado</label>
					<input type="checkbox" name="ap_estrutura" id="filtro_estrutura" value="1" <? print $cke1 ?> ><label for="filtro_estrutura" class="highlight">Condições Fisícas das UBS'S</label>
					<input type="checkbox" name="ut" id="filtro_ut" value="1" <? print $cke2 ?> ><label for="filtro_ut" class="highlight">Comunidades terapêuticas</label>
					<input type="checkbox" name="calcRota" id="calcRota" value="1" disabled=true><label for="calcRota" class="highlight" disabled=true>Calcular Rota: (Breve)</label>
					<input type="hidden" name="orig" id="orig" class="orig" placeholder="Informe seu endereço de Origem" hidden="true">
					 <!-- onclick="calcRoute()"> -->
				</div>
			</div>
		</div>
	</div>
</form>

