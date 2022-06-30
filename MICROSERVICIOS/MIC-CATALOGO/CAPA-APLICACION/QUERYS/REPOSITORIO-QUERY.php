<?php

require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-CATALOGO/CAPA-DOMINIO/INTERFACE-QUERYS/REPOSITORIO-INTERFACE-QUERY.php');
require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-CATALOGO/CAPA-DATOS/capa-acceso.php');
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



    
    public function get_filtros($solapa){
        //ESTO RETORNA UNA LISTA DE FILTROSDTOS


        //SOLAPA 0, FILTROS_ID : 0,1,3,4
        //SOLAPA 1, FILTROS_ID : 0,3,4,5
        //SOLAPA 2, FILTROS_ID : 0,2,3,4
        //SOLAPA 3, FILTROS_ID : 0,3,4

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

        switch($solapa){

            case 0:
                $QUERY_DEFINITIVA = "SELECT F.*,COALESCE(T.total,0) AS total "
                ." FROM "
                ." mod_catalogo.vw_filtros_values F "
                ."LEFT JOIN "
                ."("
                ."--QUERY_UNION"
                .")T "
                ."ON F.filtro_id=T.filtro_id AND F.valor_id = T.valor_id ORDER BY valor_desc ASC AND F.total!=0;";
                $QUERY_DEFINITIVA=str_replace("--QUERY_UNION",ConstruirUnion($lista_filtros_solapa_0, 0, $filtro_id), $QUERY_DEFINITIVA);           
                break;

            case 1:
                //HACER LO MISMO QUE ARRIBA Y PROBAR TODO
                break;
            case 2:
                break;
            case 3:
                break;

        }




        //EJECUTAR QUERY DEFINITIVA Y VAS A RECORRER ESE RESULTADO Y VAS A FORMAR Y DEVOLVER UNA LISTA DE FILTROSDTOS


    }

    public function ConstruirUnion($lista_filtros_solapa, $solapa, $filtro_id){
        $LISTA_UNIONES=array();
        $QUERY_RETURN="";
        $QUERY="SELECT '||_filtro_id||'::BIGINT AS filtro_id,sub_proyecto_desc::TEXT AS desc,
        CASE
                    WHEN r.sub_proyecto_id IS NULL THEN e.sub_proyecto_id
                    ELSE r.sub_proyecto_id
                END AS sub_proyecto_id::BIGINT AS valor_id,COUNT(*)::BIGINT AS total
        FROM MIC-MEDIATECA.recurso r --db link
        LEFT JOIN MIC-MEDIATECA.formato f ON f.formato_id = r.formato_id --con db link
        LEFT JOIN MIC-MEDIATECA.tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id --db link
        LEFT JOIN mod_catalogo.vw_estudio e ON r.estudios_id = e.estudios_id
        LEFT JOIN mod_catalogo.subclase sc ON sc.subclase_id = r.subclase_id
        LEFT JOIN mod_catalogo.clase cc ON sc.clase_id = cc.clase_id;
        WHERE tf.tipo_formato_solapa = $solapa AND valor_id IS NOT NULL AND _desc IS NOT NULL";

        for($x=0;x<=$lista_filtros_solapa.lenght; $x++)
        {
            if($x==$lista_filtros_solapa_0.lenght)
            {
                $QUERY_RETURN+=$QUERY. "\n".ConstruirQuery($lista_filtros_solapa[$x]);
            }
            $QUERY_RETURN+=$QUERY. "\n".ConstruirQuery($lista_filtros_solapa[$x]) + "UNION ALL"."\n";
            //en el caso de perderse, mirar la base de datos AHRCS EN MOD_MEDIATECA.GET_CONSULKTA_FILTRO_CONSULTA
            //TAMBIEN SI TE PERDES ANDA A MEDIATECA_FIND_PAGE       
        }

        return $QUERY_RETURN;

    }













    public function ConstruirQuery($filtro_id){
        
        //FILTRO ID 0
        $CONSULTA_PROYECTO=' GROUP BY sub_proyecto_desc,sub_proyecto_id_principal ';
        //FILTRO ID 1
        $CONSULTA_AREA_GESTION='AND recurso_categoria_id IN(SELECT recurso_categoria_id FROM mod_mediateca.recurso_categoria WHERE recurso_categoria_filtro=1) GROUP BY recurso_categoria_desc,recurso_categoria_id ';
        //FILTRO ID 2
        $CONSULTA_RECURSOS_TECNICOS='AND recurso_categoria_id IN(SELECT recurso_categoria_id FROM mod_mediateca.recurso_categoria WHERE recurso_categoria_filtro=2) GROUP BY recurso_categoria_desc,recurso_categoria_id ';
        //FILTRO ID 3 
        $CONSULTA_AREA_TEMATICA=' GROUP BY clase_id ';
        //FILTRO ID 4
        $CONSULTA_TEMA='GROUP BY subclase_desc,subclase_id ';
        //FILTRO ID 5
        $CONSULTA_RECURSOS_AUDIOVISUALES='AND recurso_categoria_id IN(SELECT recurso_categoria_id FROM mod_mediateca.recurso_categoria WHERE recurso_categoria_filtro=5) GROUP BY recurso_categoria_desc,recurso_categoria_id ';
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

