<?php

require_once(dirname(__FILE__,4).'\MIC-INDICADORES\CAPA-DOMINIO\INTERFACE-SERVICIOS\REPOSITORIO-INTERFACE-SERVICIO.php');
require_once(dirname(__FILE__,4).'\MIC-INDICADORES\CAPA-APLICACION\QUERYS\REPOSITORIO-QUERY.php');

class RepositorioServicioIndicadores implements IRepositorioServicioIndicadores{
    public $query;

    public function __construct(){
        $this->query= new RepositorioQueryIndicadores();
    }

    // a partir de aca se definiran todos los servicios 


}