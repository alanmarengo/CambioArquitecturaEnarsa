<?php
require_once(dirname(__FILE__,4).'\MIC-GEOVISOR\CAPA-DOMINIO\INTERFACE-REPOSITORIO-QUERY\INTERFACE-REPOSITORIO-QUERY.php');
require_once(dirname(__FILE__,4).'\MIC-GEOVISOR\CAPA-DATOS\capa-acceso.php');

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


    public function ListaProyectos()
	{
		// NOTA IMPORTANTE: por el momento la tabla Proyectos no exite en MIC-GEOVISORES porque tampoco existe en la bd AHRSC
		// por lo que aparentemente esa tabla existe en la base de datos de produccion nada mas 
		// una vez se replique esa tabla a la bd la funcion se ejecutara correctamente .
        $query_string = 'SELECT proyecto_id,proyecto_titulo FROM "MIC-GEOVISORES".proyectos ORDER BY proyecto_titulo ASC'; 

		$conexion = new ConexionGeovisores();        
        //realizo la consulta            
        $consulta = $conexion->get_consulta($query_string);   	

		 // recorro el arreglo con los datos de la consulta 
		for($x=0; $x<=count($consulta)-1; $x++)
		{  
			?>

			<a class="dropdown-item" href="#" data-id="<?php echo  $consulta[$x]["proyecto_id"]; ?>"><?php echo  $consulta[$x]["proyecto_titulo"]; ?></a>          
		
			<?php 
		}
	
		
	}

	public function DrawAbr()
	{
		$query_string = <<<EOD
                            SELECT * FROM dblink('dbname=MIC-CATALOGO
                            hostaddr=179.43.126.101 
                            user=postgres 
                            password=plahe100%
                            port=5432',
                            'SELECT clase_id,clase_desc,color_hex,color_head,cod_clase_alf FROM "MIC-CATALOGO".clase ORDER BY clase_id ASC') 
                            as dt(clase_id integer, clase_desc text, color_hex text, color_head text, cod_clase_alf text)
                        EOD;

		$conexion = new ConexionGeovisores(); 

		//realizo la consulta 
		$r = $conexion->get_consulta($query_string);
		//print_r($r);

		for($x=0; $x<=count($r)-1; $x++)
		{  
			echo '<div class="abr panel-abr" data-color="#31cbfd" data-bgcolor="#FFFFFF" data-active="0" data-cid="'.$r[$x]["clase_id"].'" title="'.$r[$x]["clase_desc"].'">
                 <span>'.$r[$x]["cod_clase_alf"].'</span>
            </div>' ;
		}	    

	}

	public function DrawLayers($clase_id) 
	{
		$consulta_definitiva = 'SELECT DISTINCT clase_id,layer_id,tipo_layer_id,layer_desc,layer_wms_layer,layer_wms_server,layer_metadata_url FROM ';

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
									LEFT JOIN dblink('dbname=MIC-CATALOGO
														hostaddr=179.43.126.101 
														user=postgres 
														password=plahe100%
														port=5432',
														'SELECT sc.subclase_id, sc.subclase_desc, sc.clase_id,  c.clase_desc,  c.cod_clase_alf
														FROM "MIC-CATALOGO".subclase sc
														JOIN "MIC-CATALOGO".clase c ON sc.clase_id = c.clase_id') 
											as sc(subclase_id bigint, subclase_desc text, clase_id bigint, clase_desc text, cod_clase_alf text) ON sc.subclase_id = c.subclase_id
									LEFT JOIN dblink('dbname=MIC-CATALOGO
														hostaddr=179.43.126.101 
														user=postgres 
														password=plahe100%
														port=5432',
														'SELECT estudios_id, nombre, cod_oficial FROM "MIC-CATALOGO".estudios') 
											as e(estudios_id bigint, nombre text, cod_oficial text) ON e.estudios_id = c.estudios_id
									LEFT JOIN "MIC-GEOVISORES".tipo_layer tl ON tl.tipo_layer_id = l.tipo_layer_id
									LEFT JOIN "MIC-GEOVISORES".tipo_origen tipo_o ON tipo_o.tipo_origen_id = l.tipo_origen_id) A 
								EOD;
		// por ultimo, concatenamos el where
		$consulta_definitiva .= " WHERE clase_id = " . $clase_id . " ORDER BY layer_desc ASC";

		$conexion = new ConexionGeovisores(); 

		//realizo la consulta 
		$r = $conexion->get_consulta($consulta_definitiva);
		//print_r($r);
		
		for($x=0; $x<=count($r)-1; $x++)
			{				
			?>				
				<div class="layer-group" data-state="0" data-layer-name="<?php echo $r[$x][$x]["layer_wms_layer"]; ?>" data-layer="<?php echo $r[$x]["layer_id"]; ?>" data-cid="<?php echo $r[$x]["clase_id"]; ?>" data-layer-type="<?php echo $r[$x]["tipo_layer_id"]; ?>">
				
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
		$query_string = <<<EOD
                            SELECT * FROM dblink('dbname=MIC-CATALOGO
                            hostaddr=179.43.126.101 
                            user=postgres 
                            password=plahe100%
                            port=5432',
                            'SELECT clase_id,cod_nom,color_hex,color_head,cod_clase_alf FROM "MIC-CATALOGO".clase ORDER BY clase_id ASC') 
                            as dt(clase_id integer, cod_nom text,color_hex text,color_head text,cod_clase_alf text)
                        EOD;

		$conexion = new ConexionGeovisores(); 

		//realizo la consulta 
		$r = $conexion->get_consulta($query_string);
		//print_r($r);
		
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





































	}


