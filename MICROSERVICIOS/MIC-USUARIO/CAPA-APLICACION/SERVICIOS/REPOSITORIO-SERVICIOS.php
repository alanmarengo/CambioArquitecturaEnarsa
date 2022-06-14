<?php


require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-USUARIO/CAPA-DOMINIO/INTERFACE-SERVICIOS/REPOSITORIO-INTERFACE-SERVICIO.php');
require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-USUARIO/CAPA-APLICACION/QUERYS/REPOSITORIO-QUERY.php');



class RepositorioServicioUsuario implements IRepositorioServicioUsuario{
    public $query;

    public function __construct(){
        $this->query= new RepositorioQueryUsuario();
    }


    public function get_recursos_restringidos(){

        return $this->query->get_recursos_id();
        //print_r($recursos_list);
        //ACA VOY A HACER LA LOGICA UNA VEZ QUE RECIBO LA LISTA DE ENTEROS CON LOS RECURSOS ID.

    }

    public function get_recursos_restringidos_user($user_id){
        
        return $this->query->get_recursos_id_user($user_id);
        //ACA VOY A HACER LA LOGICA UNA VEZ QUE RECIBO LA LISTA DE ENTEROS CON LOS RECURSOS ID.
        //print_r($recursos_list);

    }


}

//$servicio= new RepositorioServicioUsuario();
//print_r($servicio->get_recursos_restringidos());
//$servicio->get_recursos_restringidos_user(10);
