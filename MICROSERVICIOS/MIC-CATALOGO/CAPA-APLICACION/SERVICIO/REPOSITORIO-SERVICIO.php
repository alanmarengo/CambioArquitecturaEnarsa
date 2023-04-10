<?php
require_once(dirname(__FILE__,4).'\MIC-CATALOGO\CAPA-DOMINIO\INTERFACE-SERVICIO\REPOSITORIO-INTERFACE-SERVICIO.php');
require_once(dirname(__FILE__,4).'\MIC-CATALOGO\CAPA-APLICACION\QUERY\REPOSITORIO-QUERY.php');

class RepositorioServicioCatalogo implements IRepositorioServicioCatalogo{
    public $query;

    public function __construct(){
        $this->query= new RepositorioQueryCatalogo();    }


    public function get_info_territorio($territorio_id){
        return $this->query->get_info_territorio($territorio_id);               
    }


    public function get_filtros($solapa,$aux_cadena_filtros,$recursos_restringidos, $si_tengo_que_filtrar){
        return $this->query->get_filtros($solapa,$aux_cadena_filtros,$recursos_restringidos, $si_tengo_que_filtrar);    
    }

    public function get_consulta($query_string){
        return $this->query->get_consulta($query_string);
    }

    public function GET_LINK($ID){
        return $this->query->GET_LINK($ID);
    }
    
    
    //public function get_filtros_filtrados($solapa,$aux_cadena_filtros,$recursos_restringidos, $si_tengo_que_filtrar){
    //    return $this->query->get_filtros_filtrados($solapa,$aux_cadena_filtros,$recursos_restringidos, $si_tengo_que_filtrar);    
    //}   

}