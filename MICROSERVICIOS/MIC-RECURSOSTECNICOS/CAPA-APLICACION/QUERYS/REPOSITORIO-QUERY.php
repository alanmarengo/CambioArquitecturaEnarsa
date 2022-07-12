<?php

require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-RECURSOSTECNICOS/CAPA-DOMINIO/INTERFACE-QUERYS/REPOSITORIO-INTERFACE-QUERY.php');


//INJECTAR LA CONEXION
require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-RECURSOSTECNICOS/CAPA-DATOS/capa-acceso.php');

//INJECTAR DTO
//INJECTAR ENTIDADES


class RepositorioQueryRecursosTecnicos implements IRepositorioQueryRecursosTecnicos{

    public function get_recursos_tecnicos($lista_recursos_restringidos, $current_page, $page_size)
    {
        //HACER LOGICA RECURSOS RESTRINGIDOS.
        $extension_consulta_filtro_recursos = "WHERE u.origen_id_especifico NOT IN ("; // apuntar al campo deseado 

        // armo una cadena para usar como subconsulta en la query principal 
        /*
        for($x=0; $x<=count($lista_recursos_restringidos)-1; $x++)
        {       
           if($x==count($lista_recursos_restringidos)-1){
               
               $extension_consulta_filtro_recursos.=$lista_recursos_restringidos[$x]['objeto_id'].")";
           }else{
               $extension_consulta_filtro_recursos.=$lista_recursos_restringidos[$x]['objeto_id'].",";
           }       
        }  */ // este for esta adaptado al array que recibira realmente 

        // for con array de prueba para verificar los datos 

        for($x=0; $x<=count($lista_recursos_restringidos)-1; $x++)
        {       
           if($x==count($lista_recursos_restringidos)-1){
               
               $extension_consulta_filtro_recursos.=$lista_recursos_restringidos[$x].")";
           }else{
               $extension_consulta_filtro_recursos.=$lista_recursos_restringidos[$x].",";
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
                                EOD;
        
        
        $CONSULTA_DEFINITIVA_RECURSOS_TECNICOS = $aux_consulta_recursos.' '.$extension_consulta_filtro_recursos.' '.$paginador;
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
            $recurso = new RecursoTecnico($solapa,$origen_id,$id_recurso,$titulo,$descripcion,$link_imagen,$metatag,$autores,$estudios_id,$fecha,$tema,$territorio_id,$ico);
            array_push($array_recursos_tecnicos,$recurso);                    
        }
        // faltaria estadistica de la solapa para devolver en mediateca, tentativamente ira la variable total_registros. ya que es total de registros 
        return new Recursos($array_recursos_tecnicos,$cant_paginas ,$extension_consulta_filtro_recursos,$total_registros);         
    } // fin function get_recursos_tecnicos 




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



