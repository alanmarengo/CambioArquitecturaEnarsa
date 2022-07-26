<?php

// (dirname(__FILE__,4).'\MIC-MEDIATECA\CAPA-DOMINIO\INTERFACE-REPOSITORIO-SERVICIO\INTERFACE-REPOSITORIO-SERVICIO.php')
require_once(dirname(__FILE__,4).'\MIC-GEOVISOR\CAPA-DOMINIO\INTERFACE-REPOSITORIO-SERVICIO\INTERFACE-REPOSITORIO-SERVICIO.php');
require_once(dirname(__FILE__,4).'\MIC-GEOVISOR\CAPA-APLICACION\QUERYS\REPOSITORIO-QUERY.php');
require_once(dirname(__FILE__,4).'\MIC-USUARIO\CAPA-APLICACION\SERVICIOS\REPOSITORIO-SERVICIOS.php');


//INJECTAR MICROSERVICIO USUARIO

class RepositorioServicioGeovisor implements IRepositorioServicioGeovisor{

    public $servicio_usuario;
    public $query;
    //lo mismo con la querry


    public function __construct(){
        $this->servicio_usuario=new RepositorioServicioUsuario();
        $this->query= new RepositorioQueryGeovisor();
    }
    



    public function Get_Layer_Security($user_id, $layer_id){
        $lista_recursos_restringidos = array();   
        if(empty($user_id)){ $user_id = -1; } // si el id de usuario viene vacio, se le pone -1.

        if($user_id!=-1){
            $lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos_user($user_id);
        }else{
            $lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos();
        }

        //if layer_id esta en   $lista_recursos_restringidos  entonces devuelvo true, sino devuelvo false;
    }   

    public function ListaProyectos(){
        return $this->query->ListaProyectos();
    }


}


$test = new RepositorioServicioGeovisor();
$test->ListaProyectos();