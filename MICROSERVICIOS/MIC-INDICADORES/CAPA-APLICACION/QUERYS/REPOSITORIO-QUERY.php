<?php

require_once(dirname(__FILE__,4).'\MIC-INDICADORES\CAPA-DOMINIO\INTERFACE-QUERYS\REPOSITORIO-INTERFACE-QUERY.php');
require_once(dirname(__FILE__,4).'\MIC-INDICADORES\CAPA-DATOS\capa-acceso.php');



class RepositorioQueryIndicadores implements IRepositorioQueryIndicadores{

    public function DrawAbrInd($lista_recursos_restringidos)
    {
        // print_r($lista_recursos_restringidos);
       
        $extension_recursos_restringidos = " AND ind_id NOT IN (";

        // armo una cadena para usar como subconsulta en la query principal 
        for($x=0; $x<=count($lista_recursos_restringidos->detalle)-1; $x++)
        {       
            if($x==count($lista_recursos_restringidos->detalle)-1){
                
                $extension_recursos_restringidos.=$lista_recursos_restringidos->detalle[$x]['objeto_id'].")";
            }else{
                $extension_recursos_restringidos.=$lista_recursos_restringidos->detalle[$x]['objeto_id'].",";
            }       
        }       

        $conexion = new ConexionIndicadores();
        $query_string = 'SELECT clase_id,clase_desc,color_hex,color_head,cod_clase_alf FROM mic_catalogo_fdw.clase ORDER BY clase_id ASC;'; 
        
        //echo $query_string; 

        $resultado_consulta = $conexion->get_consulta($query_string);
 		$lista_resultado = '';

        foreach($resultado_consulta as $clase) 
        {       
          // print_r($clase); 
        
           $query_string_records = 'SELECT * FROM "MIC-INDICADORES".ind_panel WHERE clase_id = '. $clase["clase_id"] . "  ORDER BY ind_titulo ASC"; // falta poner el and del filtro de los recursos restringidos. 
		
		   //echo $query_string_records;

           $resultado_consulta_records = $conexion->get_consulta($query_string_records);   

            if (!empty($resultado_consulta_records)) {

				$aux_cantidad = count($resultado_consulta_records);
            
                $lista_resultado .= <<<EOD
                    <div class="abr panel-abr" data-color="#31cbfd" data-bgcolor="#FFFFFF" data-active="0" data-cid="{$clase["clase_id"]}" title="{$clase["clase_desc"]}" data-r="$aux_cantidad">
                            <span>{$clase["cod_clase_alf"]}</span>
                    </div>                
                EOD;    
            
            }

        } // fin foreach 
        
		$respuesta_op_server = new respuesta_error_indicadores();

		if(!empty($lista_resultado))
		{
			$respuesta_op_server->flag = true;
			$respuesta_op_server->detalle = $lista_resultado;    

		}else{

			$respuesta_op_server->flag = false;
			$respuesta_op_server->detalle = $html_response;        
		}

		return $respuesta_op_server;


    } // fin DrawAbrInd 

	public function DrawContainersInd($lista_recursos_restringidos)
	{   
		// print_r($lista_recursos_restringidos);
       	$extension_recursos_restringidos = " AND recurso_id NOT IN (";

		// armo una cadena para usar como subconsulta en la query principal 
		for($x=0; $x<=count($lista_recursos_restringidos->detalle)-1; $x++)
		{       
			if($x==count($lista_recursos_restringidos->detalle)-1){
				
				$extension_recursos_restringidos.=$lista_recursos_restringidos->detalle[$x]['objeto_id'].")";
			}else{
				$extension_recursos_restringidos.=$lista_recursos_restringidos->detalle[$x]['objeto_id'].",";
			}       
		}   

 		$conexion = new ConexionIndicadores();

		$query_string = 'SELECT clase_id,cod_nom,color_hex,color_head,cod_clase_alf FROM mic_catalogo_fdw.clase ORDER BY clase_id ASC;';
		
		//echo $query_string; 
 		$resultado_consulta = $conexion->get_consulta($query_string);
		$lista_resultado = '';

		foreach($resultado_consulta as $clase) 
		{       

		// print_r($clase); 
		
		$query_string_records = 'SELECT * FROM "MIC-INDICADORES".ind_panel WHERE clase_id = '. $clase["clase_id"] . " ORDER BY ind_titulo ASC"; // falta poner el and del filtro de los recursos restringidos. 
		
		$resultado_consulta_records = $conexion->get_consulta($query_string_records);                
						
		 if (!empty($resultado_consulta_records)) {

			$aux_draw_ind = $this->DrawIndicadores($lista_recursos_restringidos, $clase["clase_id"]);
		 
			 $lista_resultado .= <<<EOD
							<div class="layer-container" data-color="#31cbfd" data-cid="{$clase["clase_id"]}" style="border-color:#FFFFFF">
								<div class="layer-container-header" style="background-color:#31cbfd;">				
									<span> {$clase["cod_nom"]} </span>		
								</div>
								<div class="layer-container-body scrollbar-content">
									$aux_draw_ind
								</div>
							</div>             
			EOD;    
		 
		 }
 
		 } // fin foreach 	
 
		$respuesta_op_server = new respuesta_error_indicadores();

		if(!empty($lista_resultado))
		{
			$respuesta_op_server->flag = true;
			$respuesta_op_server->detalle = $lista_resultado;    

		}else{

			$respuesta_op_server->flag = false;
			$respuesta_op_server->detalle = $html_response;        
		}

		return $respuesta_op_server;

	} // fin DrawContainersInd

	public function DrawIndicadores($lista_recursos_restringidos,$clase_id) 
	{
	
		$extension_recursos_restringidos = " AND ip.recurso_id NOT IN (";

        // armo una cadena para usar como subconsulta en la query principal con los recursos restringidos
        for($x=0; $x<=count($lista_recursos_restringidos->detalle)-1; $x++)
        {       
            if($x==count($lista_recursos_restringidos->detalle)-1){
                
                $extension_recursos_restringidos.=$lista_recursos_restringidos->detalle[$x]['objeto_id'].")";
            }else{
                $extension_recursos_restringidos.=$lista_recursos_restringidos->detalle[$x]['objeto_id'].",";
            }       
        }       

        $conexion = new ConexionIndicadores();

        $query_string = 'SELECT DISTINCT * FROM "MIC-INDICADORES".ind_panel ip WHERE clase_id = '.$clase_id.'  ORDER BY ind_titulo ASC';
        
        // echo $query_string; 

        $resultado_consulta = $conexion->get_consulta($query_string);

		$html_return = '';
		
		if(!empty($resultado_consulta))
		{			
			foreach($resultado_consulta as $clase) 
			{ 
				
				$html_return.= <<<EOD
				<div class="layer-group" data-state="0" data-cid="{$clase["clase_id"]}">					
					<div class="layer-header">							
						<a href="#" class="layer-label" id="indicador-label-{$clase["ind_id"]}" onclick="indicadores.loadIndicador({$clase["ind_id"]},{$clase["ind_titulo"]},{$clase["clase_id"]}); $('.layer-label').removeClass('layer-label-active'); $(this).addClass('layer-label-active'); $('#nav-panel-arrow-a').trigger('click');">
							<span>{$clase["ind_titulo"]} </span>
						</a>							
					</div>					
				</div>		

				EOD;				
			}
		
		}else{
			
			$html_return .= <<<EOD
				<div class="layer-group" data-state="0" data-cid="{$clase["clase_id"]}">				
					<div class="layer-header">					
						<p>
							<span>No se encontraron paneles de indicadores asociados a esta clase.</span>
						</p>					
					</div>			
				</div>	
			EOD;				
		}		

		return $html_return;
	}

	function DrawIndicadoresSearch($lista_recursos_restringidos,$pattern)
	{	
		       
        $extension_recursos_restringidos = " AND r.recurso_id NOT IN (";

        // armo una cadena para usar como subconsulta en la query principal 
        for($x=0; $x<=count($lista_recursos_restringidos->detalle)-1; $x++)
        {       
            if($x==count($lista_recursos_restringidos->detalle)-1){
                
                $extension_recursos_restringidos.=$lista_recursos_restringidos->detalle[$x]['objeto_id'].")";
            }else{
                $extension_recursos_restringidos.=$lista_recursos_restringidos->detalle[$x]['objeto_id'].",";
            }       
        }       

        $conexion = new ConexionIndicadores();

        $query_string = 'SELECT DISTINCT * FROM "MIC-INDICADORES".ind_panel WHERE ind_titulo ILIKE '."'%$pattern%' ORDER BY ind_titulo ASC;"; // falta hacer el filtro de recuross restringidos. AND mod_login.check_permisos_new(3, ind_id, $user_id)
        
        $resultado_consulta = $conexion->get_consulta($query_string);

		$respuesta = "<ul>";
		$results = false;

        foreach($resultado_consulta as $clase) 
        {       

			$low_desc = strtolower($clase["ind_titulo"]);
			$low_pattern = strtolower($pattern);
			
			$desc = str_replace($low_pattern,"<span class=\"panel-highlighted-list-item\">".$low_pattern."</span>",$low_desc);
			
			$respuesta .= "<li>";
			$respuesta .= "<a href=\"javascript:void(0);\" onclick=\"indicadores.loadIndicador(" . $clase["ind_id"] . ",'" . $clase["ind_titulo"] . "',".$clase["clase_id"]."); $('#panel-busqueda-geovisor').hide();\">" . $desc . "</a>";
			$respuesta .= "</li>";
	
			$results = true;
	
		}
		
		if (!$results) {
		
			$respuesta .= "<li>No se encontraron resultados para su búsqueda</li>";		
		}
		
		$respuesta .= "</ul>";	


		$respuesta_op_server = new respuesta_error_indicadores();

		$respuesta_op_server->flag = true;
		$respuesta_op_server->detalle = $respuesta;    

		return $respuesta_op_server;
		

	} // DrawIndicadoresSearch

	public function ComboCruce()  // la relacion a la que apunta esta funcion no se encuentra definida en la bd replicada
	{		
		$conexion = new ConexionIndicadores();

		$query_string = 'SELECT * FROM "MIC-ESTADISTICAS".dt_cruce ORDER BY dt_cruce_etiqueta ASC';
              
        $resultado_consulta = $conexion->get_consulta($query_string);

		foreach($resultado_consulta as $opcion) 
        {       
			?>
			
			<option value="<?php echo $opcion["dt_cruce_table"]; ?>"><?php echo $opcion["dt_cruce_etiqueta"]; ?></option>
			
			<?php
			
		}
		
	}

} // fin RepositorioQueryIndicadores


