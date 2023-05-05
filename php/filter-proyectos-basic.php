<?php

//include("../pgconfig.php");
//include("../login.php");

require_once(dirname(__FILE__,2).'/MICROSERVICIOS/MIC-GEOVISOR/CAPA-APLICACION/SERVICIOS/REPOSITORIO-SERVICIO.php');
require_once(dirname(__FILE__,2).'/MICROSERVICIOS/MIC-USUARIO/CAPA-APLICACION/SERVICIO/REPOSITORIO-SERVICIO.php');



if ((isset($_SESSION)) && (sizeof($_SESSION) > 0))
{
	$user_id = $_SESSION["user_info"]["user_id"];
}else $user_id = -1; /* usuario publico, no hay perfil */

$proyectos = $_POST["proyectos"];    // array(5,3,9,11,10,6,2,4,7,1);
$geovisor = $_POST["geovisor"];

//$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
//$conn = pg_connect($string_conn);

if (isset($proyectos)>0) {
	
	
	// obtencion de lista de recursos restringidos
	$servicio_usuario = new RepositorioServicioUsuario();

	$lista_recursos_restringidos = array(); 

    if($user_id!=-1){
        $lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos_user($user_id);
    }else{
        $lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos();
    }

	$extension_registros_restringidos = "  NOT IN ( " ; 

	$flag_rec_restringidos = true;

	foreach($lista_recursos_restringidos->detalle as $objeto)
	{
		if($flag_rec_restringidos)
		{
			$extension_registros_restringidos .= $objeto['objeto_id'];
			$flag_rec_restringidos = false;
		}else{
			$extension_registros_restringidos .= ",".$objeto['objeto_id'];
		}
		
	}
	$extension_registros_restringidos .= ")";

	// FIN obtencion de lista de recursos restringidos

	if ($geovisor != -1) {

		// variable que adicionara una parte de la consulta 
			$subconsulta_proyectos = "";			

			if(!empty($proyectos)) // si la lista de proyectos no viene vacia.
			{
				/* se crea la extension para la consulta  */
				//$subconsulta_proyectos = ' AND C.sub_proyecto_id IN ('.implode(",",$proyectos).')';
				$subconsulta_proyectos = ' AND C.sub_proyecto_id IN ('.implode(",",$proyectos).')';
			}
	
		$get_layers_query_string = <<<EOD
									SELECT string_agg(layer_id::text, ', ') AS layer_ids 
									FROM (  SELECT DISTINCT L.* FROM "MIC-GEOVISORES".vw_catalogo_search C 
											INNER JOIN  "MIC-GEOVISORES".vw_layers L ON C.origen_id_especifico=L.layer_id 
											WHERE C.origen_search_text ILIKE '%%'
											$subconsulta_proyectos) R 
									WHERE R.layer_id
								EOD;	

		$extension_consulta_capa_inicial = ' AND  R.layer_id IN(SELECT layer_id FROM "MIC-GEOVISORES".geovisor_capa_inicial WHERE geovisor_id = '.$geovisor.')';

		$get_layers_query_string .= $extension_registros_restringidos.$extension_consulta_capa_inicial;
		
	}else{

		// variable que adicionara una parte de la consulta 
			$subconsulta_proyectos = "";			

			if(!empty($proyectos)) // si la lista de proyectos no viene vacia.
			{
				/* se crea la extension para la consulta  */
				//$subconsulta_proyectos = ' AND C.sub_proyecto_id IN ('.implode(",",$proyectos).')';
				$subconsulta_proyectos = ' AND C.sub_proyecto_id IN ('.implode(",",$proyectos).')';
			}
		
		$get_layers_query_string = <<<EOD
								SELECT string_agg(layer_id::text, ', ') AS layer_ids 
								FROM (  SELECT DISTINCT L.* FROM "MIC-GEOVISORES".vw_catalogo_search C 
										INNER JOIN  "MIC-GEOVISORES".vw_layers L ON C.origen_id_especifico=L.layer_id 
										WHERE C.origen_search_text ILIKE '%%'
										$subconsulta_proyectos) R 
							EOD;			

		$get_layers_query_string .= " WHERE R.layer_id ".$extension_registros_restringidos;	
	
	
	}

	
	
	//$get_layers_query = pg_query($conn,$get_layers_query_string);

	//$get_layers = pg_fetch_assoc($get_layers_query);

	//echo $get_layers_query_string;

	$servicio_geovisor = new RepositorioServicioGeovisor();

	$layer_ids = $servicio_geovisor->get_consulta($get_layers_query_string);

	//$layer_ids = $get_layers[0]["layer_ids"];
	
	if ($layer_ids != "") 
	{
		
		$aux_layer_ids = $layer_ids[0]["layer_ids"];
		$query_string = <<<EOD
							SELECT clase_id,subclase_id,clase_desc,subclase_desc 
							FROM "MIC-GEOVISORES".vw_layers 
							WHERE layer_id IN ($aux_layer_ids) 						
							GROUP BY clase_id,subclase_id,clase_desc,subclase_desc 
							ORDER BY clase_desc ASC, subclase_desc ASC
		EOD;

		//$query = pg_query($conn,$query_string);

		$result_query_string = $servicio_geovisor->get_consulta($query_string);
		
		$clase = "";
		$first = true;

		//while($r = pg_fetch_assoc($query))
		
		foreach($result_query_string as $r) {
		
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
						//$layer_query_string = "SELECT DISTINCT clase_id,layer_id,tipo_layer_id,layer_desc,layer_wms_layer,layer_wms_server FROM mod_geovisores.vw_layers WHERE clase_id = " . $r["clase_id"] . " AND subclase_id = " . $r["subclase_id"] . " AND layer_id IN (" . $layer_ids . ")   AND mod_login.check_permisos_new(0, layer_id, $user_id) ORDER BY layer_desc ASC";
						//$layer_query = pg_query($conn,$layer_query_string);
						
						$layer_query_string ="SELECT DISTINCT clase_id,layer_id,tipo_layer_id,layer_desc,layer_wms_layer,layer_wms_server 
											FROM ".'"MIC-GEOVISORES"'.".vw_layers 
											WHERE clase_id = " . $r["clase_id"] . 
											" AND subclase_id = " . $r["subclase_id"] .
											" AND layer_id IN ( $aux_layer_ids ) AND layer_id NOT IN (10,11,22,345) ORDER BY layer_desc ASC";

						$result_layers = $servicio_geovisor->get_consulta($layer_query_string);

						//while($l = pg_fetch_assoc($layer_query)) {
						
						foreach($result_layers as $l)
						{
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
