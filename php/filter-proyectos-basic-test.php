<?php

include("../pgconfig.php");

$proyectos = 3;

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

if (isset($proyectos)>0) {

	$get_layers_query_string = "SELECT string_agg(layer_id::text, ', ') AS layer_ids FROM mod_geovisores.layers_find('','','','".implode(",",$proyectos)."',-1,-1,-1,'',-1,-1);";
	
	$get_layers_query = pg_query($conn,$get_layers_query_string);

	$get_layers = pg_fetch_assoc($get_layers_query);
	
	var_dump($get_layers);
	
	$layer_ids = $get_layers["layer_ids"];
	
	if ($layer_ids != "") {
	
		$query_string = "SELECT clase_id,subclase_id,clase_desc,subclase_desc FROM mod_geovisores.vw_layers WHERE layer_id IN ($layer_ids) GROUP BY clase_id,subclase_id,clase_desc,subclase_desc ORDER BY clase_desc ASC, subclase_desc ASC;";

		$query = pg_query($conn,$query_string);

		while($r = pg_fetch_assoc($query)) {

		?>

		<div class="popup-panel-tree-item" data-state="0">
			<div class="popup-panel-tree-item-header">
				<i class="fas fa-folder popup-panel-tree-item-icon popup-icon"></i>
				<a href="#" class="popup-panel-tree-item-label popup-text">
					<span><?php echo $r["clase_id"] . " - " . $r["subclase_id"] . " - " . $r["clase_desc"] . " - " . $r["subclase_desc"]; ?></span>
				</a>
				<a href="#" class="simple-tree-pm-button">
					<i class="fa fa-plus-circle popup-panel-tree-item-icon-toggler popup-icon"></i>
				</a>
			</div>
			
			<div class="popup-panel-tree-item-subpanel">
				<ul>
				
					<?php
					
					$layer_query_string = "SELECT DISTINCT * FROM mod_geovisores.vw_layers WHERE clase_id = " . $r["clase_id"] . " AND subclase_id = " . $r["subclase_id"] . " AND layer_id IN (" . $layer_ids . ") ORDER BY layer_desc ASC";
					$layer_query = pg_query($conn,$layer_query_string);
					
					while($l = pg_fetch_assoc($layer_query)) {
						
						?>
						
						<a href="#" onclick="geomap.panel.PreviewLayer(<?php echo $l["layer_id"]; ?>)">
							<li>
								<?php echo $l["layer_desc"]; ?>
							</li>
						</a>					
						
						<?php
						
					}
					
					?>
				</ul>
			</div>
		</div>

		<?php		

		} // END OF WHILE
		
	}else{
		
		?>
		
		<p>No se encontraron capas asociadas a estos proyectos</p>
		
		<?php
		
	}

}

?>