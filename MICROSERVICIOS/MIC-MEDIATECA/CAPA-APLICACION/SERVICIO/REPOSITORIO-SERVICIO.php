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
    public function get_Recursos($user_id, $solapa, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$si_tengo_que_filtrar)
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

        $recursos_mediateca_filtros; // variable contenedora de los recursos

        $filtros; // variable contenedora de los filtros 

        //seccion logica de obtencion de recursos y filtros  
        //llamo al metodo get_recursos para obtener los recursos de la mediateca

        if($si_tengo_que_filtrar==1){  
            $recursos_mediateca=$this->query->get_recursos_filtrado($lista_recursos_restringidos, $solapa, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad);
            $filtros=$servicio_catalogo->get_filtros($solapa,$lista_recursos_restringidos,$si_tengo_que_filtrar);
        }else{
            $recursos_mediateca= $this->query->get_recursos($lista_recursos_restringidos, $solapa, $current_page,$page_size);
            $filtros=$servicio_catalogo->get_filtros($solapa,$lista_recursos_restringidos,$si_tengo_que_filtrar);
        }
        
        //ESTADISTICA EN LA PRIMERA CARGA VALOR 0
        //SI YA ESTA EN MEDIATECA Y  ACCIONA FILTROS VALOR 1
        //SI YA ESTA EN MEDIATECA Y NO ACCIONA FILTROS VALOR 2    

       //seccion estadistica
       $calculo_estadistica = 0;
        if($calculo_estadistica == 0 ) // la variable calculo estadistica sera la bandera para determinar
        {                                          // si se calcularan o no las estadisticas 
             $estadistica_inicial = $this->query->get_estadistica_inicial();
             // aca traeremos las estadisticas iniciales, si es que no se deben calcular de nuevo
            
        }else if ($calculo_estadistica == 1){            
            // aca se van a calcular las estadisticas de ser necesario 
            $estadistica_inicial = null; // aca voy a ir a buscar las estadisticas dependiendo en que solapa fue.
        }
        else{
            $estadistica_inicial = null;
        }

        $array_respuesta_final = Array();

        array_push($array_respuesta_final,$recursos_mediateca);
        array_push($array_respuesta_final,$filtros);
        array_push($array_respuesta_final,$estadistica_inicial);

        return  $array_respuesta_final;
        //ACA IDENTIFICO UN FLAG DEL FRONT SI ES QUE DEBO CALCULAR O NO LAS ESTADISTICAS. SI NO LAS DEBO CALCULAR, LAS VOY A BUSCAR A BASE DE DATOS.
        //SI LAS DEBO CALCULAR, DEBO CALCULAR LAS ESTADISTICAS CON LOS FILTROS, TANTO ACA EN MEDIATECA COMO EN LOS DEMAS MICROSERVICIOS.
        //LA ENCARGADA DE DEVOLVER LOS FILTROS Y LAS ESTADISITCAS DE ESOS FILTROS SERA EL MICROSERVICIO CATALOGO

        //aca abajo le pedimos a los otros microservicios sus recursos y estadisticas, en el caso de que la solapa sea la 2 o de que se halla accionado un filtro.

        


    }

    // funcion para buscar los filtros
    
    
}

 //prueba de aplicacion 
 $obtener_recursos_mediateca = new RepositorioServicioMediateca();
 //$lista_recursos_restringidos, $solapa, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$si_tengo_que_filtrar
 //$user_id, $solapa, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$si_tengo_que_filtrar)
 // 
 // $user_id, $solapa, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$si_tengo_que_filtrar,$filtro_id

 // si no hay que filtrar 
 // test solapa 0 - documentos 
 //$recursos_mediateca = $obtener_recursos_mediateca->get_Recursos(-1,0,1,20,"","","","","","","","","",0,""); // test solapa cero, sin filtros 
 //print_r($recursos_mediateca);

 // test solapa 1  - recursos audivisuales
 // $recursos_mediateca = $obtener_recursos_mediateca->get_Recursos(-1,1,1,20,"","","","","","","","","",0,"");
 // print_r($recursos_mediateca);

 // test solapa 3 - novedades 
 //$recursos_mediateca = $obtener_recursos_mediateca->get_Recursos(-1,3,1,20,"","","","","","","","","",0,"");
 //print_r($recursos_mediateca);

// si hay que filtrar
 // test solapa 0 - documentos 
 //$recursos_mediateca = $obtener_recursos_mediateca->get_Recursos(-1,0,1,20,"","","","","","","","","",1,""); // test solapa cero, sin filtros 
 //print_r($recursos_mediateca);

 // test solapa 1  - recursos audivisuales
 // $recursos_mediateca = $obtener_recursos_mediateca->get_Recursos(-1,1,1,20,"","","","","","","","","",1,"");
 // print_r($recursos_mediateca);

 // test solapa 3 - novedades 
 //$recursos_mediateca = $obtener_recursos_mediateca->get_Recursos(-1,3,1,20,"","","","","","","","","",1,"");
 //print_r($recursos_mediateca);





