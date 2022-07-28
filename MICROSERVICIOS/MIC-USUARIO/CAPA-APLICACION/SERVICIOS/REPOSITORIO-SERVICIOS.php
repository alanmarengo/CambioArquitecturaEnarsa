<?php

require_once(dirname(__FILE__,4).'\MIC-USUARIO\CAPA-DOMINIO\INTERFACE-SERVICIOS\REPOSITORIO-INTERFACE-SERVICIO.php');
require_once(dirname(__FILE__,4).'\MIC-USUARIO\CAPA-APLICACION\QUERYS\REPOSITORIO-QUERY.php');

class RepositorioServicioUsuario implements IRepositorioServicioUsuario{
    public $query;

    public function __construct(){
        $this->query= new RepositorioQueryUsuario();
    }


    public function get_recursos_restringidos()
    {
        return $this->query->get_recursos_id();
    }

    public function get_recursos_restringidos_user($user_id)
    {        
        return $this->query->get_recursos_id_user($user_id);
    }


}

// ejeplos de implementacion 

//$servicio= new RepositorioServicioUsuario();
//print_r($servicio->get_recursos_restringidos());
//$servicio->get_recursos_restringidos_user(10);
