<?php
require_once(dirname(__FILE__,4).'/MIC-MEDIATECA/CAPA-DOMINIO/INTERFACE-REPOSITORIO-QUERY/INTERFACE-REPOSITORIO-QUERY.php');
require_once(dirname(__FILE__,4).'/MIC-MEDIATECA/CAPA-DATOS/capa-acceso.php');
require_once(dirname(__FILE__,4).'/MIC-MEDIATECA/CAPA-DOMINIO/CLASES/clases.php');
require_once(dirname(__FILE__,4).'/MIC-MEDIATECA/CAPA-DOMINIO/ENTIDADES/ENTIDADES.php');
require_once(dirname(__FILE__,4).'/MIC-MEDIATECA/CAPA-DOMINIO/DTOS/DTOS.php');



// COMENTARIO DE PRUEBA
class RepositorioQueryMediateca implements IRepositorioQueryMediateca{

    public function get_recursos($lista_recursos_restringidos, $solapa, $current_page,$page_size,$order_by){

        $extension_consulta_filtro_recursos = " AND r.recurso_id NOT IN (";

        // armo una cadena para usar como subconsulta en la query principal 
        for($x=0; $x<=count($lista_recursos_restringidos->detalle)-1; $x++)
        {       
           if($x==count($lista_recursos_restringidos->detalle)-1){
               
               $extension_consulta_filtro_recursos.=$lista_recursos_restringidos->detalle[$x]['objeto_id'].")";
           }else{
               $extension_consulta_filtro_recursos.=$lista_recursos_restringidos->detalle[$x]['objeto_id'].",";
           }       
        }

        // ordenamiento

        switch ($order_by)
		{
			case 0: 	$ORDER = " ORDER BY origen_id_especifico, r.recurso_titulo ASC"; break;
			case 1: 	$ORDER = " ORDER BY origen_id_especifico, r.recurso_titulo DESC"; break;
			case 2: 	$ORDER = " ORDER BY tipo_formato_solapa, mod_mediateca.get_total_vistas_recurso(origen_id_especifico,origen_id) DESC"; break; // quedan estos dos para revisar 
			case 3: 	$ORDER = " ORDER BY tipo_formato_solapa, mod_mediateca.get_total_vistas_recurso(origen_id_especifico,origen_id) ASC"; break; // quedan estos dos para revisar 
			case 4: 	$ORDER = " ORDER BY origen_id_especifico, r.recurso_fecha DESC"; break;
			case 5: 	$ORDER = " ORDER BY origen_id_especifico, r.recurso_fecha ASC"; break;
			case 6: 	$ORDER = "  ORDER BY origen_id_especifico, r.fecha_observatorio DESC"; break;
			//default: 	$ORDER = " ORDER BY tipo_formato_solapa,recurso_titulo ASC"; break;
		};

        if($order_by==6){
            $filtro_fecha_observatorio= " AND r.fecha_observatorio IS NOT NULL";
        }
        else{
            $filtro_fecha_observatorio="";
        }

        // variable paginado  

        $consulta_paginado= 'SELECT COUNT(*) AS cant_rec_solapa
                             FROM "MIC-MEDIATECA".recurso r
                             INNER JOIN "MIC-MEDIATECA".formato f ON f.formato_id = r.formato_id
                             INNER JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                             WHERE tf.tipo_formato_solapa =';

        $total_registros = $this->get_cantidad_recursos_solapa($consulta_paginado,$solapa,"",$extension_consulta_filtro_recursos);
        $cant_paginas= ceil($total_registros/$page_size);
        
        if($current_page == 0)
        {
            $inicio = 0;
        }elseif($current_page > 0){
            $inicio = ($current_page - 1) * $page_size; 
        }                

        $paginador = ' LIMIT '.$page_size.' OFFSET '.$inicio;

        // fin paginador ---------------------------------

        $consulta_definitiva = <<<EOD
                                    SELECT 'recurso mediateca'::text AS origen, 5::bigint AS origen_id, 
                                    r.recurso_id AS origen_id_especifico,    
                                    r.recurso_titulo AS origen_search_text, r.subclase_id, r.estudios_id, 
                                    NULL::bigint AS cod_esia_id, r.cod_temporalidad_id, 
                                    NULL::bigint AS objetos_id, r.recurso_categoria_id, r.tipo_recurso_id, 
                                    r.formato_id, r.recurso_titulo, r.recurso_desc, r.recurso_fecha, 
                                    r.recurso_autores, r.recurso_path_url, r.recurso_size, r.territorio_id, 
                                    tr.tipo_recurso_desc, rc.recurso_categoria_desc, f.tipo_formato_id, 
                                    f.visualizacion_tipo_id, f.formato_desc, f.formato_extension, 
                                    vt.visualizacion_tipo_desc,tf.tipo_formato_solapa, 
                                    tf.tipo_formato_desc, r.sub_proyecto_id as sub_proyecto_id, r.fecha_observatorio
                                    FROM "MIC-MEDIATECA".recurso r
                                    LEFT JOIN "MIC-MEDIATECA".tipo_recurso tr ON tr.tipo_recurso_id = r.tipo_recurso_id
                                    LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = r.formato_id
                                    LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = r.recurso_categoria_id
                                    LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                    LEFT JOIN "MIC-MEDIATECA".visualizacion_tipo vt ON vt.visualizacion_tipo_id = f.visualizacion_tipo_id
                                    WHERE tf.tipo_formato_solapa =  
                                    EOD; 

        $consulta_definitiva .= ' '.$solapa.' '.$extension_consulta_filtro_recursos.' '.$filtro_fecha_observatorio.' '.$ORDER.' '.$paginador;        
       
        // instancio una nueva conexion 
        $conexion = new ConexionMediateca();

       // echo $consulta_definitiva;
        
        //realizo la consulta            
        $recursos_mediateca = $conexion->get_consulta($consulta_definitiva);   

        //creo un array para guardar todos los recursos 
        $array_recursos_mediateca = array();

        // recorro el arreglo con los datos de la consulta 
        for($x=0; $x<=count($recursos_mediateca)-1; $x++)
        {
            $solapa= $recursos_mediateca[$x]['origen'];
            $origen_id= $recursos_mediateca[$x]['origen_id'];
            $id_recurso= $recursos_mediateca[$x]['origen_id_especifico'];
            $titulo= $recursos_mediateca[$x]['recurso_titulo'];
            $descripcion= $recursos_mediateca[$x]['recurso_desc'];
            $link_imagen= $recursos_mediateca[$x]['recurso_path_url']; 
            $autores= $recursos_mediateca[$x]['recurso_autores']; 
            $fecha= $recursos_mediateca[$x]['recurso_fecha'];
            $territorio_id= $recursos_mediateca[$x]['territorio_id'];
            $estudios_id= $recursos_mediateca[$x]['sub_proyecto_id'];            
            $metatag= $recursos_mediateca[$x]['recurso_categoria_desc'];
            $tema= $recursos_mediateca[$x]['recurso_categoria_desc'];            

    
            // por cada registro, se agrega un objeto recurso al array contenedor 
            $recurso = new Recurso($solapa,$origen_id,$id_recurso,$titulo,$descripcion,$link_imagen,$metatag,$autores,$estudios_id,$fecha,$tema,$territorio_id);
            array_push($array_recursos_mediateca,$recurso);
            
        }      
        
        $conexion->desconectar(); // cierro la conexion 

                
        $respuesta_recursos_mediateca = new respuesta_error_mediateca();
        $respuesta_recursos_mediateca->flag = true;
        $respuesta_recursos_mediateca->detalle = new Recursos($array_recursos_mediateca,$cant_paginas ,$extension_consulta_filtro_recursos);       
        
        return $respuesta_recursos_mediateca;


        // se retorna un objeto json de los recursos 
        // Recursos($recursos,$CantidadPaginas,$lista_recursos_restringidos)
        // CANTIDAD DE PAGINAS // ,  $extension_consulta_filtro_recursos );
    }

    public function get_cantidad_recursos_solapa($query, $solapa, $filtros, $extension_consulta_filtro_recursos)
    {
        // variable consulta  
        $cantidad_recursos_solapa = $query.' '.$solapa.' '.$filtros.' '.$extension_consulta_filtro_recursos.';';
        //echo $cantidad_recursos_solapa; 

        // instancio una nueva conexion 
        $conexion = new ConexionMediateca();

        //realizo la consulta   
                       
        $aux_cantidad = $conexion->get_consulta($cantidad_recursos_solapa);   

        $conexion->desconectar(); // cierro la conexion

        return $aux_cantidad[0]['cant_rec_solapa'];
    }

    public function get_estadistica_inicial()
    {
        $consulta_estadistica_inicial = 'SELECT * FROM "MIC-MEDIATECA".estadistica_inicial ';

        $conexion = new ConexionMediateca();

        $resultado = $conexion->get_consulta($consulta_estadistica_inicial);
        $documentos = $resultado[0]['solapa_0'];
        $recursos_audiovisuales = $resultado[0]['solapa_1'];
        $recursos_tecnicos = $resultado[0]['solapa_2'];
        $novedades = $resultado[0]['solapa_3'];
        $obj_estadistica = new estadisticaInicial($documentos,$recursos_audiovisuales,$recursos_tecnicos,$novedades);

        $conexion->desconectar();
        return  json_encode($obj_estadistica);

    }


    public function get_recursos_filtrado($lista_recursos_restringidos, $solapa, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$order_by){
    
        $extension_consulta_filtro_recursos = "AND t.recurso_id NOT IN (";

        // armo una cadena para usar como subconsulta en la query principal 
        for($x=0; $x<=count($lista_recursos_restringidos->detalle)-1; $x++)
        {       
           if($x==count($lista_recursos_restringidos->detalle)-1){
               
               $extension_consulta_filtro_recursos.=$lista_recursos_restringidos->detalle[$x]['objeto_id'].")";
           }else{
               $extension_consulta_filtro_recursos.=$lista_recursos_restringidos->detalle[$x]['objeto_id'].",";
           }       
        }

        // ordenamiento
        $ORDER = "";
        if(!empty($order_by))
        {
            switch ($order_by)
            {
                case 0: 	$ORDER = " ORDER BY tipo_formato_solapa, recurso_titulo ASC"; break;
                case 1: 	$ORDER = " ORDER BY tipo_formato_solapa, recurso_titulo DESC"; break;
            // case 2: 	$ORDER = " ORDER BY tipo_formato_solapa, mod_mediateca.get_total_vistas_recurso(origen_id_especifico,origen_id) DESC"; break; // quedan estos dos para revisar 
            // case 3: 	$ORDER = " ORDER BY tipo_formato_solapa, mod_mediateca.get_total_vistas_recurso(origen_id_especifico,origen_id) ASC"; break; // quedan estos dos para revisar 
                case 4: 	$ORDER = " ORDER BY tipo_formato_solapa, fecha DESC"; break;
                case 5: 	$ORDER = " ORDER BY tipo_formato_solapa, fecha ASC"; break;
                case 6: 	$ORDER = " ORDER BY tipo_formato_solapa, fecha_observatorio DESC"; break;
                //default: 	$ORDER = " ORDER BY tipo_formato_solapa,recurso_titulo ASC"; break;
            };

            if($order_by==6){
                $filtro_fecha_observatorio= " AND fecha_observatorio IS NOT NULL";
            }
            else{
                $filtro_fecha_observatorio="";
            }

        }
        

        // validacion de filtros 

        $aux_cadena_filtros = ""; // variable contenedora, almacenara un string con todas las adeciones de filtros a la consulta principal

        if(!empty($qt)) // variable que viene del buscador.
        {            

            
            $aux_cadena_filtros = <<<EOD
            AND ( lower("MIC-MEDIATECA".unaccent(T.origen_search_text)) LIKE  lower("MIC-MEDIATECA".unaccent('%$qt%'))
            OR lower("MIC-MEDIATECA".unaccent(e.estudios_palabras_clave)) LIKE  lower("MIC-MEDIATECA".unaccent('%$qt%'))
            OR lower("MIC-MEDIATECA".unaccent(e.nombre)) LIKE  lower("MIC-MEDIATECA".unaccent('%$qt%'))
            OR lower("MIC-MEDIATECA".unaccent(e.equipo)) LIKE  lower("MIC-MEDIATECA".unaccent('%$qt%')) 
            OR lower("MIC-MEDIATECA".unaccent(e.institucion)) LIKE  lower("MIC-MEDIATECA".unaccent('%$qt%'))
            OR lower("MIC-MEDIATECA".unaccent(e.responsable)) LIKE  lower("MIC-MEDIATECA".unaccent('%$qt%')) )
            EOD;


            /*
            
            $aux_cadena_filtros .= " AND ( lower(unaccent(T.origen_search_text)) LIKE  lower(unaccent('%".$qt."%'))"; // con unaccent  lower(unaccent('my_MMuíèles'))
            $aux_cadena_filtros .= " OR lower(unaccent(e.estudios_palabras_clave)) LIKE  lower(unaccent('%".$qt."%'))";
            $aux_cadena_filtros .= " OR lower(unaccent(e.nombre)) LIKE  lower(unaccent('%".$qt."%')) ";
            $aux_cadena_filtros .= " OR lower(unaccent(e.equipo)) LIKE  lower(unaccent('%".$qt."%')) ";
            $aux_cadena_filtros .= " OR lower(unaccent(e.institucion)) LIKE  lower(unaccent('%".$qt."%')) ";
            $aux_cadena_filtros .= " OR lower(unaccent(e.responsable)) LIKE  lower(unaccent('%".$qt."%')) ) "; */
             
        }

        if(!empty($filtro_temporalidad)){

            switch ($filtro_temporalidad) { // dependiendo del valor de $tipo_temporalidad, el filtro de fecha se hace en campos diferentes
                
                case 0:

                    if(!empty($desde) && !empty($hasta)) // si ningun filtro viene vacio. 
                    {

                        $date_hasta = date_create(str_replace("/","-",$hasta));
                        $aux_hora_hasta = date_format($date_hasta, 'Y-m-d');

                        $date_desde = date_create(str_replace("/","-",$desde));
                        $aux_hora_desde = date_format($date_desde, 'Y-m-d');

                        $aux_cadena_filtros .= "  AND (('$aux_hora_desde' BETWEEN ct.tempo_desde AND ct.tempo_hasta) 
                                                OR('$aux_hora_hasta' BETWEEN ct.tempo_desde AND ct.tempo_hasta))";  
                    
                    }else{ 

                        if(empty($desde) && !empty($hasta)) // si desde viene vacio y hasta no. 
                        {
                            $date_hasta = date_create(str_replace("/","-",$hasta));
                            $aux_hora_hasta = date_format($date_hasta, 'Y-m-d');

                            $aux_cadena_filtros .= "  AND (('$aux_hora_hasta' BETWEEN ct.tempo_desde AND ct.tempo_hasta) 
                                                    OR('$aux_hora_hasta' BETWEEN ct.tempo_desde AND ct.tempo_hasta))";
    
                        }else if(!empty($desde) && empty($hasta)) // si desde no viene vacio y hasta si.
                        {

                            $date_desde = date_create(str_replace("/","-",$desde));
                            $aux_hora_desde = date_format($date_desde, 'Y-m-d');

                            $aux_cadena_filtros .= "  AND (('$aux_hora_desde' BETWEEN ct.tempo_desde AND ct.tempo_hasta) 
                                                    OR('$aux_hora_desde' BETWEEN ct.tempo_desde AND ct.tempo_hasta))";
    
                        }
                    }
    
                    break;

                case 1:

                    if(!empty($desde) && !empty($hasta)) // si ningun filtro viene vacio. 
                    {
                        $date_hasta = date_create(str_replace("/","-",$hasta));
                        $aux_hora_hasta = date_format($date_hasta, 'Y-m-d');

                        $date_desde = date_create(str_replace("/","-",$desde));
                        $aux_hora_desde = date_format($date_desde, 'Y-m-d');

                        $aux_cadena_filtros .= " AND (T.fecha_observatorio IS NOT NULL) AND (T.fecha_observatorio BETWEEN '$aux_hora_desde' AND '$aux_hora_hasta')";

                    } else if(empty($desde) && !empty($hasta)){              // si desde viene vacio y hasta no. 

                        $date_hasta = date_create(str_replace("/","-",$hasta));
                        $aux_hora_hasta = date_format($date_hasta, 'Y-m-d');

                        $aux_cadena_filtros .= "  AND (T.fecha_observatorio IS NOT NULL) AND (T.fecha_observatorio <= '$aux_hora_hasta')";
    
                    }else if(!empty($desde) && empty($hasta)){ // si desde no viene vacio y hasta si.
                        
                        $date_desde = date_create(str_replace("/","-",$desde));
                        $aux_hora_desde = date_format($date_desde, 'Y-m-d');

                        $aux_cadena_filtros .= "  AND (T.fecha_observatorio IS NOT NULL) AND (T.fecha_observatorio >= '$aux_hora_desde')";
    
                    }else{ // si llego a este punto, ninguno de los parametros tiene datos, por lo que no asigna nada a la variable.
                        $aux_cadena_filtros .= "";

                    }
                    
                    break;

                case 2:

                    if(!empty($desde) || !empty($hasta)) // si ningun filtro viene vacio. 
                    {
                        
                        if(empty($desde) && !empty($hasta)) // si desde viene vacio y hasta no. 
                        {                                   
                            $date_hasta = date_create(str_replace("/","-",$hasta));
                            $aux_hora_hasta = date_format($date_hasta, 'Y-m-d');

                            $aux_cadena_filtros .= "  AND (recurso_fecha IS NOT NULL)  AND 
                                                           (T.recurso_fecha <= '$haaux_hora_hasta')";
    
                        }else if(!empty($desde) && empty($hasta)) // si desde no viene vacio y hasta si.
                        {
                            $date_desde = date_create(str_replace("/","-",$desde));
                            $aux_hora_desde = date_format($date_desde, 'Y-m-d');

                            $aux_cadena_filtros .= "  AND (recurso_fecha IS NOT NULL) AND (recurso_fecha >= '$aux_hora_desde')";
    
                        }else if(!empty($desde) && !empty($hasta)){

                            $date_hasta = date_create(str_replace("/","-",$hasta));
                            $aux_hora_hasta = date_format($date_hasta, 'Y-m-d');

                            $date_desde = date_create(str_replace("/","-",$desde));
                            $aux_hora_desde = date_format($date_desde, 'Y-m-d');

                            $aux_cadena_filtros .= " AND (recurso_fecha IS NOT NULL) AND (recurso_fecha BETWEEN '$aux_hora_desde' AND '$aux_hora_hasta')";
                        }

                    } 
                    break;
            }

        } 


        if(!empty($proyecto)) { $aux_cadena_filtros .= " AND e.sub_proyecto_id = ".$proyecto; }
        if(!empty($clase)) { $aux_cadena_filtros .= " AND sc.clase_id = ".$clase; }
        if(!empty($subclase)) { $aux_cadena_filtros .= "AND sc.subclase_id =".$subclase; }
        if(!empty($tipo_doc)) { $aux_cadena_filtros .= "AND t.recurso_categoria_id = ".$tipo_doc; }

        // fin validacion de filtros 

        // instancio una nueva conexion 
        $conexion = new ConexionMediateca();
        
        
        // variable paginado  

        $consulta_paginado =<<<EOD
                                SELECT COUNT(*) as cant_rec_solapa  
                                FROM (SELECT r.estudios_id as estudios_id_rec,'recurso mediateca'::text AS origen, 5::bigint AS origen_id, 
                                            r.recurso_id AS origen_id_especifico, r.recurso_id ,
                                            r.recurso_titulo AS origen_search_text, r.subclase_id, r.estudios_id, 
                                            NULL::bigint AS cod_esia_id, r.cod_temporalidad_id, 
                                            NULL::bigint AS objetos_id, r.recurso_categoria_id, r.tipo_recurso_id, 
                                            r.formato_id, r.recurso_titulo, r.recurso_desc, r.recurso_fecha, 
                                            r.recurso_autores, r.recurso_path_url, r.recurso_size, r.territorio_id,
                                            r.sub_proyecto_id, r.fecha_observatorio,
                                            tr.tipo_recurso_desc, rc.recurso_categoria_desc,f.tipo_formato_id
                                            ,f.visualizacion_tipo_id, f.formato_desc, f.formato_extension,vt.visualizacion_tipo_desc,
                                            tf.tipo_formato_solapa
                                    FROM "MIC-MEDIATECA".recurso as r
                                    LEFT JOIN "MIC-MEDIATECA".tipo_recurso tr ON tr.tipo_recurso_id = r.tipo_recurso_id
                                    LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = r.recurso_categoria_id
                                    LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = r.formato_id
                                    LEFT JOIN "MIC-MEDIATECA".visualizacion_tipo vt ON vt.visualizacion_tipo_id = f.visualizacion_tipo_id
                                    LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id) AS T
                                    LEFT JOIN mic_catalogo_fdw.cod_esia AS ce ON t.cod_esia_id = ce.cod_esia_id
                                    LEFT JOIN mic_catalogo_fdw.cod_temporalidad AS ct ON t.cod_temporalidad_id = ct.cod_temporalidad_id
                                    LEFT JOIN mic_catalogo_fdw.subclase AS sc ON T.subclase_id = sc.subclase_id
                                    LEFT JOIN (SELECT e.estudios_id, e.estudios_palabras_clave, e.sub_proyecto_id, 
                                                    e.estudio_estado_id,e.nombre,e.fecha, e.institucion,e.responsable,
                                                    e.equipo, e.cod_oficial, e.descripcion, e.fecha_text_original,
                                                    e.institucion_id, sp.proyecto_id,p.proyecto_desc,
                                                    p.proyecto_extent,i.institucion_nombre, i.institucion_tel,
                                                    i.institucion_contacto, i.institucion_email
                                                FROM mic_catalogo_fdw.estudios e
                                                LEFT JOIN mic_catalogo_fdw.sub_proyecto sp ON sp.sub_proyecto_id = e.sub_proyecto_id
                                                LEFT JOIN mic_catalogo_fdw.proyecto p ON sp.proyecto_id = p.proyecto_id
                                                JOIN mic_catalogo_fdw.institucion i ON i.institucion_id = e.institucion_id) AS e ON t.estudios_id_rec = e.estudios_id
                                    WHERE t.tipo_formato_solapa = 
        EOD;

       // echo $consulta_paginado;

        $total_registros = $this->get_cantidad_recursos_solapa($consulta_paginado,$solapa,$aux_cadena_filtros,$extension_consulta_filtro_recursos);

        $cant_paginas= ceil($total_registros/$page_size);
        
        if($current_page == 0)
        {
            $inicio = 0;
        }elseif($current_page > 0){
            $inicio = ($current_page - 1) * $page_size; 
        }                 

        $paginador = ' LIMIT '.$page_size.' OFFSET '.$inicio;

        // fin paginador ---------------------------------

        // Consulta obtencion de recursos de Mediateca
        $consulta_definitiva = <<<EOD
                                SELECT *,CASE WHEN t.sub_proyecto_id IS NULL THEN e.sub_proyecto_id ELSE t.sub_proyecto_id
                                END AS sub_proyecto_id_principal FROM (SELECT r.estudios_id as estudios_id_rec,'recurso mediateca'::text AS origen, 5::bigint AS origen_id, 
                                                r.recurso_id AS origen_id_especifico, r.recurso_id,
                                                r.recurso_titulo AS origen_search_text, r.subclase_id, r.estudios_id, 
                                                NULL::bigint AS cod_esia_id, r.cod_temporalidad_id, 
                                                NULL::bigint AS objetos_id, r.recurso_categoria_id, r.tipo_recurso_id, 
                                                r.formato_id, r.recurso_titulo, r.recurso_desc, r.recurso_fecha, 
                                                r.recurso_autores, r.recurso_path_url, r.recurso_size, r.territorio_id,
                                                r.sub_proyecto_id, r.fecha_observatorio,
                                                tr.tipo_recurso_desc, rc.recurso_categoria_desc,f.tipo_formato_id
                                                ,f.visualizacion_tipo_id, f.formato_desc, f.formato_extension,vt.visualizacion_tipo_desc,
                                                tf.tipo_formato_solapa
                                            FROM "MIC-MEDIATECA".recurso as r
                                            LEFT JOIN "MIC-MEDIATECA".tipo_recurso tr ON tr.tipo_recurso_id = r.tipo_recurso_id
                                            LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = r.recurso_categoria_id
                                            LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = r.formato_id
                                            LEFT JOIN "MIC-MEDIATECA".visualizacion_tipo vt ON vt.visualizacion_tipo_id = f.visualizacion_tipo_id
                                            LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id) AS T
                                            LEFT JOIN mic_catalogo_fdw.cod_esia AS ce ON t.cod_esia_id = ce.cod_esia_id
                                            LEFT JOIN mic_catalogo_fdw.cod_temporalidad AS ct ON t.cod_temporalidad_id = ct.cod_temporalidad_id
                                            LEFT JOIN mic_catalogo_fdw.subclase AS sc ON T.subclase_id = sc.subclase_id
                                            LEFT JOIN (SELECT e.estudios_id, e.estudios_palabras_clave, e.sub_proyecto_id, 
                                                                    e.estudio_estado_id,e.nombre,e.fecha, e.institucion,e.responsable,
                                                                    e.equipo, e.cod_oficial, e.descripcion, e.fecha_text_original,
                                                                    e.institucion_id, sp.proyecto_id,p.proyecto_desc,
                                                                    p.proyecto_extent,i.institucion_nombre, i.institucion_tel,
                                                                    i.institucion_contacto, i.institucion_email
                                                        FROM mic_catalogo_fdw.estudios e
                                                        LEFT JOIN mic_catalogo_fdw.sub_proyecto sp ON sp.sub_proyecto_id = e.sub_proyecto_id
                                                        LEFT JOIN mic_catalogo_fdw.proyecto p ON sp.proyecto_id = p.proyecto_id
                                                        LEFT JOIN mic_catalogo_fdw.institucion i ON i.institucion_id = e.institucion_id) AS e 
                                                        ON t.estudios_id_rec = e.estudios_id
                                        WHERE t.tipo_formato_solapa =  $solapa $aux_cadena_filtros $extension_consulta_filtro_recursos $filtro_fecha_observatorio $ORDER $paginador
        EOD;
       
        // echo $consulta_definitiva;

        
        //realizo la consulta            
        //echo $consulta_definitiva;
        $recursos_mediateca_filtrados = $conexion->get_consulta($consulta_definitiva);   

        //creo un array para guardar todos los recursos 
        $array_recursos_mediateca_filtrados = array();

        // recorro el arreglo con los datos de la consulta ll
        for($x=0; $x<=count($recursos_mediateca_filtrados)-1; $x++)
        {
            $solapa= $recursos_mediateca_filtrados[$x]['origen'];
            $origen_id= $recursos_mediateca_filtrados[$x]['origen_id'];
            $id_recurso= $recursos_mediateca_filtrados[$x]['origen_id_especifico'];
            $titulo= $recursos_mediateca_filtrados[$x]['recurso_titulo'];
            $descripcion= $recursos_mediateca_filtrados[$x]['recurso_desc'];
            $link_imagen= $recursos_mediateca_filtrados[$x]['recurso_path_url']; 
            $autores= $recursos_mediateca_filtrados[$x]['recurso_autores']; 
            $fecha= $recursos_mediateca_filtrados[$x]['recurso_fecha'];
            $territorio_id= $recursos_mediateca_filtrados[$x]['territorio_id'];
            $estudios_id= $recursos_mediateca_filtrados[$x]['sub_proyecto_id'];            
            $metatag= $recursos_mediateca_filtrados[$x]['recurso_categoria_desc'];//
            $tema= $recursos_mediateca_filtrados[$x]['recurso_categoria_desc'];            

    

            // por cada registro, se agrega un objeto recurso al array contenedor 
            $recurso = new Recurso($solapa,$origen_id,$id_recurso,$titulo,$descripcion,$link_imagen,$metatag,$autores,$estudios_id,$fecha,$tema,$territorio_id);
            array_push($array_recursos_mediateca_filtrados,$recurso);      
        
        }


        //

         $conexion->desconectar(); // cierro la conexion 


         $estadisticas_filtrado = $this->get_estadistica_filtrado($aux_cadena_filtros,$extension_consulta_filtro_recursos);
         
        $respuesta_recursos_mediateca = new respuesta_error_mediateca();
        $respuesta_recursos_mediateca->flag = true;
        $respuesta_recursos_mediateca->detalle = new RecursosFiltros($array_recursos_mediateca_filtrados,$aux_cadena_filtros,$cant_paginas,$estadisticas_filtrado, $extension_consulta_filtro_recursos);   
        


        // se retorna un objeto json de los recursos 
        //RecursosFiltros($recursos,$aux_cadena_filtros,$CantidadPaginas,$EstadisticasFiltros,$lista_recursos_restringidos)

        return $respuesta_recursos_mediateca;


      
    }

    public function get_estadistica_filtrado($aux_cadena_filtros,$extension_consulta_filtro_recursos)
    {
         $estadistica_documentos;
         $estadistica_recursos_audiovisuales;
         $estadistica_novedades;
         $solapa=null;

        $solapas=[0,1,3]; // solapas que ocuparan la misma consulta 

        $conexion = new ConexionMediateca();   
        
        // variable contenedora de la consulta que calculara las estadisticas 
        $consulta_estadistica_solapa = <<<EOD
                                            SELECT COUNT(*) as total FROM
                                            (SELECT *,CASE WHEN t.sub_proyecto_id IS NULL THEN e.sub_proyecto_id ELSE t.sub_proyecto_id
                                            END AS sub_proyecto_id_principal FROM (SELECT r.estudios_id as estudios_id_rec,'recurso mediateca'::text AS origen, 5::bigint AS origen_id, 
                                                            r.recurso_id AS origen_id_especifico, r.recurso_id,
                                                            r.recurso_titulo AS origen_search_text, r.subclase_id, r.estudios_id, 
                                                            NULL::bigint AS cod_esia_id, r.cod_temporalidad_id, 
                                                            NULL::bigint AS objetos_id, r.recurso_categoria_id, r.tipo_recurso_id, 
                                                            r.formato_id, r.recurso_titulo, r.recurso_desc, r.recurso_fecha, 
                                                            r.recurso_autores, r.recurso_path_url, r.recurso_size, r.territorio_id,
                                                            r.sub_proyecto_id, r.fecha_observatorio,
                                                            tr.tipo_recurso_desc, rc.recurso_categoria_desc,f.tipo_formato_id
                                                            ,f.visualizacion_tipo_id, f.formato_desc, f.formato_extension,vt.visualizacion_tipo_desc,
                                                            tf.tipo_formato_solapa
                                                        FROM "MIC-MEDIATECA".recurso as r
                                                        LEFT JOIN "MIC-MEDIATECA".tipo_recurso tr ON tr.tipo_recurso_id = r.tipo_recurso_id
                                                        LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = r.recurso_categoria_id
                                                        LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = r.formato_id
                                                        LEFT JOIN "MIC-MEDIATECA".visualizacion_tipo vt ON vt.visualizacion_tipo_id = f.visualizacion_tipo_id
                                                        LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id) AS T
                                                        LEFT JOIN mic_catalogo_fdw.cod_esia AS ce ON t.cod_esia_id = ce.cod_esia_id
                                                        LEFT JOIN mic_catalogo_fdw.cod_temporalidad AS ct ON t.cod_temporalidad_id = ct.cod_temporalidad_id
                                                        LEFT JOIN mic_catalogo_fdw.subclase AS sc ON T.subclase_id = sc.subclase_id
                                                        LEFT JOIN (SELECT e.estudios_id, e.estudios_palabras_clave, e.sub_proyecto_id, 
                                                                                e.estudio_estado_id,e.nombre,e.fecha, e.institucion,e.responsable,
                                                                                e.equipo, e.cod_oficial, e.descripcion, e.fecha_text_original,
                                                                                e.institucion_id, sp.proyecto_id,p.proyecto_desc,
                                                                                p.proyecto_extent,i.institucion_nombre, i.institucion_tel,
                                                                                i.institucion_contacto, i.institucion_email
                                                                    FROM mic_catalogo_fdw.estudios e
                                                                    LEFT JOIN mic_catalogo_fdw.sub_proyecto sp ON sp.sub_proyecto_id = e.sub_proyecto_id
                                                                    LEFT JOIN mic_catalogo_fdw.proyecto p ON sp.proyecto_id = p.proyecto_id
                                                                    LEFT JOIN mic_catalogo_fdw.institucion i ON i.institucion_id = e.institucion_id) AS e 
                                                                    ON t.estudios_id_rec = e.estudios_id
                                                    WHERE t.tipo_formato_solapa =        
        EOD;
        
        
        for($x=0; $x<=count($solapas)-1; $x++)
        {
            $consulta_final_estadistica = $consulta_estadistica_solapa.' '.$solapas[$x].' '.$aux_cadena_filtros.' '.$extension_consulta_filtro_recursos.') as RR;';
               
          
            //realizo la consulta            
            $total_estadistica_solapa = $conexion->get_consulta($consulta_final_estadistica);

            switch($solapas[$x])
            {
                case 0:
                    $estadistica_documentos= $total_estadistica_solapa[0];
                    break;
                case 1:
                    $estadistica_recursos_audiovisuales= $total_estadistica_solapa[0];
                    break;
                case 3:
                     $estadistica_novedades= $total_estadistica_solapa[0];
                    break;
            }                       

        }

        return new EstadisticasFiltros($estadistica_documentos,$estadistica_recursos_audiovisuales,$estadistica_novedades);
    
    }


    public function busqueda_mediateca($str_filtro_mediateca){

        $sql= <<<EOD
                SELECT ARC.alias_filtro,ARC.palabra_clave
                FROM "MIC-MEDIATECA".alias_recursos_clave as ARC
                WHERE "MIC-MEDIATECA".unaccent(LOWER(ARC.alias_filtro)) LIKE "MIC-MEDIATECA".unaccent(LOWER('%$str_filtro_mediateca%'))
                ORDER BY ARC.alias_filtro ASC  
            EOD;
          

        $conexion = new ConexionMediateca();        
        //realizo la consulta            
        $consulta = $conexion->get_consulta($sql);   
      
        //creo un array para guardar todos los datos 
        $coincidencias = Array();
      
        // recorro el arreglo con los datos de la consulta 
        for($x=0; $x<=count($consulta)-1; $x++)
        {            
            $alias_filtro= $consulta[$x]['alias_filtro'];
            $palabra_clave= $consulta[$x]['palabra_clave'];

            array_push($coincidencias,new Coincidencia($alias_filtro,$palabra_clave));                  
        }

        $respuesta_recursos_mediateca = new respuesta_error_mediateca();
        $respuesta_recursos_mediateca->flag = true;
        $respuesta_recursos_mediateca->detalle = $coincidencias;

        return $respuesta_recursos_mediateca;
        
    }

    public function carrusel_represas($represa){

        //consulta filtrando por la represa
        // ACLARACION, LA RELACION mod_mediateca.fotos_proyectos  NO EXISTE EN LA VERSION DE LA BD A LA QUE NOS DIERON ACCESO, HABRIA QUE PEDIR 
        $QUERY='SELECT * FROM "MIC-MEDIATECA".fotos_proyectos as fp WHERE fp.presa = '."'$represa'".' ORDER BY fp.recurso_fecha DESC;';
        
        $conexion = new ConexionMediateca();        
        //realizo la consulta            
        $consulta = $conexion->get_consulta($QUERY);

        if(!empty($consulta))
        {

            $Array_recursos=array(); // array contenedor 
            foreach($consulta as $recurso)
            {   
                $aux_recurso_id = $recurso['recurso_id'];
                $aux_recurso_desc = $recurso['recurso_desc'];
                $aux_presa = $recurso['presa'];
                $aux_recurso_path_url = $recurso['recurso_path_url'];
                $aux_recurso_fecha = $recurso['recurso_fecha'];
                $aux_formato_id = $recurso['formato_id'];
            
                // se graba cada fila de la consulta en un objeto
                $record= new Imagen($aux_recurso_id, $aux_recurso_desc, $aux_presa, $aux_recurso_path_url, $aux_recurso_fecha, $aux_formato_id);
                array_push($Array_recursos,$record); // se agrega el objeto al array 

            }

            $respuesta_op_server = new respuesta_error_mediateca();
            $respuesta_op_server->flag = true;
            $respuesta_op_server->detalle = $Array_recursos;        

        }else{

            $respuesta_op_server = new respuesta_error_mediateca();
            $respuesta_op_server->flag = false;
            $respuesta_op_server->detalle = "No se encontraron resultados";

        }
        
        //retorno un fetch_row o fetch_assoc        
        return  $respuesta_op_server; // resultado, array assoc de los archivos bloqueados 

    }

    public function noticias_mediateca(){

        // por el momento queda con la consulta vieja, queda refactorizar a la nueva base de datos. "MIC-MEDIATECA"

        // una vez implementado todo, usa la siguiente consulta 

        /* la misma ya apunta a la base de datos del microservicio
        
        SELECT ('./cache/'||recurso_id::TEXT||'.jpg')::text AS path_img, recurso_titulo as titulo,recurso_fecha as fecha,recurso_path_url as path_pdf,recurso_desc as desc,recurso_id,(recurso_fecha-30) AS fecha_menos_30,recurso_preview_path as path_img2  
        from  "MIC-MEDIATECA".recurso r where formato_id in(102) order by recurso_fecha desc limit 7        
        
        */


        $consulta_noticias_mediateca = <<<EOD
                                    SELECT './cache/'||recurso_id::TEXT||'.jpg'::text AS path_img, recurso_titulo as titulo,recurso_fecha as fecha,recurso_path_url as path_pdf,recurso_desc as desc,recurso_id,(recurso_fecha-30) AS fecha_menos_30,recurso_preview_path as path_img2  
                                    from  "MIC-MEDIATECA".recurso r where formato_id in(102) order by recurso_fecha desc limit 7;
        EOD;
        
        $conexion = new ConexionMediateca();
        //realizo la consulta            
        $resultado = $conexion->get_consulta($consulta_noticias_mediateca);   

        $noticias_mediateca = array();

        if(!empty($resultado))
        {            
            foreach($resultado as $registro)
            {            
                $path_img;

                if($registro['path_img2']==null){

                    $path_img=$registro['path_img'];
                }else{
                    $path_img=$registro['path_img2'];
                }
                
                $aux_noticia = new Noticia_mediateca($path_img,$registro['titulo'],$registro['fecha'],$registro['path_pdf'],$registro['desc'],$registro['fecha_menos_30']);

                array_push($noticias_mediateca,$aux_noticia);
            }

            $respuesta_op_server = new respuesta_error_mediateca();
            $respuesta_op_server->flag = true;
            $respuesta_op_server->detalle = $noticias_mediateca;

        }else{

            $respuesta_op_server = new respuesta_error_mediateca();
            $respuesta_op_server->flag = false;
            $respuesta_op_server->detalle = "No se encontraron resultados";
        }

        return $respuesta_op_server; //  revisar bien la respuesta 

    }

   



} // fin repositorio mediateca


//$test = new RepositorioQueryMediateca();
//echo $test->get_recursos($lista_recursos_restringidos, $solapa, $current_page,$page_size,$order_by);
