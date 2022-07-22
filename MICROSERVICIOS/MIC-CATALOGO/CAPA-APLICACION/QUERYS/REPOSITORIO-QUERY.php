<?php

require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-CATALOGO/CAPA-DOMINIO/INTERFACE-QUERYS/REPOSITORIO-INTERFACE-QUERY.php');
require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-CATALOGO/CAPA-DATOS/capa-acceso.php');
require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-CATALOGO/CAPA-DOMINIO/DTOS/DTOS.php');
//INCLUIR LA LIBRERIA DTO.

class RepositorioQuery implements IRepositorioQuery{

    // metodo para obtener datos del territorio a partir del id 
    public function get_info_territorio($territorio_id)
    {
            //aca instancio a la conexion y hago toda la query y la retorno.
            $conexion = new ConexionCatalogo();
            $query = 'SELECT t.fec_bbdd_date, t.territorio_simpli,t.fec_bbdd,t.descripcion FROM "MIC-CATALOGO".territorio t WHERE t.territorio_id = '.$territorio_id;
            return $conexion->get_consulta($query); //  //
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
        $lista_filtros_solapa_2=[0,2,3,4];
        $lista_filtros_solapa_3=[0,3,4];
        
        
        $QUERY_DEFINITIVA = ""; // variable contenedora de consulta final a ejecutar. 

      
            switch($solapa)
            {       
                case 0:

                    $QUERY_DEFINITIVA = 'SELECT F.*,COALESCE(A.total,0) AS total FROM "MIC-CATALOGO".vw_filtros_values F '.
                    'LEFT JOIN'.$this->ConstruirQueryUnion($lista_filtros_solapa_0, 0,$aux_cadena_filtros,$lista_recursos_restringidos,$si_tengo_que_filtrar).
                    " ON F.filtro_id=A.filtro_id AND F.valor_id = A.valor_id ORDER BY valor_desc ASC ";
                    break;


                    //    AND F.total!=0; <--- aun falta discriminar los valores 0, pero eso cuando hayan datos 
                    //echo $QUERY_DEFINITIVA;
                    //$QUERY_DEFINITIVA=str_replace("--QUERY_UNION",ConstruirQueryUnion($lista_filtros_solapa_0, 0, $filtro_id,$aux_cadena_filtros,$si_tengo_que_filtrar), $QUERY_DEFINITIVA);           
                    //break;

                case 1: 

                    $QUERY_DEFINITIVA = 'SELECT F.*,COALESCE(A.total,0) AS total FROM "MIC-CATALOGO".vw_filtros_values F '.
                    'LEFT JOIN'.$this->ConstruirQueryUnion($lista_filtros_solapa_1, 1,$aux_cadena_filtros,$lista_recursos_restringidos,$si_tengo_que_filtrar).
                    " ON F.filtro_id=A.filtro_id AND F.valor_id = A.valor_id ORDER BY valor_desc ASC ";
                    break;

                    //$QUERY_DEFINITIVA = 'SELECT F.*,COALESCE(A.total,0) AS total FROM "MIC-CATALOGO".vw_filtros_values F '.
                    //'LEFT JOIN'.
                    //'--QUERY_UNION'.
                    //")A ON F.filtro_id=A.filtro_id AND F.valor_id = A.valor_id ORDER BY valor_desc ASC AND F.total!=0;";

                    //$union = $this->ConstruirQueryUnion($lista_filtros_solapa_1, 1,$aux_cadena_filtros,$si_tengo_que_filtrar);

                // $QUERY_DEFINITIVA=str_replace("--QUERY_UNION",, $QUERY_DEFINITIVA);           
                    //break;
                        //HACER LO MISMO QUE ARRIBA Y PROBAR TODO
                
                case 2: //  en solapa 2 por el momento no se hace nada 
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

            // ejecutar consulta final, para obtener lista de filtros 

            $conexion = New ConexionCatalogo(); //
            //echo $QUERY_DEFINITIVA;

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

        // se retorna un objeto json de los filtros 
        return $filtros; 

        //EJECUTAR QUERY DEFINITIVA Y VAS A RECORRER ESE RESULTADO Y VAS A FORMAR Y DEVOLVER UNA LISTA DE FILTROSDTOS

    }

    public function ConstruirQueryUnion($lista_filtros_solapa, $solapa,$aux_cadena_filtros,$lista_recursos_restringidos,$si_tengo_que_filtrar){

        $QUERY_RETURN = "("; // variable contenedora de la union de filtros

        $auxiliar_extensiones_filtros = ""; // variable que concatenara los filtros y los recursos restringidos en caso de ser necesario, sino no hay que filtrar. solo ira vacio.
        
        if($si_tengo_que_filtrar == 1)
        {
            $auxiliar_extensiones_filtros = ' '.$aux_cadena_filtros.' '.$lista_recursos_restringidos;
        }

        for($x=0;$x<=count($lista_filtros_solapa)-1; $x++) // cada filtro_id que exista en la lista 
        {            
            switch($lista_filtros_solapa[$x])
            {  
                case 0:                                                                                                            //CONSEGUIR COMO SEA QUE ENTRE EL CASE DE ALLA ARRIBA
                    $query_parcial = "SELECT ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id,
                                      sp.sub_proyecto_desc::TEXT AS desc,
                                        CASE
                                            WHEN t.sub_proyecto_id IS NULL THEN e.sub_proyecto_id
                                            ELSE t.sub_proyecto_id
                                        END  AS valor_id ,
                                        COUNT(*)::BIGINT AS total 
                                    FROM dblink('dbname=MIC-MEDIATECA hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                                                'SELECT t.recurso_id, t.recurso_titulo as origen_search_text, t.estudios_id, t.cod_temporalidad_id,t.subclase_id, t.sub_proyecto_id, tf.tipo_formato_solapa,rc.recurso_categoria_desc,t.recurso_categoria_id
                                                    FROM ".'"MIC-MEDIATECA".recurso t 
                                                LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = t.formato_id 
                                                LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                                LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = t.recurso_categoria_id'."')
                                            as T (recurso_id bigint, origen_search_text text, estudios_id bigint, cod_temporalidad_id bigint,subclase_id bigint, sub_proyecto_id bigint, tipo_formato_solapa bigint, recurso_categoria_desc text,recurso_categoria_id bigint)
                                    LEFT JOIN ".'"MIC-CATALOGO".vw_estudio e ON t.estudios_id = e.estudios_id
                                    LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = t.cod_temporalidad_id
                                    LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = t.subclase_id
                                    LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = t.subclase_id -- añadir tabla sub proyecto
                                    WHERE t.tipo_formato_solapa = '.$solapa.' '.$auxiliar_extensiones_filtros;    


                                /* consulta final de ejemplo
                                
                                SELECT 0::BIGINT AS filtro_id,
                                    sp.sub_proyecto_desc::TEXT AS desc,
                                    CASE
                                        WHEN t.sub_proyecto_id IS NULL THEN e.sub_proyecto_id
                                    ELSE t.sub_proyecto_id 
                                    END  AS valor_id,
                                    COUNT(*)::BIGINT AS total 
                                FROM dblink('dbname=MIC-MEDIATECA hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                                            'SELECT t.recurso_id, t.recurso_titulo as origen_search_text, t.estudios_id, t.cod_temporalidad_id,t.subclase_id, t.sub_proyecto_id, tf.tipo_formato_solapa,rc.recurso_categoria_desc,t.recurso_categoria_id
                                            FROM "MIC-MEDIATECA".recurso t 
                                            LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = t.formato_id 
                                            LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                            LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = t.recurso_categoria_id')
                                            as T (recurso_id bigint, origen_search_text text, estudios_id bigint, cod_temporalidad_id bigint,subclase_id bigint, sub_proyecto_id bigint, tipo_formato_solapa bigint, recurso_categoria_desc text,recurso_categoria_id bigint)
                                LEFT JOIN "MIC-CATALOGO".vw_estudio e ON t.estudios_id = e.estudios_id
                                LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = t.cod_temporalidad_id
                                LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = t.subclase_id
                                LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = t.subclase_id 
                                WHERE t.tipo_formato_solapa = 0 AND t.recurso_id NOT IN (1,2,3,4) 
                                GROUP BY sp.sub_proyecto_desc,valor_id                        
                                
                                
                                */

                    break;               

                case 1: // nota: entre el caso 1 y dos, solo varia el valor del campo recurso_categoria_filtro  en 1 y 2, por lo que queda pre seteado. 
                    $query_parcial = "SELECT ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id, recurso_categoria_desc::TEXT AS desc,
                                        t.recurso_categoria_id::BIGINT AS valor_id,
                                        COUNT(*)::BIGINT AS total 
                                    FROM dblink('dbname=MIC-MEDIATECA hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                                            'SELECT t.recurso_id, t.recurso_titulo as origen_search_text,t.estudios_id, t.cod_temporalidad_id,t.subclase_id, t.sub_proyecto_id, tf.tipo_formato_solapa,rc.recurso_categoria_desc,t.recurso_categoria_id
                                                FROM ".'"MIC-MEDIATECA".recurso t 
                                            LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = t.formato_id 
                                            LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                            LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = t.recurso_categoria_id'."')
                                            as T (recurso_id bigint, origen_search_text text,estudios_id bigint, cod_temporalidad_id bigint,subclase_id bigint, sub_proyecto_id bigint, tipo_formato_solapa bigint, recurso_categoria_desc text,recurso_categoria_id bigint)
                                    LEFT JOIN ".'"MIC-CATALOGO".vw_estudio e ON t.estudios_id = e.estudios_id
                                    LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = t.cod_temporalidad_id
                                    LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = t.subclase_id
                                    LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = t.subclase_id -- añadir tabla sub proyecto
                                    WHERE t.tipo_formato_solapa = '.$solapa.' '.$auxiliar_extensiones_filtros; //SIEMPRE CONCATENAR LOS FILTROS DE RECURSOS RESTRINGIDOS

                                    //SI TENGO QUE FILTRAR ==1
                                    //QUERY_PARCIAL . = $AUX_CADENA_FILTROS.
                    break;
                case 2: // nota: entre el caso 1 y dos, solo varia el valor del campo recurso_categoria_filtro  en 1 y 2, por lo que queda pre seteado. 
                        $query_parcial = "SELECT ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id, recurso_categoria_desc::TEXT AS desc,
                                            t.recurso_categoria_id::BIGINT AS valor_id,
                                            COUNT(*)::BIGINT AS total 
                                        FROM dblink('dbname=MIC-MEDIATECA hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                                                'SELECT t.recurso_id, t.recurso_titulo as origen_search_text, t.estudios_id, t.cod_temporalidad_id,t.subclase_id, t.sub_proyecto_id, tf.tipo_formato_solapa,rc.recurso_categoria_desc,t.recurso_categoria_id
                                                    FROM ".'"MIC-MEDIATECA".recurso t 
                                                LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = t.formato_id 
                                                LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                                LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = t.recurso_categoria_id'."')
                                                as T (recurso_id bigint, origen_search_text text, estudios_id bigint, cod_temporalidad_id bigint,subclase_id bigint, sub_proyecto_id bigint, tipo_formato_solapa bigint, recurso_categoria_desc text,recurso_categoria_id bigint)
                                        LEFT JOIN ".'"MIC-CATALOGO".vw_estudio e ON t.estudios_id = e.estudios_id
                                        LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = t.cod_temporalidad_id
                                        LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = t.subclase_id
                                        LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = t.subclase_id -- añadir tabla sub proyecto
                                        WHERE t.tipo_formato_solapa = '.$solapa.' '.$auxiliar_extensiones_filtros; 
                        break;    
                case 3:
                    $query_parcial = "SELECT  ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id,'tema'::TEXT AS desc,clase_id::BIGINT AS valor_id,COUNT(*)::BIGINT AS total			
                                        FROM dblink('dbname=MIC-MEDIATECA hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                                                    'SELECT t.recurso_id, t.recurso_titulo as origen_search_text, t.estudios_id, t.cod_temporalidad_id,t.subclase_id, t.sub_proyecto_id, tf.tipo_formato_solapa,rc.recurso_categoria_desc,t.recurso_categoria_id
                                                        FROM ".'"MIC-MEDIATECA".recurso t 
                                                    LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = t.formato_id 
                                                    LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                                    LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = t.recurso_categoria_id'."')
                                                as T (recurso_id bigint, origen_search_text text, estudios_id bigint, cod_temporalidad_id bigint,subclase_id bigint, sub_proyecto_id bigint, tipo_formato_solapa bigint, recurso_categoria_desc text,recurso_categoria_id bigint)
                                        LEFT JOIN ".'"MIC-CATALOGO".vw_estudio e ON t.estudios_id = e.estudios_id
                                        LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = t.cod_temporalidad_id
                                        LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = t.subclase_id
                                        LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = t.subclase_id -- añadir tabla sub proyecto
                                        WHERE t.tipo_formato_solapa ='.$solapa.' '.$auxiliar_extensiones_filtros; 
                    break;   
                case 4:
                    $query_parcial = "SELECT ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id,subclase_desc::TEXT AS desc,t.subclase_id::BIGINT AS valor_id,COUNT(*)::BIGINT AS total			
                                        FROM dblink('dbname=MIC-MEDIATECA hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                                                    'SELECT t.recurso_id, t.recurso_titulo as origen_search_text, t.estudios_id, t.cod_temporalidad_id,t.subclase_id, t.sub_proyecto_id, tf.tipo_formato_solapa,rc.recurso_categoria_desc,t.recurso_categoria_id
                                                        FROM ".'"MIC-MEDIATECA".recurso t 
                                                    LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = t.formato_id 
                                                    LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                                    LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = t.recurso_categoria_id'."')
                                                as T (recurso_id bigint, origen_search_text text, estudios_id bigint, cod_temporalidad_id bigint,subclase_id bigint, sub_proyecto_id bigint, tipo_formato_solapa bigint, recurso_categoria_desc text,recurso_categoria_id bigint)
                                        LEFT JOIN ".'"MIC-CATALOGO".vw_estudio e ON t.estudios_id = e.estudios_id
                                        LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = t.cod_temporalidad_id
                                        LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = t.subclase_id
                                        LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = t.subclase_id -- añadir tabla sub proyecto
                                        WHERE t.tipo_formato_solapa = '.$solapa.' '.$auxiliar_extensiones_filtros;
                    break;  
                case 5:
                    $query_parcial = "SELECT ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id,recurso_categoria_desc::TEXT AS desc,recurso_categoria_id::BIGINT AS valor_id,COUNT(*)::BIGINT AS total 
                    FROM dblink('dbname=MIC-MEDIATECA hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                                'SELECT t.recurso_id ,t.recurso_titulo as origen_search_text,t.estudios_id, t.cod_temporalidad_id,t.subclase_id, t.sub_proyecto_id, tf.tipo_formato_solapa,rc.recurso_categoria_desc,t.recurso_categoria_id
                                    FROM ".'"MIC-MEDIATECA".recurso t 
                                LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = t.formato_id 
                                LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = t.recurso_categoria_id'."')
                            as T (recurso_id bigint, estudios_id bigint, cod_temporalidad_id bigint,subclase_id bigint, sub_proyecto_id bigint, tipo_formato_solapa bigint, recurso_categoria_desc text,recurso_categoria_id bigint)
                    LEFT JOIN ".'"MIC-CATALOGO".vw_estudio e ON t.estudios_id = e.estudios_id
                    LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = t.cod_temporalidad_id
                    LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = t.subclase_id
                    LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = t.subclase_id -- añadir tabla sub proyecto
                    WHERE t.tipo_formato_solapa = '.$solapa.' '.$auxiliar_extensiones_filtros;
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
            
        return $QUERY_RETURN;

    }

    public function ConstruirQueryUnionRecursosTecnicos($lista_filtros_solapa, $solapa,$aux_cadena_filtros,$lista_recursos_restringidos,$si_tengo_que_filtrar){
        
        $QUERY_RETURN = "("; // variable contenedora de la union de filtros

        // variable que concatenara los filtros y los recursos restringidos en caso de ser necesario, sino no hay que filtrar. solo ira vacio.
       
        $auxiliar_extensiones_filtros = $lista_recursos_restringidos;
       
        if($si_tengo_que_filtrar == 1)
        {
            $auxiliar_extensiones_filtros .= ' '.$aux_cadena_filtros;
        }


        $from = <<<EOD
                                        FROM( SELECT 'GIS'::text AS origen, 0 AS origen_id,G.origen_id_especifico,
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
                                        SELECT 'recurso mediateca'::text AS origen, r.* FROM dblink('dbname=MIC-MEDIATECA
                                                                hostaddr=179.43.126.101 
                                                                user=postgres 
                                                                password=plahe100%
                                                                port=5432',
                                                                'SELECT  5::bigint AS origen_id, 
                                                                r.recurso_id AS origen_id_especifico, r.recurso_titulo AS origen_search_text,
                                                                r.subclase_id,r.estudios_id,NULL::bigint AS cod_esia_id,r.cod_temporalidad_id,
                                                                NULL::bigint AS objetos_id,r.fecha_observatorio,r.recurso_categoria_id,
                                                                rc.recurso_categoria_desc,r.recurso_desc,r.recurso_titulo,r.recurso_fecha,   
                                                                r.recurso_autores, r.recurso_path_url,  r.recurso_size,r.territorio_id,
                                                                f.tipo_formato_id, f.visualizacion_tipo_id,f.formato_desc,f.formato_extension, 
                                                                vt.visualizacion_tipo_desc,tf.tipo_formato_desc,tf.tipo_formato_solapa, r.sub_proyecto_id
                                                                FROM "MIC-MEDIATECA".recurso r
                                                                LEFT JOIN "MIC-MEDIATECA".tipo_recurso tr ON tr.tipo_recurso_id = r.tipo_recurso_id
                                                                LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = r.formato_id
                                                                LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = r.recurso_categoria_id
                                                                LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                                                LEFT JOIN "MIC-MEDIATECA".visualizacion_tipo vt ON vt.visualizacion_tipo_id = f.visualizacion_tipo_id
                                                                WHERE tf.tipo_formato_solapa = 2') 
                                                        as r(origen_id bigint, origen_id_especifico bigint, origen_search_text text,
                                                            subclase_id bigint, estudios_id bigint, cod_esia_id bigint, cod_temporalidad_id bigint,
                                                            objetos_id bigint, fecha_observatorio date, recurso_categoria_id bigint,
                                                            recurso_categoria_desc text, recurso_desc text, recurso_titulo text, recurso_fecha date,   
                                                            recurso_autores text, recurso_path_url text,  recurso_size bigint, territorio_id bigint,
                                                            tipo_formato_id bigint, visualizacion_tipo_id bigint, formato_desc text, formato_extension text, 
                                                            visualizacion_tipo_desc text, tipo_formato_desc text, tipo_formato_solapa bigint, sub_proyecto_id bigint)) as u
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

                    $query_parcial .= ' '.$from.' '.$auxiliar_extensiones_filtros;
                    break; 

                     /*  //CONSEGUIR COMO SEA QUE ENTRE EL CASE DE ALLA ARRIBA
                    $query_parcial = "SELECT ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id,sp.sub_proyecto_desc::TEXT AS desc,
                                        CASE
                                            WHEN t.sub_proyecto_id IS NULL THEN e.sub_proyecto_id
                                            ELSE t.sub_proyecto_id
                                        END  AS valor_id ,COUNT(*)::BIGINT AS total 
                                    FROM dblink(
                                        "".<<<EOD
                                    SELECT * FROM 
                            
                                    ( SELECT 'GIS'::text AS origen, 0 AS origen_id,G.origen_id_especifico,
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
                                            
                                            EOD

                                    )
                                    LEFT JOIN ".'"MIC-CATALOGO".vw_estudio e ON t.estudios_id = e.estudios_id
                                    LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = t.cod_temporalidad_id
                                    LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = t.subclase_id
                                    LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = t.subclase_id -- añadir tabla sub proyecto
                                    WHERE t.tipo_formato_solapa = '.$solapa.$auxiliar_extensiones_filtros;    


                                    */
                                  

                case 1: // nota: entre el caso 1 y dos, solo varia el valor del campo recurso_categoria_filtro  en 1 y 2, por lo que queda pre seteado. 
                    $query_parcial = "SELECT ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id, 
                                      recurso_categoria_desc::TEXT AS desc,
                                      u.recurso_categoria_id::BIGINT AS valor_id,
                                      COUNT(*)::BIGINT AS total  "; 

                     $query_parcial .= ' '.$from.' '.$auxiliar_extensiones_filtros;
                     break;

                case 2: // nota: entre el caso 1 y dos, solo varia el valor del campo recurso_categoria_filtro  en 1 y 2, por lo que queda pre seteado. 
                    
                    $query_parcial = "SELECT ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id, 
                                                recurso_categoria_desc::TEXT AS desc,
                                                u.recurso_categoria_id::BIGINT AS valor_id,
                                                COUNT(*)::BIGINT AS total  "; 

                    $query_parcial .= ' '.$from.' '.$auxiliar_extensiones_filtros;
                    break;

                case 3:

                    $query_parcial = "SELECT  ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id,
                                     'tema'::TEXT AS desc,
                                     clase_id::BIGINT AS valor_id,
                                     COUNT(*)::BIGINT AS total  ";
                                     
                    $query_parcial .= ' '.$from.' '.$auxiliar_extensiones_filtros;
                    break;

                case 4:

                    $query_parcial = "SELECT ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id,
                                      subclase_desc::TEXT AS desc,
                                      u.subclase_id::BIGINT AS valor_id,
                                      COUNT(*)::BIGINT AS total ";                                      
                      
                    $query_parcial .= ' '.$from.' '.$auxiliar_extensiones_filtros;
                    break;  

                case 5:

                    $query_parcial = "SELECT ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id,
                                      recurso_categoria_desc::TEXT AS desc,
                                      recurso_categoria_id::BIGINT AS valor_id,
                                      COUNT(*)::BIGINT AS total ";

                    $query_parcial .= ' '.$from.' '.$auxiliar_extensiones_filtros;   
                    break;         
            }
            
            if($x == count($lista_filtros_solapa)-1) // si es el ultimo elemento, cerrara la sub consulta 
            {
                $group_by = $this->ConstruirQueryFiltroRecursosTecnicos($lista_filtros_solapa[$x]);
                $QUERY_RETURN .= $query_parcial . $group_by .") A"; // fin subconsulta union de filtros
            }else{
                $group_by = $this->ConstruirQueryFiltroRecursosTecnicos($lista_filtros_solapa[$x]); // si no es el ultimo elemento, agregara UNION ALL
                $QUERY_RETURN .= $query_parcial . $group_by . " UNION ALL ";
            }  

        } 

        echo $QUERY_RETURN;
            
        return $QUERY_RETURN;




    }




    public function ConstruirQueryFiltro($filtro_id){
        
        //FILTRO ID 0
        $CONSULTA_PROYECTO=' GROUP BY sp.sub_proyecto_desc,valor_id '; // nota: reemplazo el valor sub_proyecto_id_principal por la variable valor_ir(contienen el mismo valor y se obtiene de la misma manera, cambia el nombre nomas)
        //FILTRO ID 1 
        $CONSULTA_AREA_GESTION=" AND t.recurso_categoria_id IN (SELECT * FROM dblink('dbname=MIC-MEDIATECA hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                                                                'SELECT recurso_categoria_id FROM ".'"MIC-MEDIATECA".recurso_categoria WHERE recurso_categoria_filtro=1'."') as g (recurso_categoria_id bigint))
                                 GROUP BY recurso_categoria_desc,recurso_categoria_id ";
        //FILTRO ID 2
        $CONSULTA_RECURSOS_TECNICOS=" AND t.recurso_categoria_id IN (SELECT * FROM dblink('dbname=MIC-MEDIATECA hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                                                                    'SELECT recurso_categoria_id FROM ".'"MIC-MEDIATECA".recurso_categoria WHERE recurso_categoria_filtro=2'."') as g (recurso_categoria_id bigint))
                                      GROUP BY recurso_categoria_desc,recurso_categoria_id ";
        //FILTRO ID 3 
        $CONSULTA_AREA_TEMATICA=' GROUP BY clase_id ';
        //FILTRO ID 4
        $CONSULTA_TEMA=' GROUP BY subclase_desc,t.subclase_id';
        //FILTRO ID 5
        $CONSULTA_RECURSOS_AUDIOVISUALES= " AND t.recurso_categoria_id IN (SELECT * FROM dblink('dbname=MIC-MEDIATECA hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                                                                                                'SELECT recurso_categoria_id FROM ".'"MIC-MEDIATECA".recurso_categoria WHERE recurso_categoria_filtro=5'."') as g (recurso_categoria_id bigint))
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

    public function ConstruirQueryFiltroRecursosTecnicos($filtro_id){
        
        //FILTRO ID 0
        $CONSULTA_PROYECTO=' GROUP BY sp.sub_proyecto_desc,valor_id '; // nota: reemplazo el valor sub_proyecto_id_principal por la variable valor_ir(contienen el mismo valor y se obtiene de la misma manera, cambia el nombre nomas)
        //FILTRO ID 1 
        $CONSULTA_AREA_GESTION=" AND u.recurso_categoria_id IN (SELECT * FROM dblink('dbname=MIC-MEDIATECA hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                                                                'SELECT recurso_categoria_id FROM ".'"MIC-MEDIATECA".recurso_categoria WHERE recurso_categoria_filtro=1'."') as g (recurso_categoria_id bigint))
                                 GROUP BY recurso_categoria_desc,recurso_categoria_id ";
        //FILTRO ID 2
        $CONSULTA_RECURSOS_TECNICOS=" AND u.recurso_categoria_id IN (SELECT * FROM dblink('dbname=MIC-MEDIATECA hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                                                                    'SELECT recurso_categoria_id FROM ".'"MIC-MEDIATECA".recurso_categoria WHERE recurso_categoria_filtro=2'."') as g (recurso_categoria_id bigint))
                                      GROUP BY recurso_categoria_desc,recurso_categoria_id ";
        //FILTRO ID 3 
        $CONSULTA_AREA_TEMATICA=' GROUP BY clase_id ';
        //FILTRO ID 4
        $CONSULTA_TEMA=' GROUP BY subclase_desc,u.subclase_id';
        //FILTRO ID 5
        $CONSULTA_RECURSOS_AUDIOVISUALES= " AND u.recurso_categoria_id IN (SELECT * FROM dblink('dbname=MIC-MEDIATECA hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                                                                                                'SELECT recurso_categoria_id FROM ".'"MIC-MEDIATECA".recurso_categoria WHERE recurso_categoria_filtro=5'."') as g (recurso_categoria_id bigint))
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


}

