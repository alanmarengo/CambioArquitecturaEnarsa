<?php
require_once('C:/xampp/htdocs/atic/obs_nueva_arq/obs_op/MICROSERVICIOS/MIC-GEOVISOR/CAPA-DOMINIO/INTERFACE-SERVICIOS/REPOSITORIO-INTERFACE-SERVICIO.php');
require_once('C:/xampp/htdocs/atic/obs_nueva_arq/obs_op/MICROSERVICIOS/MIC-GEOVISOR/CAPA-APLICACION/QUERYS/REPOSITORIO-QUERY.php');

//INJECTAR MICROSERVICIO USUARIO

class RepositorioServicioGeovisor implements IRepositorioServicioGeovisor{

    public $servicio_usuario;
    public $query;
    //lo mismo con la querry


    public function _construct(){
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

    public function ListarProyectos(){
        return $this->query->ListarProyectos();
    }









}