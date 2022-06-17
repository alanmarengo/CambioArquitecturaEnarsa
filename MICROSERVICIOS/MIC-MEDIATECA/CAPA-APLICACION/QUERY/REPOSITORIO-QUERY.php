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
}

$test = new RepositorioQueryMediateca();
echo $test->get_estadistica_inicial();