<?php

require_once(dirname(__FILE__,4).'/MIC-SENSORES/CAPA-DOMINIO/REPOSITORIO-INTERFACE-QUERY/REPOSITORIO-INTERFACE-QUERY.php');
require_once(dirname(__FILE__,4).'/MIC-SENSORES/CAPA-DATOS/capa-acceso.php');
require_once(dirname(__FILE__,4).'/MIC-SENSORES/CAPA-DOMINIO/CLASES/Clases.php');


class RepositorioQuerySensores implements IRepositorioQuerySensores{

    public function get_consulta($query_string)
    {
        $conexion = new ConexionSensores();
        $resultado = $conexion->get_consulta($query_string);

        if(!empty($resultado))
        {
            return $resultado;
        }else{
            return 'la consulta no produjo resultados.';
        }
    }


    public function clear_json($str) {
	
        $bad = array("\n","\r","\"");
        
        $good = array("","","");
        
        return str_replace($bad,$good,$str);
        
    } 

    public function parseSQLToCSV($recordset)
    {
    
        $TotalColum = pg_num_fields($recordset);
                
        $fflag_delimitador = false;

        $omitir_index = array();
        $omitir_column = array("fec_bbdd_date","id_og", "id_og2", "id_og3", "id_og4","the_geom","geom","cod_","origen","id","fec_bbdd","cod_estudio","cod_esia","cod_temp","cod_ob","cod_unsubclase");
    
        for ($index = 0; $index < $TotalColum; $index++) 
        {
            if($fflag_delimitador) {$json.= ";";};
                            
            $fieldname = pg_field_name($recordset, $index);
                            
                            if (!in_array($fieldname, $omitir_column))
                            {
                                $json.= "\"".$fieldname."\"";
                                $fflag_delimitador = true;
                            }
                            else 
                            {
                                array_push ($omitir_index,$index);
                                $fflag_delimitador = false;
                            };
        }
      
        $json.= "\n"; // \n\r se reemplazó por \n

        $flagFirstSeparator = true;
                 
        while ($row = pg_fetch_row($recordset)) 
        {

            if($flagFirstSeparator)
            {
                $flagFirstSeparator = false;
            }else $json.= "\n"; // \n\r se reemplazó por \n
                            
                            $fflag_delimitador  = false;

            for ($index = 0; $index < $TotalColum; $index++) 
            {
                                    if($fflag_delimitador) {$json.= ";";}; 
                                    
                                    if(!in_array($index, $omitir_index))
                                    {
                                        $json.= "\"".$row[$index]."\"";
                                        $fflag_delimitador = true;
                                    }else $fflag_delimitador = false;                                  
                                    
            }
        
        }
      
        return $json;
        
    }

    public function csv_redes($parametro_id, $fd,$fh,$lista_estaciones)
    {
        
        $query_string    = "SELECT * ";
        $query_string   .= " FROM mod_sensores.get_parametro_datos_sin_agrupar('$lista_estaciones'::text,$parametro_id::bigint,'$fd'::timestamp with time zone,'$fh'::timestamp with time zone) ";
        $query_string   .= " ORDER BY estacion_nombre ASC;";
        
        $conexion = new ConexionSensores();

        $resultado = $conexion->get_consulta($query_string);

        $csv = parseSQLToCSV($resultado);
        
        echo $csv;
        
        $conexion = null;



    }

    public function json_sensores()
    {        
    
        $SQL = "SELECT estacion, dato_nombre, dato, maximo, minimo, to_char(media::float, 'FM999999990.00') as media, ultima_act,unidad,tipo_sensor,(ultima_act::date-30) AS fecha_menos_30 FROM datos.vw_sensores_data_index WHERE dato IS NOT NULL ORDER BY estacion ASC";
        $conexion = new ConexionSensores();

        $recordset = $conexion->get_consulta($SQL);

        if(!empty($recordset))
        {
            $array_recordset = array();

            foreach($recordset as $dato)
            {
                $array_dato =  array();
               
                $array_dato["estacion"] = $dato[0];
                $array_dato["dato_nombre"] = $dato[1];
                $array_dato["dato"] = $dato[2];
                $array_dato["maximo"] = $dato[3];
                $array_dato["minimo"] = $dato[4];
                $array_dato["media"] = $dato[5];
                $array_dato["ultima_act"] = $dato[6];
                $array_dato["fecha_inicial"] = $dato[9];
                $array_dato["unidad"] = $dato[7];
                $array_dato["tipo"] = $dato[8];
                
                array_push($array_recordset, $array_dato);
                 
            }

            $respuesta_op_server = new respuesta_error_sensor();
            $respuesta_op_server->flag = true;
            $respuesta_op_server->detalle = $array_recordset;   
            
            return $respuesta_op_server;

        }else{

            $respuesta_op_server = new respuesta_error_sensor();
            $respuesta_op_server->flag = false;
            $respuesta_op_server->detalle = "No se encontraron registros.S";  
            
            return $respuesta_op_server;

        }  

    }
    
    public function csv_redes_hidro($parametro_id,$fd, $fh, $estacion_id, $categoria_parametro_id)
    {
        
        $query_string    = "SELECT * ";
        $query_string   .= " FROM estaciones.get_estacion_datos_fechas_sin_agrupar($estacion_id,$parametro_id,$categoria_parametro_id,'$fd'::timestamp with time zone,'$fh'::timestamp with time zone) ";
        $query_string   .= " ORDER BY fecha ASC;";

        $conexion_sensores = new ConexionSensores();

        $query = $conexion_sensores->get_consulta($query_string);

        if(!empty($query))
        {

            $csv = parseSQLToCSV($query);

            $respuesta_op_server = new respuesta_error_sensor();
            $respuesta_op_server->flag = true;
            $respuesta_op_server->detalle = $csv;   
            
            return $respuesta_op_server;

        }else{

            $respuesta_op_server = new respuesta_error_sensor();
            $respuesta_op_server->flag = false;
            $respuesta_op_server->detalle = "No se encontraron resultados";   
            
            return $respuesta_op_server;
        }

    }



} // fin repositorio query

