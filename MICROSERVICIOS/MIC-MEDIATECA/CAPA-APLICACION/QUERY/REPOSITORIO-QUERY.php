<?php

require_once('C:/xampp/htdocs/atic/obs_nueva_arq/obs_op/MICROSERVICIOS/MIC-MEDIATECA/CAPA-DOMINIO/INTERFACE-REPOSITORIO-QUERY/INTERFACE-REPOSITORIO-QUERY.php');
require_once('C:/xampp/htdocs/atic/obs_nueva_arq/obs_op/MICROSERVICIOS/MIC-MEDIATECA/CAPA-DATOS/capa-acceso.php');

//INJECTAR EL ARCHIVO ENTIDADES.php DE ESTE MICROSERVICIO



class RepositorioQueryMediateca implements IRepositorioQueryMediateca{

    public function get_recursos($lista_recursos_restringidos, $solapa){


        $extension_consulta_filtro_recursos = "AND origen_id_especifico NOT IN (";

        for($x=0; $x<=count($lista_recursos_restringidos)-1; $x++){
       
           if($x==count($lista_recursos_restringidos)-1){
               //$lista_recursos[x]==$lista_recursos[-1]
               $extension_consulta_filtro_recursos.=$lista_recursos_restringidos[$x]['objeto_id'].")";
           }
           else{
               $extension_consulta_filtro_recursos.=$lista_recursos_restringidos[$x]['objeto_id'].",";
           }
       
        }

        $consulta_definitiva = 'SELECT `recurso mediateca`::text AS origen, 5::bigint AS origen_id, 
                                r.recurso_id AS origen_id_especifico,    
                                r.recurso_titulo AS origen_search_text, r.subclase_id, r.estudios_id, 
                                NULL::bigint AS cod_esia_id, r.cod_temporalidad_id, 
                                NULL::bigint AS objetos_id, r.recurso_categoria_id, r.tipo_recurso_id, 
                                r.formato_id, r.recurso_titulo, r.recurso_desc, r.recurso_fecha, 
                                r.recurso_autores, r.recurso_path_url, r.recurso_size, r.territorio_id, 
                                tr.tipo_recurso_desc, rc.recurso_categoria_desc, f.tipo_formato_id, 
                                f.visualizacion_tipo_id, f.formato_desc, f.formato_extension, 
                                vt.visualizacion_tipo_desc,tf.tipo_formato_solapa, 
                                tf.tipo_formato_desc, r.sub_pruyecto_id as sub_proyecto_id, r.fecha_observatorio
                                FROM "MIC-MEDIATECA".recurso r
                                LEFT JOIN "MIC-MEDIATECA".tipo_recurso tr ON tr.tipo_recurso_id = r.tipo_recurso_id
                                LEFT JOIN "MIC-MEDIATECA".formato f ON f.formato_id = r.formato_id
                                LEFT JOIN "MIC-MEDIATECA".recurso_categoria rc ON rc.recurso_categoria_id = r.recurso_categoria_id
                                LEFT JOIN "MIC-MEDIATECA".tipo_formato tf ON tf.tipo_formato_id = f.tipo_formato_id
                                LEFT JOIN "MIC-MEDIATECA".visualizacion_tipo vt ON vt.visualizacion_tipo_id = f.visualizacion_tipo_id
                                WHERE tf.tipo_formato_solapa = '.$solapa.' '.$extension_consulta_filtro_recursos.';';
       
            $conexion = new ConexionMediateca();   
            
            
            //ACA AGARRO CADA UNO DE ESOS REGISTROS, IDENTIFICO LAS COLUMNAS Y CREO UN NEW RECURSOS(COLUMNAS)}
            $array_recursos_mediateca = array();
            $array_recursos_mediateca = $conexion->get_consulta($consulta_definitiva);
           

            //ARRAY.PUSH($LISTA_RECURSOS, $RECURSO)



          



        return $lista_recursos;


    }




}