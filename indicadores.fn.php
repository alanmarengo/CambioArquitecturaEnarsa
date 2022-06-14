<?php

include("./login.php");

if ((isset($_SESSION)) && (sizeof($_SESSION) > 0))
{
	$user_id = $_SESSION["user_info"]["user_id"];
}else $user_id = -1; /* usuario publico, no hay perfil */


function DrawAbrInd() {
	
	global $user_id;
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT clase_id,clase_desc,color_hex,color_head,cod_clase_alf FROM mod_catalogo.clase ORDER BY clase_id ASC";
	
	$query = pg_query($conn,$query_string);
		
	while ($r = pg_fetch_assoc($query)) {
	
		$query_string_records = "SELECT * FROM mod_indicadores.ind_panel WHERE clase_id = " . $r["clase_id"] . " AND mod_login.check_permisos_new(3,ind_id,$user_id)  ORDER BY ind_titulo ASC";
		
		$query_records = pg_query($conn,$query_string_records);
			
		$records = pg_num_rows($query_records);
			
		if ($records>0) {
		
		?>
		
		<div class="abr panel-abr" data-color="#31cbfd" data-bgcolor="#FFFFFF" data-active="0" data-cid="<?php echo $r["clase_id"]; ?>" title="<?php echo $r["clase_desc"]; ?>" data-r="<?php echo $records; ?>">
			<span><?php echo $r["cod_clase_alf"]; ?></span>
		</div>
		
		<?php
		
		}
		
	}
	
}

function DrawContainersInd() {		
	
	global $user_id;	

	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT clase_id,cod_nom,color_hex,color_head,cod_clase_alf FROM mod_catalogo.clase ORDER BY clase_id ASC";
	
	$query = pg_query($conn,$query_string);	
	
	while ($r = pg_fetch_assoc($query)) {
		
		$query_string_records = "SELECT * FROM mod_indicadores.ind_panel WHERE clase_id = " . $r["clase_id"] . "  AND mod_login.check_permisos_new(3, ind_id, $user_id) ORDER BY ind_titulo ASC";
		
		$query_records = pg_query($conn,$query_string_records);
			
		$records = pg_num_rows($query_records);
			
		if ($records>0) {
			
		?>
		
		<div class="layer-container" data-color="#31cbfd" data-cid="<?php echo $r["clase_id"]; ?>" style="border-color:#FFFFFF">
			<div class="layer-container-header" style="background-color:#31cbfd;">				
				<span><?php echo $r["cod_nom"]; ?></span>		
			</div>
			<div class="layer-container-body scrollbar-content">
				<?php DrawIndicadores($r["clase_id"]); ?>
			</div>
		</div>
		
		<?php
		
		}
		
	}
	
}

function DrawIndicadores($clase_id) {		
	
	global $user_id;	

	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT DISTINCT * FROM mod_indicadores.ind_panel WHERE clase_id = " . $clase_id . "  AND mod_login.check_permisos_new(3, ind_id, $user_id) ORDER BY ind_titulo ASC";
	
	$query = pg_query($conn,$query_string);
	
	$records = pg_num_rows($query);
	
	if ($records>0) {
	
		while ($r = pg_fetch_assoc($query)) {
			
			?>
			
			<div class="layer-group" data-state="0" data-cid="<?php echo $r["clase_id"]; ?>">
			
				<div class="layer-header">
					
					<a href="#" class="layer-label" id="indicador-label-<?php echo $r["ind_id"]; ?>" onclick="indicadores.loadIndicador(<?php echo $r["ind_id"]; ?>,'<?php echo $r["ind_titulo"]; ?>',<?php echo $r["clase_id"]; ?>); $('.layer-label').removeClass('layer-label-active'); $(this).addClass('layer-label-active'); $('#nav-panel-arrow-a').trigger('click');">
						<span><?php echo $r["ind_titulo"]; ?></span>
					</a>
					
				</div>
			
			</div>
			
			<?php
			
		}
	
	}else{
		
		?>
		
		<div class="layer-group" data-state="0" data-cid="<?php echo $r["clase_id"]; ?>">
			
			<div class="layer-header">
				
				<p>
					<span>No se encontraron datasets asociados a esta clase.</span>
				</p>
				
			</div>
		
		</div>
		
		<?php
		
	}
	
}



function DrawIndicadoresSearch($pattern) {	
	
	global $user_id;		

	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT DISTINCT * FROM mod_indicadores.ind_panel WHERE ind_titulo ILIKE '%" . $pattern . "%'  AND mod_login.check_permisos_new(3, ind_id, $user_id) ORDER BY ind_titulo ASC";
	
	$query = pg_query($conn,$query_string);
	
	$output = "<ul>";
	
	$results = false;
	
	while ($r = pg_fetch_assoc($query)) {
		
		$low_desc = strtolower($r["ind_titulo"]);
		$low_pattern = strtolower($pattern);
		
		$desc = str_replace($low_pattern,"<span class=\"panel-highlighted-list-item\">".$low_pattern."</span>",$low_desc);
		
		$output .= "<li>";
		$output .= "<a href=\"javascript:void(0);\" onclick=\"indicadores.loadIndicador(" . $r["ind_id"] . ",'" . $r["ind_titulo"] . "',".$r["clase_id"]."); $('#panel-busqueda-geovisor').hide();\">" . $desc . "</a>";
		$output .= "</li>";

		$results = true;

	}
	
	if (!$results) {
	
		$output .= "<li>No se encontraron resultados para su búsqueda</li>";
	
	}
	
	$output .= "</ul>";
	
	pg_close($conn);
	
	return $output;
	
}

function ComboCruce() {		

	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM mod_estadistica.dt_cruce ORDER BY dt_cruce_etiqueta ASC";
	
	$query = pg_query($conn,$query_string);
	
	while ($r = pg_fetch_assoc($query)) {
		
		?>
		
		<option value="<?php echo $r["dt_cruce_table"]; ?>"><?php echo $r["dt_cruce_etiqueta"]; ?></option>
		
		<?php
		
	}
	
}

?>
