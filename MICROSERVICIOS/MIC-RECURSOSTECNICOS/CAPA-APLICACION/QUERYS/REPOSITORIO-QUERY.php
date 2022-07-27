<?php

require_once(dirname(__FILE__,4).'\MIC-RECURSOSTECNICOS/CAPA-DOMINIO/INTERFACE-QUERYS/REPOSITORIO-INTERFACE-QUERY.php');
require_once(dirname(__FILE__,4).'\MIC-RECURSOSTECNICOS/CAPA-DATOS/capa-acceso.php');
require_once(dirname(__FILE__,4).'\\MIC-RECURSOSTECNICOS/CAPA-DOMINIO/DTOS/DTOS.php');
require_once(dirname(__FILE__,4).'\\MIC-RECURSOSTECNICOS/CAPA-DOMINIO/ENTIDADES/ENTIDADES.php');


class RepositorioQueryRecursosTecnicos implements IRepositorioQueryRecursosTecnicos{

    public function get_recursos_tecnicos($lista_recursos_restringidos, $current_page, $page_size, $order_by)
    {
        //HACER LOGICA RECURSOS RESTRINGIDOS.
        $extension_consulta_filtro_recursos = "WHERE u.origen_id_especifico NOT IN ("; // apuntar al campo deseado 

        // armo una cadena para usar como subconsulta en la query principal 
        
        for($x=0; $x<=count($lista_recursos_restringidos)-1; $x++)
        {       
           if($x==count($lista_recursos_restringidos)-1){
               
               $extension_consulta_filtro_recursos.=$lista_recursos_restringidos[$x]['objeto_id'].")";
           }else{
               $extension_consulta_filtro_recursos.=$lista_recursos_restringidos[$x]['objeto_id'].",";
           }       
        }   
    

        //LOGICA DE PAGINADOR
        $aux_consulta_paginador= <<<EOD
                        SELECT COUNT(*) as total_registros FROM ( SELECT 'GIS'::text AS origen, 0 AS origen_id,G.origen_id_especifico,
                        G.origen_search_text,G.subclase_id,G.estudios_id,G.cod_esia_id,
                        G.cod_temporalidad_id,G.objetos_id,G.fecha_observatorio,
                        10::bigint AS recurso_categoria_id,'Capas Geográficas'::text AS recurso_categoria_desc,
                        G.recurso_desc, G.recurso_titulo, NULL::date AS recurso_fecha,
                        NULL::text AS recurso_autores, NULL::text AS recurso_path_url,
                        NULL::bigint AS recurso_size, NULL::bigint AS territorio_id,(-1) AS tipo_formato_id,
                        (-1) AS visualizacion_tipo_id,'Modulo Interno'::text AS formato_desc,
                        'MI'::text AS formato_extension,'En modulo'::text AS visualizacion_tipo_desc,
                        NULL::text AS tipo_formato_desc,2::bigint AS tipo_formato_solapa,NULL::bigint AS sub_proyecto_id                    
                        FROM dblink('dbname=MIC-GEOVISORES
                        hostaddr=179.43.126.101 
                        user=postgres 
                        password=plahe100%
                        port=5432',
                        'SELECT c.origen_id_especifico, c.origen_search_text, 
                                c.subclase_id, c.estudios_id, 
                                c.cod_esia_id, c.cod_temporalidad_id, 
                                c.objetos_id, c.fecha_observatorio, 
                                l.preview_desc  AS recurso_desc,
                                l.preview_titulo  AS recurso_titulo       
                        FROM "MIC-GEOVISORES".catalogo c
                        INNER JOIN "MIC-GEOVISORES".layer l on l.layer_id=c.origen_id_especifico') 
                                        as G (origen_id_especifico bigint, origen_search_text text, subclase_id bigint, estudios_id bigint, 
                                        cod_esia_id bigint, cod_temporalidad_id bigint, objetos_id bigint, fecha_observatorio date, recurso_desc text, recurso_titulo text)
                        
                        UNION ALL
                        SELECT 'Estadistica'::text AS origen, 2 AS origen_id, 
                                dt.dt_id AS origen_id_especifico, dt.dt_titulo AS origen_search_text, 
                                NULL::bigint AS subclase_id, NULL::bigint AS estudios_id, 
                                NULL::bigint AS cod_esia_id, NULL::bigint AS cod_temporalidad_id, 
                                NULL::bigint AS objetos_id, dt.fecha_observatorio, 29::bigint AS recurso_categoria_id,
                                'Estadísticas'::text AS recurso_categoria_desc,  dt_desc AS recurso_desc, dt_titulo AS recurso_titulo, 
                                NULL::date AS recurso_fecha, NULL::text AS recurso_autores, NULL::text AS recurso_path_url,
                                NULL::bigint AS recurso_size, NULL::bigint AS territorio_id,(-1) AS tipo_formato_id,(-1) AS visualizacion_tipo_id,
                                'Modulo Interno'::text AS formato_desc, 'MI'::text AS formato_extension,'En modulo'::text AS visualizacion_tipo_desc,
                                NULL::text AS tipo_formato_desc,2::bigint AS tipo_formato_solapa,NULL::bigint AS sub_proyecto_id
                                FROM dblink('dbname=MIC-ESTADISTICAS
                                                hostaddr=179.43.126.101 
                                                user=postgres 
                                                password=plahe100%
                                                port=5432',
                                                'SELECT dt_id, dt_titulo, fecha_observatorio, dt_desc FROM "MIC-ESTADISTICAS".dt') 
                                                as dt(dt_id bigint, dt_titulo text, fecha_observatorio date , dt_desc text)
                        
                        UNION ALL
                        SELECT 'recurso mediateca'::text AS origen, 5::bigint AS origen_id, 
                                r.recurso_id AS origen_id_especifico, r.recurso_titulo AS origen_search_text,
                                r.subclase_id,r.estudios_id,NULL::bigint AS cod_esia_id,r.cod_temporalidad_id,
                                NULL::bigint AS objetos_id,r.fecha_observatorio,r.recurso_categoria_id,
                                rc.recurso_categoria_desc,r.recurso_desc,r.recurso_titulo,r.recurso_fecha,   
                                r.recurso_autores, r.recurso_path_url,  r.recurso_size,r.territorio_id,
                                f.tipo_formato_id, f.visualizacion_tipo_id,f.formato_desc,f.formato_extension, 
                                vt.visualizacion_tipo_desc,tf.tipo_formato_desc,tf.tipo_formato_solapa, r.sub_proyecto_id as sub_proyecto_id 
                                FROM "MIC-MEDIATECA".recurso r
                                LEFT JOIN "MIC-MEDIATECA".tipo_recurso tr ON tr.tipo_recurso_id = r.tipo_recurso_id
                                LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = r.formato_id
                                LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = r.recurso_categoria_id
                                LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                LEFT JOIN "MIC-MEDIATECA".visualizacion_tipo vt ON vt.visualizacion_tipo_id = f.visualizacion_tipo_id
                                WHERE tf.tipo_formato_solapa = 2 ) as u
                        EOD; 

        
        $CONSULTA_PAGINADOR = $aux_consulta_paginador.' '.$extension_consulta_filtro_recursos;
        
        //instancio una conexion 
        $conexion_rec_tecnicos = new ConexionRecursosTecnicos();
        
        $total_registros = $conexion_rec_tecnicos->get_consulta($CONSULTA_PAGINADOR);

        $cant_paginas= ceil(intval($total_registros[0]['total_registros'], 10)/$page_size) ;
        $inicio = ($current_page - 1) * $page_size;         

        $paginador = ' LIMIT '.$page_size.' OFFSET '.$inicio;

        // fin paginador ---------------------------------

        // ordenamiento
        switch ($order_by)
        {
            case 0: 	$ORDER = " ORDER BY u.tipo_formato_solapa, u.recurso_titulo ASC"; break;
            case 1: 	$ORDER = " ORDER BY u.tipo_formato_solapa, u.recurso_titulo DESC"; break;
            case 2: 	$ORDER = " ORDER BY tipo_formato_solapa, mod_mediateca.get_total_vistas_recurso(origen_id_especifico,origen_id) DESC"; break;
            case 3: 	$ORDER = " ORDER BY tipo_formato_solapa, mod_mediateca.get_total_vistas_recurso(origen_id_especifico,origen_id) ASC"; break;
            case 4: 	$ORDER = " ORDER BY u.tipo_formato_solapa, u.recurso_fecha DESC"; break;
            case 5: 	$ORDER = " ORDER BY u.tipo_formato_solapa, u.recurso_fecha DESC ASC"; break;
            case 6: 	$ORDER ="  ORDER BY u.tipo_formato_solapa, u.fecha_observatorio DESC"; break;
            //default: 	$ORDER = " ORDER BY tipo_formato_solapa,recurso_titulo ASC"; break;
        };

        // OBTENCION DE RECURSOS

        $aux_consulta_recursos = <<<EOD
                                SELECT * FROM ( SELECT 'GIS'::text AS origen, 0 AS origen_id,G.origen_id_especifico,
                                G.origen_search_text,G.subclase_id,G.estudios_id,G.cod_esia_id,
                                G.cod_temporalidad_id,G.objetos_id,G.fecha_observatorio,
                                10::bigint AS recurso_categoria_id,'Capas Geográficas'::text AS recurso_categoria_desc,
                                G.recurso_desc, G.recurso_titulo, NULL::date AS recurso_fecha,
                                NULL::text AS recurso_autores, NULL::text AS recurso_path_url,
                                NULL::bigint AS recurso_size, NULL::bigint AS territorio_id,(-1) AS tipo_formato_id,
                                (-1) AS visualizacion_tipo_id,'Modulo Interno'::text AS formato_desc,
                                'MI'::text AS formato_extension,'En modulo'::text AS visualizacion_tipo_desc,
                                NULL::text AS tipo_formato_desc,2::bigint AS tipo_formato_solapa,NULL::bigint AS sub_proyecto_id                    
                                FROM dblink('dbname=MIC-GEOVISORES
                                hostaddr=179.43.126.101 
                                user=postgres 
                                password=plahe100%
                                port=5432',
                                'SELECT c.origen_id_especifico, c.origen_search_text, 
                                        c.subclase_id, c.estudios_id, 
                                        c.cod_esia_id, c.cod_temporalidad_id, 
                                        c.objetos_id, c.fecha_observatorio, 
                                        l.preview_desc  AS recurso_desc,
                                        l.preview_titulo  AS recurso_titulo       
                                FROM "MIC-GEOVISORES".catalogo c
                                INNER JOIN "MIC-GEOVISORES".layer l on l.layer_id=c.origen_id_especifico') 
                                                as G (origen_id_especifico bigint, origen_search_text text, subclase_id bigint, estudios_id bigint, 
                                                cod_esia_id bigint, cod_temporalidad_id bigint, objetos_id bigint, fecha_observatorio date, recurso_desc text, recurso_titulo text)
                                
                                UNION ALL
                                SELECT 'Estadistica'::text AS origen, 2 AS origen_id, 
                                        dt.dt_id AS origen_id_especifico, dt.dt_titulo AS origen_search_text, 
                                        NULL::bigint AS subclase_id, NULL::bigint AS estudios_id, 
                                        NULL::bigint AS cod_esia_id, NULL::bigint AS cod_temporalidad_id, 
                                        NULL::bigint AS objetos_id, dt.fecha_observatorio, 29::bigint AS recurso_categoria_id,
                                        'Estadísticas'::text AS recurso_categoria_desc,  dt_desc AS recurso_desc, dt_titulo AS recurso_titulo, 
                                        NULL::date AS recurso_fecha, NULL::text AS recurso_autores, NULL::text AS recurso_path_url,
                                        NULL::bigint AS recurso_size, NULL::bigint AS territorio_id,(-1) AS tipo_formato_id,(-1) AS visualizacion_tipo_id,
                                        'Modulo Interno'::text AS formato_desc, 'MI'::text AS formato_extension,'En modulo'::text AS visualizacion_tipo_desc,
                                        NULL::text AS tipo_formato_desc,2::bigint AS tipo_formato_solapa,NULL::bigint AS sub_proyecto_id
                                        FROM dblink('dbname=MIC-ESTADISTICAS
                                                        hostaddr=179.43.126.101 
                                                        user=postgres 
                                                        password=plahe100%
                                                        port=5432',
                                                        'SELECT dt_id, dt_titulo, fecha_observatorio, dt_desc FROM "MIC-ESTADISTICAS".dt') 
                                                        as dt(dt_id bigint, dt_titulo text, fecha_observatorio date , dt_desc text)                                
                                UNION ALL
                                SELECT 'recurso mediateca'::text AS origen, 5::bigint AS origen_id, 
                                        r.recurso_id AS origen_id_especifico, r.recurso_titulo AS origen_search_text,
                                        r.subclase_id,r.estudios_id,NULL::bigint AS cod_esia_id,r.cod_temporalidad_id,
                                        NULL::bigint AS objetos_id,r.fecha_observatorio,r.recurso_categoria_id,
                                        rc.recurso_categoria_desc,r.recurso_desc,r.recurso_titulo,r.recurso_fecha,   
                                        r.recurso_autores, r.recurso_path_url,  r.recurso_size,r.territorio_id,
                                        f.tipo_formato_id, f.visualizacion_tipo_id,f.formato_desc,f.formato_extension, 
                                        vt.visualizacion_tipo_desc,tf.tipo_formato_desc,tf.tipo_formato_solapa, r.sub_proyecto_id as sub_proyecto_id 
                                        FROM "MIC-MEDIATECA".recurso r
                                        LEFT JOIN "MIC-MEDIATECA".tipo_recurso tr ON tr.tipo_recurso_id = r.tipo_recurso_id
                                        LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = r.formato_id
                                        LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = r.recurso_categoria_id
                                        LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                        LEFT JOIN "MIC-MEDIATECA".visualizacion_tipo vt ON vt.visualizacion_tipo_id = f.visualizacion_tipo_id
                                        WHERE tf.tipo_formato_solapa = 2 ) as u
                                EOD;
        
        
        $CONSULTA_DEFINITIVA_RECURSOS_TECNICOS = $aux_consulta_recursos.' '.$extension_consulta_filtro_recursos.' '.$ORDER.' '.$paginador;
        $recursos_tecnicos = $conexion_rec_tecnicos->get_consulta( $CONSULTA_DEFINITIVA_RECURSOS_TECNICOS);

        //creo un array para guardar todos los recursos  tecnicos
        $array_recursos_tecnicos = array();

        // recorro el arreglo con los datos de la consulta 
        for($x=0; $x<=count($recursos_tecnicos)-1; $x++)
        {
            $solapa= $recursos_tecnicos[$x]['origen'];
            $origen_id= $recursos_tecnicos[$x]['origen_id'];
            $id_recurso= $recursos_tecnicos[$x]['origen_id_especifico'];
            $titulo= $recursos_tecnicos[$x]['recurso_titulo'];
            $descripcion= $recursos_tecnicos[$x]['recurso_desc'];
            $link_imagen= $recursos_tecnicos[$x]['recurso_path_url']; 
            $autores= $recursos_tecnicos[$x]['recurso_autores']; 
            $fecha= $recursos_tecnicos[$x]['recurso_fecha'];
            $territorio_id= $recursos_tecnicos[$x]['territorio_id'];
            $estudios_id= $recursos_tecnicos[$x]['sub_proyecto_id'];            
            $metatag= $recursos_tecnicos[$x]['recurso_categoria_desc'];
            $tema= $recursos_tecnicos[$x]['recurso_categoria_desc'];            
            $ico= $recursos_tecnicos[$x]['ico'];

    
            // por cada registro, se agrega un objeto recurso al array contenedor 
            $recurso = new Recurso($solapa,$origen_id,$id_recurso,$titulo,$descripcion,$link_imagen,$metatag,$autores,$estudios_id,$fecha,$tema,$territorio_id,$ico);
            array_push($array_recursos_tecnicos,$recurso);                    
        }
        // faltaria estadistica de la solapa para devolver en mediateca, tentativamente ira la variable total_registros. ya que es total de registros 
        return new RecursosTecnicos($array_recursos_tecnicos,$cant_paginas ,$extension_consulta_filtro_recursos);         
    } // fin function get_recursos_tecnicos 

    public function get_recursos_tecnicos_filtrado($lista_recursos_restringidos, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad, $order_by)
    {
                
         $extension_consulta_filtro_recursos = "WHERE u.origen_id_especifico NOT IN ("; // apuntar al campo deseado 
         // armo una cadena para usar como subconsulta en la query principal 
                 
         for($x=0; $x<=count($lista_recursos_restringidos)-1; $x++)
         {       
            if($x==count($lista_recursos_restringidos)-1){
                
                $extension_consulta_filtro_recursos.=$lista_recursos_restringidos[$x]['objeto_id'].")";
            }else{
                $extension_consulta_filtro_recursos.=$lista_recursos_restringidos[$x]['objeto_id'].",";
            }       
         }   
        
        
        //LOGICA DE PAGINADOR
        $aux_consulta_paginador= <<<EOD
                                    SELECT COUNT(*) AS total_registros FROM ( SELECT 'GIS'::text AS origen, 0 AS origen_id,G.origen_id_especifico,
                                    G.origen_search_text,G.subclase_id,G.estudios_id,G.cod_esia_id,
                                    G.cod_temporalidad_id,G.objetos_id,G.fecha_observatorio,
                                    10::bigint AS recurso_categoria_id,'Capas Geográficas'::text AS recurso_categoria_desc,
                                    G.recurso_desc, G.recurso_titulo, NULL::date AS recurso_fecha,
                                    NULL::text AS recurso_autores, NULL::text AS recurso_path_url,
                                    NULL::bigint AS recurso_size, NULL::bigint AS territorio_id,(-1) AS tipo_formato_id,
                                    (-1) AS visualizacion_tipo_id,'Modulo Interno'::text AS formato_desc,
                                    'MI'::text AS formato_extension,'En modulo'::text AS visualizacion_tipo_desc,
                                    NULL::text AS tipo_formato_desc,2::bigint AS tipo_formato_solapa,NULL::bigint AS sub_proyecto_id                    
                                    FROM dblink('dbname=MIC-GEOVISORES
                                    hostaddr=179.43.126.101 
                                    user=postgres 
                                    password=plahe100%
                                    port=5432',
                                    'SELECT c.origen_id_especifico, c.origen_search_text, 
                                            c.subclase_id, c.estudios_id, 
                                            c.cod_esia_id, c.cod_temporalidad_id, 
                                            c.objetos_id, c.fecha_observatorio, 
                                            l.preview_desc  AS recurso_desc,
                                            l.preview_titulo  AS recurso_titulo       
                                    FROM "MIC-GEOVISORES".catalogo c
                                    INNER JOIN "MIC-GEOVISORES".layer l on l.layer_id=c.origen_id_especifico') 
                                                    as G (origen_id_especifico bigint, origen_search_text text, subclase_id bigint, estudios_id bigint, 
                                                    cod_esia_id bigint, cod_temporalidad_id bigint, objetos_id bigint, fecha_observatorio date, recurso_desc text, recurso_titulo text)
                                    
                                    UNION ALL
                                    SELECT 'Estadistica'::text AS origen, 2 AS origen_id, 
                                            dt.dt_id AS origen_id_especifico, dt.dt_titulo AS origen_search_text, 
                                            NULL::bigint AS subclase_id, NULL::bigint AS estudios_id, 
                                            NULL::bigint AS cod_esia_id, NULL::bigint AS cod_temporalidad_id, 
                                            NULL::bigint AS objetos_id, dt.fecha_observatorio, 29::bigint AS recurso_categoria_id,
                                            'Estadísticas'::text AS recurso_categoria_desc,  dt_desc AS recurso_desc, dt_titulo AS recurso_titulo, 
                                            NULL::date AS recurso_fecha, NULL::text AS recurso_autores, NULL::text AS recurso_path_url,
                                            NULL::bigint AS recurso_size, NULL::bigint AS territorio_id,(-1) AS tipo_formato_id,(-1) AS visualizacion_tipo_id,
                                            'Modulo Interno'::text AS formato_desc, 'MI'::text AS formato_extension,'En modulo'::text AS visualizacion_tipo_desc,
                                            NULL::text AS tipo_formato_desc,2::bigint AS tipo_formato_solapa,NULL::bigint AS sub_proyecto_id
                                            FROM dblink('dbname=MIC-ESTADISTICAS
                                                            hostaddr=179.43.126.101 
                                                            user=postgres 
                                                            password=plahe100%
                                                            port=5432',
                                                            'SELECT dt_id, dt_titulo, fecha_observatorio, dt_desc FROM "MIC-ESTADISTICAS".dt') 
                                                            as dt(dt_id bigint, dt_titulo text, fecha_observatorio date , dt_desc text)
                                    
                                    UNION ALL
                                    SELECT 'recurso mediateca'::text AS origen, 5::bigint AS origen_id, 
                                            r.recurso_id AS origen_id_especifico, r.recurso_titulo AS origen_search_text,
                                            r.subclase_id,r.estudios_id,NULL::bigint AS cod_esia_id,r.cod_temporalidad_id,
                                            NULL::bigint AS objetos_id,r.fecha_observatorio,r.recurso_categoria_id,
                                            rc.recurso_categoria_desc,r.recurso_desc,r.recurso_titulo,r.recurso_fecha,   
                                            r.recurso_autores, r.recurso_path_url,  r.recurso_size,r.territorio_id,
                                            f.tipo_formato_id, f.visualizacion_tipo_id,f.formato_desc,f.formato_extension, 
                                            vt.visualizacion_tipo_desc,tf.tipo_formato_desc,tf.tipo_formato_solapa, r.sub_proyecto_id as sub_proyecto_id 
                                            FROM "MIC-MEDIATECA".recurso r
                                            LEFT JOIN "MIC-MEDIATECA".tipo_recurso tr ON tr.tipo_recurso_id = r.tipo_recurso_id
                                            LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = r.formato_id
                                            LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = r.recurso_categoria_id
                                            LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                            LEFT JOIN "MIC-MEDIATECA".visualizacion_tipo vt ON vt.visualizacion_tipo_id = f.visualizacion_tipo_id
                                            WHERE tf.tipo_formato_solapa = 2 ) as u 
                            INNER JOIN dblink('dbname=MIC-CATALOGO
                            hostaddr=179.43.126.101 
                            user=postgres 
                            password=plahe100%
                            port=5432',
                            'SELECT estudios_id, estudios_palabras_clave,nombre,equipo,institucion,responsable
                                FROM "MIC-CATALOGO".estudios') 
                            as e(estudios_id bigint, estudios_palabras_clave text, nombre text, equipo text, institucion text, responsable text)
                            ON u.estudios_id = e.estudios_id
                            INNER JOIN dblink('dbname=MIC-CATALOGO
                            hostaddr=179.43.126.101 
                            user=postgres 
                            password=plahe100%
                            port=5432',
                            'SELECT cod_temporalidad_id,desde AS tempo_desde, hasta AS tempo_hasta FROM "MIC-CATALOGO".cod_temporalidad')
                            as ct(cod_temporalidad_id bigint, tempo_desde date, tempo_hasta date) ON u.cod_temporalidad_id = ct.cod_temporalidad_id
                            INNER JOIN dblink('dbname=MIC-CATALOGO
                            hostaddr=179.43.126.101 
                            user=postgres 
                            password=plahe100%
                            port=5432',
                            'SELECT subclase_id, clase_id FROM "MIC-CATALOGO".subclase')
                            as sc(subclase_id bigint,clase_id bigint) ON u.subclase_id = sc.subclase_id
                        EOD; 

        
        $CONSULTA_PAGINADOR = $aux_consulta_paginador.' '.$extension_consulta_filtro_recursos.' '.$this->get_string_filtros($qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad);
        
        //instancio una conexion 
        $conexion_rec_tecnicos = new ConexionRecursosTecnicos();
        
        $total_registros = $conexion_rec_tecnicos->get_consulta($CONSULTA_PAGINADOR);

        $cant_paginas= ceil(intval($total_registros[0]['total_registros'], 10)/$page_size) + 1;
        $inicio = ($current_page - 1) * $page_size;         

        $paginador = ' LIMIT '.$page_size.' OFFSET '.$inicio;

        // fin paginador ---------------------------------

        // OBTENCION DE RECURSOS

        $aux_consulta_recursos = <<<EOD
                                    SELECT * FROM ( SELECT 'GIS'::text AS origen, 0 AS origen_id,G.origen_id_especifico,
                                    G.origen_search_text,G.subclase_id,G.estudios_id,G.cod_esia_id,
                                    G.cod_temporalidad_id,G.objetos_id,G.fecha_observatorio,
                                    10::bigint AS recurso_categoria_id,'Capas Geográficas'::text AS recurso_categoria_desc,
                                    G.recurso_desc, G.recurso_titulo, NULL::date AS recurso_fecha,
                                    NULL::text AS recurso_autores, NULL::text AS recurso_path_url,
                                    NULL::bigint AS recurso_size, NULL::bigint AS territorio_id,(-1) AS tipo_formato_id,
                                    (-1) AS visualizacion_tipo_id,'Modulo Interno'::text AS formato_desc,
                                    'MI'::text AS formato_extension,'En modulo'::text AS visualizacion_tipo_desc,
                                    NULL::text AS tipo_formato_desc,2::bigint AS tipo_formato_solapa,NULL::bigint AS sub_proyecto_id                    
                                    FROM dblink('dbname=MIC-GEOVISORES
                                    hostaddr=179.43.126.101 
                                    user=postgres 
                                    password=plahe100%
                                    port=5432',
                                    'SELECT c.origen_id_especifico, c.origen_search_text, 
                                            c.subclase_id, c.estudios_id, 
                                            c.cod_esia_id, c.cod_temporalidad_id, 
                                            c.objetos_id, c.fecha_observatorio, 
                                            l.preview_desc  AS recurso_desc,
                                            l.preview_titulo  AS recurso_titulo       
                                    FROM "MIC-GEOVISORES".catalogo c
                                    INNER JOIN "MIC-GEOVISORES".layer l on l.layer_id=c.origen_id_especifico') 
                                                    as G (origen_id_especifico bigint, origen_search_text text, subclase_id bigint, estudios_id bigint, 
                                                    cod_esia_id bigint, cod_temporalidad_id bigint, objetos_id bigint, fecha_observatorio date, recurso_desc text, recurso_titulo text)
                                    
                                    UNION ALL
                                    SELECT 'Estadistica'::text AS origen, 2 AS origen_id, 
                                            dt.dt_id AS origen_id_especifico, dt.dt_titulo AS origen_search_text, 
                                            NULL::bigint AS subclase_id, NULL::bigint AS estudios_id, 
                                            NULL::bigint AS cod_esia_id, NULL::bigint AS cod_temporalidad_id, 
                                            NULL::bigint AS objetos_id, dt.fecha_observatorio, 29::bigint AS recurso_categoria_id,
                                            'Estadísticas'::text AS recurso_categoria_desc,  dt_desc AS recurso_desc, dt_titulo AS recurso_titulo, 
                                            NULL::date AS recurso_fecha, NULL::text AS recurso_autores, NULL::text AS recurso_path_url,
                                            NULL::bigint AS recurso_size, NULL::bigint AS territorio_id,(-1) AS tipo_formato_id,(-1) AS visualizacion_tipo_id,
                                            'Modulo Interno'::text AS formato_desc, 'MI'::text AS formato_extension,'En modulo'::text AS visualizacion_tipo_desc,
                                            NULL::text AS tipo_formato_desc,2::bigint AS tipo_formato_solapa,NULL::bigint AS sub_proyecto_id
                                            FROM dblink('dbname=MIC-ESTADISTICAS
                                                            hostaddr=179.43.126.101 
                                                            user=postgres 
                                                            password=plahe100%
                                                            port=5432',
                                                            'SELECT dt_id, dt_titulo, fecha_observatorio, dt_desc FROM "MIC-ESTADISTICAS".dt') 
                                                            as dt(dt_id bigint, dt_titulo text, fecha_observatorio date , dt_desc text)
                                    
                                    UNION ALL
                                    SELECT 'recurso mediateca'::text AS origen, 5::bigint AS origen_id, 
                                            r.recurso_id AS origen_id_especifico, r.recurso_titulo AS origen_search_text,
                                            r.subclase_id,r.estudios_id,NULL::bigint AS cod_esia_id,r.cod_temporalidad_id,
                                            NULL::bigint AS objetos_id,r.fecha_observatorio,r.recurso_categoria_id,
                                            rc.recurso_categoria_desc,r.recurso_desc,r.recurso_titulo,r.recurso_fecha,   
                                            r.recurso_autores, r.recurso_path_url,  r.recurso_size,r.territorio_id,
                                            f.tipo_formato_id, f.visualizacion_tipo_id,f.formato_desc,f.formato_extension, 
                                            vt.visualizacion_tipo_desc,tf.tipo_formato_desc,tf.tipo_formato_solapa, r.sub_proyecto_id as sub_proyecto_id 
                                            FROM "MIC-MEDIATECA".recurso r
                                            LEFT JOIN "MIC-MEDIATECA".tipo_recurso tr ON tr.tipo_recurso_id = r.tipo_recurso_id
                                            LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = r.formato_id
                                            LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = r.recurso_categoria_id
                                            LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                            LEFT JOIN "MIC-MEDIATECA".visualizacion_tipo vt ON vt.visualizacion_tipo_id = f.visualizacion_tipo_id
                                            WHERE tf.tipo_formato_solapa = 2 ) as u 
                            INNER JOIN dblink('dbname=MIC-CATALOGO
                            hostaddr=179.43.126.101 
                            user=postgres 
                            password=plahe100%
                            port=5432',
                            'SELECT estudios_id, estudios_palabras_clave,nombre,equipo,institucion,responsable
                                FROM "MIC-CATALOGO".estudios') 
                            as e(estudios_id bigint, estudios_palabras_clave text, nombre text, equipo text, institucion text, responsable text)
                            ON u.estudios_id = e.estudios_id
                            INNER JOIN dblink('dbname=MIC-CATALOGO
                            hostaddr=179.43.126.101 
                            user=postgres 
                            password=plahe100%
                            port=5432',
                            'SELECT cod_temporalidad_id,desde AS tempo_desde, hasta AS tempo_hasta FROM "MIC-CATALOGO".cod_temporalidad')
                            as ct(cod_temporalidad_id bigint, tempo_desde date, tempo_hasta date) ON u.cod_temporalidad_id = ct.cod_temporalidad_id
                            INNER JOIN dblink('dbname=MIC-CATALOGO
                            hostaddr=179.43.126.101 
                            user=postgres 
                            password=plahe100%
                            port=5432',
                            'SELECT subclase_id, clase_id FROM "MIC-CATALOGO".subclase')
                            as sc(subclase_id bigint,clase_id bigint) ON u.subclase_id = sc.subclase_id
                            EOD;
        
        
        $CONSULTA_DEFINITIVA_RECURSOS_TECNICOS = $aux_consulta_recursos.' '.$extension_consulta_filtro_recursos.' '.$this->get_string_filtros($qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad).' '.$ORDER.' '.$paginador;
        $recursos_tecnicos = $conexion_rec_tecnicos->get_consulta( $CONSULTA_DEFINITIVA_RECURSOS_TECNICOS);

        //creo un array para guardar todos los recursos  tecnicos
        $array_recursos_tecnicos = array();

        // recorro el arreglo con los datos de la consulta 
        for($x=0; $x<=count($recursos_tecnicos)-1; $x++)
        {
            $solapa= $recursos_tecnicos[$x]['origen'];
            $origen_id= $recursos_tecnicos[$x]['origen_id'];
            $id_recurso= $recursos_tecnicos[$x]['origen_id_especifico'];
            $titulo= $recursos_tecnicos[$x]['recurso_titulo'];
            $descripcion= $recursos_tecnicos[$x]['recurso_desc'];
            $link_imagen= $recursos_tecnicos[$x]['recurso_path_url']; 
            $autores= $recursos_tecnicos[$x]['recurso_autores']; 
            $fecha= $recursos_tecnicos[$x]['recurso_fecha'];
            $territorio_id= $recursos_tecnicos[$x]['territorio_id'];
            $estudios_id= $recursos_tecnicos[$x]['sub_proyecto_id'];            
            $metatag= $recursos_tecnicos[$x]['recurso_categoria_desc'];
            $tema= $recursos_tecnicos[$x]['recurso_categoria_desc'];            
            $ico= $recursos_tecnicos[$x]['ico'];

    
            // por cada registro, se agrega un objeto recurso al array contenedor 
            $recurso = new Recurso($solapa,$origen_id,$id_recurso,$titulo,$descripcion,$link_imagen,$metatag,$autores,$estudios_id,$fecha,$tema,$territorio_id,$ico);
            array_push($array_recursos_tecnicos,$recurso);                    
        }
        // faltaria estadistica de la solapa para devolver en mediateca, tentativamente ira la variable total_registros. ya que es total de registros 
        
        //  RecursosTecnicosFiltrado($recursos,$CantidadPaginas,$lista_recursos_restringidos,$aux_cadena_filtros)
        return new RecursosTecnicosFiltrado($array_recursos_tecnicos,$cant_paginas ,$extension_consulta_filtro_recursos,$this->get_string_filtros($qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad));       
    }


    public function get_string_filtros($qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad)
    {
        
        // validacion de filtros 
        $aux_cadena_filtros = ""; // variable contenedora, almacenara un string con todas las adeciones de filtros a la consulta principal

        if(!empty($qt)) // variable que viene del buscador.
        {            
            $aux_cadena_filtros .= " AND ( lower(unaccent(u.origen_search_text)) LIKE  lower(unaccent('%".$qt."%'))"; // este ya esta 
            $aux_cadena_filtros .= " OR lower(unaccent(e.estudios_palabras_clave)) LIKE  lower(unaccent('%".$qt."%'))"; // este y los de abajo se buscan en MIC-CATALOGO.estudios 
            $aux_cadena_filtros .= " OR lower(unaccent(e.nombre)) LIKE  lower(unaccent('%".$qt."%')) ";
            $aux_cadena_filtros .= " OR lower(unaccent(e.equipo)) LIKE  lower(unaccent('%".$qt."%')) ";
            $aux_cadena_filtros .= " OR lower(unaccent(e.institucion)) LIKE  lower(unaccent('%".$qt."%')) ";
            $aux_cadena_filtros .= " OR lower(unaccent(e.responsable)) LIKE  lower(unaccent('%".$qt."%')) ) "; 
             
        }
        
        switch ($tipo_temporalidad) { // dependiendo del valor de $tipo_temporalidad, el filtro de fecha se hace en campos diferentes
                    case 0:
                        if(!empty($desde) && !empty($hasta)) // si ningun filtro viene vacio. 
                        {
                            $aux_cadena_filtros .= "  AND (('".$desde."' BETWEEN ct.tempo_desde AND ct.tempo_hasta)  
                                                    OR('".$hasta."' BETWEEN ct.tempo_desde AND ct.tempo_hasta))";  // SE buscan en MIC-CATALOGO".cod_temporalidad'
                        
                        }else{ 
                            if(empty($desde) && !empty($hasta)) // si desde viene vacio y hasta no. 
                            {
                                $aux_cadena_filtros .= "  AND (('".$hasta."' BETWEEN ct.tempo_desde AND ct.tempo_hasta) 
                                                        OR('".$hasta."' BETWEEN ct.tempo_desde AND ct.tempo_hasta))";// MIC-CATALOGO".cod_temporalidad'
        
                            }else if(!empty($desde) && empty($hasta)) // si desde no viene vacio y hasta si.
                            {
                                $aux_cadena_filtros .= "  AND (('".$desde."' BETWEEN ct.tempo_desde AND ct.tempo_hasta) 
                                                        OR('".$desde."' BETWEEN ct.tempo_desde AND ct.tempo_hasta))"; // MIC-CATALOGO".cod_temporalidad'
        
                            }else{ // si llego a este punto, ninguno de los parametros tiene datos, por lo que no asigna nada a la variable.
                                $aux_cadena_filtros .= "";
                            }
        
                        } break;
                    case 1:
                        if(!empty($desde) && !empty($hasta)) // si ningun filtro viene vacio. 
                        {
                            $aux_cadena_filtros .= " AND ((u.fecha_observatorio IS NOT NULL)   AND
                                                          (u.fecha_observatorio BETWEEN ".$desde." AND ".$hasta."))"; // este campo ya esta 
                            if(empty($desde) && !empty($hasta)) // si desde viene vacio y hasta no. 
                            {
                                $aux_cadena_filtros .= "  AND ((u.fecha_observatorio IS NOT NULL)  AND 
                                                               (u.fecha_observatorio <= ".$hasta."))"; // este campo ya esta 
        
                            }else if(!empty($desde) && empty($hasta)) // si desde no viene vacio y hasta si.
                            {
                                $aux_cadena_filtros .= "  AND ((u.fecha_observatorio IS NOT NULL)  AND 
                                                               (u.fecha_observatorio >= ".$desde."))"; // este campo ya esta 
        
                            }else{ // si llego a este punto, ninguno de los parametros tiene datos, por lo que no asigna nada a la variable.
                                $aux_cadena_filtros .= "";
                            }
                        } break;
                    case 2:
                        if(!empty($desde) && !empty($hasta)) // si ningun filtro viene vacio. 
                        {
                            $aux_cadena_filtros .= " AND ((u.recurso_fecha IS NOT NULL)   AND
                                                          (u.recurso_fecha BETWEEN ".$desde." AND ".$hasta."))"; // estos campos ya estan
                            if(empty($desde) && !empty($hasta)) // si desde viene vacio y hasta no. 
                            {
                                $aux_cadena_filtros .= "  AND ((u.recurso_fecha IS NOT NULL)  AND 
                                                               (u.recurso_fecha <= ".$hasta."))"; // estos campos ya estan
        
                            }else if(!empty($desde) && empty($hasta)) // si desde no viene vacio y hasta si.
                            {
                                $aux_cadena_filtros .= "  AND ((u.recurso_fecha IS NOT NULL)  AND 
                                                               (u.recurso_fecha >= ".$desde."))"; // estos campos ya estan
        
                            }else{ // si llego a este punto, ninguno de los parametros tiene datos, por lo que no asigna nada a la variable.
                                $aux_cadena_filtros .= "";
                            }
                        } break;
        }
                
        if(!empty($proyecto)) { $aux_cadena_filtros .= " AND u.sub_proyecto_id = ".$proyecto; } // se busca en MIC-CATALOGO.estudios 
        if(!empty($clase)) { $aux_cadena_filtros .= " AND sc.clase_id = ".$clase; } // se busca en la tabla MIC-CATALOGO.subclase  ->>> pendiente 
        if(!empty($subclase)) { $aux_cadena_filtros .= " AND u.subclase_id =".$subclase; } // se busca en la tabla MIC-CATALOGO.subclase
        if(!empty($tipo_doc)) { $aux_cadena_filtros .= " AND u.recurso_categoria_id = ".$tipo_doc; } // este ya esta 
        
        // fin validacion de filtros 
        return  $aux_cadena_filtros;     
    }

    public function get_estadistica_recursos_tecnicos($lista_recursos_restringidos,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$si_tengo_que_filtrar,$calculo_estadistica)
    {

        $extension_consulta_filtro_recursos = "WHERE u.origen_id_especifico NOT IN ("; // apuntar al campo deseado 
        // armo una cadena para usar como subconsulta en la query principal 
                
        for($x=0; $x<=count($lista_recursos_restringidos)-1; $x++)
        {       
           if($x==count($lista_recursos_restringidos)-1){
               
               $extension_consulta_filtro_recursos.=$lista_recursos_restringidos[$x]['objeto_id'].")";
           }else{
               $extension_consulta_filtro_recursos.=$lista_recursos_restringidos[$x]['objeto_id'].",";
           }       
        }   
       
       // defino la consulta principal

       $aux_consulta_recursos = <<<EOD
                                    SELECT COUNT(*) FROM ( SELECT 'GIS'::text AS origen, 0 AS origen_id,G.origen_id_especifico,
                                    G.origen_search_text,G.subclase_id,G.estudios_id,G.cod_esia_id,
                                    G.cod_temporalidad_id,G.objetos_id,G.fecha_observatorio,
                                    10::bigint AS recurso_categoria_id,'Capas Geográficas'::text AS recurso_categoria_desc,
                                    G.recurso_desc, G.recurso_titulo, NULL::date AS recurso_fecha,
                                    NULL::text AS recurso_autores, NULL::text AS recurso_path_url,
                                    NULL::bigint AS recurso_size, NULL::bigint AS territorio_id,(-1) AS tipo_formato_id,
                                    (-1) AS visualizacion_tipo_id,'Modulo Interno'::text AS formato_desc,
                                    'MI'::text AS formato_extension,'En modulo'::text AS visualizacion_tipo_desc,
                                    NULL::text AS tipo_formato_desc,2::bigint AS tipo_formato_solapa,NULL::bigint AS sub_proyecto_id                    
                                    FROM dblink('dbname=MIC-GEOVISORES
                                    hostaddr=179.43.126.101 
                                    user=postgres 
                                    password=plahe100%
                                    port=5432',
                                    'SELECT c.origen_id_especifico, c.origen_search_text, 
                                            c.subclase_id, c.estudios_id, 
                                            c.cod_esia_id, c.cod_temporalidad_id, 
                                            c.objetos_id, c.fecha_observatorio, 
                                            l.preview_desc  AS recurso_desc,
                                            l.preview_titulo  AS recurso_titulo       
                                    FROM "MIC-GEOVISORES".catalogo c
                                    INNER JOIN "MIC-GEOVISORES".layer l on l.layer_id=c.origen_id_especifico') 
                                                    as G (origen_id_especifico bigint, origen_search_text text, subclase_id bigint, estudios_id bigint, 
                                                    cod_esia_id bigint, cod_temporalidad_id bigint, objetos_id bigint, fecha_observatorio date, recurso_desc text, recurso_titulo text)
                                    
                                    UNION ALL
                                    SELECT 'Estadistica'::text AS origen, 2 AS origen_id, 
                                            dt.dt_id AS origen_id_especifico, dt.dt_titulo AS origen_search_text, 
                                            NULL::bigint AS subclase_id, NULL::bigint AS estudios_id, 
                                            NULL::bigint AS cod_esia_id, NULL::bigint AS cod_temporalidad_id, 
                                            NULL::bigint AS objetos_id, dt.fecha_observatorio, 29::bigint AS recurso_categoria_id,
                                            'Estadísticas'::text AS recurso_categoria_desc,  dt_desc AS recurso_desc, dt_titulo AS recurso_titulo, 
                                            NULL::date AS recurso_fecha, NULL::text AS recurso_autores, NULL::text AS recurso_path_url,
                                            NULL::bigint AS recurso_size, NULL::bigint AS territorio_id,(-1) AS tipo_formato_id,(-1) AS visualizacion_tipo_id,
                                            'Modulo Interno'::text AS formato_desc, 'MI'::text AS formato_extension,'En modulo'::text AS visualizacion_tipo_desc,
                                            NULL::text AS tipo_formato_desc,2::bigint AS tipo_formato_solapa,NULL::bigint AS sub_proyecto_id
                                            FROM dblink('dbname=MIC-ESTADISTICAS
                                                            hostaddr=179.43.126.101 
                                                            user=postgres 
                                                            password=plahe100%
                                                            port=5432',
                                                            'SELECT dt_id, dt_titulo, fecha_observatorio, dt_desc FROM "MIC-ESTADISTICAS".dt') 
                                                            as dt(dt_id bigint, dt_titulo text, fecha_observatorio date , dt_desc text)
                                    
                                    UNION ALL
                                    SELECT 'recurso mediateca'::text AS origen, 5::bigint AS origen_id, 
                                            r.recurso_id AS origen_id_especifico, r.recurso_titulo AS origen_search_text,
                                            r.subclase_id,r.estudios_id,NULL::bigint AS cod_esia_id,r.cod_temporalidad_id,
                                            NULL::bigint AS objetos_id,r.fecha_observatorio,r.recurso_categoria_id,
                                            rc.recurso_categoria_desc,r.recurso_desc,r.recurso_titulo,r.recurso_fecha,   
                                            r.recurso_autores, r.recurso_path_url,  r.recurso_size,r.territorio_id,
                                            f.tipo_formato_id, f.visualizacion_tipo_id,f.formato_desc,f.formato_extension, 
                                            vt.visualizacion_tipo_desc,tf.tipo_formato_desc,tf.tipo_formato_solapa, r.sub_proyecto_id as sub_proyecto_id 
                                            FROM "MIC-MEDIATECA".recurso r
                                            LEFT JOIN "MIC-MEDIATECA".tipo_recurso tr ON tr.tipo_recurso_id = r.tipo_recurso_id
                                            LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = r.formato_id
                                            LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = r.recurso_categoria_id
                                            LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                            LEFT JOIN "MIC-MEDIATECA".visualizacion_tipo vt ON vt.visualizacion_tipo_id = f.visualizacion_tipo_id
                                            WHERE tf.tipo_formato_solapa = 2 ) as u 
                                INNER JOIN dblink('dbname=MIC-CATALOGO
                                hostaddr=179.43.126.101 
                                user=postgres 
                                password=plahe100%
                                port=5432',
                                'SELECT estudios_id, estudios_palabras_clave,nombre,equipo,institucion,responsable
                                FROM "MIC-CATALOGO".estudios') 
                                as e(estudios_id bigint, estudios_palabras_clave text, nombre text, equipo text, institucion text, responsable text)
                                ON u.estudios_id = e.estudios_id
                                INNER JOIN dblink('dbname=MIC-CATALOGO
                                hostaddr=179.43.126.101 
                                user=postgres 
                                password=plahe100%
                                port=5432',
                                'SELECT cod_temporalidad_id,desde AS tempo_desde, hasta AS tempo_hasta FROM "MIC-CATALOGO".cod_temporalidad')
                                as ct(cod_temporalidad_id bigint, tempo_desde date, tempo_hasta date) ON u.cod_temporalidad_id = ct.cod_temporalidad_id
                                INNER JOIN dblink('dbname=MIC-CATALOGO
                                hostaddr=179.43.126.101 
                                user=postgres 
                                password=plahe100%
                                port=5432',
                                'SELECT subclase_id, clase_id FROM "MIC-CATALOGO".subclase')
                                as sc(subclase_id bigint,clase_id bigint) ON u.subclase_id = sc.subclase_id
                                EOD;      
        
        $CONSULTA_DEFINITIVA_ESTADISTICA_RT =  $aux_consulta_recursos.' '.$extension_consulta_filtro_recursos.' '.$this->get_string_filtros($qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad);
        
        //instancio una conexion 
        $conexion_rec_tecnicos = new ConexionRecursosTecnicos();
        
        $total_registros = $conexion_rec_tecnicos->get_consulta($CONSULTA_DEFINITIVA_ESTADISTICA_RT);
        
        return  $total_registros ;
    }


} // fin repositorio query


        //EJECUTAR CONSULTA PRINCIPAL

        /* consulta propuesta p/ catalogo de geovisores 

        (SELECT 'GIS'::text AS origen, 0 AS origen_id, 
        c.origen_id_especifico, c.origen_search_text, 
        c.subclase_id, c.estudios_id, 
        c.cod_esia_id, c.cod_temporalidad_id, 
        c.objetos_id, c.fecha_observatorio, 
        10::bigint AS recurso_categoria_id,
        'Capas Geográficas'::text AS recurso_categoria_desc, 
        l.preview_desc  AS recurso_desc,
        l.preview_titulo  AS recurso_titulo, 
        NULL::date AS recurso_fecha, NULL::text AS recurso_autores, NULL::text AS recurso_path_url,
        NULL::bigint AS recurso_size, NULL::bigint AS territorio_id,(-1) AS tipo_formato_id,(-1) AS visualizacion_tipo_id,
        'Modulo Interno'::text AS formato_desc, 'MI'::text AS formato_extension,'En modulo'::text AS visualizacion_tipo_desc,
        NULL::text AS tipo_formato_desc,2::bigint AS tipo_formato_solapa,NULL::bigint AS sub_proyecto_id
        FROM mod_geovisores.catalogo c  
        INNER JOIN mod_geovisores.layer l on l.layer_id=c.origen_id_especifico
        WHERE c.origen_id_especifico NOT IN () 



        // consulta definitiva, MIC-GEOVISORES ejecutada desde MIC-MEDIATECA

        SELECT 'GIS'::text AS origen, 0 AS origen_id,G.origen_id_especifico,
                G.origen_search_text,G.subclase_id,G.estudios_id,G.cod_esia_id,
                G.cod_temporalidad_id,G.objetos_id,G.fecha_observatorio,
                10::bigint AS recurso_categoria_id,'Capas Geográficas'::text AS recurso_categoria_desc,
                G.recurso_desc, G.recurso_titulo, NULL::date AS recurso_fecha,
                NULL::text AS recurso_autores, NULL::text AS recurso_path_url,
                NULL::bigint AS recurso_size, NULL::bigint AS territorio_id,(-1) AS tipo_formato_id,
                (-1) AS visualizacion_tipo_id,'Modulo Interno'::text AS formato_desc,
                'MI'::text AS formato_extension,'En modulo'::text AS visualizacion_tipo_desc,
                NULL::text AS tipo_formato_desc,2::bigint AS tipo_formato_solapa,NULL::bigint AS sub_proyecto_id                    
        FROM dblink('dbname=MIC-GEOVISORES
                    hostaddr=179.43.126.101 
                    user=postgres 
                    password=plahe100%
                    port=5432',
                    'SELECT c.origen_id_especifico, c.origen_search_text, 
                            c.subclase_id, c.estudios_id, 
                            c.cod_esia_id, c.cod_temporalidad_id, 
                            c.objetos_id, c.fecha_observatorio, 
                            l.preview_desc  AS recurso_desc,
                            l.preview_titulo  AS recurso_titulo       
                    FROM "MIC-GEOVISORES".catalogo c
                    INNER JOIN "MIC-GEOVISORES".layer l on l.layer_id=c.origen_id_especifico') 
                                as G (origen_id_especifico bigint, origen_search_text text, subclase_id bigint, estudios_id bigint, 
                                    cod_esia_id bigint, cod_temporalidad_id bigint, objetos_id bigint, fecha_observatorio date, recurso_desc text, recurso_titulo text) ;
        
        ------ falta agregar --> WHERE c.origen_id_especifico NOT IN ()



        UNION ALL
        
         consulta propuesta para mic estadisticas 

        SELECT 'Estadistica'::text AS origen, 2 AS origen_id, 
        dt.dt_id AS origen_id_especifico, dt.dt_titulo AS origen_search_text, 
        NULL::bigint AS subclase_id, NULL::bigint AS estudios_id, 
        NULL::bigint AS cod_esia_id, NULL::bigint AS cod_temporalidad_id, 
        NULL::bigint AS objetos_id, dt.fecha_observatorio, 29::bigint AS recurso_categoria_id,
        'Estadísticas'::text AS recurso_categoria_desc,  dt_desc AS recurso_desc, dt_titulo AS recurso_titulo, 
        NULL::date AS recurso_fecha, NULL::text AS recurso_autores, NULL::text AS recurso_path_url,
        NULL::bigint AS recurso_size, NULL::bigint AS territorio_id,(-1) AS tipo_formato_id,(-1) AS visualizacion_tipo_id,
        'Modulo Interno'::text AS formato_desc, 'MI'::text AS formato_extension,'En modulo'::text AS visualizacion_tipo_desc,
        NULL::text AS tipo_formato_desc,2::bigint AS tipo_formato_solapa,NULL::bigint AS sub_proyecto_id
        FROM mod_estadistica.dt WHERE dt.origen_id_especifico NOT IN ()


        consulta definitiva para MIC-ESTADISTICAS ejecutada desde MIC-MEDIATECA

        SELECT 'Estadistica'::text AS origen, 2 AS origen_id, 
        dt.dt_id AS origen_id_especifico, dt.dt_titulo AS origen_search_text, 
        NULL::bigint AS subclase_id, NULL::bigint AS estudios_id, 
        NULL::bigint AS cod_esia_id, NULL::bigint AS cod_temporalidad_id, 
        NULL::bigint AS objetos_id, dt.fecha_observatorio, 29::bigint AS recurso_categoria_id,
        'Estadísticas'::text AS recurso_categoria_desc,  dt_desc AS recurso_desc, dt_titulo AS recurso_titulo, 
        NULL::date AS recurso_fecha, NULL::text AS recurso_autores, NULL::text AS recurso_path_url,
        NULL::bigint AS recurso_size, NULL::bigint AS territorio_id,(-1) AS tipo_formato_id,(-1) AS visualizacion_tipo_id,
        'Modulo Interno'::text AS formato_desc, 'MI'::text AS formato_extension,'En modulo'::text AS visualizacion_tipo_desc,
        NULL::text AS tipo_formato_desc,2::bigint AS tipo_formato_solapa,NULL::bigint AS sub_proyecto_id
        FROM dblink('dbname=MIC-ESTADISTICAS
                             hostaddr=179.43.126.101 
                             user=postgres 
                             password=plahe100%
                             port=5432',
                            'SELECT dt_id, dt_titulo, fecha_observatorio, dt_desc FROM "MIC-ESTADISTICAS".dt') 
                            as dt(dt_id bigint, dt_titulo text, fecha_observatorio date , dt_desc text) ;


        falta agregar el where y el not in ->    WHERE dt.origen_id_especifico NOT IN ()
         
        UNION ALL
        
        consulta propuesta para recursos de solapa 2 de mediateca 

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
        FROM ".'"MIC-MEDIATECA".recurso r
        LEFT JOIN "MIC-MEDIATECA".tipo_recurso tr ON tr.tipo_recurso_id = r.tipo_recurso_id
        LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = r.formato_id
        LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = r.recurso_categoria_id
        LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
        LEFT JOIN "MIC-MEDIATECA".visualizacion_tipo vt ON vt.visualizacion_tipo_id = f.visualizacion_tipo_id
        WHERE tf.tipo_formato_solapa = 2 AND r.origen_id_especifico NOT IN () ) + paginado


        consulta definitiva recursos mediateca solapa 2 

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
        WHERE tf.tipo_formato_solapa = 2
        
        
        falta agregar el not in -> AND r.origen_id_especifico NOT IN ()

        /*



        UNION ALL DEFINITIVO
        
SELECT COUNT(*) FROM ( SELECT 'GIS'::text AS origen, 0 AS origen_id,G.origen_id_especifico,
        G.origen_search_text,G.subclase_id,G.estudios_id,G.cod_esia_id,
        G.cod_temporalidad_id,G.objetos_id,G.fecha_observatorio,
        10::bigint AS recurso_categoria_id,'Capas Geográficas'::text AS recurso_categoria_desc,
        G.recurso_desc, G.recurso_titulo, NULL::date AS recurso_fecha,
        NULL::text AS recurso_autores, NULL::text AS recurso_path_url,
        NULL::bigint AS recurso_size, NULL::bigint AS territorio_id,(-1) AS tipo_formato_id,
        (-1) AS visualizacion_tipo_id,'Modulo Interno'::text AS formato_desc,
        'MI'::text AS formato_extension,'En modulo'::text AS visualizacion_tipo_desc,
        NULL::text AS tipo_formato_desc,2::bigint AS tipo_formato_solapa,NULL::bigint AS sub_proyecto_id                    
        FROM dblink('dbname=MIC-GEOVISORES
            hostaddr=179.43.126.101 
            user=postgres 
            password=plahe100%
            port=5432',
            'SELECT c.origen_id_especifico, c.origen_search_text, 
                    c.subclase_id, c.estudios_id, 
                    c.cod_esia_id, c.cod_temporalidad_id, 
                    c.objetos_id, c.fecha_observatorio, 
                    l.preview_desc  AS recurso_desc,
                    l.preview_titulo  AS recurso_titulo       
            FROM "MIC-GEOVISORES".catalogo c
            INNER JOIN "MIC-GEOVISORES".layer l on l.layer_id=c.origen_id_especifico') 
                        as G (origen_id_especifico bigint, origen_search_text text, subclase_id bigint, estudios_id bigint, 
                            cod_esia_id bigint, cod_temporalidad_id bigint, objetos_id bigint, fecha_observatorio date, recurso_desc text, recurso_titulo text)
        
        UNION ALL
        SELECT * FROM (SELECT 'Estadistica'::text AS origen, 2 AS origen_id, 
                dt.dt_id AS origen_id_especifico, dt.dt_titulo AS origen_search_text, 
                NULL::bigint AS subclase_id, NULL::bigint AS estudios_id, 
                NULL::bigint AS cod_esia_id, NULL::bigint AS cod_temporalidad_id, 
                NULL::bigint AS objetos_id, dt.fecha_observatorio, 29::bigint AS recurso_categoria_id,
                'Estadísticas'::text AS recurso_categoria_desc,  dt_desc AS recurso_desc, dt_titulo AS recurso_titulo, 
                NULL::date AS recurso_fecha, NULL::text AS recurso_autores, NULL::text AS recurso_path_url,
                NULL::bigint AS recurso_size, NULL::bigint AS territorio_id,(-1) AS tipo_formato_id,(-1) AS visualizacion_tipo_id,
                'Modulo Interno'::text AS formato_desc, 'MI'::text AS formato_extension,'En modulo'::text AS visualizacion_tipo_desc,
                NULL::text AS tipo_formato_desc,2::bigint AS tipo_formato_solapa,NULL::bigint AS sub_proyecto_id
                FROM dblink('dbname=MIC-ESTADISTICAS
                                    hostaddr=179.43.126.101 
                                    user=postgres 
                                    password=plahe100%
                                    port=5432',
                                    'SELECT dt_id, dt_titulo, fecha_observatorio, dt_desc FROM "MIC-ESTADISTICAS".dt') 
                                    as dt(dt_id bigint, dt_titulo text, fecha_observatorio date , dt_desc text)) as E
        
        UNION ALL
        SELECT 'recurso mediateca'::text AS origen, 5::bigint AS origen_id, 
                r.recurso_id AS origen_id_especifico, r.recurso_titulo AS origen_search_text,
                r.subclase_id,r.estudios_id,NULL::bigint AS cod_esia_id,r.cod_temporalidad_id,
                NULL::bigint AS objetos_id,r.fecha_observatorio,r.recurso_categoria_id,
                rc.recurso_categoria_desc,r.recurso_desc,r.recurso_titulo,r.recurso_fecha,   
                r.recurso_autores, r.recurso_path_url,  r.recurso_size,r.territorio_id,
                f.tipo_formato_id, f.visualizacion_tipo_id,f.formato_desc,f.formato_extension, 
                vt.visualizacion_tipo_desc,tf.tipo_formato_desc,tf.tipo_formato_solapa, r.sub_proyecto_id as sub_proyecto_id 
                FROM "MIC-MEDIATECA".recurso r
                LEFT JOIN "MIC-MEDIATECA".tipo_recurso tr ON tr.tipo_recurso_id = r.tipo_recurso_id
                LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = r.formato_id
                LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = r.recurso_categoria_id
                LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                LEFT JOIN "MIC-MEDIATECA".visualizacion_tipo vt ON vt.visualizacion_tipo_id = f.visualizacion_tipo_id
                WHERE tf.tipo_formato_solapa = 2 ) as u
            WHERE u.origen_id_especifico NOT IN (1,2,3,4,5,6)
                

        --> FIN UNION ALL DEFINITIVO 

        //RETORNAR EL DTO


/*
        DTO{
           RECURSOS
           CANTIDAD PAGINAS
           FILTROS 
        }


*/



