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
            $conexion = new Conexion();
            $query = 'SELECT t.fec_bbdd_date, t.territorio_simpli,t.fec_bbdd,t.descripcion FROM "MIC-CATALOGO".territorio t WHERE t.territorio_id = '.$territorio_id;

            return $conexion->get_consulta($query);
    }



    
    public function get_filtros($solapa,$aux_cadena_filtros,$si_tengo_que_filtrar, $filtro_id){ 
      
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

        if(empty($filtro_id)) // si filtro_id viene vacio,
        {
            switch($solapa)
            {       
                case 0:

                    $QUERY_DEFINITIVA = 'SELECT F.*,COALESCE(A.total,0) AS total FROM "MIC-CATALOGO".vw_filtros_values F '.
                    'LEFT JOIN'.$this->ConstruirQueryUnion($lista_filtros_solapa_0, 0,$aux_cadena_filtros,$si_tengo_que_filtrar,$filtro_id).
                    " ON F.filtro_id=A.filtro_id AND F.valor_id = A.valor_id ORDER BY valor_desc ASC ";
                    break;


                    //    AND F.total!=0; <--- aun falta discriminar los valores 0, pero eso cuando hayan datos 
                    //echo $QUERY_DEFINITIVA;
                    //$QUERY_DEFINITIVA=str_replace("--QUERY_UNION",ConstruirQueryUnion($lista_filtros_solapa_0, 0, $filtro_id,$aux_cadena_filtros,$si_tengo_que_filtrar), $QUERY_DEFINITIVA);           
                    //break;

                case 1: 

                    $QUERY_DEFINITIVA = 'SELECT F.*,COALESCE(A.total,0) AS total FROM "MIC-CATALOGO".vw_filtros_values F '.
                    'LEFT JOIN'.$this->ConstruirQueryUnion($lista_filtros_solapa_1, 0,$aux_cadena_filtros,$si_tengo_que_filtrar,$filtro_id).
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
                
                case 2: // 

                    $QUERY_DEFINITIVA = 'SELECT F.*,COALESCE(A.total,0) AS total FROM "MIC-CATALOGO".vw_filtros_values F '.
                    'LEFT JOIN'.$this->ConstruirQueryUnion($lista_filtros_solapa_2, 0,$aux_cadena_filtros,$si_tengo_que_filtrar,$filtro_id).
                    " ON F.filtro_id=A.filtro_id AND F.valor_id = A.valor_id ORDER BY valor_desc ASC ";
                        //
                    break;

                case 3:

                    $QUERY_DEFINITIVA = 'SELECT F.*,COALESCE(A.total,0) AS total FROM "MIC-CATALOGO".vw_filtros_values F '.
                    'LEFT JOIN'.$this->ConstruirQueryUnion($lista_filtros_solapa_3, 0,$aux_cadena_filtros,$si_tengo_que_filtrar,$filtro_id).
                    " ON F.filtro_id=A.filtro_id AND F.valor_id = A.valor_id ORDER BY valor_desc ASC ";
                       
                    break;


            }

            // ejecutar consulta final, para obtener lista de filtros 

            $conexion = New ConexionCatalogo();

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

        }else if (!empty($filtro_id)){
            // aca va la logica para cuando se calculan los filtros para un filtro id 
        }

        
        $conexion->desconectar(); // cierro la conexion 

        // se retorna un objeto json de los filtros 
        return $filtros; 

        //EJECUTAR QUERY DEFINITIVA Y VAS A RECORRER ESE RESULTADO Y VAS A FORMAR Y DEVOLVER UNA LISTA DE FILTROSDTOS

    }

    public function ConstruirQueryUnion($lista_filtros_solapa, $solapa,$aux_cadena_filtros,$si_tengo_que_filtrar, $filtro_id){

        // NOTA: esta funcion devuelve una subconsulta  con las uniones de las consultas de los filtros

        $QUERY_RETURN = "("; // variable contenedora de la union de filtros

        /* consulta ejemplo  consulta base 
        $query_parcial = "SELECT ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id,sp.sub_proyecto_desc::TEXT AS desc,
                                    CASE
                                        WHEN t.sub_proyecto_id IS NULL THEN e.sub_proyecto_id
                                        ELSE t.sub_proyecto_id
                                    END AS valor_id,
                                    COUNT(*)::BIGINT AS total
                                FROM dblink('dbname=MIC-MEDIATECA hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                                        'SELECT t.estudios_id, t.cod_temporalidad_id,t.subclase_id, t.sub_proyecto_id, tf.tipo_formato_solapa".
                                        'FROM "MIC-MEDIATECA".recurso t 
                                        LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = t.formato_id 
                                        LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id'."')
                                        as T (estudios_id bigint, cod_temporalidad_id bigint,subclase_id bigint, sub_proyecto_id bigint, tipo_formato_solapa bigint)
                                LEFT JOIN ".'"MIC-CATALOGO".vw_estudio e ON t.estudios_id = e.estudios_id
                                LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = t.cod_temporalidad_id
                                LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = t.subclase_id
                                LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = t.subclase_id -- añadir tabla sub proyecto
                                WHERE t.tipo_formato_solapa = '.$solapa; */


        for($x=0;$x<=count($lista_filtros_solapa)-1; $x++) // cada filtro_id que exista en la lista 
        {            
            switch($lista_filtros_solapa[$x])
            {
                case 0:
                    $query_parcial = "SELECT ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id,sp.sub_proyecto_desc::TEXT AS desc,recurso_categoria_id::BIGINT AS valor_id,COUNT(*)::BIGINT AS total 
                                    FROM dblink('dbname=MIC-MEDIATECA hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                                                'SELECT t.estudios_id, t.cod_temporalidad_id,t.subclase_id, t.sub_proyecto_id, tf.tipo_formato_solapa,rc.recurso_categoria_desc,t.recurso_categoria_id
                                                    FROM ".'"MIC-MEDIATECA".recurso t 
                                                LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = t.formato_id 
                                                LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                                LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = t.recurso_categoria_id'."')
                                            as T (estudios_id bigint, cod_temporalidad_id bigint,subclase_id bigint, sub_proyecto_id bigint, tipo_formato_solapa bigint, recurso_categoria_desc text,recurso_categoria_id bigint)
                                    LEFT JOIN ".'"MIC-CATALOGO".vw_estudio e ON t.estudios_id = e.estudios_id
                                    LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = t.cod_temporalidad_id
                                    LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = t.subclase_id
                                    LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = t.subclase_id -- añadir tabla sub proyecto
                                    WHERE t.tipo_formato_solapa ='.$solapa;    
                    break;               

                case 1: // nota: entre el caso 1 y dos, solo varia el valor del campo recurso_categoria_filtro  en 1 y 2, por lo que queda pre seteado. 
                    $query_parcial = "SELECT ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id, recurso_categoria_desc::TEXT AS desc,
                                        t.recurso_categoria_id::BIGINT AS valor_id,
                                        COUNT(*)::BIGINT AS total 
                                    FROM dblink('dbname=MIC-MEDIATECA hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                                            'SELECT t.estudios_id, t.cod_temporalidad_id,t.subclase_id, t.sub_proyecto_id, tf.tipo_formato_solapa,rc.recurso_categoria_desc,t.recurso_categoria_id
                                                FROM ".'"MIC-MEDIATECA".recurso t 
                                            LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = t.formato_id 
                                            LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                            LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = t.recurso_categoria_id'."')
                                            as T (estudios_id bigint, cod_temporalidad_id bigint,subclase_id bigint, sub_proyecto_id bigint, tipo_formato_solapa bigint, recurso_categoria_desc text,recurso_categoria_id bigint)
                                    LEFT JOIN ".'"MIC-CATALOGO".vw_estudio e ON t.estudios_id = e.estudios_id
                                    LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = t.cod_temporalidad_id
                                    LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = t.subclase_id
                                    LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = t.subclase_id -- añadir tabla sub proyecto
                                    WHERE t.tipo_formato_solapa = '.$solapa; 
                    break;
                case 2: // nota: entre el caso 1 y dos, solo varia el valor del campo recurso_categoria_filtro  en 1 y 2, por lo que queda pre seteado. 
                        $query_parcial = "SELECT ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id, recurso_categoria_desc::TEXT AS desc,
                                            t.recurso_categoria_id::BIGINT AS valor_id,
                                            COUNT(*)::BIGINT AS total 
                                        FROM dblink('dbname=MIC-MEDIATECA hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                                                'SELECT t.estudios_id, t.cod_temporalidad_id,t.subclase_id, t.sub_proyecto_id, tf.tipo_formato_solapa,rc.recurso_categoria_desc,t.recurso_categoria_id
                                                    FROM ".'"MIC-MEDIATECA".recurso t 
                                                LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = t.formato_id 
                                                LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                                LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = t.recurso_categoria_id'."')
                                                as T (estudios_id bigint, cod_temporalidad_id bigint,subclase_id bigint, sub_proyecto_id bigint, tipo_formato_solapa bigint, recurso_categoria_desc text,recurso_categoria_id bigint)
                                        LEFT JOIN ".'"MIC-CATALOGO".vw_estudio e ON t.estudios_id = e.estudios_id
                                        LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = t.cod_temporalidad_id
                                        LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = t.subclase_id
                                        LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = t.subclase_id -- añadir tabla sub proyecto
                                        WHERE t.tipo_formato_solapa = '.$solapa; 
                        break;    
                case 3:
                    $query_parcial = "SELECT  ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id,'tema'::TEXT AS desc,clase_id::BIGINT AS valor_id,COUNT(*)::BIGINT AS total			
                                        FROM dblink('dbname=MIC-MEDIATECA hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                                                    'SELECT t.estudios_id, t.cod_temporalidad_id,t.subclase_id, t.sub_proyecto_id, tf.tipo_formato_solapa,rc.recurso_categoria_desc,t.recurso_categoria_id
                                                        FROM ".'"MIC-MEDIATECA".recurso t 
                                                    LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = t.formato_id 
                                                    LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                                    LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = t.recurso_categoria_id'."')
                                                as T (estudios_id bigint, cod_temporalidad_id bigint,subclase_id bigint, sub_proyecto_id bigint, tipo_formato_solapa bigint, recurso_categoria_desc text,recurso_categoria_id bigint)
                                        LEFT JOIN ".'"MIC-CATALOGO".vw_estudio e ON t.estudios_id = e.estudios_id
                                        LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = t.cod_temporalidad_id
                                        LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = t.subclase_id
                                        LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = t.subclase_id -- añadir tabla sub proyecto
                                        WHERE t.tipo_formato_solapa ='.$solapa; 
                    break;   
                case 4:
                    $query_parcial = "SELECT ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id,subclase_desc::TEXT AS desc,t.subclase_id::BIGINT AS valor_id,COUNT(*)::BIGINT AS total			
                                        FROM dblink('dbname=MIC-MEDIATECA hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                                                    'SELECT t.estudios_id, t.cod_temporalidad_id,t.subclase_id, t.sub_proyecto_id, tf.tipo_formato_solapa,rc.recurso_categoria_desc,t.recurso_categoria_id
                                                        FROM ".'"MIC-MEDIATECA".recurso t 
                                                    LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = t.formato_id 
                                                    LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                                    LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = t.recurso_categoria_id'."')
                                                as T (estudios_id bigint, cod_temporalidad_id bigint,subclase_id bigint, sub_proyecto_id bigint, tipo_formato_solapa bigint, recurso_categoria_desc text,recurso_categoria_id bigint)
                                        LEFT JOIN ".'"MIC-CATALOGO".vw_estudio e ON t.estudios_id = e.estudios_id
                                        LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = t.cod_temporalidad_id
                                        LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = t.subclase_id
                                        LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = t.subclase_id -- añadir tabla sub proyecto
                                        WHERE t.tipo_formato_solapa = '.$solapa;
                    break;  
                case 5:
                    $query_parcial = "SELECT ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id,recurso_categoria_desc::TEXT AS desc,recurso_categoria_id::BIGINT AS valor_id,COUNT(*)::BIGINT AS total 
                    FROM dblink('dbname=MIC-MEDIATECA hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                                'SELECT t.estudios_id, t.cod_temporalidad_id,t.subclase_id, t.sub_proyecto_id, tf.tipo_formato_solapa,rc.recurso_categoria_desc,t.recurso_categoria_id
                                    FROM ".'"MIC-MEDIATECA".recurso t 
                                LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = t.formato_id 
                                LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = t.recurso_categoria_id'."')
                            as T (estudios_id bigint, cod_temporalidad_id bigint,subclase_id bigint, sub_proyecto_id bigint, tipo_formato_solapa bigint, recurso_categoria_desc text,recurso_categoria_id bigint)
                    LEFT JOIN ".'"MIC-CATALOGO".vw_estudio e ON t.estudios_id = e.estudios_id
                    LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = t.cod_temporalidad_id
                    LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = t.subclase_id
                    LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = t.subclase_id -- añadir tabla sub proyecto
                    WHERE t.tipo_formato_solapa ='.$solapa;
                    break;                      
            }
            
            if($x == count($lista_filtros_solapa)-1) // si es el ultimo elemento, cerrara la sub consulta 
            {
                $group_by = $this->ConstruirQueryFiltro($lista_filtros_solapa[$x]);
                $QUERY_RETURN .= $query_parcial . $group_by .")A"; // fin subconsulta union de filtros
            }else{
                $group_by = $this->ConstruirQueryFiltro($lista_filtros_solapa[$x]); // si no es el ultimo elemento, agregara UNION ALL
                $QUERY_RETURN .= $query_parcial . $group_by . " UNION ALL ";
            }
            
            // echo $QUERY_RETURN; 
            
                    /*
            
            $query_parcial = "SELECT ".$lista_filtros_solapa[$x]."::BIGINT AS filtro_id,sp.sub_proyecto_desc::TEXT AS desc,
                                    CASE
                                        WHEN t.sub_proyecto_id IS NULL THEN e.sub_proyecto_id
                                        ELSE t.sub_proyecto_id
                                    END AS valor_id,
                                    COUNT(*)::BIGINT AS total
                                FROM dblink('dbname=MIC-MEDIATECA hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432',
                                        'SELECT t.estudios_id, t.cod_temporalidad_id,t.subclase_id, t.sub_proyecto_id, tf.tipo_formato_solapa".
                                        'FROM "MIC-MEDIATECA".recurso t 
                                        LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = t.formato_id 
                                        LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id'."')
                                        as T (estudios_id bigint, cod_temporalidad_id bigint,subclase_id bigint, sub_proyecto_id bigint, tipo_formato_solapa bigint)
                                LEFT JOIN ".'"MIC-CATALOGO".vw_estudio e ON t.estudios_id = e.estudios_id
                                LEFT JOIN "MIC-CATALOGO".cod_temporalidad ct ON ct.cod_temporalidad_id = t.cod_temporalidad_id
                                LEFT JOIN "MIC-CATALOGO".subclase sc ON sc.subclase_id = t.subclase_id
                                LEFT JOIN "MIC-CATALOGO".sub_proyecto sp ON sp.sub_proyecto_id = t.subclase_id -- añadir tabla sub proyecto
                                WHERE t.tipo_formato_solapa = '.$solapa;

                        
            if($si_tengo_que_filtrar==1){
                $query_parcial.= $aux_cadena_filtros; // concatena los filtros que vienen de la mediateca a la consulta         
            }


            if($x == count($lista_filtros_solapa)-1)
            {
                $filtro = $this->ConstruirQueryFiltro($lista_filtros_solapa[$x]);
                $QUERY_RETURN .= $query_parcial . $filtro .")";
            }else{
                $filtro = $this->ConstruirQueryFiltro($lista_filtros_solapa[$x]);
                $QUERY_RETURN .= $query_parcial . $filtro . "UNION ALL";
            } */
            
            //en el caso de perderse, mirar la base de datos AHRCS EN MOD_MEDIATECA.GET_CONSULKTA_FILTRO_CONSULTA
            //TAMBIEN SI TE PERDES ANDA A MEDIATECA_FIND_PAGE       



        } // fin FOR armado union all 

        

        //  WHERE tf.tipo_formato_solapa = $solapa   faltaria agregar esto --->  AND valor_id IS NOT NULL AND _desc IS NOT NULL"; */ 

        // nota: tuve que agregar la tabla, subproyecto para poder hacer el campo "valor_id"

        /* consulta propuesta 
        $QUERY="SELECT '||_filtro_id||'::BIGINT AS filtro_id,sub_proyecto_desc::TEXT AS desc,
        CASE
                    WHEN t.sub_proyecto_id IS NULL THEN e.sub_proyecto_id
                    ELSE t.sub_proyecto_id
                END AS sub_proyecto_id::BIGINT AS valor_id,COUNT(*)::BIGINT AS total
        FROM MIC-MEDIATECA.recurso t --db link
        LEFT JOIN MIC-MEDIATECA.formato f ON f.formato_id = t.formato_id --con db link
        LEFT JOIN MIC-MEDIATECA.tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id --db link
        LEFT JOIN mod_catalogo.vw_estudio e ON t.estudios_id = e.estudios_id
        LEFT JOIN mod_catalogo.cod_esia ce ON ce.cod_esia_id = t.cod_esia_id
        LEFT JOIN mod_catalogo.cod_temporalidad ct ON ct.cod_temporalidad_id = r.cod_temporalidad_id
        LEFT JOIN mod_catalogo.subclase sc ON sc.subclase_id = t.subclase_id
        WHERE tf.tipo_formato_solapa = $solapa AND valor_id IS NOT NULL AND _desc IS NOT NULL"; */ 

        


       // echo $QUERY_RETURN;
            
            
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

    public function get_filtros_activo(){

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

        // a partir de aca desarrollar la logica 
        

    }

}

//$test = new RepositorioQuery();
//print_r( $test->get_filtros(0,"(1,2,3)",1));