<?php

require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-MEDIATECA/CAPA-DOMINIO/INTERFACE-REPOSITORIO-SERVICIO/INTERFACE-REPOSITORIO-SERVICIO.php');
require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-MEDIATECA/CAPA-APLICACION/QUERY/REPOSITORIO-QUERY.php');
require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-USUARIO/CAPA-APLICACION/SERVICIOS/REPOSITORIO-SERVICIOS.php');
require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-CATALOGO/CAPA-APLICACION/SERVICIOS/REPOSITORIO-SERVICIO.php');


class RepositorioServicioMediateca  implements IRepositorioServicioMediateca
{
    public $query;

    public function __construct(){
        $this->query= new RepositorioQueryMediateca();
    }


    // funcion para traer todos los recursos de la mediateca 
    public function get_Recursos($lista_recursos_restringidos, $solapa, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$si_tengo_que_filtrar)
    {
        //se obtiene la lista de recursos restringidos para cada usuario dependiento de su id.
        $lista_recursos_restringidos = array();
        $servicio_usuario = new RepositorioServicioUsuario();


        

        if($user_id!=-1){
            $lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos_user($user_id);
        }else{
            $lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos();
        }

        $servicio_catalogo = new RepositorioServicioCatalogo();

        $recursos_mediateca_filtros;
        $filtros;

        //seccion recursos

        //llamo al metodo get_recursos para obtener los recursos de la mediateca

        if($si_tengo_que_filtrar==1){
            $recursos_mediateca_filtros=$this->query->get_recursos_filtrado($lista_recursos_restringidos, $solapa, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad);
            $filtros=$servicio_catalogo->get_filtros($solapa,$recursos_mediateca_filtros->$aux_cadena_filtros,1);
        }else{
            $recursos_mediateca= $this->query->get_recursos($lista_recursos_restringidos, $solapa, $current_page,$page_size);
            $filtros=$servicio_catalogo->get_filtros($solapa,null,0);
        }
        
        //ESTADISTICA EN LA PRIMERA CARGA VALOR 0
        //SI YA ESTA EN MEDIATECA Y  ACCIONA FILTROS VALOR 1
        //SI YA ESTA EN MEDIATECA Y NO ACCIONA FILTROS VALOR 2    

       //seccion estadistica
        if($calculo_estadistica == 0 ) // la variable calculo estadistica sera la bandera para determinar
        {                                          // si se calcularan o no las estadisticas 
             $estadistica_inicial = $this->query->estadistica_inicial();
             // aca traeremos las estadisticas iniciales, si es que no se deben calcular de nuevo
            
        }else if ($calculo_estadistica == 1){            
            // aca se van a calcular las estadisticas de ser necesario 
            $estadistica_inicial = null; // aca voy a ir a buscar las estadisticas dependiendo en que solapa fue.
        }
        else{
            $estadistica_inicial = null;
        }

    

        return  $recursos_mediateca;
        //ACA IDENTIFICO UN FLAG DEL FRONT SI ES QUE DEBO CALCULAR O NO LAS ESTADISTICAS. SI NO LAS DEBO CALCULAR, LAS VOY A BUSCAR A BASE DE DATOS.
        //SI LAS DEBO CALCULAR, DEBO CALCULAR LAS ESTADISTICAS CON LOS FILTROS, TANTO ACA EN MEDIATECA COMO EN LOS DEMAS MICROSERVICIOS.
        //LA ENCARGADA DE DEVOLVER LOS FILTROS Y LAS ESTADISITCAS DE ESOS FILTROS SERA EL MICROSERVICIO CATALOGO

        //aca abajo le pedimos a los otros microservicios sus recursos y estadisticas, en el caso de que la solapa sea la 2 o de que se halla accionado un filtro.

        


    }
    
    
}

// prueba de aplicacion 
 //$obtener_recursos_mediateca = new RepositorioServicioMediateca();
 //$recursos_mediateca = $obtener_recursos_mediateca->get_recursos(1,2,5,0);
 //print_r($recursos_mediateca);
 //print_r($obtener_recursos_mediateca->get_Recursos_idUser(10,1));






