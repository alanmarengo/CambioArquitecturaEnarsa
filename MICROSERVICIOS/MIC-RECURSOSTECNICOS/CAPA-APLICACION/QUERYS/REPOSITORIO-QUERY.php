<?php
//INJECTAR LA CONEXION
//INJECTAR DTO
//INJECTAR ENTIDADES

class RepositorioQueryRecursosTecnicos implements IRepositorioQueryRecursosTecnicos{


    public function get_recursos_tecnicos($lista_recursos_restringidos, $current_page, $page_size)
    {
        //HACER LOGICA RECURSOS RESTRINGIDOS.
        //LOGICA DE PAGINADOR


        //SACAR CANTIDAD TOTAL DE REGISTROS PARA EL PAGINADO








        //EJECUTAR CONSULTA PRINCIPAL
        /*
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
        FROM mod_estadistica.dt WHERE dt.origen_id_especifico NOT IN ()
         
        UNION ALL
        
    
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

        /*



        //RETORNAR EL DTO


/*
        DTO{
           RECURSOS
           CANTIDAD PAGINAS
           FILTROS 
        }


*/




    }




}