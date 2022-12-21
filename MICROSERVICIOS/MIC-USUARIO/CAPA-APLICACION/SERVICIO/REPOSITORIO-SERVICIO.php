<?php

require_once(dirname(__FILE__,4).'\MIC-USUARIO\CAPA-DOMINIO\INTERFACE-REPOSITORIO-SERVICIO\INTERFACE-REPOSITORIO-SERVICIO.php');
require_once(dirname(__FILE__,4).'\MIC-USUARIO\CAPA-APLICACION\QUERY\REPOSITORIO-QUERY.php');

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

    public function login($user_name,$user_pass)
    {        
        return $this->query->login($user_name,$user_pass);
    }
   
}

// ejeplos de implementacion 

//$servicio= new RepositorioServicioUsuario();
//print_r($servicio->get_recursos_restringidos());
//$servicio->get_recursos_restringidos_user(10);

//$test = New RepositorioServicioUsuario();
//$test->login('test_nueva_arq','1234');