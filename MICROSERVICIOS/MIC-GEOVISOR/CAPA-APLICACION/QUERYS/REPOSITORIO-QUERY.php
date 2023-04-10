<?php
require_once(dirname(__FILE__,4).'\MIC-GEOVISOR\CAPA-DOMINIO\INTERFACE-REPOSITORIO-QUERY\INTERFACE-REPOSITORIO-QUERY.php');
require_once(dirname(__FILE__,4).'\MIC-GEOVISOR\CAPA-DATOS\capa-acceso.php');
require_once(dirname(__FILE__,4).'\MIC-GEOVISOR\CAPA-DOMINIO\CLASES\Clases.php');

//reemplazar los paths aboslutos por la nueva y linda forma que encontramos


class RepositorioQueryGeovisor implements IRepositorioQueryGeovisor{

	/*
	public $consulta_principal;

	public function _construct(){

		$this->consulta_principal=  'SELECT c.origen, c.origen_id, c.origen_id_especifico, c.origen_search_text, 
										c.subclase_id, c.estudios_id, c.cod_esia_id, c.cod_temporalidad_id, 
										c.objetos_id, ce.cap AS esia_cap, ce.titulo AS esia_titulo, 
										ce.orden_esia AS esia_orden_esia, ce.ruta AS esia_ruta, 
										ce.cod_esia AS esia_cod_original, e.estudios_palabras_clave, 
										e.sub_proyecto_id, e.estudio_estado_id, e.nombre, e.fecha, e.institucion, 
										e.responsable, e.equipo, e.cod_oficial, e.descripcion, 
										e.fecha_text_original, e.institucion_id, e.sub_proyecto_desc, e.proyecto_id, 
										e.proyecto_desc, e.proyecto_extent, e.institucion_nombre, e.institucion_tel, 
										e.institucion_contacto, e.institucion_email, t.cod_temp, 
										t.desde AS tempo_desde, t.hasta AS tempo_hasta, t.descripcion AS tempo_desc, 
										sc.clase_id, sc.subclase_desc, sc.subclase_cod, sc.estado_subclase, 
										sc.cod_unsubclase, sc.descripcio, sc.cod_nom, sc.fec_bbdd, cs.clase_desc
									FROM mod_geovisores.catalogo c
									LEFT JOIN mod_catalogo.vw_estudio e ON c.estudios_id = e.estudios_id
									LEFT JOIN mod_catalogo.cod_esia ce ON ce.cod_esia_id = c.cod_esia_id
									LEFT JOIN mod_catalogo.cod_temporalidad t ON t.cod_temporalidad_id = c.cod_temporalidad_id
									LEFT JOIN mod_catalogo.subclase sc ON sc.subclase_id = c.subclase_id
									LEFT JOIN mod_catalogo.clase cs ON cs.clase_id = sc.clase_id;';
	}

	*/

	public function get_layer_info_pgda() // faltan registros para su funcionamiento 
	{
		//$layer_id_arr = array();
		//$layer_desc_arr = array();


		$layer_id_arr = array(873,937,938,939,875);
		$layer_title_arr = array(
			"Provincia Santa Cruz",
			"Subcuenca Alta Del Río Santa Cruz",
			"Subcuenca Media Y Baja Del Río Santa Cruz",
			"Estuario Río Santa Cruz",
			"Áreas De Obra De Los Aprovechamientos Hidroeléctricos Del Río Santa Cruz"
		);

		//$layer_id_arr = array_values($layer_id_arr);	

		$html = "";

		for ($i=0; $i<sizeof($layer_id_arr); $i++) 
		{	
			$query_string = 'SELECT DISTINCT layer_id,layer_desc FROM "MIC-GEOVISORES".vw_layers WHERE layer_id = '. $layer_id_arr[$i] . ' LIMIT 1';
			
			$conexion = new ConexionGeovisores();       
			$data =  $conexion->get_consulta($query_string);  
			
			$layer_id = $data[0]["layer_id"];
			$layer_desc = $data[0]["layer_desc"];
			
			$query_string2 = 'SELECT * FROM mic_catalogo_fdw.vw_visor_pg_programas WHERE layer_id = ' . $layer_id . " ORDER BY programa ASC";
			
			$query2 = $conexion->get_consulta($query_string2); 
			
			//$query_count = pg_num_rows($query2);
			
			$metadata_url = $data["metadata_url"];
			$target = " target=\"_blank\"";
						
			if ($metadata_url == "") {
								
				$metadata_url = "javascript:alert('Esta capa no posee metadatos asociados');";
				$target = "";
								
			}

			$html = <<<EOD
					<div class="popup-layer-node jus-between" data-state="0" data-layer="$layer_id" data-index="$i">
							<div class="popup-layer-node-icons ml-15">
								<div class="layer-icon" title="Ver/Ocultar">
									<a href="javascript:void(0);" onclick="geomap.map.togglePopupLayers(this);"><img src="./images/geovisor/icons/popup-layer-closed.png" data-inactive="./images/geovisor/icons/popup-layer-closed.png"
									data-active="./images/geovisor/icons/popup-layer-opened.png"></a>
								</div>
							</div>
							<a href="#" class="layer-label" style="cursor:text" alt=" $layer_title_arr[$i]">" $layer_title_arr[$i]"</a>
						</div>
						
						<div style="display:none;" class="popup-layer-content">	
							
							<table class="popup-table gfi-info-table" cellpadding="5">
									
								<tr>
								<th>Programas Asociados</th>;
								</tr>
				EOD;
		
		
			
				while($r) {
						
					$html .= "<tr>";
					$html .= "<td>" . $r["programa"] . "</td>";
					$html .= "</tr>";
					
				}
			
				$html .= "</table>";
			$html .= "</div>";

		}

		return $html;

	}


    public function ListaProyectos()
	{
		// no existe la relacion proyectos
        $query_string = 'SELECT proyecto_id,proyecto_titulo FROM "MIC-GEOVISORES".proyectos ORDER BY proyecto_titulo ASC'; 

		$conexion = new ConexionGeovisores();        
        //realizo la consulta            
        $consulta = $conexion->get_consulta($query_string);   	

		 // recorro el arreglo con los datos de la consulta 
		for($x=0; $x<=count($consulta)-1; $x++)
		{  
			?>

			<a class="dropdown-item" href="#" data-id="<?php echo  $consulta[$x]["proyecto_id"]; ?>">
							<?php echo  $consulta[$x]["proyecto_titulo"]; ?>
			</a>          
		
			<?php 
		}

		$conexion = null;
	
		
	}

	public function DrawAbr()
	{
		$conexion = new ConexionGeovisores(); 

		$query_string ='SELECT clase_id,clase_desc,color_hex,color_head,cod_clase_alf FROM mic_catalogo_fdw.clase ORDER BY clase_id ASC;';
		//realizo la consulta 
		//echo $query_string;
		$r = $conexion->get_consulta($query_string);

		$html_response = '';
		for($x=0; $x<=count($r)-1; $x++)
		{  
			$html_response .= '<div class="abr panel-abr" data-color="#31cbfd" data-bgcolor="#FFFFFF" data-active="0" data-cid="'.$r[$x]["clase_id"].'" title="'.$r[$x]["clase_desc"].'">
                 	<span>'.$r[$x]["cod_clase_alf"].'</span>
           		 </div>' ;
		}	    

		
		$respuesta_op_server = new respuesta_error_geovisor();
		$respuesta_op_server->flag = true;
		$respuesta_op_server->detalle = $html_response;        

		return $respuesta_op_server;
	}

	public function DrawLayers($clase_id) 
	{
		$consulta_definitiva = 'SELECT DISTINCT clase_id,layer_id,tipo_layer_id,layer_desc,layer_wms_layer,layer_wms_server,layer_metadata_url FROM ';
		
		$conexion = new ConexionGeovisores(); 

		// se le concatena la consulta equivalente a la vista vw_layers
		$consulta_definitiva .= <<<EOD
								(SELECT l.layer_id, l.layer_desc, 
								CASE
									WHEN l.layer_alter_activo THEN l.layer_wms_server_alter
									ELSE l.layer_wms_server
								END AS layer_wms_server, 
								CASE
									WHEN l.layer_alter_activo THEN l.layer_wms_layer_alter
									ELSE l.layer_wms_layer
								END AS layer_wms_layer, 
							l.layer_metadata_url, l.layer_wms_sld, l.layer_sld_id, l.layer_schema, 
							l.layer_table, l.tipo_layer_id, l.tipo_origen_id, l.preview_desc, 
							l.preview_link, l.preview_titulo, 
								CASE
									WHEN sc.subclase_id IS NULL THEN (-1)::bigint
									ELSE sc.subclase_id
								END AS subclase_id, 
								CASE
									WHEN sc.subclase_desc IS NULL THEN 'General'::text
									ELSE sc.subclase_desc
								END AS subclase_desc, 
								CASE
									WHEN sc.clase_id IS NULL THEN (-1)::bigint
									ELSE sc.clase_id
								END AS clase_id, 
								CASE
									WHEN sc.clase_desc IS NULL THEN 'General'::text
									ELSE sc.clase_desc
								END AS clase_desc, 
							e.estudios_id, e.nombre AS estudio_nombre, tl.tipo_layer_desc, 
							tipo_o.tipo_origen_desc, 
								CASE
									WHEN sc.cod_clase_alf IS NULL THEN 'G-N'::text
									ELSE sc.cod_clase_alf
								END AS cod_clase_alf, 
							e.cod_oficial
							FROM "MIC-GEOVISORES".layer l
							LEFT JOIN "MIC-GEOVISORES".catalogo c ON l.layer_id = c.origen_id_especifico
							LEFT JOIN ( SELECT sc.subclase_id, sc.subclase_desc, sc.clase_id,  c.clase_desc,  c.cod_clase_alf
												FROM mic_catalogo_fdw.subclase sc
												JOIN mic_catalogo_fdw.clase c ON sc.clase_id = c.clase_id) sc ON sc.subclase_id = c.subclase_id
							LEFT JOIN mic_catalogo_fdw.estudios e ON e.estudios_id = c.estudios_id
							LEFT JOIN "MIC-GEOVISORES".tipo_layer tl ON tl.tipo_layer_id = l.tipo_layer_id
							LEFT JOIN "MIC-GEOVISORES".tipo_origen tipo_o ON tipo_o.tipo_origen_id = l.tipo_origen_id) A
						EOD;
		// por ultimo, concatenamos el where
		$consulta_definitiva .= " WHERE clase_id =  $clase_id  ORDER BY layer_desc ASC";		

		//echo $consulta_definitiva;
		//realizo la consulta 
		$r = $conexion->get_consulta($consulta_definitiva);
		
		for($x=0; $x<=count($r)-1; $x++)
			{				
			?>				
				<div class="layer-group" data-state="0" data-layer-name="<?php echo $r[$x]["layer_wms_layer"]; ?>" data-layer="<?php echo $r[$x]["layer_id"]; ?>" data-cid="<?php echo $r[$x]["clase_id"]; ?>" data-layer-type="<?php echo $r[$x]["tipo_layer_id"]; ?>">
				
					<div class="layer-header">
						<!--<a href="javascript:void(0);">
							<i class="fa fa-eye"></i>
						</a>-->
						
						<div class="pretty p-default p-curve p-toggle">
							<input type="checkbox" class="layer-checkbox default-empty-checkbox" id="layer-checkbox-<?php echo $r[$x]["layer_id"]; ?>" data-lid="<?php echo $r[$x]["layer_id"]; ?>" data-cid="<?php echo $r[$x]["clase_id"]; ?>" data-added="0" data-layer="<?php echo $r[$x]["layer_wms_layer"]; ?>" data-wms="<?php echo $r[$x]["layer_wms_server"]; ?>" data-layer-type="<?php echo $r[$x]["tipo_layer_id"]; ?>"/>
							<div class="state p-success p-on" title="Mostrar capa">
								<i class="fa fa-eye"></i>
							</div>
							<div class="state p-danger p-off" title="Ocultar capa">
								<i class="fa fa-eye-slash"></i>
							</div>
						</div>
						
						<a href="#" class="layer-label" onclick="$(this).parent().next().slideToggle('slow'); $(this).toggleClass('layer-label-active')" title="<?php echo $r[$x]["layer_desc"]; ?>">
							<span><?php echo $r[$x]["layer_desc"]; ?></span>
						</a>
						
						<!--<a href="#" class="simple-tree-pm-button ml-1 btn-plus-layer">
							<i class="fa fa-plus-circle popup-panel-tree-item-icon-toggler popup-icon"></i>
						</a>-->
						
						<a href="#" class="simple-tree-pm-button" id="remove-layer-icon-<?php echo $r[$x]["layer_id"]; ?>" onclick="geomap.panel.removeLayer(<?php echo $r[$x]["layer_id"]; ?>,<?php echo $r[$x]["clase_id"]; ?>); geomap.map.updateLayerCount();" title="Eliminar capa">
							<i class="fa fa-trash popup-panel-tree-item-icon-toggler popup-icon"></i>
						</a>
						
					</div>
					
					<div class="layer-body">
					
						<div class="layer-icons">
						
							<div class="layer-icon" id="layer-icon-zoomext-<?php echo $r[$x]["layer_id"]; ?>" onclick="geomap.map.zoomToLayerExtent(<?php echo $r[$x]["layer_id"]; ?>);" title="Ir a zoom de la capa">
								<a href="javascript:void(0);">
									<img src="./images/geovisor/icons/layer-bar-zoom.png">
								</a>
							</div>
							
							<?php
							
							$metadata_url = trim($r[$x]["layer_metadata_url"]);
							$target = " target=\"_blank\"";
							
							if ($metadata_url == "") {
								
								$metadata_url = "javascript:alert('Esta capa no posee Metadatos asociados');";
								$target = "";
								
							}
							
							?>
						
							<div class="layer-icon" onclick="$(this).children('a').trigger('click');" title="Metadatos" data-metaurl="<?php echo $r[$x]["layer_metadata_url"]; ?>">
								<a href="<?php echo $metadata_url; ?>"<?php echo $target; ?>>
									<img src="./images/geovisor/icons/layer-bar-info.png">
								</a>
							</div>
						
							<div class="layer-icon jump-toggleimage" onclick="$('.layer-tool-wrapper').not('#layer-colorpicker-<?php echo $r[$x]["layer_id"]; ?>').hide(); $('#layer-colorpicker-<?php echo $r[$x]["layer_id"]; ?>').slideToggle('slow');"
									data-state="0" 
									data-ini-src="./images/geovisor/icons/layer-bar-relleno.png"
									data-end-src="./images/geovisor/icons/layer-bar-relleno-blue.png"
									data-clean="1"
									title="Cambiar color"
								>
								<a href="javascript:void(0);">
									<img src="./images/geovisor/icons/layer-bar-relleno.png">
								</a>
							</div>
						
							<div class="layer-icon jump-toggleimage" onclick="$('.layer-tool-wrapper').not('#layer-opacity-<?php echo $r[$x]["layer_id"]; ?>').hide(); $('#layer-opacity-<?php echo $r[$x]["layer_id"]; ?>').slideToggle('slow');"
									data-state="0" 
									data-ini-src="./images/geovisor/icons/layer-bar-gota.png"
									data-end-src="./images/geovisor/icons/layer-bar-gota-blue.png"
									data-clean="1"
									title="Transparencia"
								>
								<a href="javascript:void(0);">
									<img src="./images/geovisor/icons/layer-bar-gota.png">
								</a>
							</div>
						
							<div class="layer-icon layer-icon-buffer jump-toggleimage" id="layer-icon-buffer-<?php echo $r[$x]["layer_id"]; ?>" onclick="$('.layer-tool-wrapper').not('#layer-buffer-<?php echo $r[$x]["layer_id"]; ?>').hide(); $('#layer-buffer-<?php echo $r[$x]["layer_id"]; ?>').slideToggle('slow'); geomap.panel.checkBuffer(<?php echo $r[$x]["layer_id"]; ?>,<?php echo $r[$x]["clase_id"]; ?>,this);"
									data-state="0" 
									data-ini-src="./images/geovisor/icons/layer-bar-buffer.png"
									data-end-src="./images/geovisor/icons/layer-bar-buffer-blue.png"
									data-clean="1"
									data-lid="<?php echo $r[$x]["layer_id"]; ?>"
									title="Buffer de capa"
								>
								<a href="javascript:void(0);">
									<img src="./images/geovisor/icons/layer-bar-buffer.png">
								</a>
							</div>
						
							<div class="layer-icon" onclick="$(this).children('a').trigger('click');" title="Descargar capa">
								<a href="<?php echo $r[$x]["layer_wms_server"]; ?>&service=WFS&version=1.0.0&request=GetFeature&typeName=<?php echo $r[$x]["layer_wms_layer"]; ?>&outputFormat=application/vnd.google-earth.kml+xml">
									<img src="./images/geovisor/icons/layer-bar-download.png">
								</a>
							</div>
						
						</div>
					
						<div class="layer-colorpicker layer-tool-wrapper" id="layer-colorpicker-<?php echo $r[$x]["layer_id"]; ?>">
							
							<div class="colorpicker-bullet-content">
								<div class="colorpicker-bullet"></div>
							</div>
							
							<div id="layer-colorpicker-inner-<?php echo $r[$x]["layer_id"]; ?>">
							
							</div>
							
						</div>
					
						<div class="layer-opacity layer-tool-wrapper" id="layer-opacity-<?php echo $r[$x]["layer_id"]; ?>">
							
							<div class="opacity-bullet-content">
								<div class="opacity-bullet"></div>
							</div>
							
							<p>
								<label for="transp-value-<?php echo $r[$x]["layer_id"]; ?>">Opacidad:</label>
								<input type="text" id="transp-value-<?php echo $r[$x]["layer_id"]; ?>" class="transp-value" readonly="readonly" style="border:0;">
							</p>
							
							<div class="slider-range" id="slider-range-<?php echo $r[$x]["layer_id"]; ?>"></div>
							
						</div>				
					
						<div class="layer-buffer layer-tool-wrapper" id="layer-buffer-<?php echo $r[$x]["layer_id"]; ?>">
						
							<div class="buffer-bullet-content">
								<div class="buffer-bullet"></div>
							</div>
							
							<p class="mb-0">
								<label for="buffer-value-<?php echo $r[$x]["layer_id"]; ?>">Distancia en mts:</label>
							</p>
							
							<div>
							
								<div class="multi-button">
									<input type="text" class="input getbufferdist" id="buffer-input-<?php echo $r[$x]["layer_id"]; ?>" placeholder="Metros...">
									<a href="#" onclick="geomap.map.addBuffer(<?php echo $r[$x]["layer_id"]; ?>,'<?php echo $r[$x]["layer_wms_server"]; ?>&service=WFS&version=1.0.0&request=GetFeature&typeName=get_buffer&outputFormat=shape-zip&',this);">AGREGAR</a>
								</div>	
								
								<!--<div class="texticon-button texticon-button-blue mt-10">
									<a id="dlbuffer-link-<?php //echo $r[$x]["layer_id"]; ?>" href="#" target="_blank" title="Descargar buffer">
										DESCARGAR 
									</a>
									<img src="./images/geovisor/icons/drawing-bar-download.png">
								</div>-->
								
							</div>
							
						</div>
						
						<div class="layer-legend" id="layer-legend-<?php echo $r[$x]["layer_id"]; ?>"></div>
					
					</div>
				
				</div>
				
				<?php
				
			}
			
	
	}

	public function DrawContainers()
	{
		$query_string ='SELECT clase_id,cod_nom,color_hex,color_head,cod_clase_alf FROM mic_catalogo_fdw.clase ORDER BY clase_id ASC;';

		$conexion = new ConexionGeovisores(); 
		//realizo la consulta 
		$r = $conexion->get_consulta($query_string);

		for($x=0; $x<=count($r)-1; $x++)
			{				
			?>				
				<div class="layer-container" data-color="#31cbfd" data-cid="<?php echo $r[$x]["clase_id"]; ?>" style="border-color:#ffffff;">
					<div class="layer-container-header" style="background-color:#31cbfd;">
						<div class="pretty p-default p-curve p-toggle">
							<input type="checkbox" class="layer-checkbox default-empty-checkbox" id="layer-checkbox-class-<?php echo $r[$x]["clase_id"]; ?>" data-layer="<?php //echo $r[$x]["layer_wms_layer"]; ?>" data-wms="<?php //echo $r[$x]["layer_wms_server"]; ?>"/>
							<div class="state p-success p-on" title="Mostrar capa">
								<i class="fa fa-eye"></i>
							</div>
							<div class="state p-danger p-off" title="Ocultar capa">
								<i class="fa fa-eye-slash"></i>
							</div>
						</div>
						<span><?php echo $r[$x]["cod_nom"]; ?> (<span id="abr-layer-count-<?php echo $r[$x]["clase_id"]; ?>" class="abr-layer-count"></span>)</span>		
					</div>
					<div class="layer-container-body scrollbar-content">
						<?php $this->DrawLayers($r[$x]["clase_id"]); ?>
					</div>
				</div>				
				<?php				
			}			
	}

	public function DrawLayersSearch($pattern) // esta funcion recibira un string como parametro
	{
		// variable contenedora de consulta a realizar
		$query_string = <<<EOD
						SELECT DISTINCT * FROM "MIC-GEOVISORES".vw_layers WHERE layer_desc ILIKE '%$pattern%' ORDER BY layer_desc ASC;		
						EOD;
		
		$conexion = new ConexionGeovisores(); 
		//realizo la consulta 
		$resultado = $conexion->get_consulta($query_string);


		// variable contenedora de respuesta final 
		$output = "<ul>";
		
		if(!empty($resultado))
		{
			for($x=0; $x<=count($resultado)-1; $x++)
			{						
				$low_desc = strtolower($resultado[$x]["layer_desc"]);
				$low_pattern = strtolower($pattern);
			
				$desc = str_replace($low_pattern,"<span class=\"panel-highlighted-list-item\">".$low_pattern."</span>",$low_desc);
			
				$output .= "<li>";
				$output .= "<a href=\"javascript:void(0);\" onclick=\"geomap.panel.AddLayer(" . $resultado[$x]["clase_id"] . "," . $resultado[$x]["layer_id"] . "); $('#panel-busqueda-geovisor').hide();\">" . $desc . "</a>";
				$output .= "</li>";
			}
		
		}else{		
			$output .= "<li>No se encontraron resultados para su búsqueda</li>";		
		}
		
		$output .= "</ul>";

		$respuesta_op_server = new respuesta_error_geovisor();
        $respuesta_op_server->flag = true;
        $respuesta_op_server->detalle = $output;

		return $respuesta_op_server;
		
	}

	public function DrawDatasetSearch($pattern) // esta funcion recibira un string como parametro
	{

		$conexion = new ConexionGeovisores();

		// variable contenedora de consulta a realizar
		$query_string = "SELECT DISTINCT * FROM mic_estadisticas_fdw.vw_dt WHERE dt_titulo ILIKE '%$pattern%' ORDER BY dt_titulo ASC;";
			
		$output = "<ul>";

		 

		//realizo la consulta 
		$resultado = $conexion->get_consulta($query_string);
		//print_r($resultado);


		// variable contenedora de respuesta final 
		$output = "<ul>";
		
		if(!empty($resultado))
		{
			for($x=0; $x<=count($resultado)-1; $x++)
			{	

				$low_desc = strtolower($resultado[$x]["dt_titulo"]);
				$low_pattern = strtolower($pattern);
				
				$desc = str_replace($low_pattern,"<span class=\"panel-highlighted-list-item\">".$low_pattern."</span>",$low_desc);
				
				$output .= "<li>";
				$output .= "<a href=\"javascript:void(0);\" onclick=\"$('.panel-abr[data-cid=".$resultado[$x]["clase_id"]."]').trigger('click'); $('#panel-busqueda-geovisor').hide();\">" . $desc . "</a>";
				$output .= "</li>";				
	
			}
		
		}else{		
			$output .= "<li>No se encontraron resultados para su búsqueda</li>";		
		}
		
		$output .= "</ul>";

		return $output;		
	}

	public function DrawProyectos() 
	{			

		$conexion = new ConexionGeovisores(); 

		// variable contenedora de consulta a realizar
		$query_string = <<<EOD
						SELECT * FROM mic_catalogo_fdw.sub_proyecto as e
						WHERE sub_proyecto_id IN (SELECT DISTINCT e.sub_proyecto_id  
												FROM "MIC-GEOVISORES".catalogo c
												LEFT JOIN "MIC-GEOVISORES".vw_estudio_catalogo e ON c.estudios_id = e.estudios_id) 
						ORDER BY sub_proyecto_desc ASC;
					EOD;

		//echo $query_string;
		//realizo la consulta 
		$resultado = $conexion->get_consulta($query_string);
		//print_r($resultado);
		
		$respuesta = '';
		$respuesta_op_server = new respuesta_error();
		if(!empty($resultado))
		{	
			$respuesta = '';

			for($x=0; $x<=count($resultado)-1; $x++)
			{	
					
				$respuesta .= <<<EOD
						<div class="popup-panel-tree-item">
							<div class="pretty p-icon p-curve">
								<input type="checkbox" class="basic-filter-checkbox default-empty-checkbox" data-spid="{$resultado[$x]["sub_proyecto_id"]}"/>
								<div class="state">
									<i class="icon mdi mdi-check" onclick="$(this).parent().prev('input[type=checkbox]').trigger('click');"></i>
									<label>{$resultado[$x]["sub_proyecto_desc"]}</label>
								</div>
							</div>
						</div>

				EOD;

			}
			
			
            $respuesta_op_server->flag = true;
            $respuesta_op_server->detalle = $respuesta;
			
		}else{

            $respuesta_op_server->flag = false;
            $respuesta_op_server->detalle = "No se encontraron resultados";

		}

		return  $respuesta_op_server; 

	}

	public function DrawComboSimple($id,$desc,$schema,$table,$opini,$opini_label,$opini_val,$hname,$hid)
	{
		// nota, queda pendiente lo de editar las variables $schema y $table, para que apunten al lugar correspondientes
		// en teoria, no se cambiaran, pero para tener en cuenta! 

		$query_string = "SELECT $id,$desc FROM $schema.$table ORDER BY $desc ASC";

		$conexion = new ConexionGeovisores(); 

		//realizo la consulta 
		$respuesta = $conexion->get_consulta($query_string);
		//print_r($r);

		if(!empty($respuesta))
		{
			?>
		
			<select class="selectpicker" data-width="100%" 
				<?php 
					if($hname) {
						echo "name=\"$hname\"";
					}
					if($hid) {
						echo "id=\"$hid\"";
					} ?> >
				<?php

					if ($opini) 
					{	?>
							
						<option value="<?php echo $opini_val; ?>"><?php echo $opini_label; ?></option>
							
					<?php

						for($x=0; $x<=count($respuesta)-1; $x++)
						{	?>
					
							<option value="<?php echo $respuesta[$x][$id]; ?>"><?php echo $respuesta[$x][$desc]; ?> </option>
						
					<?php
							
						}	
					} ?>
		
			</select>		
			<?php				
		}
	}

	public function DrawComboSimpleFN($id,$desc,$schema,$table,$opini,$opini_label,$opini_val,$hname,$hid,$fn)
	{	
		$query_string = "SELECT $id,$desc FROM $schema.$table ORDER BY $desc ASC";

		$conexion = new ConexionGeovisores(); 

		//realizo la consulta 
		$respuesta = $conexion->get_consulta($query_string);
		//print_r($r);
		?> 
		
		<select onchange="<?php echo str_replace($id,"this.options[this.selectedIndex].value",$fn); ?>" class="selectpicker" 
		
		<?php 

		if($hname) {
			echo "name=\"$hname\"";
		}
		if($hid) {
			echo "id=\"$hid\"";
		} ?> >

		<?php

		if(!empty($respuesta))
		{ 
			for($x=0; $x<=count($respuesta)-1; $x++)
			{
				if ($opini) 
				{				
					?>
					
					<option value="<?php echo $opini_val; ?>"><?php echo $opini_label; ?></option>
					
					<?php
					
				} ?>				
		
					<option value="<?php echo $respuesta[$x][$id]; ?>"><?php echo $respuesta[$x][$desc]; ?></option>
					
				<?php						
			}
		
		}	?>
		
		</select>
		
		<?php		
		
	}

	public function DrawComboSimpleClase($id,$desc,$schema,$table,$opini,$opini_label,$opini_val,$hname,$hid) 
	{

		// variable contenedora de consulta a realizar
		$query_string =	'SELECT '.$id.','.$desc.' FROM "MIC-GEOVISORES".vw_filtros_avanzados_subclase GROUP BY clase_id,clase_desc ORDER BY $desc ASC';		
			
		$conexion = new ConexionGeovisores(); 

		//realizo la consulta 
		$respuesta = $conexion->get_consulta($query_string);
		//print_r($r);
		?> 
			
		<select class="selectpicker" data-width="100%" onchange="load_sub_clase(this.options[this.selectedIndex].value);"
			<?php 
				if($hname) {
					echo "name=\"$hname\"";
				}
				if($hid) {
					echo "id=\"$hid\"";
				}?>>
			<?php
		
			if ($opini) {
					
				?>
					
			<option value="<?php echo $opini_val; ?>"><?php echo $opini_label; ?></option>
					
				<?php
					
			}

		if(!empty($respuesta))
		{
			for($x=0; $x<=count($respuesta)-1; $x++)
			{
				?>
			
				<option value="<?php echo $r[$id]; ?>"><?php echo $r[$desc]; ?></option>
						
				<?php
							
			}

		}		
		?>
		
		</select> 
		
		<?php
		
	}

	public function GetLayerLabel($layer_name) 
	{				
		
		$query_string = <<<EOD
							SELECT * FROM "MIC-GEOVISORES".vw_layers WHERE layer_wms_layer = '$layer_name';
						EOD;

		//echo $query_string;
					
		$conexion = new ConexionGeovisores(); 

		//realizo la consulta 
		$respuesta = $conexion->get_consulta($query_string);
		//print_r($r);		

		$respuesta_op_server = new respuesta_error();
		if(!empty($respuesta))
		{	
		
            $respuesta_op_server->flag = true;
            $respuesta_op_server->detalle = $layer_desc = $respuesta[0]["layer_desc"];
			
		}else{

            $respuesta_op_server->flag = false;
            $respuesta_op_server->detalle = "No se encontraron resultados";

		}

		return  $respuesta_op_server;
		
	}

	//Nota: $lista_recursos_restringidos es un array con elementos.
	//      $proyectos tambien es un array con varios elementos. 
	//      $geovisor es un valor. 
	public function filter_proyectos_basic($lista_recursos_restringidos, $proyectos, $geovisor) 
	{
		$extension_registros_restringidos = "  NOT IN ( " ; 

        // armo una cadena para usar como subconsulta en la query principal 
        for($x=0; $x<=count($lista_recursos_restringidos)-1; $x++)
        {       
           if($x==count($lista_recursos_restringidos)-1){
               
               $extension_registros_restringidos.=$lista_recursos_restringidos[$x]['objeto_id'].")";
           }else{
               $extension_registros_restringidos.=$lista_recursos_restringidos[$x]['objeto_id'].",";
           }       
        }

		// evaluo la variable $geovisor para realizar la consulta que corresponde en cada caso. 
		if ($geovisor != -1) 
		{	
			// variable que adicionara una parte de la consulta 
			$subconsulta_proyectos = "";			

			if(!empty($proyectos)) // si la lista de proyectos no viene vacia.
			{
				/* se crea la extension para la consulta  */
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

			// echo $get_layers_query_string;

		}else{	// si el geovisor es -1 ( unico valor conocido hasta el momento)

			// variable que adicionara una parte de la consulta 
			$subconsulta_proyectos = "";			

			if(!empty($proyectos)) // si la lista de proyectos no viene vacia.
			{
				/* se crea la extension para la consulta  */
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

		// echo $get_layers_query_string;

		// ejecuto la consulta y evaluo el resultado 

		$conexion = new ConexionGeovisores();
		
		//echo $get_layers_query_string;

		//realizo la consulta 
		$respuesta = $conexion->get_consulta($get_layers_query_string);

		// variable que se debe evaluar en el if !empty $respuesta[0]['layer_ids']
		//$test = '444,222,21,45,78,54,33,441';
		$layers_ids = $respuesta[0]['layer_ids'];
		$respuesta_html = "";
		if(!empty($layers_ids))
		{	
			$query_string = "SELECT clase_id,subclase_id,clase_desc,subclase_desc 
							FROM ".'"MIC-GEOVISORES"'.".vw_layers 
							WHERE layer_id IN ($layers_ids)   
							AND layer_id $extension_registros_restringidos  
							GROUP BY clase_id,subclase_id,clase_desc,subclase_desc 
							ORDER BY clase_desc ASC, subclase_desc ASC";
			//echo $query_string;
		
			$respuesta_2 = $conexion->get_consulta($query_string);
					
			$clase = "";			
			
			for($x=0; $x<=count($respuesta_2)-1; $x++)
			{
				if ($clase != $respuesta_2[$x]["clase_desc"])
				{			
					$clase = $respuesta_2[$x]["clase_desc"];

					$aux_primera_seccion = "";
					if($x==0) // si es el primer registro
					{ 
						$aux_primera_seccion .= <<<EOD
												div class="popup-panel-tree-item" data-state="0">
												<div class="popup-panel-tree-item-header">
													<i class="fas fa-folder popup-panel-tree-item-icon popup-icon"></i>
													<a href="#" class="popup-panel-tree-item-label popup-text">
														<span> $clase </span>
													</a>
													<a href="#" class="simple-tree-pm-button">
														<i class="fa fa-angle-down popup-panel-tree-item-icon-toggler popup-icon"></i>
													</a>
												</div>
												
												<div class="popup-panel-tree-item-subpanel">
						EOD;
						
					}else{ // si no es el primer registro

						$aux_primera_seccion = <<<EOD
												</div>
												</div>
												
												<div class="popup-panel-tree-item" data-state="0">
													<div class="popup-panel-tree-item-header">
														<i class="fas fa-folder popup-panel-tree-item-icon popup-icon"></i>
														<a href="#" class="popup-panel-tree-item-label popup-text">
															<span> $clase </span>
														</a>
														<a href="#" class="simple-tree-pm-button">
															<i class="fa fa-angle-down popup-panel-tree-item-icon-toggler popup-icon"></i>
														</a>
													</div>
													
													<div class="popup-panel-tree-item-subpanel">
						EOD;						
					}  

					$respuesta_html .= $aux_primera_seccion;
					//echo $aux_primera_seccion;

				}

				// segunda seccion 
				$aux_segunda_seccion = <<<EOD

										<div class="popup-panel-tree-item" data-state="0">
					
											<div class="popup-panel-tree-item-header">
												<i class="fa fa-layer-group popup-panel-tree-item-icon popup-icon"></i>
												<a href="#" class="popup-panel-tree-item-label popup-text">
													<span> {$respuesta_2[$x]["subclase_desc"]}</span>
												</a>
												<a href="#" class="simple-tree-pm-button">
													<i class="fa fa-angle-down popup-panel-tree-item-icon-toggler popup-icon"></i>
												</a>
											</div>
				EOD;


				$layer_query_string = "SELECT DISTINCT clase_id,layer_id,tipo_layer_id,layer_desc,layer_wms_layer,layer_wms_server 
										FROM ".'"MIC-GEOVISORES"'.".vw_layers 
										WHERE clase_id = " . $respuesta_2[$x]["clase_id"] . 
										" AND subclase_id = " . $respuesta_2[$x]["subclase_id"] .
										" AND layer_id IN (" . $layers_ids . ")  
										AND layer_id NOT IN (10,11,22,345) 
										ORDER BY layer_desc ASC";
				

				//echo $layer_query_string;
				$respuesta_3 =  $conexion->get_consulta($layer_query_string);

				$lista_li = "";

				for($x2=0; $x2<=count($respuesta_3)-1; $x2++)
				{
					$lista_li .= <<<EOD
									<li>
										<a href="#" onclick="geomap.panel.PreviewLayer({$respuesta_3[$x2]["layer_id"]})"> {$respuesta_3[$x2]["layer_desc"]}</a>	
									</li>					
					EOD;

				}

				$aux_segunda_seccion .= <<<EOD
										<div class="popup-panel-tree-item-subpanel">
											<ul>											
												$lista_li
											</ul>										
										</div>
									</div>
				EOD;

				$respuesta_html .= $aux_segunda_seccion;
						
			} // FIN FOR 

			$respuesta_html .= "	</div>
									</div>";
			

		}else{
			
			$respuesta_html = '<p>No se encontraron capas asociadas a estos proyectos</p>';
		}

		$respuesta_op_server = new respuesta_error_geovisor();
		$respuesta_op_server->flag = true;
		$respuesta_op_server->detalle = $respuesta_html;
		return  $respuesta_op_server;

	}

	public function filter_proyectos_advanced($lista_recursos_restringidos, $adv_search_busqueda, $adv_search_fdesde, $adv_search_fhasta,
											  $adv_search_proyecto_combo, $adv_search_clase_combo, $adv_search_subclase_combo, 
											  $adv_search_responsable_combo, $adv_search_esia_combo, $adv_search_objeto_combo, $geovisor){
		
		//  a partir de aca comienza la funcionalidad del metodo 

		$extension_registros_restringidos = " WHERE C.origen_id_especifico NOT IN ( " ; 

        // armo una cadena para usar como subconsulta en la query principal 
        for($x=0; $x<=count($lista_recursos_restringidos->detalle)-1; $x++)
        {       
           if($x==count($lista_recursos_restringidos->detalle)-1){
               
               $extension_registros_restringidos.=$lista_recursos_restringidos->detalle[$x]['objeto_id'].")";
           }else{
               $extension_registros_restringidos.=$lista_recursos_restringidos->detalle[$x]['objeto_id'].",";
           }       
        }

		$aux_filtros_advanced = "";

		// Armado de filtros
		if(!empty($adv_search_busqueda))
		{
			$aux_filtros_advanced .= " AND C.origen_search_text ILIKE '%".$adv_search_busqueda."%'";
		}

		if(!empty($adv_search_fdesde) OR !empty($adv_search_fhasta)) // si alguna de las fechas no es vacia, agrega el string a la cadena.
		{
			$aux_filtros_advanced .= " AND (('".$adv_search_fdesde."'<=C.tempo_hasta) AND ('".$adv_search_fhasta."' >= C.tempo_desde))";		
		}

		if(!empty($adv_search_proyecto_combo)) 
		{			
			$aux_filtros_advanced .= " AND C.sub_proyecto_id IN ($adv_search_proyecto_combo)";		
		}

		if(!empty($adv_search_clase_combo) && $adv_search_clase_combo >=0) 
		{
			$aux_filtros_advanced .= " AND C.clase_id = ".$adv_search_clase_combo ;		
		}

		if(!empty($adv_search_subclase_combo) && $adv_search_subclase_combo >=0) 
		{
			$aux_filtros_advanced .= " AND C.subclase_id = ".$adv_search_subclase_combo ;		
		}

		if(!empty($adv_search_responsable_combo)) 
		{
			$aux_filtros_advanced .= " AND C.responsable = ".$adv_search_responsable_combo ;		
		}

		if(!empty($adv_search_esia_combo)) 
		{
			$aux_filtros_advanced .= " AND C.cod_esia_id = ".$adv_search_esia_combo ;		
		}

		if(!empty($adv_search_objeto_combo)) 
		{
			$aux_filtros_advanced .= " AND C.objetos_id = ".$adv_search_objeto_combo ;		
		}

		if($geovisor != -1)
		{
			$query_string_filtros_advanced = <<<EOD
												SELECT string_agg(layer_id::text, ', ') AS layer_ids
												FROM (SELECT DISTINCT L.* FROM "MIC-GEOVISORES".vw_catalogo_search C
												INNER JOIN "MIC-GEOVISORES".vw_layers L ON C.origen_id_especifico=L.layer_id 
												$extension_registros_restringidos $aux_filtros_advanced )T 
												WHERE T.layer_id IN(SELECT layer_id FROM "MIC-GEOVISORES".geovisor_capa_inicial 
																	WHERE geovisor_id =  $geovisor)
							EOD;		
		}else{
			$query_string_filtros_advanced = <<<EOD
											SELECT string_agg(layer_id::text, ', ') AS layer_ids
											FROM (SELECT DISTINCT L.* FROM "MIC-GEOVISORES".vw_catalogo_search C
											INNER JOIN "MIC-GEOVISORES".vw_layers L ON C.origen_id_especifico=L.layer_id 
											$extension_registros_restringidos $aux_filtros_advanced )T 
										EOD;			
		}
		// echo $query_string_filtros_advanced;

		
		$conexion = new ConexionGeovisores(); 

		//echo $query_string_filtros_advanced;

		//realizo la consulta que regresara la lista de layers para los filtros seleccionados 

		$respuesta = $conexion->get_consulta($query_string_filtros_advanced);
		
		$layer_ids = $respuesta[0]["layer_ids"];

		$html_respuesta = "";

		if(empty($layer_ids)) // si no hay layers/capas disponibles
		{							
			$html_respuesta .= '<p>No se encontraron capas asociadas a estos proyectos</p>';			
		}else{

			$query_string = <<<EOD
			SELECT clase_id,subclase_id,clase_desc,subclase_desc 
			FROM "MIC-GEOVISORES".vw_layers WHERE layer_id IN ( $layer_ids ) 
			GROUP BY clase_id,subclase_id,clase_desc,subclase_desc 
			ORDER BY clase_desc ASC, subclase_desc ASC;
			EOD;

			$respuesta_2 = $conexion->get_consulta($query_string);

			$clase = "";
					
			for($x=0; $x<=count($respuesta_2)-1; $x++) // por cada capa en la lista 
			{				
				if ($clase != $respuesta_2[$x]["clase_desc"]) { 
					
					$clase = $respuesta_2[$x]["clase_desc"];
					
					if ($x==0) // si es el primer registro... 
					{						
						?>				
						<div class="popup-panel-tree-item" data-state="0">
							<div class="popup-panel-tree-item-header">
								<i class="fas fa-folder popup-panel-tree-item-icon popup-icon"></i>
								<a href="#" class="popup-panel-tree-item-label popup-text">
									<span><?php echo $respuesta_2[$x]["clase_desc"]; ?></span>
								</a>
								<a href="#" class="simple-tree-pm-button">
									<i class="fa fa-angle-down popup-panel-tree-item-icon-toggler popup-icon"></i>
								</a>
							</div>
							
							<div class="popup-panel-tree-item-subpanel">							
						<?php	

					}else{					

						?>				
						
						</div>
						</div>
						
						<div class="popup-panel-tree-item" data-state="0">
							<div class="popup-panel-tree-item-header">
								<i class="fas fa-folder popup-panel-tree-item-icon popup-icon"></i>
								<a href="#" class="popup-panel-tree-item-label popup-text">
									<span><?php echo $respuesta_2[$x]["clase_desc"]; ?></span>
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
							<span><?php echo $respuesta_2[$x]["subclase_desc"]; ?></span>
						</a>
						<a href="#" class="simple-tree-pm-button">
							<i class="fa fa-angle-down popup-panel-tree-item-icon-toggler popup-icon"></i>
						</a>
					</div>
						
					<div class="popup-panel-tree-item-subpanel">
						<ul>
						
							<?php
							
							$layer_query_string = 'SELECT DISTINCT clase_id,layer_id,tipo_layer_id,layer_desc,layer_wms_layer,layer_wms_server 
												   FROM "MIC-GEOVISORES".vw_layers 
												   WHERE clase_id = '.  $respuesta_2[$x]["clase_id"] . " 
												   AND subclase_id = " .  $respuesta_2[$x]["subclase_id"] . " 
												   AND layer_id IN (" . $layer_ids . ") ORDER BY layer_desc ASC";

							$respuesta_3 = $conexion->get_consulta($layer_query_string);

							for($x=0; $x<=count($respuesta_3)-1; $x++)
							{	
								?>
								
								<li>
									<a href="#" onclick="geomap.panel.PreviewLayer(<?php echo $respuesta_3[$x]["layer_id"]; ?>)">
											<?php echo $respuesta_3[$x]["layer_desc"]; ?>
									</a>	
								</li>				
								
								<?php
							}
							
							?>
							
						</ul>
						
					</div>
					
				</div>

				<?php		
		
				$results = true;

			}
			
		}

		


		$html_respuesta .= '</div>
						</div>';
		
		$respuesta_op_server = new respuesta_error();
		$respuesta_op_server->flag = true;
		$respuesta_op_server->detalle = $html_respuesta;
		
	}

	public function wms_get_layer_extent($str_layer_name) 
	{

		// definicion de direccion geoserver 
		// a la hora de pasar a produccion se necesitaria usar la direccion correcta del geoserver 
		$tools_wms_server = 'http://geo.ambiente.gob.ar/geoserver/ows?';

		$index_layers = 0;/* Indice de capa, hay que buscar la capa $str_layer_name */
		$index_boundind = 0; /* Indice de extent, solo aceptamos 4326 */

	    $wms_request = $tools_wms_server."REQUEST=GetCapabilities&SERVICE=WMS";

		$con = curl_init($wms_request);
	
		curl_setopt($con,CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($con,CURLOPT_RETURNTRANSFER, true);
	
		$response = curl_exec($con);

		curl_close($con);

		$capacidades = simplexml_load_string($response);

		$json_buffer_extent = '';

		for($index_layers=0;$index_layers<sizeof($capacidades->Capability->Layer->Layer);$index_layers++)
		{
			if($capacidades->Capability->Layer->Layer[$index_layers]->Name==$str_layer_name)
			{
				for($index_boundind=0;$index_boundind<sizeof($capacidades->Capability->Layer->Layer[$index_layers]->BoundingBox);$index_boundind++)
				{
					if($capacidades->Capability->Layer->Layer[$index_layers]->BoundingBox[$index_boundind]["CRS"]=='EPSG:3857')
					{
						$json_buffer_extent .= "{";
						$json_buffer_extent .= "\"minx\":\"".$capacidades->Capability->Layer->Layer[$index_layers]->BoundingBox[$index_boundind]["minx"]."\",";
						$json_buffer_extent .= "\"miny\":\"".$capacidades->Capability->Layer->Layer[$index_layers]->BoundingBox[$index_boundind]["miny"]."\",";
						$json_buffer_extent .= "\"maxx\":\"".$capacidades->Capability->Layer->Layer[$index_layers]->BoundingBox[$index_boundind]["maxx"]."\",";
						$json_buffer_extent .= "\"maxy\":\"".$capacidades->Capability->Layer->Layer[$index_layers]->BoundingBox[$index_boundind]["maxy"]."\"";
						$json_buffer_extent .= "}";
					};	
				};	
			};	
		};

		return $json_buffer_extent;
	}

	public function get_layer_extent($layer_id) // faltan refactorizar algunas cosas en la consulta y acceso del dblink
	{
		
		$query_string = 'SELECT layer_schema,layer_table,layer_wms_layer 
						 FROM "MIC-GEOVISORES".vw_layers WHERE layer_id = '. $layer_id . " LIMIT 1";

		$conexion = new ConexionGeovisores(); 

		//realizo la consulta 
		$data = $conexion->get_consulta($query_string);

		$query_string_2 = 'SELECT 
							st_xmin(st_expand(st_extent(st_transform(T.geom, 3857)), 200::double precision)::box3d) AS minx,
							st_ymin(st_expand(st_extent(st_transform(T.geom, 3857)), 200::double precision)::box3d) AS miny,
							st_xmax(st_expand(st_extent(st_transform(T.geom, 3857)), 200::double precision)::box3d) AS maxx,
							st_ymax(st_expand(st_extent(st_transform(T.geom, 3857)), 200::double precision)::box3d) AS maxy
						 FROM '.$data[0]["layer_schema"].'.'.$data[0]["layer_table"].'  T';

		//echo $query_string_2;

		$extent = $conexion->get_consulta($query_string_2);

		$json = "";

		$json .= "{";
		$json .= "\"minx\":\"" . $extent[0]["minx"] . "\",";
		$json .= "\"miny\":\"" . $extent[0]["miny"] . "\",";
		$json .= "\"maxx\":\"" . $extent[0]["maxx"] . "\",";
		$json .= "\"maxy\":\"" . $extent[0]["maxy"] . "\"";
		$json .= "}";

		if($extent["minx"]=='') //Algo fue mal, intentamos obtener en extent desde el servicio WMS
		{
			$json = wms_get_layer_extent(trim($data[0]["layer_wms_layer"]));
		};

		$conexion = null;
		return $json;

	}

	public function get_coor_transformed($lon, $lat)
	{

		// esta funcion utiliza una funcion de mod_geovisores
		// la misma no se puede replicar por el tipo de dato GEOMETRY. replicar en bd de produccion. 
		/*
		
		-- FUNCTION: "MIC-GEOVISORES".get_coord(bigint, double precision, double precision)

		-- DROP FUNCTION IF EXISTS "MIC-GEOVISORES".get_coord(bigint, double precision, double precision);

		CREATE OR REPLACE FUNCTION "MIC-GEOVISORES".get_coord(
			epsg bigint,
			_lon double precision,
			_lat double precision)
		RETURNS TABLE(nlon double precision, nlat double precision) 
			LANGUAGE 'plpgsql'
			COST 100
			VOLATILE 
			ROWS 1000
		AS $BODY$
		DECLARE
			n_point GEOMETRY;
			area	GEOMETRY;
		BEGIN

			n_point := ST_SetSRID(ST_MakePoint(_lon, _lat),3857);
			--n_point := ST_MakePoint(_lon, _lat);
			
			CASE epsg
				WHEN 100003 /* Lambert */ /* THEN
					
				SELECT ST_transform(the_geom,3857) INTO area FROM  "MIC-GEOVISORES".extent_coordenadas WHERE srid=epsg::TEXT;
					
				IF (ST_Within(n_point,area))THEN
					n_point := ST_transform(n_point,100003);
					
					RETURN QUERY SELECT ST_X(n_point)AS _lon,ST_Y(n_point)AS nlat;
				ELSE
					RETURN QUERY SELECT 0.0::DOUBLE PRECISION AS _lon,0.0::DOUBLE PRECISION AS nlat;
				END IF;
				
			WHEN 100001  /* Condor Cliff */ /* THEN
				
				SELECT ST_transform(the_geom,3857) INTO area FROM  "MIC-GEOVISORES".extent_coordenadas WHERE srid=epsg::TEXT;
				
				IF (ST_Within(n_point,area))THEN
					n_point := ST_transform(n_point,100001);
					RETURN QUERY SELECT ST_X(n_point)AS _lon,ST_Y(n_point)AS nlat;
				ELSE
					RETURN QUERY SELECT 0.0::DOUBLE PRECISION AS _lon,0.0::DOUBLE PRECISION AS nlat;
				END IF;
				
			WHEN 100002 /* Barrancosa */ /*THEN
				SELECT ST_transform(the_geom,3857) INTO area FROM  "MIC-GEOVISORES".extent_coordenadas WHERE srid=epsg::TEXT;
				
				IF (ST_Within(n_point,area))THEN
					n_point := ST_transform(n_point,100002);
					RETURN QUERY SELECT ST_X(n_point)AS _lon,ST_Y(n_point)AS nlat;
				ELSE
					RETURN QUERY SELECT 0.0::DOUBLE PRECISION AS _lon,0.0::DOUBLE PRECISION AS nlat;
				END IF;
				
			ELSE
				RETURN QUERY SELECT 0.0::DOUBLE PRECISION AS _lon,0.0::DOUBLE PRECISION AS nlat;
		END CASE;

		END;
		$BODY$;

		ALTER FUNCTION "MIC-GEOVISORES".get_coord(bigint, double precision, double precision)
		OWNER TO postgres;		
		
		*/


		$conexion = new ConexionGeovisores(); 

		
		$query_string = 'SELECT * FROM "MIC-GEOVISORES".get_coord(100001,$lon,$lat)';		
		$data = $conexion->get_consulta($query_string);
		$lon100001 = $data[0]["nlon"];
		$lat100001 = $data[0]["nlat"];

		$query_string = 'SELECT * FROM "MIC-GEOVISORES".get_coord(100002,$lon,$lat)';		
		$data = $conexion->get_consulta($query_string);
		$lon100002 = $data[0]["nlon"];
		$lat100002 = $data[0]["nlat"];

		$query_string = 'SELECT * FROM "MIC-GEOVISORES".get_coord(100003,$lon,$lat)';		
		$data = $conexion->get_consulta($query_string);
		$lon100003 = $data[0]["nlon"];
		$lat100003 = $data[0]["nlat"];

		$json = "{";

		$json .= "\"coord100001\":{\"lon\":\"$lon100001\",\"lat\":\"$lat100001\",\"label\":\"Condor Cliff\"},";
		$json .= "\"coord100002\":{\"lon\":\"$lon100002\",\"lat\":\"$lat100002\",\"label\":\"Barrancosa\"},";
		$json .= "\"coord100003\":{\"lon\":\"$lon100003\",\"lat\":\"$lat100003\",\"label\":\"Lambert\"}";

		$json .= "}";

		$respuesta_op_server = new respuesta_error_geovisor();
		$respuesta_op_server->flag = true;
   		$respuesta_op_server->detalle = $json;

		return $respuesta_op_server;

	}

	public function get_medicion($wkt, $type)
	{
		if ($type == "LineString") {

			//$query_string = "SELECT ST_Length(ST_GeomFromText('".$wkt."')::geography,true) / 1000 AS km;";
			$query_string = "SELECT ST_Length(st_transform(ST_GeomFromText('".$wkt."',3857),4326)::geography,true) / 1000 AS km;";
			//echo $query_string;

		}else{
			
			//$query_string = "SELECT ST_Perimeter(ST_GeomFromText('".$wkt."')) / 1000 AS km,ST_Area(ST_GeomFromText('".$wkt."')) / 1000 AS area;";
			
			//$query_string = "SELECT ST_Perimeter(ST_GeomFromText('".$wkt."')) / 1000 AS km,ST_Area(ST_Transform(ST_GeomFromText('".$wkt."',3857),4326)::geography) AS area;";
			
			$query_string = "SELECT ST_Perimeter(st_transform(ST_GeomFromText('".$wkt."',3857),4326)::geography) / 1000 AS km,ST_Area(ST_Transform(ST_GeomFromText('".$wkt."',3857),4326)::geography) AS area;";

			//echo "<!--$query_string-->";
			

		}

		$conexion = new ConexionGeovisores(); 

		$data = $conexion->get_consulta($query_string);

		$area = $data[0]["area"];

		$data = explode(".",$data[0]["km"]);

		$data = $data[0][0] . "." . substr($data[0][1],0,2);

		if ($type == "LineString") 
		{
			echo "<p>Distancia: " . $data . " Km.</p>";
			
		}else{
			
			echo "<p>Área: " . $area . " m2.</p>";
			echo "<p>Perímetro: " . $data . " Km.</p>";			
		}

	}

	public function get_buffer($wkt, $layers)
	{

		$query_string = "SELECT * FROM ".'"MIC-GEOVISORES"'.".gfi_buffer('" . $wkt . "','" . implode(",",$layers) . "');";

		$conexion = new ConexionGeovisores(); 

		$respuesta = $conexion->get_consulta($query_string);

		for($x=0; $x<=count($respuesta)-1; $x++)
		{
			echo $respuesta[$x]["img_tag"];
		}
	}

	public function get_layer_preview($layer_id)
	{
		
		$query_string = 'SELECT clase_id,preview_titulo,preview_desc,preview_link FROM "MIC-GEOVISORES".vw_layers WHERE layer_id = ' . $layer_id;

		$conexion = new ConexionGeovisores(); 

		$data = $conexion->get_consulta($query_string);

		$respuesta_op_server = new respuesta_error_geovisor();

		if(!empty($data))
		{	
			$html = <<<EOD
						<p class="title" id="layer-preview-title"> {$data[0]["preview_titulo"]} </p>
						<p class="content"> {$data[0]["preview_desc"]}</p>
					EOD;	

		    $respuesta_op_server->flag = true;
            $respuesta_op_server->detalle = $html;
			
		}else{

            $respuesta_op_server->flag = false;
            $respuesta_op_server->detalle = "No se encontraron resultados";

		}

		return  $respuesta_op_server;
	
	
	}

	public function ComboSubclase($clase_id)
	{

		$conexion = new ConexionGeovisores(); 		
		
		$query_string = 'SELECT * FROM "MIC-GEOVISORES".vw_filtros_avanzados_subclase WHERE clase_id = $clase_id ORDER BY subclase_desc ASC';
		
		$data = $conexion->get_consulta($query_string);
		
		$html = "<option value=\"-1\" selected>Subclase</option>";

		foreach($data as $registro)
		{
			$html .= "<option value=\"" . $registro["subclase_id"] . "\">" . $registro["subclase_desc"] . "</option>";
		
		}
			
		return $html;
    }

}; // fin interface 



// test

$test = new RepositorioQueryGeovisor();
$respuesta = $test->get_layer_info_pgda();
echo $respuesta;




//echo $test->get_buffer('raster', [1,2,3,4]);
//echo wms_get_layer_extent('ahrsc:area_lb'); //Demo






	

 
?>
