<?php

require_once(dirname(__FILE__,4).'/MIC-SENSORES/CAPA-DOMINIO/REPOSITORIO-INTERFACE-SERVICIO/REPOSITORIO-INTERFACE-SERVICIO.php');
require_once(dirname(__FILE__,4).'/MIC-SENSORES/CAPA-APLICACION/QUERY/REPOSITORIO-QUERY.php');


class RepositorioServicioSensores implements IRepositorioServicioSensores{

    public $query;

    public function __construct(){
        $this->query= new RepositorioQuerySensores();
    }
    
    public function json_sensores(){
        return $this->query->json_sensores();
    }

    public function csv_redes_hidro($parametro_id,$fd, $fh, $estacion_id, $categoria_parametro_id){
        $this->query->csv_redes_hidro($parametro_id,$fd, $fh, $estacion_id, $categoria_parametro_id);
    }

    public function get_consulta($query_string){
       return $this->query->get_consulta($query_string);

    }


}
