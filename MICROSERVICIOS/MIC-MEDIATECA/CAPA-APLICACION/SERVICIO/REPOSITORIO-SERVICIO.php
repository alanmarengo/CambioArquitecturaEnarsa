<?php

 require_once(dirname(__FILE__,4).'\MIC-MEDIATECA\CAPA-DOMINIO\INTERFACE-REPOSITORIO-SERVICIO\INTERFACE-REPOSITORIO-SERVICIO.php');
 require_once(dirname(__FILE__,4).'\MIC-MEDIATECA\CAPA-APLICACION\QUERY\REPOSITORIO-QUERY.php');
 require_once(dirname(__FILE__,4).'\MIC-USUARIO\CAPA-APLICACION\SERVICIO\REPOSITORIO-SERVICIO.php');
 require_once(dirname(__FILE__,4).'\MIC-CATALOGO\CAPA-APLICACION\SERVICIO\REPOSITORIO-SERVICIO.php');
 require_once(dirname(__FILE__,4).'\MIC-MEDIATECA\CAPA-DOMINIO\DTOS\DTOS.php');
 require_once(dirname(__FILE__,4).'\MIC-RECURSOSTECNICOS\CAPA-APLICACION\SERVICIO\REPOSITORIO-SERVICIO.php');

//$rola = dirname(__FILE__,4); no tocar es un ejemplo de como cponseguir la ruta absoluta


class RepositorioServicioMediateca  implements IRepositorioServicioMediateca
{
    public $query;

    public function __construct(){
        $this->query= new RepositorioQueryMediateca();
    }


    // funcion para traer todos los recursos de la mediateca 
    public function get_Recursos($user_id, $solapa, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,
                                $subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$si_tengo_que_filtrar,$calculo_estadistica,$order_by)
    {
        $respuesta= new Respuesta(); // objeto que recopilara la informacion 
        $respuesta->solapa = $solapa ;
        $respuesta->current_page = $current_page;

        
        $lista_recursos_restringidos = array();
        $servicio_usuario = new RepositorioServicioUsuario();
        
        if(empty($user_id)){ $user_id = -1; } // si el id de usuario viene vacio, se le pone -1.

        if($user_id!=-1){ //se obtiene la lista de recursos restringidos para cada usuario dependiento de su id.
            $lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos_user($user_id);
        }else{
            $lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos();
        }        

        $servicio_catalogo = new RepositorioServicioCatalogo();        

        $recursos_mediateca; // variable contenedora de los recursos

        $servicio_recursos_tecnicos; // variable que contendra los servicios del micro recursos tecnicos. en caso de ser necesario. 

        $filtros; // variable contenedora de los filtros 

        //seccion logica de obtencion de recursos y filtros  
    
        if($si_tengo_que_filtrar==1){ // si hay que aplicar filtros a los registros

            if($solapa==2){ // si la solapa ingresada es Recursos Tecnicos (solapa 2)                
                $servicio_recursos_tecnicos= new RepositorioServicioRecursosTecnicos();
                $recursos_mediateca = $servicio_recursos_tecnicos->get_recursos_tecnicos_filtrado($lista_recursos_restringidos, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,
                                                                                                    $clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$order_by);

                $filtros=$servicio_catalogo->get_filtros($solapa,$recursos_mediateca->aux_cadena_filtros,$recursos_mediateca->lista_recursos_restringidos,$si_tengo_que_filtrar);
            } 
            else{ // sino, si es cualquiera de las otras solapas... (0,1,3) hago lo siguiente 

                $recursos_mediateca=$this->query->get_recursos_filtrado($lista_recursos_restringidos, $solapa, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,
                                                                        $subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$order_by);

                $filtros=$servicio_catalogo->get_filtros($solapa,$recursos_mediateca->aux_cadena_filtros,$recursos_mediateca->lista_recursos_restringidos,$si_tengo_que_filtrar);
                $respuesta->cant_paginas = $recursos_mediateca->CantidadPaginas;  

            }

        }else{ // si no hay que aplicar filtros...

            if($solapa==2){ // // si la solapa ingresada es Recursos Tecnicos (solapa 2) 
                $servicio_recursos_tecnicos= new RepositorioServicioRecursosTecnicos();
                $recursos_mediateca = $servicio_recursos_tecnicos->get_recursos_tecnicos($lista_recursos_restringidos, $current_page,$page_size,$order_by);
                $filtros=$servicio_catalogo->get_filtros($solapa,"",$recursos_mediateca->lista_recursos_restringidos,$si_tengo_que_filtrar);
                
            }else{ // sino, si es cualquiera de las otras solapas... (0,1,3) hago lo siguiente.

                $recursos_mediateca= $this->query->get_recursos($lista_recursos_restringidos, $solapa, $current_page,$page_size,$order_by);
                $filtros=$servicio_catalogo->get_filtros($solapa,"",$recursos_mediateca->lista_recursos_restringidos,$si_tengo_que_filtrar); // si no hay que filtrar, se envia vacio en el parametro de los filtros. 
                $respuesta->cant_paginas = $recursos_mediateca->CantidadPaginas;
            }
        }
        
        //ESTADISTICA EN LA PRIMERA CARGA VALOR 0
        //SI YA ESTA EN MEDIATECA Y  ACCIONA FILTROS VALOR 1
        //SI YA ESTA EN MEDIATECA Y NO ACCIONA FILTROS VALOR 2    

       //seccion estadistica
        $calculo_estadistica = 0;
        if($calculo_estadistica == 0 ) // la variable calculo estadistica sera la bandera para determinar
        {                                          // si se calcularan o no las estadisticas 
             $estadistica_inicial = JSON_decode($this->query->get_estadistica_inicial());

             $respuesta->registros_total_0 = $estadistica_inicial->documentos;
             $respuesta->registros_total_1 = $estadistica_inicial->recursos_audiovisuales;
             $respuesta->registros_total_2 = $estadistica_inicial->recursos_tecnicos;
             $respuesta->registros_total_3 = $estadistica_inicial->novedades;

            
        }else if ($calculo_estadistica == 1){       

            // aca se van a calcular las estadisticas de ser necesario 
            //HAY QUE DESARROLLAR EL METODO get_estadistica_recursos_tecnicos();
            $estadistica_solapa_2= $servicio_recursos_tecnicos->get_estadistica_recursos_tecnicos($lista_recursos_restringidos,$qt,$desde,$hasta,$proyecto,$clase,
                                                                                                  $subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,
                                                                                                  $si_tengo_que_filtrar,$calculo_estadistica); 


            $estadisticas_filtradas = $this->query->get_estadistica_filtrado($recursos_mediateca->aux_cadena_filtros,$recursos_mediateca->lista_recursos_restringidos);
            $respuesta->registros_total_0 =  $estadisticas_filtradas->estadistica_documentos;
            $respuesta->registros_total_1 = $estadisticas_filtradas->estadistica_recursos_audiovisuales;
            $respuesta->registros_total_3 = $estadisticas_filtradas->estadistica_novedades;


        }
        
        $respuesta->filtros=$filtros;
        $respuesta->recordset=$recursos_mediateca->recursos;       
        
        $respuesta_final = new respuesta_servidor();
        $respuesta_final->flag = true;
        $respuesta_final->cod_status = 200;
        $respuesta_final->detalle = $respuesta;

        return  $respuesta_final;


    }

    // funcion para el buscador de palabras clave 
    public function busqueda_mediateca($str_filtro_mediateca){

       return $this->query->busqueda_mediateca($str_filtro_mediateca);

    } //

    public function carrusel_represas($represa){
        return $this->query->carrusel_represas($represa);
    }

    public function noticias_mediateca(){
        return $this->query->noticias_mediateca();
    }


} // fin clase RepositorioServicioMediateca  <-----------------



// a partir de aqui, lo de abajo son pruebas de aplicacion.

 //prueba de aplicacion 
 //$obtener_recursos_mediateca = new RepositorioServicioMediateca();
 

 // si no hay que filtrar 
 // test solapa 0 - documentos 
 // public function get_Recursos($user_id, $solapa, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$si_tengo_que_filtrar,$calculo_estadistica,$order_by)
 //  $recursos_mediateca = $obtener_recursos_mediateca->get_Recursos("", 0, 1,20,"","","","","","","","","",0,0,1); // test solapa cero, sin filtros 
 //  print_r($recursos_mediateca);


 // test solapa 1 - recursos audiovisuales 
 // public function get_Recursos($user_id, $solapa, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$si_tengo_que_filtrar,$calculo_estadistica,$order_by)
 //  $recursos_mediateca = $obtener_recursos_mediateca->get_Recursos("", 1, 1,20,"","","","","","","","","",0,0,1); // test solapa cero, sin filtros 
 //  print_r($recursos_mediateca);


// test solapa 2 - recursos tecnicos 
 // public function get_Recursos($user_id, $solapa, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$si_tengo_que_filtrar,$calculo_estadistica,$order_by)
// $recursos_mediateca = $obtener_recursos_mediateca->get_Recursos("", 2, 1,20,"","","","","","","","","",0,0,1); // test solapa cero, sin filtros 
// print_r($recursos_mediateca);


// test solapa 3 - novedades
 // public function get_Recursos($user_id, $solapa, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$si_tengo_que_filtrar,$calculo_estadistica,$order_by)
 //$recursos_mediateca = $obtener_recursos_mediateca->get_Recursos("", 3, 1,20,"","","","","","","","","",0,0,1); // test solapa cero, sin filtros 
 //print_r($recursos_mediateca);


// si tengo que aplicar filtros 

// filtro $qt -> corresponde al filtro del buscador 
// test filtro $qt por solapa

// test solapa 0 - documentos 
 // public function get_Recursos($user_id, $solapa, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$si_tengo_que_filtrar,$calculo_estadistica,$order_by)
 //$recursos_mediateca = $obtener_recursos_mediateca->get_Recursos("", 0, 1,20,"estudio","","","","","","","","",1,0,1); // test solapa cero, sin filtros 
 //print_r($recursos_mediateca);

// test solapa 1 - recursos audiovisuales 
 // public function get_Recursos($user_id, $solapa, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$si_tengo_que_filtrar,$calculo_estadistica,$order_by)
// $recursos_mediateca = $obtener_recursos_mediateca->get_Recursos("",1, 1,20,"foto","","","","","","","","",1,0,1); // test solapa cero, sin filtros 
// print_r($recursos_mediateca);

// test solapa 2 - recursos tecnicos
 // public function get_Recursos($user_id, $solapa, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$si_tengo_que_filtrar,$calculo_estadistica,$order_by)
 //$recursos_mediateca = $obtener_recursos_mediateca->get_Recursos("",2, 1,20,"foto","","","","","","","","",1,0,1); // test solapa cero, sin filtros 
 //print_r($recursos_mediateca);

 // test solapa 3 - novedades
 // public function get_Recursos($user_id, $solapa, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$si_tengo_que_filtrar,$calculo_estadistica,$order_by)
 //$recursos_mediateca = $obtener_recursos_mediateca->get_Recursos("",3, 1,20,"foto","","","","","","","","",1,0,1); // test solapa cero, sin filtros 
 //print_r($recursos_mediateca);




 // test obtencion de recursos cuando se aplican filtros en la mediateca 

 // test solapa 0 - documentos 
 // public function get_Recursos($user_id, $solapa, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$si_tengo_que_filtrar,$calculo_estadistica,$order_by)
 //$recursos_mediateca = $obtener_recursos_mediateca->get_Recursos("",3, 1,20,"foto","","","","","","","","",1,0,1); // test solapa cero, sin filtros 
 //print_r($recursos_mediateca);