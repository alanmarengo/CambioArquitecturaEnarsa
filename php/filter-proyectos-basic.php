<?php

include("../pgconfig.php");

include("../login.php");


if ((isset($_SESSION)) && (sizeof($_SESSION) > 0))
{
	$user_id = $_SESSION["user_info"]["user_id"];
}else $user_id = -1; /* usuario publico, no hay perfil */

$proyectos = $_POST["proyectos"];
$geovisor = $_POST["geovisor"];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

if (isset($proyectos)>0) {
	
	if ($geovisor != -1) {
	
		$get_layers_query_string = "SELECT string_agg(layer_id::text, ', ') AS layer_ids FROM mod_geovisores.layers_find('','','','".implode(",",$proyectos)."',-1,-1,-1,'',-1,-1) WHERE layer_id IN(SELECT layer_id FROM mod_geovisores.geovisor_capa_inicial WHERE geovisor_id = " . $geovisor . ")   AND mod_login.check_permisos_new(0, layer_id, $user_id) ;";
		
	}else{
		
		$get_layers_query_string = "SELECT string_agg(layer_id::text, ', ') AS layer_ids FROM mod_geovisores.layers_find('','','','".implode(",",$proyectos)."',-1,-1,-1,'',-1,-1)   WHERE mod_login.check_permisos_new(0, layer_id, $user_id) ;";
	}
	
	$get_layers_query = pg_query($conn,$get_layers_query_string);

	$get_layers = pg_fetch_assoc($get_layers_query);

	$layer_ids = $get_layers["layer_ids"];
	
	if ($layer_ids != "") {
	
		$query_string = "SELECT clase_id,subclase_id,clase_desc,subclase_desc FROM mod_geovisores.vw_layers WHERE layer_id IN ($layer_ids)   AND mod_login.check_permisos_new(0, layer_id, $user_id)  GROUP BY clase_id,subclase_id,clase_desc,subclase_desc ORDER BY clase_desc ASC, subclase_desc ASC;";

		$query = pg_query($conn,$query_string);

		$clase = "";
		$first = true;
		
		while($r = pg_fetch_assoc($query)) {
		
		if ($clase != $r["clase_desc"]) {
			
			$clase = $r["clase_desc"];
			
			if ($first) {
				
				?>				
		
				<div class="popup-panel-tree-item" data-state="0">
					<div class="popup-panel-tree-item-header">
						<i class="fas fa-folder popup-panel-tree-item-icon popup-icon"></i>
						<a href="#" class="popup-panel-tree-item-label popup-text">
							<span><?php echo $r["clase_desc"]; ?></span>
						</a>
						<a href="#" class="simple-tree-pm-button">
							<i class="fa fa-angle-down popup-panel-tree-item-icon-toggler popup-icon"></i>
						</a>
					</div>
					
					<div class="popup-panel-tree-item-subpanel">
					
				<?php
				
				$first = false;
				
			}else{
				
				?>				
				
				</div>
				</div>
				
				<div class="popup-panel-tree-item" data-state="0">
					<div class="popup-panel-tree-item-header">
						<i class="fas fa-folder popup-panel-tree-item-icon popup-icon"></i>
						<a href="#" class="popup-panel-tree-item-label popup-text">
							<span><?php echo $r["clase_desc"]; ?></span>
						</a>
						<a href="#" class="simple-tree-pm-button">
							<i class="fa fa-angle-down popup-panel-tree-item-icon-toggler popup-icon"></i>
						</a>
					</div>
					
					<div class="popup-panel-tree-item-subpanel">
					
				<?php
				
			}
			
		}
		
		?>			
		
			<div class="popup-panel-tree-item" data-state="0">
				
				<div class="popup-panel-tree-item-header">
					<i class="fa fa-layer-group popup-panel-tree-item-icon popup-icon"></i>
					<a href="#" class="popup-panel-tree-item-label popup-text">
						<span><?php echo $r["subclase_desc"]; ?></span>
					</a>
					<a href="#" class="simple-tree-pm-button">
						<i class="fa fa-angle-down popup-panel-tree-item-icon-toggler popup-icon"></i>
					</a>
				</div>
					
				<div class="popup-panel-tree-item-subpanel">
					<ul>
					
						<?php
						
						$layer_query_string = "SELECT DISTINCT clase_id,layer_id,tipo_layer_id,layer_desc,layer_wms_layer,layer_wms_server FROM mod_geovisores.vw_layers WHERE clase_id = " . $r["clase_id"] . " AND subclase_id = " . $r["subclase_id"] . " AND layer_id IN (" . $layer_ids . ")   AND mod_login.check_permisos_new(0, layer_id, $user_id) ORDER BY layer_desc ASC";
						$layer_query = pg_query($conn,$layer_query_string);
						
						while($l = pg_fetch_assoc($layer_query)) {
							
							?>
							
							<li>
								<a href="#" onclick="geomap.panel.PreviewLayer(<?php echo $l["layer_id"]; ?>)">
										<?php echo $l["layer_desc"]; ?>
								</a>	
							</li>				
							
							<?php
							
						}
						
						?>
						
					</ul>
					
				</div>
				
			</div>

		<?php		

		} // END OF WHILE
		
		?>
		
		</div>
		</div>
		
		<?php
		
	}else{
		
		?>
		
		<p>No se encontraron capas asociadas a estos proyectos</p>
		
		<?php
		
	}

}

?>
