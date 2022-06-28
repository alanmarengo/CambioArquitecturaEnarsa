<?php

require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-MEDIATECA/CAPA-DOMINIO/INTERFACE-REPOSITORIO-QUERY/INTERFACE-REPOSITORIO-QUERY.php');
require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-MEDIATECA/CAPA-DATOS/capa-acceso.php');
require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-MEDIATECA/CAPA-DOMINIO/ENTIDADES/ENTIDADES.php');

//INJECTAR EL ARCHIVO ENTIDADES.php DE ESTE MICROSERVICIO


// COMENTARIO DE PRUEBA
class RepositorioQueryMediateca implements IRepositorioQueryMediateca{

    public function get_recursos($lista_recursos_restringidos, $solapa, $current_page,$page_size){

        $extension_consulta_filtro_recursos = "AND r.recurso_id NOT IN (";

        // armo una cadena para usar como subconsulta en la query principal 
        for($x=0; $x<=count($lista_recursos_restringidos)-1; $x++)
        {       
           if($x==count($lista_recursos_restringidos)-1){
               
               $extension_consulta_filtro_recursos.=$lista_recursos_restringidos[$x]['objeto_id'].")";
           }else{
               $extension_consulta_filtro_recursos.=$lista_recursos_restringidos[$x]['objeto_id'].",";
           }       
        }

        // variable paginado  

        $total_registros = $this->get_cantidad_recursos_solapa($solapa,$extension_consulta_filtro_recursos);

        $inicio = ($current_page - 1) * $page_size;         

        $paginador = ' LIMIT '.$page_size.' OFFSET '.$inicio;

        // fin paginador ---------------------------------



        $consulta_definitiva = "SELECT 'recurso mediateca'::text AS origen, 5::bigint AS origen_id, 
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
                                WHERE tf.tipo_formato_solapa = '.$solapa.' '.$extension_consulta_filtro_recursos.' '.$paginador.';';
       
        
        // instancio una nueva conexion 
        $conexion = new ConexionMediateca();
        
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

        // se retorna un objeto json de los recursos 
        return $array_recursos_mediateca; 
    }

    public function get_cantidad_recursos_solapa($solapa,$extension_consulta_filtro_recursos)
    {
        // variable consulta  
        $cantidad_recursos_solapa = 'SELECT COUNT(*) AS cant_rec_solapa
                                    FROM "MIC-MEDIATECA".recurso r
                                    INNER JOIN "MIC-MEDIATECA".formato f ON f.formato_id = r.formato_id
                                    INNER JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                    WHERE tf.tipo_formato_solapa ='.$solapa.' '.$extension_consulta_filtro_recursos.';';

        // instancio una nueva conexion 
        $conexion = new ConexionMediateca();

        //realizo la consulta            
        $aux_cantidad = $conexion->get_consulta($cantidad_recursos_solapa);   

        $conexion->desconectar(); // cierro la conexion

        return $aux_cantidad[0]['cant_rec_solapa'];
    }

    public function get_estadistica_inicial()
    {
        $consulta_estadistica_inicial = 'SELECT * FROM "MIC-MEDIATECA".estadistica_inicial        ';

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


    public function get_recursos_filtrado($lista_recursos_restringidos, $solapa, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad){
    
        $extension_consulta_filtro_recursos = "AND r.recurso_id NOT IN (";

        // armo una cadena para usar como subconsulta en la query principal 
        for($x=0; $x<=count($lista_recursos_restringidos)-1; $x++)
        {       
           if($x==count($lista_recursos_restringidos)-1){
               
               $extension_consulta_filtro_recursos.=$lista_recursos_restringidos[$x]['objeto_id'].")";
           }else{
               $extension_consulta_filtro_recursos.=$lista_recursos_restringidos[$x]['objeto_id'].",";
           }       
        }

        // variable paginado  

        $total_registros = $this->get_cantidad_recursos_solapa($solapa,$extension_consulta_filtro_recursos);

        $inicio = ($current_page - 1) * $page_size;         

        $paginador = ' LIMIT '.$page_size.' OFFSET '.$inicio;

        // fin paginador ---------------------------------

        // validacion de filtros 

        $aux_cadena_filtros = ""; // variable contenedora, almacenara un string con todas las adeciones de filtros a la consulta principal

        if(!empty($qt)) // variable que viene del buscador.
        {            
            $aux_cadena_filtros .= "AND (lower(unaccent(T.origen_search_text)) LIKE  lower(unaccent(%".$qt."%))"; // con unaccent  lower(unaccent('my_MMuíèles'))
            $aux_cadena_filtros .= " OR lower(unaccent(e.estudios_palabras_clave)) LIKE  lower(unaccent(%".$qt."%))";
            $aux_cadena_filtros .= " OR lower(unaccent(e.nombre)) LIKE  lower(unaccent(%".$qt."%))) "; 
        }

        switch ($tipo_temporalidad) { // dependiendo del valor de $tipo_temporalidad, el filtro de fecha se hace en campos diferentes
            case 0:
                if(!empty($desde) && !empty($hasta)) // si ningun filtro viene vacio. 
                {
                    $aux_cadena_filtros .= "  AND (('".$desde."' BETWEEN ct.tempo_desde AND ct.tempo_hasta) 
                                            OR('".$hasta."' BETWEEN ct.tempo_desde AND ct.tempo_hasta))";  
                
                }else{ 
                    if(empty($desde) && !empty($hasta)) // si desde viene vacio y hasta no. 
                    {
                        $aux_cadena_filtros .= "  AND (('".$hasta."' BETWEEN ct.tempo_desde AND ct.tempo_hasta) 
                                                OR('".$hasta."' BETWEEN ct.tempo_desde AND ct.tempo_hasta))";

                    }else if(!empty($desde) && empty($hasta)) // si desde no viene vacio y hasta si.
                    {
                        $aux_cadena_filtros .= "  AND (('".$desde."' BETWEEN ct.tempo_desde AND ct.tempo_hasta) 
                                                OR('".$desde."' BETWEEN ct.tempo_desde AND ct.tempo_hasta))";

                    }else{ // si llego a este punto, ninguno de los parametros tiene datos, por lo que no asigna nada a la variable.
                        $aux_cadena_filtros .= "";
                    }

                }
            case 1:
                if(!empty($desde) && !empty($hasta)) // si ningun filtro viene vacio. 
                {
                    $aux_cadena_filtros .= " AND ((T.fecha_observatorio IS NOT NULL)   AND
                                                  (T.fecha_observatorio BETWEEN ".$desde." AND ".$hasta."))";
                    if(empty($desde) && !empty($hasta)) // si desde viene vacio y hasta no. 
                    {
                        $aux_cadena_filtros .= "  AND ((T.fecha_observatorio IS NOT NULL)  AND 
                                                       (T.fecha_observatorio <= ".$hasta."))";

                    }else if(!empty($desde) && empty($hasta)) // si desde no viene vacio y hasta si.
                    {
                        $aux_cadena_filtros .= "  AND ((T.fecha_observatorio IS NOT NULL)  AND 
                                                       (T.fecha_observatorio >= ".$desde."))";

                    }else{ // si llego a este punto, ninguno de los parametros tiene datos, por lo que no asigna nada a la variable.
                        $aux_cadena_filtros .= "";
                    }
                }
            case 2:
                if(!empty($desde) && !empty($hasta)) // si ningun filtro viene vacio. 
                {
                    $aux_cadena_filtros .= " AND ((T.recurso_fecha IS NOT NULL)   AND
                                                  (T.recurso_fecha BETWEEN ".$desde." AND ".$hasta."))";
                    if(empty($desde) && !empty($hasta)) // si desde viene vacio y hasta no. 
                    {
                        $aux_cadena_filtros .= "  AND ((T.recurso_fecha IS NOT NULL)  AND 
                                                       (T.recurso_fecha <= ".$hasta."))";

                    }else if(!empty($desde) && empty($hasta)) // si desde no viene vacio y hasta si.
                    {
                        $aux_cadena_filtros .= "  AND ((T.recurso_fecha IS NOT NULL)  AND 
                                                       (T.recurso_fecha >= ".$desde."))";

                    }else{ // si llego a este punto, ninguno de los parametros tiene datos, por lo que no asigna nada a la variable.
                        $aux_cadena_filtros .= "";
                    }
                }
        }
        
        if(!empty($proyecto))
        {
            $aux_cadena_filtros .= " AND e.sub_proyecto_id = ".$proyecto; //
        }

        if(!empty($clase))
        {
            $aux_cadena_filtros .= " AND sc.clase_id = ".$clase; // con unaccent 
        }
        if(!empty($subclase))
        {
            $aux_cadena_filtros .= "AND sc.subclase_id =".$subclase; // con unaccent 
        }
        if(!empty($tipo_doc))
        {
            $aux_cadena_filtros .= "AND t.recurso_categoria_id = ".$tipo_doc; // con unaccent 
        }
        if(!empty($filtro_temporalidad))
        {
            $aux_cadena_filtros .= "AND "; // con unaccent 
        }
        
        $consulta_definitiva = "".$solapa.' '.$extension_consulta_filtro_recursos.' '.$paginador.';';
       
        
        // instancio una nueva conexion 
        $conexion = new ConexionMediateca();
        
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

        // se retorna un objeto json de los recursos 
        return $array_recursos_filtrados_mediateca; 
    
    
    
    
        /* SELECT 'recurso mediateca'::text AS origen, 5::bigint AS origen_id, 
    r.recurso_id AS origen_id_especifico, 
    r.recurso_titulo AS origen_search_text, r.subclase_id, r.estudios_id, 
    NULL::bigint AS cod_esia_id, r.cod_temporalidad_id, 
    NULL::bigint AS objetos_id, r.recurso_categoria_id, r.tipo_recurso_id, 
    r.formato_id, r.recurso_titulo, r.recurso_desc, r.recurso_fecha, 
    r.recurso_autores, r.recurso_path_url, r.recurso_size, r.territorio_id, 
    tr.tipo_recurso_desc, rc.recurso_categoria_desc, f.tipo_formato_id, 
    f.visualizacion_tipo_id, f.formato_desc, f.formato_extension, 
    vt.visualizacion_tipo_desc, t.descripcion AS territorio_desc, 
    t.fec_bbdd_date AS territorio_fec_bbdd_date, t.territorio_simpli, 
    t.fec_bbdd AS territorio_fec_bbdd, tf.tipo_formato_solapa, 
    tf.tipo_formato_desc, r.sub_proyecto_id, r.fecha_observatorio,
	ce.cap AS esia_cap, ce.titulo AS esia_titulo, 
    ce.orden_esia AS esia_orden_esia, ce.ruta AS esia_ruta, 
    ce.cod_esia AS esia_cod_original, e.estudios_palabras_clave, 
    e.sub_proyecto_id, e.estudio_estado_id, e.nombre, e.fecha, e.institucion, 
    e.responsable, e.equipo, e.cod_oficial, e.descripcion, 
    e.fecha_text_original, e.institucion_id, 
    ( SELECT sub_proyecto.sub_proyecto_desc
           FROM mod_catalogo.sub_proyecto
          WHERE sub_proyecto.sub_proyecto_id = COALESCE(c.sub_proyecto_id, e.sub_proyecto_id, NULL::bigint)
         LIMIT 1) AS sub_proyecto_desc, 
    e.proyecto_id, e.proyecto_desc, e.proyecto_extent, e.institucion_nombre, 
    e.institucion_tel, e.institucion_contacto, e.institucion_email, t.cod_temp, 
    t.desde AS tempo_desde, t.hasta AS tempo_hasta, t.descripcion AS tempo_desc, 
    sc.clase_id, sc.subclase_desc, sc.subclase_cod, sc.estado_subclase, 
    sc.cod_unsubclase, sc.descripcio, sc.cod_nom, sc.fec_bbdd, 
        CASE
            WHEN c.sub_proyecto_id IS NULL THEN e.sub_proyecto_id
            ELSE c.sub_proyecto_id
        END AS sub_proyecto_id_principal, 
    c.fecha_observatorio
   FROM mod_mediateca.recurso r
   LEFT JOIN mod_mediateca.tipo_recurso tr ON tr.tipo_recurso_id = r.tipo_recurso_id
   LEFT JOIN mod_catalogo.territorio t ON t.territorio_id = r.territorio_id -> aca db link
   LEFT JOIN mod_mediateca.formato f ON f.formato_id = r.formato_id
   LEFT JOIN mod_mediateca.recurso_categoria rc ON rc.recurso_categoria_id = r.recurso_categoria_id
   LEFT JOIN mod_mediateca.tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
   LEFT JOIN mod_mediateca.visualizacion_tipo vt ON vt.visualizacion_tipo_id = f.visualizacion_tipo_id;
   LEFT JOIN mod_catalogo.vw_estudio e ON r.estudios_id = e.estudios_id
   LEFT JOIN mod_catalogo.cod_esia ce ON ce.cod_esia_id = r.cod_esia_id
   LEFT JOIN mod_catalogo.cod_temporalidad t ON t.cod_temporalidad_id = r.cod_temporalidad_id
   LEFT JOIN mod_catalogo.subclase sc ON sc.subclase_id = r.subclase_id
   LEFT JOIN mod_catalogo.clase cc ON sc.clase_id = cc.clase_id;
   WHERE c.tipo_formato_solapa= $solapa
   LIMIT
   OFFSET

   */
    }
}

$test = new RepositorioQueryMediateca();
echo $test->get_estadistica_inicial();


/* query a medias, falta poner db link
SELECT * FROM (SELECT r.estudios_id as estudios_id_rec,'recurso mediateca'::text AS origen, 5::bigint AS origen_id, 
    r.recurso_id AS origen_id_especifico, 
    r.recurso_titulo AS origen_search_text, r.subclase_id, r.estudios_id, 
    NULL::bigint AS cod_esia_id, r.cod_temporalidad_id, 
    NULL::bigint AS objetos_id, r.recurso_categoria_id, r.tipo_recurso_id, 
    r.formato_id, r.recurso_titulo, r.recurso_desc, r.recurso_fecha, 
    r.recurso_autores, r.recurso_path_url, r.recurso_size, r.territorio_id,
    r.sub_proyecto_id, r.fecha_observatorio,
    tr.tipo_recurso_desc, rc.recurso_categoria_desc,f.tipo_formato_id
    ,f.visualizacion_tipo_id, f.formato_desc, f.formato_extension,vt.visualizacion_tipo_desc,
    tf.tipo_formato_solapa, r.fecha_observatorio
    FROM "MIC-MEDIATECA".recurso as r
    LEFT JOIN "MIC-MEDIATECA".tipo_recurso tr ON tr.tipo_recurso_id = r.tipo_recurso_id
    LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = r.recurso_categoria_id
    LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = r.formato_id
    LEFT JOIN "MIC-MEDIATECA".visualizacion_tipo vt ON vt.visualizacion_tipo_id = f.visualizacion_tipo_id
    LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id) AS T
    LEFT JOIN dblink('dbname=MIC-CATALOGO hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                    'SELECT * FROM "MIC-CATALOGO".cod_esia') 
			   	    AS ce (cod_esia_id bigint ,cap  text,titulo  text,orden_esia  text,ruta  text,cod_esia text)  
                    ON t.cod_esia_id = ce.cod_esia_id
    LEFT JOIN dblink('dbname=MIC-CATALOGO hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                    'select cod_temp,desde AS tempo_desde, hasta AS tempo_hasta, descripcion AS tempo_desc from "MIC-CATALOGO".cod_temporalidad') 
			   	    AS ct (cod_temp bigint ,tempo_desde  text,tempo_hasta  text,tempo_desc  text)  
                    ON t.cod_temporalidad_id = ct.cod_temp
    LEFT JOIN dblink('dbname=MIC-CATALOGO hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                    'select subclase_id, clase_id, subclase_desc, subclase_cod, estado_subclase, 
                            cod_unsubclase, descripcio, cod_nom, fec_bbdd from "MIC-CATALOGO".subclase') 
			   	    AS sc (subclase_id bigint,clase_id bigint, subclase_desc text, subclase_cod text, estado_subclase bigint, 
                           cod_unsubclase text, descripcio text, cod_nom text, fec_bbdd text)  
                    ON T.subclase_id = sc.subclase_id
    LEFT JOIN dblink('dbname=MIC-CATALOGO hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                    'SELECT e.estudios_id, e.estudios_palabras_clave, e.sub_proyecto_id, 
                            e.estudio_estado_id,e.nombre,e.fecha, e.institucion,e.responsable,
                            e.equipo, e.cod_oficial, e.descripcion, e.fecha_text_original,
                            e.institucion_id, sp.proyecto_id,p.proyecto_desc,
                            p.proyecto_extent,i.institucion_nombre, i.institucion_tel,
                            i.institucion_contacto, i.institucion_email
                    FROM "MIC-CATALOGO".estudios e
                    LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = e.sub_proyecto_id
                    LEFT JOIN "MIC-CATALOGO".proyecto p ON sp.proyecto_id = p.proyecto_id
                    LEFT JOIN "MIC-CATALOGO".institucion i ON i.institucion_id = e.institucion_id') 
			   	    AS e (estudios_id bigint, estudios_palabras_clave text, sub_proyecto_id bigint, 
                            estudio_estado_id bigint,nombre text,fecha date, institucion text,responsable text,
                            equipo text, cod_oficial text, descripcion text, fecha_text_original text,
                            institucion_id bigint, proyecto_id bigint,proyecto_desc text,
                            proyecto_extent text,institucion_nombre text, institucion_tel text,
                            institucion_contacto text, institucion_email text)  
                    ON t.estudios_id_rec = e.estudios_id
   WHERE t.tipo_formato_solapa = 1 




   //AGREGAR PARAMETRO  TIPO_TEMPORALIDAD Y REALIZAR ESTAS VERIFICACIONES.

   IF (_desde <> '' AND _tipo_temporalidad ='0') THEN
		buffer := buffer || ' AND ((C.tempo_desde >= '''||_desde||''')AND( C.tempo_hasta<='''||_hasta||''' ))';
	END IF;
	
	IF (_desde <> '' AND _tipo_temporalidad ='1') THEN
		buffer := buffer || 'AND (C.fecha_observatorio IS NOT NULL) AND ((C.fecha_observatorio >= '''||_desde||''')AND(C.fecha_observatorio<= '''||_hasta||''')) ';
	END IF;
	
	IF (_desde <> '' AND _tipo_temporalidad ='2') THEN
		buffer := buffer || 'AND (C.recurso_fecha IS NOT NULL) AND (( C.recurso_fecha >='''||_desde||''')AND(C.recurso_fecha <= '''||_hasta||''')) ';
	END IF;

