<?php

require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-MEDIATECA/CAPA-DOMINIO/INTERFACE-REPOSITORIO-SERVICIO/INTERFACE-REPOSITORIO-SERVICIO.php');
require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-MEDIATECA/CAPA-APLICACION/QUERY/REPOSITORIO-QUERY.php');
require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-USUARIO/CAPA-APLICACION/SERVICIOS/REPOSITORIO-SERVICIOS.php');


class RepositorioServicioMediateca  implements IRepositorioServicioMediateca
{
    public $query;

    public function __construct(){
        $this->query= new RepositorioQueryMediateca();
    }


    // funcion para traer todos los recursos de la mediateca 
    public function get_Recursos_idUser($user_id, $solapa)
    {
        //se obtiene la lista de recursos restringidos para cada usuario dependiento de su id.
        $lista_recursos_restringidos = array();
        $servicio_usuario = new RepositorioServicioUsuario();
        $lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos_user($user_id);
        
        //llamo al metodo get_recursos para obtener los recursos de la mediateca 
        $recursos_mediateca= $this->query->get_recursos($lista_recursos_restringidos, $solapa); 
       
        return  $recursos_mediateca;
        //ACA IDENTIFICO UN FLAG DEL FRONT SI ES QUE DEBO CALCULAR O NO LAS ESTADISTICAS. SI NO LAS DEBO CALCULAR, LAS VOY A BUSCAR A BASE DE DATOS.
        //SI LAS DEBO CALCULAR, DEBO CALCULAR LAS ESTADISTICAS CON LOS FILTROS, TANTO ACA EN MEDIATECA COMO EN LOS DEMAS MICROSERVICIOS.
        //LA ENCARGADA DE DEVOLVER LOS FILTROS Y LAS ESTADISITCAS DE ESOS FILTROS SERA EL MICROSERVICIO CATALOGO

        //aca abajo le pedimos a los otros microservicios sus recursos y estadisticas, en el caso de que la solapa sea la 2 o de que se halla accionado un filtro.




    }

    public function get_Recursos($solapa)
    {
        //se obtiene la lista de recursos restringidos para cada usuario dependiento de su id.
        $lista_recursos_restringidos = array();
        $servicio_usuario = new RepositorioServicioUsuario();
        $lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos();
        
        //llamo al metodo get_recursos para obtener los recursos de la mediateca 
        $recursos_mediateca= $this->query->get_recursos($lista_recursos_restringidos, $solapa); 
        return  $recursos_mediateca;
        // return;
                

    }
    
    


}

// prueba de aplicacion 
 //$obtener_recursos_mediateca = new RepositorioServicioMediateca();
 //$recursos_mediateca = $obtener_recursos_mediateca->get_recursos(1);
 //print_r($recursos_mediateca);
 //print_r($obtener_recursos_mediateca->get_Recursos_idUser(10,1));






