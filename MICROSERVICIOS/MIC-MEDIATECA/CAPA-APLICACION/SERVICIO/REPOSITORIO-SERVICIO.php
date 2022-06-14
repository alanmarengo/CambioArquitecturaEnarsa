<?php

require_once('C:/xampp/htdocs/atic/obs_nueva_arq/obs_op/MICROSERVICIOS/MIC-MEDIATECA/CAPA-DOMINIO/INTERFACE-REPOSITORIO-SERVICIO/INTERFACE-REPOSITORIO-SERVICIO.php');
require_once('C:/xampp/htdocs/atic/obs_nueva_arq/obs_op/MICROSERVICIOS/MIC-MEDIATECA/CAPA-APLICACION/QUERY/REPOSITORIO-QUERY.php');
require_once('C:/xampp/htdocs/atic/obs_nueva_arq/obs_op/MICROSERVICIOS/MIC-USUARIO/CAPA-APLICACION/SERVICIOS/REPOSITORIO-SERVICIOS.php');
//DESPUES VAMOS A TENER QUE INJECTAR TODOS LOS SERVICIOS DE LOS MICROSERVICIOS: ARTICULOS, ESTADISTICA, GEOVISORES E INDICADORES.




class RepositorioServicioMediateca  implements IRepositorioServicioMediateca
{
    public $query;

    public function __construct(){
        $this->query= new RepositorioQueryMediateca();
    }


    // funcion para traer todos los recursos de la mediateca 
    public function get_Recursos_idUser($user_id, $solapa)
    {
        //UTILIZAR EL METODO DEL USUARIO PARA SABER QUE RECURSOS TIENE RESTRINGIDOS/DENEGADOS.
        $lista_recursos_restringidos = array();
        $servicio_usuario = new RepositorioServicioUsuario();
        $lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos_user($user_id);
        
        //return $lista_recursos_restringidos;
        $recursos = $this->query->get_recursos($lista_recursos_restringidos, $solapa); 

        //$lista_recursos_mediateca = get_recursos($lista_recursos_restringidos, $solapa);



        //ACA IDENTIFICO UN FLAG DEL FRONT SI ES QUE DEBO CALCULAR O NO LAS ESTADISTICAS. SI NO LAS DEBO CALCULAR, LAS VOY A BUSCAR A BASE DE DATOS.
        //SI LAS DEBO CALCULAR, DEBO CALCULAR LAS ESTADISTICAS CON LOS FILTROS, TANTO ACA EN MEDIATECA COMO EN LOS DEMAS MICROSERVICIOS.
        //LA ENCARGADA DE DEVOLVER LOS FILTROS Y LAS ESTADISITCAS DE ESOS FILTROS SERA EL MICROSERVICIO CATALOGO

        //aca abajo le pedimos a los otros microservicios sus recursos y estadisticas, en el caso de que la solapa sea la 2 o de que se halla accionado un filtro.




    }

    public function get_Recursos($solapa)
    {
        //UTILIZAR EL METODO DEL USUARIO PARA SABER QUE RECURSOS TIENE RESTRINGIDOS/DENEGADOS.
        $lista_recursos_restringidos = array();
        $servicio_usuario = new RepositorioServicioUsuario();
        $lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos();        


    }
    
    


}


$obtener_recursos_mediateca = new RepositorioServicioMediateca();
print_r($obtener_recursos_mediateca->get_recursos(0));
print_r($obtener_recursos_mediateca->get_Recursos_idUser(10,0));






