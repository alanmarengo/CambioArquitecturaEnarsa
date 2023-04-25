<?php
require_once(dirname(__FILE__,4).'/MIC-CATALOGO/CAPA-DOMINIO/INTERFACE-QUERY/REPOSITORIO-INTERFACE-QUERY.php');
require_once(dirname(__FILE__,4).'/MIC-CATALOGO/CAPA-DATOS/capa-acceso.php');
require_once(dirname(__FILE__,4).'/MIC-CATALOGO/CAPA-DOMINIO/DTOS/DTOS.php');
require_once(dirname(__FILE__,4).'/MIC-CATALOGO/CAPA-DOMINIO/CLASES/Clases.php');

//INCLUIR LA LIBRERIA DTO.

class RepositorioQueryCatalogo implements IRepositorioQueryCatalogo{


    public function get_consulta($query_string)
    {
        $conexion = new ConexionCatalogo();
        $resultado = $conexion->get_consulta($query_string);

        if(!empty($resultado))
        {
            return $resultado;
        }else{
            return false;
        }
    }


    // metodo para obtener datos del territorio a partir del id 
    public function get_info_territorio($territorio_id)
    {
        //aca instancio a la conexion 
        $conexion = new ConexionCatalogo();

        $query = 'SELECT t.fec_bbdd_date, t.territorio_simpli,t.fec_bbdd,t.descripcion 
                    FROM "MIC-CATALOGO".territorio t 
                    WHERE t.territorio_id = '.$territorio_id;

        $resultado_query_info_territorio = $conexion->get_consulta($query); // retorno el resultado de la consulta ejecutada

        if(!empty($resultado_query_info_territorio))
        {
            $respuesta_op_server = new respuesta_error_catalogo();
            $respuesta_op_server->flag = true;
            $respuesta_op_server->detalle = $resultado_query_info_territorio;  

        }else{

            $respuesta_op_server = new respuesta_error_catalogo();
            $respuesta_op_server->flag = false;
            $respuesta_op_server->detalle = "No se encontraron resultados";

        }
        
        //retorno un fetch_row o fetch_assoc        
        return  $respuesta_op_server; // resultado, a

    }
    
    public function get_filtros($solapa,$aux_cadena_filtros,$lista_recursos_restringidos,$si_tengo_que_filtrar){ 
      
        //ESTO RETORNA UNA LISTA DE FILTROSDTOS

        // cada solapa, hace utiliza una determinada cantidad de filtros 
        //SOLAPA 0, FILTROS_ID : 0,1,3,4 -> filtros_id 
        //SOLAPA 1, FILTROS_ID : 0,3,4,5
        //SOLAPA 2, FILTROS_ID : 0,2,3,4
        //SOLAPA 3, FILTROS_ID : 0,3,4

        // cada filtro tiene una clase o tipo 
        //OBRA/PROYECTO : FILTRO_ID 0
        //AREA GESTION : FILTRO_ID 1
        //RECURSOS TECNICOS: FILTRO_ID 2
        //AREA TEMATICA : FILTRO_ID 3
        //TEMA/SUBTEMA: FILTRO_ID 4
        //RECURSOS AUDIOVISUALES: FILTRO ID 5

        //DEPENDIENDO DE QUE SOLAPA ENTRE Y QUE FILTROS ID CALCULO ENTONCES:        
        $lista_filtros_solapa_0=[0,1,3,4]; 
        $lista_filtros_solapa_1=[0,3,4,5];
        $lista_filtros_solapa_2=[0,2,3,4]; // quitar el 1 y el 5 
        $lista_filtros_solapa_3=[0,3,4];        
        
        $QUERY_DEFINITIVA = ""; // variable contenedora de consulta final a ejecutar. 
      
            switch($solapa)
            {       
                case 0:

                    $QUERY_DEFINITIVA = 'SELECT F.*,COALESCE(A.total,0) AS total FROM "MIC-CATALOGO".vw_filtros_values F '.
                    'LEFT JOIN'.$this->ConstruirQueryUnion($lista_filtros_solapa_0, 0,$aux_cadena_filtros,$lista_recursos_restringidos,$si_tengo_que_filtrar).
                    " ON F.filtro_id=A.filtro_id AND F.valor_id = A.valor_id ORDER BY valor_desc ASC ";
                    break;

                case 1: 

                    $QUERY_DEFINITIVA = 'SELECT F.*,COALESCE(A.total,0) AS total FROM "MIC-CATALOGO".vw_filtros_values F '.
                    'LEFT JOIN'.$this->ConstruirQueryUnion($lista_filtros_solapa_1, 1,$aux_cadena_filtros,$lista_recursos_restringidos,$si_tengo_que_filtrar).
                    " ON F.filtro_id=A.filtro_id AND F.valor_id = A.valor_id ORDER BY valor_desc ASC ";
                    break;                   
                
                case 2:
                    $QUERY_DEFINITIVA = 'SELECT F.*,COALESCE(A.total,0) AS total FROM "MIC-CATALOGO".vw_filtros_values F '.
                    'LEFT JOIN'.$this->ConstruirQueryUnionRecursosTecnicos($lista_filtros_solapa_2, 2,$aux_cadena_filtros,$lista_recursos_restringidos,$si_tengo_que_filtrar).
                    " ON F.filtro_id=A.filtro_id AND F.valor_id = A.valor_id ORDER BY valor_desc ASC ";
                    break;

                case 3:

                    $QUERY_DEFINITIVA = 'SELECT F.*,COALESCE(A.total,0) AS total FROM "MIC-CATALOGO".vw_filtros_values F '.
                    'LEFT JOIN'.$this->ConstruirQueryUnion($lista_filtros_solapa_3, 3,$aux_cadena_filtros,$lista_recursos_restringidos,$si_tengo_que_filtrar).
                    " ON F.filtro_id=A.filtro_id AND F.valor_id = A.valor_id ORDER BY valor_desc ASC ";
                       
                    break;


            }


            $conexion = New ConexionCatalogo(); //
            //echo $QUERY_DEFINITIVA; exit;

            $resultado_final_filtros = $conexion->get_consulta($QUERY_DEFINITIVA);
            
            //creo un array para guardar todos los filtros 
            $filtros= array();

            // recorro el arreglo con los datos de la consulta 
            for($x=0; $x<=count($resultado_final_filtros)-1; $x++)
            {
                $filtro_nombre= $resultado_final_filtros[$x]['filtro_nombre'];
                $filtro_id= $resultado_final_filtros[$x]['filtro_id'];
                $valor_id= $resultado_final_filtros[$x]['valor_id'];
                $valor_desc= $resultado_final_filtros[$x]['valor_desc'];
                $parent_filtro_id= $resultado_final_filtros[$x]['parent_filtro_id'];
                $parent_valor_id= $resultado_final_filtros[$x]['parent_valor_id']; 
                $total= $resultado_final_filtros[$x]['total'];    

                // por cada registro, se agrega un objeto FiltroDTO al array contenedor    

                $filtro = new FiltroDTO($filtro_nombre,$filtro_id,$valor_id,$valor_desc,$total,$parent_valor_id);
                array_push($filtros,$filtro);
                
            }
        
        $conexion->desconectar(); // cierro la conexion
        
        if(!empty($filtros))
        {
            $respuesta_op_server = new respuesta_error_catalogo();
            $respuesta_op_server->flag = true;
            $respuesta_op_server->detalle = $filtros;  

        }else{

            $respuesta_op_server = new respuesta_error_catalogo();
            $respuesta_op_server->flag = false;
            $respuesta_op_server->detalle = "No se encontraron resultados";

        }
        
        //retorno un fetch_row o fetch_assoc        
        return  $respuesta_op_server; // resultado, a

        // se retorna un objeto json de los filtros 
        //return $filtros; 
 
    }

    public function ConstruirQueryUnion($lista_filtros_solapa, $solapa,$filtros,$lista_recursos_restringidos,$si_tengo_que_filtrar){

        $QUERY_RETURN = "("; // variable contenedora de la union de filtros

        $conect_mic_catalogo = new ConexionCatalogo;
        
        
        
        // SECCION DE ARMADO DE FILTTROS 
        
        $auxiliar_extensiones_filtros = ""; // variable que concatenara los filtros y los recursos restringidos en caso de ser necesario,    

        $extension_consulta_filtro_recursos = "AND r.recurso_id NOT IN (";

                // armo una cadena para usar como subconsulta en la query principal 
        for($x=0; $x<=count($lista_recursos_restringidos->detalle)-1; $x++)
        {       
           if($x==count($lista_recursos_restringidos->detalle)-1){
               
               $extension_consulta_filtro_recursos.=$lista_recursos_restringidos->detalle[$x]['objeto_id'].")";
           }else{
               $extension_consulta_filtro_recursos.=$lista_recursos_restringidos->detalle[$x]['objeto_id'].",";
           }       
        }
        
                // validacion de filtros 
                $aux_cadena_filtros = "";

        if(!empty($filtros))
        {                       

            $aux_cadena_filtros = ""; // variable contenedora, almacenara un string con todas las adeciones de filtros a la consulta principal
            
            if(!empty($filtros->qt)) // variable que viene del buscador.
            {            

                $aux_cadena_filtros = <<<EOD
                AND ( lower("MIC-CATALOGO".unaccent(r.origen_search_text)) LIKE  lower("MIC-CATALOGO".unaccent('%$filtros->qt%'))
                OR lower("MIC-CATALOGO".unaccent(e.estudios_palabras_clave)) LIKE  lower("MIC-CATALOGO".unaccent('%$filtros->qt%'))
                OR lower("MIC-CATALOGO".unaccent(e.nombre)) LIKE  lower("MIC-CATALOGO".unaccent('%$filtros->qt%'))
                OR lower("MIC-CATALOGO".unaccent(e.equipo)) LIKE  lower("MIC-CATALOGO".unaccent('%$filtros->qt%')) 
                OR lower("MIC-CATALOGO".unaccent(e.institucion)) LIKE  lower("MIC-CATALOGO".unaccent('%$filtros->qt%'))
                OR lower("MIC-CATALOGO".unaccent(e.responsable)) LIKE  lower("MIC-CATALOGO".unaccent('%$filtros->qt%')) )
                EOD;
        
        
                /*
                
                $aux_cadena_filtros .= " AND ( lower(unaccent(T.origen_search_text)) LIKE  lower(unaccent('%".$qt."%'))"; // con unaccent  lower(unaccent('my_MMuíèles'))
                $aux_cadena_filtros .= " OR lower(unaccent(e.estudios_palabras_clave)) LIKE  lower(unaccent('%".$qt."%'))";
                $aux_cadena_filtros .= " OR lower(unaccent(e.nombre)) LIKE  lower(unaccent('%".$qt."%')) ";
                $aux_cadena_filtros .= " OR lower(unaccent(e.equipo)) LIKE  lower(unaccent('%".$qt."%')) ";
                $aux_cadena_filtros .= " OR lower(unaccent(e.institucion)) LIKE  lower(unaccent('%".$qt."%')) ";
                $aux_cadena_filtros .= " OR lower(unaccent(e.responsable)) LIKE  lower(unaccent('%".$qt."%')) ) "; */
                
            }
            
            if(!empty($filtros->filtro_temporalidad)){

                switch ($filtros->filtro_temporalidad) { // dependiendo del valor de $tipo_temporalidad, el filtro de fecha se hace en campos diferentes
                    
                    case 0:
    
                        if(!empty($filtros->desde) && !empty($filtros->hasta)) // si ningun filtro viene vacio. 
                        {
    
                            $date_hasta = date_create(str_replace("/","-",$filtros->hasta));
                            $aux_hora_hasta = date_format($date_hasta, 'Y-m-d');
    
                            $date_desde = date_create(str_replace("/","-",$filtros->desde));
                            $aux_hora_desde = date_format($date_desde, 'Y-m-d');
    
                            $aux_cadena_filtros .= "  AND (('$aux_hora_desde' BETWEEN ct.tempo_desde AND ct.tempo_hasta) 
                                                    OR('$aux_hora_hasta' BETWEEN ct.tempo_desde AND ct.tempo_hasta))";  
                        
                        }else{ 
    
                            if(empty($filtros->desde) && !empty($filtros->hasta)) // si desde viene vacio y hasta no. 
                            {
                                $date_hasta = date_create(str_replace("/","-",$filtros->hasta));
                                $aux_hora_hasta = date_format($date_hasta, 'Y-m-d');
    
                                $aux_cadena_filtros .= "  AND (('$aux_hora_hasta' BETWEEN ct.tempo_desde AND ct.tempo_hasta) 
                                                        OR('$aux_hora_hasta' BETWEEN ct.tempo_desde AND ct.tempo_hasta))";
        
                            }else if(!empty($filtros->desde) && empty($filtros->hasta)) // si desde no viene vacio y hasta si.
                            {
    
                                $date_desde = date_create(str_replace("/","-",$filtros->desde));
                                $aux_hora_desde = date_format($date_desde, 'Y-m-d');
    
                                $aux_cadena_filtros .= "  AND (('$aux_hora_desde' BETWEEN ct.tempo_desde AND ct.tempo_hasta) 
                                                        OR('$aux_hora_desde' BETWEEN ct.tempo_desde AND ct.tempo_hasta))";
        
                            }
                        }
        
                        break;
    
                    case 1:
    
                        if(!empty($filtros->desde) && !empty($filtros->hasta)) // si ningun filtro viene vacio. 
                        {
                            $date_hasta = date_create(str_replace("/","-",$filtros->hasta));
                            $aux_hora_hasta = date_format($date_hasta, 'Y-m-d');
    
                            $date_desde = date_create(str_replace("/","-",$filtros->desde));
                            $aux_hora_desde = date_format($date_desde, 'Y-m-d');
    
                            $aux_cadena_filtros .= " AND (fecha_observatorio IS NOT NULL) AND (fecha_observatorio BETWEEN '$aux_hora_desde' AND '$aux_hora_hasta')";
    
                        } else if(empty($filtros->desde) && !empty($filtros->hasta)){              // si desde viene vacio y hasta no. 
    
                            $date_hasta = date_create(str_replace("/","-",$filtros->hasta));
                            $aux_hora_hasta = date_format($date_hasta, 'Y-m-d');
    
                            $aux_cadena_filtros .= "  AND (fecha_observatorio IS NOT NULL) AND (fecha_observatorio <= '$aux_hora_hasta')";
        
                        }else if(!empty($filtros->desde) && empty($filtros->hasta)){ // si desde no viene vacio y hasta si.
                            
                            $date_desde = date_create(str_replace("/","-",$filtros->desde));
                            $aux_hora_desde = date_format($date_desde, 'Y-m-d');
    
                            $aux_cadena_filtros .= "  AND (fecha_observatorio IS NOT NULL) AND (fecha_observatorio >= '$aux_hora_desde')";
        
                        }else{ // si llego a este punto, ninguno de los parametros tiene datos, por lo que no asigna nada a la variable.
                            $aux_cadena_filtros .= "";
    
                        }
                        
                        break;
    
                    case 2:
    
                        if(!empty($filtros->desde) || !empty($filtros->hasta)) // si ningun filtro viene vacio. 
                        {
                            
                            if(empty($filtros->desde) && !empty($filtros->hasta)) // si desde viene vacio y hasta no. 
                            {                                   
                                $date_hasta = date_create(str_replace("/","-",$filtros->hasta));
                                $aux_hora_hasta = date_format($date_hasta, 'Y-m-d');
    
                                $aux_cadena_filtros .= "  AND (recurso_fecha IS NOT NULL)  AND 
                                                               (recurso_fecha <= '$haaux_hora_hasta')";
        
                            }else if(!empty($filtros->desde) && empty($filtros->hasta)) // si desde no viene vacio y hasta si.
                            {
                                $date_desde = date_create(str_replace("/","-",$filtros->desde));
                                $aux_hora_desde = date_format($date_desde, 'Y-m-d');
    
                                $aux_cadena_filtros .= "  AND (recurso_fecha IS NOT NULL) AND (recurso_fecha >= '$aux_hora_desde')";
        
                            }else if(!empty($filtros->desde) && !empty($filtros->hasta)){
    
                                $date_hasta = date_create(str_replace("/","-",$filtros->hasta));
                                $aux_hora_hasta = date_format($date_hasta, 'Y-m-d');
    
                                $date_desde = date_create(str_replace("/","-",$filtros->desde));
                                $aux_hora_desde = date_format($date_desde, 'Y-m-d');
    
                                $aux_cadena_filtros .= " AND (recurso_fecha IS NOT NULL) AND (recurso_fecha BETWEEN '$aux_hora_desde' AND '$aux_hora_hasta')";
                            }
    
                        } 
                        break;
                }
    
            }    
            
            
            if(!empty($filtros->proyecto)) { $aux_cadena_filtros .= " AND e.sub_proyecto_id = ".$filtros->proyecto; }
            if(!empty($filtros->clase)) { $aux_cadena_filtros .= " AND sc.clase_id = ".$filtros->clase; }
            if(!empty($filtros->subclase)) { $aux_cadena_filtros .= "AND sc.subclase_id =".$filtros->subclase; }
            if(!empty($filtros->tipo_doc)) { $aux_cadena_filtros .= "AND r.recurso_categoria_id = ".$filtros->tipo_doc; }
            
                    // fin validacion de filtros   

         }
        
        
        $auxiliar_extensiones_filtros = ' '.$aux_cadena_filtros.' '.$extension_consulta_filtro_recursos; // se concatena el string de los filtros y los recursos restringidos
       
      
        for($x=0;$x<=count($lista_filtros_solapa)-1; $x++) // por cada filtro_id que exista en la lista 
        {            
            switch($lista_filtros_solapa[$x])
            {  
                case 0:                                                    
                    $query_parcial = <<<EOD
                            SELECT $lista_filtros_solapa[$x]::BIGINT AS filtro_id,
                            sp.sub_proyecto_desc::TEXT AS desc,
                            CASE
                                WHEN r.sub_proyecto_id IS NULL THEN e.sub_proyecto_id
                                ELSE r.sub_proyecto_id
                            END  AS valor_id ,
                            COUNT(*)::BIGINT AS total 
                            FROM (select *, t.recurso_titulo as origen_search_text, t.recurso_categoria_id as categoria_id, rc.recurso_categoria_desc as categoria_desc
                                    FROM mic_mediateca_fdw.recurso t 
                                    LEFT JOIN mic_mediateca_fdw.formato f ON f.formato_id = t.formato_id 
                                    LEFT JOIN mic_mediateca_fdw.tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                    LEFT JOIN mic_mediateca_fdw.recurso_categoria rc ON rc.recurso_categoria_id = t.recurso_categoria_id)as r 
                                        
                            LEFT JOIN "MIC-CATALOGO".vw_estudio e ON r.estudios_id = e.estudios_id
                            LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = r.cod_temporalidad_id
                            LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = r.subclase_id
                            LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = r.subclase_id -- añadir tabla sub proyecto
                            WHERE r.tipo_formato_solapa = $solapa $auxiliar_extensiones_filtros 

                        EOD; 

                    break;              
                    
                case 1: // nota: entre el caso 1 y dos, solo varia el valor del campo recurso_categoria_filtro  en 1 y 2, por lo que queda pre seteado. 
                    $query_parcial = <<<EOD
                                        SELECT $lista_filtros_solapa[$x]::BIGINT AS filtro_id, r.categoria_desc::TEXT AS desc,
                                        r.categoria_id::BIGINT AS valor_id,
                                        COUNT(*)::BIGINT AS total 
                                    FROM ( select *, t.recurso_titulo as origen_search_text, t.recurso_categoria_id as categoria_id, rc.recurso_categoria_desc as categoria_desc
                                            FROM mic_mediateca_fdw.recurso t 
                                            LEFT JOIN mic_mediateca_fdw.formato f ON f.formato_id = t.formato_id 
                                            LEFT JOIN mic_mediateca_fdw.tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                            LEFT JOIN mic_mediateca_fdw.recurso_categoria rc ON rc.recurso_categoria_id = t.recurso_categoria_id) as r 
                                    
                                    LEFT JOIN "MIC-CATALOGO".vw_estudio e ON r.estudios_id = e.estudios_id
                                    LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = r.cod_temporalidad_id
                                    LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = r.subclase_id
                                    LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = r.subclase_id -- añadir tabla sub proyecto
                                    WHERE r.tipo_formato_solapa = $solapa $auxiliar_extensiones_filtros   
                                    
                                    EOD;                                   
                                 
                    break;

                case 2: // nota: entre el caso 1 y dos, solo varia el valor del campo recurso_categoria_filtro  en 1 y 2, por lo que queda pre seteado. 
                        $query_parcial = <<<EOD

                            SELECT $lista_filtros_solapa[$x]::BIGINT AS filtro_id, r.categoria_desc::TEXT AS desc,
                                r.categoria_id::BIGINT AS valor_id,
                                COUNT(*)::BIGINT AS total 
                            FROM (select *, t.recurso_titulo as origen_search_text, t.recurso_categoria_id as categoria_id, rc.recurso_categoria_desc as categoria_desc
                                    FROM mic_mediateca_fdw.recurso t 
                                    LEFT JOIN mic_mediateca_fdw.formato f ON f.formato_id = t.formato_id 
                                    LEFT JOIN mic_mediateca_fdw.tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                    LEFT JOIN mic_mediateca_fdw.recurso_categoria rc ON rc.recurso_categoria_id = t.recurso_categoria_id) as r                             
                            LEFT JOIN "MIC-CATALOGO".vw_estudio e ON r.estudios_id = e.estudios_id
                            LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = r.cod_temporalidad_id
                            LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = r.subclase_id
                            LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = r.subclase_id -- añadir tabla sub proyecto
                            WHERE r.tipo_formato_solapa = $solapa $auxiliar_extensiones_filtros   

                            EOD;

                        break;    

                case 3:

                    $query_parcial = <<<EOD
                                        SELECT $lista_filtros_solapa[$x]::BIGINT AS filtro_id,'tema'::TEXT AS desc,clase_id::BIGINT AS valor_id,COUNT(*)::BIGINT AS total			
                                        FROM (select *, t.recurso_titulo as origen_search_text, t.recurso_categoria_id as categoria_id, rc.recurso_categoria_desc as categoria_desc
                                                FROM mic_mediateca_fdw.recurso t 
                                                LEFT JOIN mic_mediateca_fdw.formato f ON f.formato_id = t.formato_id 
                                                LEFT JOIN mic_mediateca_fdw.tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                                LEFT JOIN mic_mediateca_fdw.recurso_categoria rc ON rc.recurso_categoria_id = t.recurso_categoria_id) as r 
                                        LEFT JOIN "MIC-CATALOGO".vw_estudio e ON r.estudios_id = e.estudios_id
                                        LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = r.cod_temporalidad_id
                                        LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = r.subclase_id
                                        LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = r.subclase_id -- añadir tabla sub proyecto
                                        WHERE r.tipo_formato_solapa =  $solapa $auxiliar_extensiones_filtros 
                                        
                                        EOD;

                    break;   

                case 4:

                    $query_parcial = <<<EOD

                                SELECT $lista_filtros_solapa[$x]::BIGINT AS filtro_id,subclase_desc::TEXT AS desc,r.subclase_id::BIGINT AS valor_id,COUNT(*)::BIGINT AS total			
                                FROM (select *, t.recurso_titulo as origen_search_text, t.recurso_categoria_id as categoria_id, rc.recurso_categoria_desc as categoria_desc
                                        FROM mic_mediateca_fdw.recurso t 
                                        LEFT JOIN mic_mediateca_fdw.formato f ON f.formato_id = t.formato_id 
                                        LEFT JOIN mic_mediateca_fdw.tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                        LEFT JOIN mic_mediateca_fdw.recurso_categoria rc ON rc.recurso_categoria_id = t.recurso_categoria_id) as r 
                                LEFT JOIN "MIC-CATALOGO".vw_estudio e ON r.estudios_id = e.estudios_id
                                LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = r.cod_temporalidad_id
                                LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = r.subclase_id
                                LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = r.subclase_id -- añadir tabla sub proyecto
                                WHERE r.tipo_formato_solapa = $solapa $auxiliar_extensiones_filtros  
                                       
                                EOD;
                                   
                    break;  

                case 5:

                    $query_parcial = <<<EOD

                        SELECT $lista_filtros_solapa[$x]::BIGINT AS filtro_id,r.categoria_desc::TEXT AS desc,r.categoria_id::BIGINT AS valor_id,COUNT(*)::BIGINT AS total 
                        FROM (SELECT *, t.recurso_titulo as origen_search_text, t.recurso_categoria_id as categoria_id, rc.recurso_categoria_desc as categoria_desc
                                FROM mic_mediateca_fdw.recurso t 
                                LEFT JOIN mic_mediateca_fdw.formato f ON f.formato_id = t.formato_id 
                                LEFT JOIN mic_mediateca_fdw.tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                LEFT JOIN mic_mediateca_fdw.recurso_categoria rc ON rc.recurso_categoria_id = t.recurso_categoria_id) as r 
                        LEFT JOIN "MIC-CATALOGO".vw_estudio e ON r.estudios_id = e.estudios_id
                        LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = r.cod_temporalidad_id
                        LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = r.subclase_id
                        LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = r.subclase_id -- añadir tabla sub proyecto
                        WHERE r.tipo_formato_solapa = $solapa $auxiliar_extensiones_filtros 
                            
                        EOD;

                    break;                      
            }
            
            if($x == count($lista_filtros_solapa)-1) // si es el ultimo elemento, cerrara la sub consulta 
            {
                $group_by = $this->ConstruirQueryFiltro($lista_filtros_solapa[$x]);
                $QUERY_RETURN .= $query_parcial . $group_by .") A"; // fin subconsulta union de filtros
            }else{
                $group_by = $this->ConstruirQueryFiltro($lista_filtros_solapa[$x]); // si no es el ultimo elemento, agregara UNION ALL
                $QUERY_RETURN .= $query_parcial . $group_by . " UNION ALL ";
            }
            
            

        } 

        $conect_mic_catalogo = null;    
        return $QUERY_RETURN;

    }

    public function ConstruirQueryUnionRecursosTecnicos($lista_filtros_solapa, $solapa,$aux_cadena_filtros,$lista_recursos_restringidos,$si_tengo_que_filtrar){
        
        $conect_mic_catalogo = New ConexionCatalogo();

        $QUERY_RETURN = "("; // variable contenedora de la union de 
 
        
        // SECCION DE ARMADO DE FILTTROS 
        
        $auxiliar_extensiones_filtros = ""; // variable que concatenara los filtros y los recursos restringidos en caso de ser necesario,    

        $extension_consulta_filtro_recursos = "AND r.recurso_id NOT IN (";

                // armo una cadena para usar como subconsulta en la query principal 
        for($x=0; $x<=count($lista_recursos_restringidos->detalle)-1; $x++)
        {       
           if($x==count($lista_recursos_restringidos->detalle)-1){
               
               $extension_consulta_filtro_recursos.=$lista_recursos_restringidos->detalle[$x]['objeto_id'].")";
           }else{
               $extension_consulta_filtro_recursos.=$lista_recursos_restringidos->detalle[$x]['objeto_id'].",";
           }       
        }
        
        
        // validacion de filtros 
        $aux_cadena_filtros = "";

        if(!empty($filtros))
        {                       

            $aux_cadena_filtros = ""; // variable contenedora, almacenara un string con todas las adeciones de filtros a la consulta principal
            
            if(!empty($filtros->qt)) // variable que viene del buscador.
            {            
                               
                $aux_cadena_filtros = <<<EOD
                AND ( lower("MIC-CATALOGO".unaccent(r.origen_search_text)) LIKE  lower("MIC-CATALOGO".unaccent('%$filtros->qt%'))
                OR lower("MIC-CATALOGO".unaccent(e.estudios_palabras_clave)) LIKE  lower("MIC-CATALOGO".unaccent('%$filtros->qt%'))
                OR lower("MIC-CATALOGO".unaccent(e.nombre)) LIKE  lower("MIC-CATALOGO".unaccent('%$filtros->qt%'))
                OR lower("MIC-CATALOGO".unaccent(e.equipo)) LIKE  lower("MIC-CATALOGO".unaccent('%$filtros->qt%')) 
                OR lower("MIC-CATALOGO".unaccent(e.institucion)) LIKE  lower("MIC-CATALOGO".unaccent('%$filtros->qt%'))
                OR lower("MIC-CATALOGO".unaccent(e.responsable)) LIKE  lower("MIC-CATALOGO".unaccent('%$filtros->qt%')) )
                EOD;
        
        
                /*
                
                $aux_cadena_filtros .= " AND ( lower(unaccent(T.origen_search_text)) LIKE  lower(unaccent('%".$qt."%'))"; // con unaccent  lower(unaccent('my_MMuíèles'))
                $aux_cadena_filtros .= " OR lower(unaccent(e.estudios_palabras_clave)) LIKE  lower(unaccent('%".$qt."%'))";
                $aux_cadena_filtros .= " OR lower(unaccent(e.nombre)) LIKE  lower(unaccent('%".$qt."%')) ";
                $aux_cadena_filtros .= " OR lower(unaccent(e.equipo)) LIKE  lower(unaccent('%".$qt."%')) ";
                $aux_cadena_filtros .= " OR lower(unaccent(e.institucion)) LIKE  lower(unaccent('%".$qt."%')) ";
                $aux_cadena_filtros .= " OR lower(unaccent(e.responsable)) LIKE  lower(unaccent('%".$qt."%')) ) "; */
                
            }
            
            if(!empty($filtros->tipo_temporalidad))
            {
                switch ($filtros->tipo_temporalidad) { // dependiendo del valor de $tipo_temporalidad, el filtro de fecha se hace en campos diferentes
                 
                    case 0:

                        if(!empty($filtros->desde) && !empty($filtros->hasta)) // si ningun filtro viene vacio. 
                        {
                            $aux_cadena_filtros .= "  AND (('".$filtros->desde."' BETWEEN ct.tempo_desde AND ct.tempo_hasta) 
                                                 OR('".$filtros->hasta."' BETWEEN ct.tempo_desde AND ct.tempo_hasta))";  
                     
                        }else{
                            
                            if(empty($filtros->desde) && !empty($filtros->hasta)) // si desde viene vacio y hasta no. 
                            {
                                $aux_cadena_filtros .= "  AND (('".$filtros->hasta."' BETWEEN ct.tempo_desde AND ct.tempo_hasta) 
                                                        OR('".$filtros->hasta."' BETWEEN ct.tempo_desde AND ct.tempo_hasta))";
                    
                            }else if(!empty($filtros->desde) && empty($filtros->hasta)) // si desde no viene vacio y hasta si.
                            {
                                $aux_cadena_filtros .= "  AND (('".$filtros->desde."' BETWEEN ct.tempo_desde AND ct.tempo_hasta) 
                                                        OR('".$filtros->desde."' BETWEEN ct.tempo_desde AND ct.tempo_hasta))";
                    
                            }else{ // si llego a este punto, ninguno de los parametros tiene datos, por lo que no asigna nada a la variable.
                                $aux_cadena_filtros .= "";
                            }
                
                        }

                    break;

                    case 1:

                        if(!empty($filtros->desde) && !empty($filtros->hasta)) // si ningun filtro viene vacio. 
                        {
                            $aux_cadena_filtros .= " AND ((r.fecha_observatorio IS NOT NULL)   AND
                                                        (r.fecha_observatorio BETWEEN ".$filtros->desde." AND ".$filtros->hasta."))";
                            if(empty($filtros->desde) && !empty($filtros->hasta)) // si desde viene vacio y hasta no. 
                            {
                                $aux_cadena_filtros .= "  AND ((r.fecha_observatorio IS NOT NULL)  AND 
                                                            (r.fecha_observatorio <= ".$filtros->hasta."))";
                    
                            }else if(!empty($filtros->desde) && empty($filtros->hasta)) // si desde no viene vacio y hasta si.
                            {
                                $aux_cadena_filtros .= "  AND ((r.fecha_observatorio IS NOT NULL)  AND 
                                                            (r.fecha_observatorio >= ".$filtros->desde."))";
                    
                            }else{ // si llego a este punto, ninguno de los parametros tiene datos, por lo que no asigna nada a la variable.
                                $aux_cadena_filtros .= "";
                            }
                            
                        } 
                        break;

                    case 2:
                         if(!empty($filtros->desde) && !empty($filtros->hasta)) // si ningun filtro viene vacio. 
                         {
                             $aux_cadena_filtros .= " AND ((r.recurso_fecha IS NOT NULL)   AND
                                                         (r.recurso_fecha BETWEEN ".$filtros->desde." AND ".$filtros->hasta."))";
                             if(empty($filtros->desde) && !empty($filtros->hasta)) // si desde viene vacio y hasta no. 
                             {
                                 $aux_cadena_filtros .= "  AND ((r.recurso_fecha IS NOT NULL)  AND 
                                                             (r.recurso_fecha <= ".$filtros->hasta."))";
                
                             }else if(!empty($filtros->desde) && empty($filtros->hasta)) // si desde no viene vacio y hasta si.
                             {
                                 $aux_cadena_filtros .= "  AND ((r.recurso_fecha IS NOT NULL)  AND 
                                                             (r.recurso_fecha >= ".$filtros->desde."))";
                
                             }else{ // si llego a este punto, ninguno de los parametros tiene datos, por lo que no asigna nada a la variable.
                                 $aux_cadena_filtros .= "";
                             }
                         }
                         
                        break;
                            
                }
            } 
            
            
            if(!empty($filtros->proyecto)) { $aux_cadena_filtros .= " AND e.sub_proyecto_id = ".$filtros->proyecto; }
            if(!empty($filtros->clase)) { $aux_cadena_filtros .= " AND sc.clase_id = ".$filtros->clase; }
            if(!empty($filtros->subclase)) { $aux_cadena_filtros .= "AND sc.subclase_id =".$filtros->subclase; }
            if(!empty($filtros->tipo_doc)) { $aux_cadena_filtros .= "AND r.recurso_categoria_id = ".$filtros->tipo_doc; }
            
                    // fin validacion de filtros   

         }

        // variable que concatenara los filtros y los recursos restringidos en caso de ser necesario, sino no hay que filtrar. solo ira vacio.
       
        $auxiliar_extensiones_filtros = $extension_consulta_filtro_recursos;
       
        if($si_tengo_que_filtrar == 1)
        {
            $auxiliar_extensiones_filtros .= ' '.$aux_cadena_filtros;
        }

        // gis ya quedo, falta estadistica y medicateca 
        $from = <<<EOD

                    FROM (SELECT 'GIS'::text AS origen, 0 AS origen_id,G.origen_id_especifico,
                    G.origen_search_text,G.subclase_id,G.estudios_id,G.cod_esia_id,
                    G.cod_temporalidad_id,G.objetos_id,G.fecha_observatorio,
                    10::bigint AS recurso_categoria_id,'Capas Geográficas'::text AS recurso_categoria_desc,
                    G.recurso_desc, G.recurso_titulo, NULL::date AS recurso_fecha,
                    NULL::text AS recurso_autores, NULL::text AS recurso_path_url,
                    NULL::bigint AS recurso_size, NULL::bigint AS territorio_id,(-1) AS tipo_formato_id,
                    (-1) AS visualizacion_tipo_id,'Modulo Interno'::text AS formato_desc,
                    'MI'::text AS formato_extension,'En modulo'::text AS visualizacion_tipo_desc,
                    NULL::text AS tipo_formato_desc,2::bigint AS tipo_formato_solapa,NULL::bigint AS sub_proyecto_id                    
                    FROM (SELECT c.origen_id_especifico, c.origen_search_text,c.subclase_id, c.estudios_id, c.cod_esia_id, c.cod_temporalidad_id, 
                          c.objetos_id, c.fecha_observatorio, l.preview_desc  AS recurso_desc, l.preview_titulo  AS recurso_titulo       
                          FROM mic_geovisores_fdw.catalogo c INNER JOIN mic_geovisores_fdw.layer l on l.layer_id=c.origen_id_especifico) as G
                                        
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
                    FROM (SELECT dt_id, dt_titulo, fecha_observatorio, dt_desc FROM mic_estadistica_fdw.dt) as dt 

                    UNION ALL

                    SELECT 'recurso mediateca'::text AS origen, r.* FROM (SELECT  5::bigint AS origen_id, 
                    r.recurso_id AS origen_id_especifico, r.recurso_titulo AS origen_search_text,
                    r.subclase_id,r.estudios_id,NULL::bigint AS cod_esia_id,r.cod_temporalidad_id,
                    NULL::bigint AS objetos_id,r.fecha_observatorio,r.recurso_categoria_id,
                    rc.recurso_categoria_desc,r.recurso_desc,r.recurso_titulo,r.recurso_fecha,   
                    r.recurso_autores, r.recurso_path_url,  r.recurso_size,r.territorio_id,
                    f.tipo_formato_id, f.visualizacion_tipo_id,f.formato_desc,f.formato_extension, 
                    vt.visualizacion_tipo_desc,tf.tipo_formato_desc,tf.tipo_formato_solapa, r.sub_proyecto_id
                    FROM mic_mediateca_fdw.recurso r
                    LEFT JOIN mic_mediateca_fdw.tipo_recurso tr ON tr.tipo_recurso_id = r.tipo_recurso_id
                    LEFT JOIN mic_mediateca_fdw.formato f ON f.formato_id = r.formato_id
                    LEFT JOIN mic_mediateca_fdw.recurso_categoria rc ON rc.recurso_categoria_id = r.recurso_categoria_id
                    LEFT JOIN mic_mediateca_fdw.tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                    LEFT JOIN mic_mediateca_fdw.visualizacion_tipo vt ON vt.visualizacion_tipo_id = f.visualizacion_tipo_id
                    WHERE tf.tipo_formato_solapa = 2) r ) as u
                    
                    LEFT JOIN "MIC-CATALOGO".vw_estudio e ON u.estudios_id = e.estudios_id
                    LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = u.cod_temporalidad_id
                    LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = u.subclase_id
                    LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = u.subclase_id
                        
                EOD;

                  
        for($x=0;$x<=count($lista_filtros_solapa)-1; $x++) // cada filtro_id que exista en la lista 
        {            
            switch($lista_filtros_solapa[$x])
            {  
                case 0:  

                    $query_parcial = "SELECT ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id,sp.sub_proyecto_desc::TEXT AS desc,
                                        CASE
                                            WHEN u.sub_proyecto_id IS NULL THEN e.sub_proyecto_id
                                            ELSE u.sub_proyecto_id
                                        END  AS valor_id ,COUNT(*)::BIGINT AS total ";                   

                    $query_parcial .= ' '.$from.' '.$aux_cadena_filtros;
                    break;                                  

                case 1: // nota: entre el caso 1 y dos, solo varia el valor del campo recurso_categoria_filtro  en 1 y 2, por lo que queda pre seteado. 
                    $query_parcial = "SELECT ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id, 
                                      recurso_categoria_desc::TEXT AS desc,
                                      u.recurso_categoria_id::BIGINT AS valor_id,
                                      COUNT(*)::BIGINT AS total  "; 

                     $query_parcial .= ' '.$from.' '.$aux_cadena_filtros;
                     break;

                case 2: // nota: entre el caso 1 y dos, solo varia el valor del campo recurso_categoria_filtro  en 1 y 2, por lo que queda pre seteado. 
                    
                    $query_parcial = "SELECT ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id, 
                                                recurso_categoria_desc::TEXT AS desc,
                                                u.recurso_categoria_id::BIGINT AS valor_id,
                                                COUNT(*)::BIGINT AS total  "; 

                    $query_parcial .= ' '.$from.' '.$aux_cadena_filtros;
                    break;

                case 3:

                    $query_parcial = "SELECT  ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id,
                                     'tema'::TEXT AS desc,
                                     clase_id::BIGINT AS valor_id,
                                     COUNT(*)::BIGINT AS total  ";
                                     
                    $query_parcial .= ' '.$from.' '.$aux_cadena_filtros;
                    break;

                case 4:

                    $query_parcial = "SELECT ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id,
                                      subclase_desc::TEXT AS desc,
                                      u.subclase_id::BIGINT AS valor_id,
                                      COUNT(*)::BIGINT AS total ";                                      
                      
                    $query_parcial .= ' '.$from.' '.$aux_cadena_filtros;
                    break;  

                case 5:

                    $query_parcial = "SELECT ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id,
                                      recurso_categoria_desc::TEXT AS desc,
                                      recurso_categoria_id::BIGINT AS valor_id,
                                      COUNT(*)::BIGINT AS total ";

                    $query_parcial .= ' '.$from.' '.$aux_cadena_filtros;   
                    break;         
            }

            //echo $query_parcial;
            
            if($x == count($lista_filtros_solapa)-1) // si es el ultimo elemento, cerrara la sub consulta 
            {
                $group_by = $this->ConstruirQueryFiltroRecursosTecnicos($lista_filtros_solapa[$x]);

                //echo $query_parcial.$group_by;
                $QUERY_RETURN .= $query_parcial . $group_by .") A"; // fin subconsulta union de filtros
            }else{
                $group_by = $this->ConstruirQueryFiltroRecursosTecnicos($lista_filtros_solapa[$x]); // si no es el ultimo elemento, agregara UNION ALL

                //echo $query_parcial.$group_by;
                $QUERY_RETURN .= $query_parcial . $group_by . " UNION ALL ";
            }  
        } 

        $conect_mic_catalogo = null;
        //echo $QUERY_RETURN;
            
        return $QUERY_RETURN;




    }

    public function ConstruirQueryFiltro($filtro_id){

        //$conect_mic_catalogo = New ConexionCatalogo();
        
        //FILTRO ID 0
        $CONSULTA_PROYECTO=' GROUP BY sp.sub_proyecto_desc,valor_id '; // nota: reemplazo el valor sub_proyecto_id_principal por la variable valor_ir(contienen el mismo valor y se obtiene de la misma manera, cambia el nombre nomas)
        //FILTRO ID 1 
        $CONSULTA_AREA_GESTION=" AND r.categoria_id IN (SELECT recurso_categoria_id FROM mic_mediateca_fdw.recurso_categoria WHERE recurso_categoria_filtro=1) 
                                    GROUP BY r.categoria_desc,r.categoria_id ";
        //FILTRO ID 2
        $CONSULTA_RECURSOS_TECNICOS=" AND r.categoria_id IN (SELECT recurso_categoria_id FROM mic_mediateca_fdw.recurso_categoria WHERE recurso_categoria_filtro=2)
                                      GROUP BY r.categoria_desc,r.categoria_id ";
        //FILTRO ID 3 
        $CONSULTA_AREA_TEMATICA=' GROUP BY clase_id ';
        //FILTRO ID 4
        $CONSULTA_TEMA=' GROUP BY subclase_desc,r.subclase_id';
        //FILTRO ID 5
        $CONSULTA_RECURSOS_AUDIOVISUALES= " AND r.categoria_id IN (SELECT recurso_categoria_id FROM mic_mediateca_fdw.recurso_categoria WHERE recurso_categoria_filtro=5)
                                            GROUP BY r.categoria_desc,r.categoria_id ";
        
        $conect_mic_catalogo = null;
        
        switch($filtro_id){
            case 0:
                return $CONSULTA_PROYECTO;
            case 1:
                return  $CONSULTA_AREA_GESTION;
            case 2:
                return  $CONSULTA_RECURSOS_TECNICOS;
            case 3:
                return $CONSULTA_AREA_TEMATICA;
            case 4 :
                return  $CONSULTA_TEMA;
            case 5:
                return $CONSULTA_RECURSOS_AUDIOVISUALES;
        }

    }

    public function ConstruirQueryFiltroRecursosTecnicos($filtro_id){ //

        $conect_mic_catalogo = New ConexionCatalogo();
        
        //FILTRO ID 0
        $CONSULTA_PROYECTO=' GROUP BY sp.sub_proyecto_desc,valor_id '; // nota: reemplazo el valor sub_proyecto_id_principal por la variable valor_ir(contienen el mismo valor y se obtiene de la misma manera, cambia el nombre nomas)
        //FILTRO ID 1 
        $CONSULTA_AREA_GESTION=" AND u.recurso_categoria_id IN (SELECT recurso_categoria_id FROM mic_mediateca_fdw.recurso_categoria WHERE recurso_categoria_filtro=1)
                                 GROUP BY recurso_categoria_desc,recurso_categoria_id ";
        //FILTRO ID 2
        $CONSULTA_RECURSOS_TECNICOS=" AND u.recurso_categoria_id IN (SELECT recurso_categoria_id FROM mic_mediateca_fdw.recurso_categoria WHERE recurso_categoria_filtro=2)
                                      GROUP BY recurso_categoria_desc,recurso_categoria_id ";
        //FILTRO ID 3 
        $CONSULTA_AREA_TEMATICA=' GROUP BY clase_id ';
        //FILTRO ID 4
        $CONSULTA_TEMA=' GROUP BY subclase_desc,u.subclase_id';
        //FILTRO ID 5
        $CONSULTA_RECURSOS_AUDIOVISUALES= " AND u.recurso_categoria_id IN (SELECT recurso_categoria_id FROM mic_mediateca_fdw.recurso_categoria WHERE recurso_categoria_filtro=5))
                                            GROUP BY recurso_categoria_desc,recurso_categoria_id ";
        
        switch($filtro_id){
            case 0:
                return $CONSULTA_PROYECTO;
            case 1:
                return  $CONSULTA_AREA_GESTION;
            case 2:
                return  $CONSULTA_RECURSOS_TECNICOS;
            case 3:
                return $CONSULTA_AREA_TEMATICA;
            case 4 :
                return  $CONSULTA_TEMA;
            case 5:
                return $CONSULTA_RECURSOS_AUDIOVISUALES;
        }
    }

    public function GET_LINK($ID)
    {

        $link = "";          

        $conexion = new ConexionCatalogo();
        
        //global $conn;
        $SQL= 'SELECT RRA.link FROM "MIC-CATALOGO".redireccion_recursos_asociados as RRA WHERE RRA.id = '.$ID;

        //$resultado = ($query_string);
        
        $RESULT = $conexion->get_consulta($SQL);
        //$RESULT=pg_query($conn,$SQL);

        foreach($RESULT as $pre_link)
        {
            $link = $pre_link;
        }

        return $link;

    }
        
        

    

}
