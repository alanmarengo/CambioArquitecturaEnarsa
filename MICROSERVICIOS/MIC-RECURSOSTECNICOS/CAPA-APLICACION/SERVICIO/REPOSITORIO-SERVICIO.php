<?php

require_once(dirname(__FILE__,4).'\MIC-RECURSOSTECNICOS\CAPA-DOMINIO\REPOSITORIO-INTERFACE-SERVICIO\REPOSITORIO-INTERFACE-SERVICIO.php');
require_once(dirname(__FILE__,4).'\MIC-RECURSOSTECNICOS\CAPA-APLICACION\QUERY\REPOSITORIO-QUERY.php');
require_once(dirname(__FILE__,4).'\MIC-RECURSOSTECNICOS\CAPA-DOMINIO\DTOS\DTOS.php');

class RepositorioServicioRecursosTecnicos implements IRepositorioServicioRecursosTecnicos{

    public $query;

    public function __construct(){
        $this->query= new RepositorioQueryRecursosTecnicos();
    }

    public function get_recursos_tecnicos($lista_recursos_restringidos, $current_page, $page_size, $order_by)
    {
        return $this->query->get_recursos_tecnicos($lista_recursos_restringidos, $current_page, $page_size, $order_by);
    }

    public function get_recursos_tecnicos_filtrado($lista_recursos_restringidos, $current_page,$page_size,$qt,$desde,$hasta,
                                                  $proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$order_by)
    {
        return $this->query->get_recursos_tecnicos_filtrado($lista_recursos_restringidos, $current_page,$page_size,$qt,$desde,$hasta,
                                                            $proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$order_by);
    }
    
    public function get_estadistica_recursos_tecnicos($lista_recursos_restringidos,$qt,$desde,$hasta,$proyecto,$clase,$subclase,
                                                      $tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$si_tengo_que_filtrar,$calculo_estadistica)
    {
        return $this->query->get_estadistica_recursos_tecnicos($lista_recursos_restringidos,$qt,$desde,$hasta,$proyecto,$clase,
                                                               $subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$si_tengo_que_filtrar,
                                                               $calculo_estadistica);
    }

}
