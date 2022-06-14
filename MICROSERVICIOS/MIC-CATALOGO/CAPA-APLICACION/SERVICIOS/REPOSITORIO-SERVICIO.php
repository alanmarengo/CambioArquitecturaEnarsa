<?php

require_once('C:/xampp/htdocs/atic/obs_nueva_arq/obs_op/MICROSERVICIOS/MIC-CATALOGO/CAPA-DOMINIO/INTERFACE-SERVICIO/REPOSITORIO-INTERFACE-SERVICIO.php');
require_once('C:/xampp/htdocs/atic/obs_nueva_arq/obs_op/MICROSERVICIOS/MIC-CATALOGO/CAPA-APLICACION/QUERYS/REPOSITORIO-QUERY.php');

class RepositorioServicioCatalogo implements IRepositorioServicioCatalogo{
    public $query;

    public function __construct(){
        $this->query= new RepositorioQuery();
    }


    public function get_info_territorio($territorio_id){
        //aca tengo que decirle a la query que me traiga toda esa info
        return $this->query->get_info_territorio($territorio_id);               
    }


}

//$var = new RepositorioServicio();
//print_r($var->get_info_territorio(4));