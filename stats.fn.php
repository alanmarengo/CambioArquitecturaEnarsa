<?php

include("./login.php");

if ((isset($_SESSION)) && (sizeof($_SESSION) > 0))
{
	$user_id = $_SESSION["user_info"]["user_id"];
}else $user_id = -1; /* usuario publico, no hay perfil */




function DrawAbrStats() {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM mod_estadistica.vw_abr WHERE has_dt > 0";
	
	$query = pg_query($conn,$query_string);
	
	while ($r = pg_fetch_assoc($query)) {
		
		?>
		
		<div class="abr panel-abr" data-color="#31cbfd" data-bgcolor="#FFFFFF" data-active="0" data-cid="<?php echo $r["clase_id"]; ?>" title="<?php echo $r["clase_desc"]; ?>">
			<span><?php echo $r["cod_clase_alf"]; ?></span>
		</div>
		
		<?php
		
	}
	
}

function DrawContainersStats() {			

	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT clase_id,cod_nom,color_hex,color_head,cod_clase_alf FROM mod_catalogo.clase ORDER BY clase_id ASC";
	
	$query = pg_query($conn,$query_string);
	
	while ($r = pg_fetch_assoc($query)) {
		
		?>
		
		<div class="layer-container" data-color="#31cbfd" data-cid="<?php echo $r["clase_id"]; ?>" style="border-color:#FFFFFF">
			<div class="layer-container-header" style="background-color:#31cbfd;">				
				<span><?php echo $r["cod_nom"]; ?></span>		
			</div>
			<div class="layer-container-body scrollbar-content">
				<?php DrawDatasets($r["clase_id"]); ?>
			</div>
		</div>
		
		<?php
		
	}
	
}

function DrawDatasets($clase_id) {	
	
	global $user_id;		

	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT DISTINCT * FROM mod_estadistica.vw_dt WHERE clase_id = " . $clase_id . "  AND mod_login.check_permisos_new(2, dt_id, $user_id) ORDER BY dt_titulo ASC";
	
	$query = pg_query($conn,$query_string);
	
	$records = pg_num_rows($query);
	
	if ($records>0) {
	
		while ($r = pg_fetch_assoc($query)) {
			
			?>
			
			<div class="layer-group" data-state="0" data-cid="<?php echo $r["clase_id"]; ?>">
			
				<div class="layer-header">
					
					<a href="#" class="layer-label" onclick="stats.dataset.loadVars(<?php echo $r["dt_id"]; ?>); stats.dataset.loadContent(<?php echo $r["dt_id"]; ?>); stats.dataset.loadComboCruce(<?php echo $r["dt_id"]; ?>,this);" id="data-label-<?php echo $r["dt_id"]; ?>" data-dt="<?php echo $r["dt_id"]; ?>">
						<span><?php echo $r["dt_titulo"]; ?></span>
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

function ComboCruce($dataset_id) {		

	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM mod_estadistica.dt_cruce WHERE dt_id = $dataset_id ORDER BY dt_cruce_etiqueta ASC";
	
	$query = pg_query($conn,$query_string);
	
	$html = "<option value=\"-1\" selected>Cruce Espacial</option>";
	
	while ($r = pg_fetch_assoc($query)) {
		
		$html .= "<option value=\"" . $r["dt_cruce_table"] . "\">" . $r["dt_cruce_etiqueta"] . "</option>";
		
	}
	
	return $html;
	
}

?>
