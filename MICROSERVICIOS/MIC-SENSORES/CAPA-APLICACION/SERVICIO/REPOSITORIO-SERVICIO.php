<?php

require_once(dirname(__FILE__,4).'\MIC-SENSORES\CAPA-DOMINIO\REPOSITORIO-INTERFACE-SERVICIO\REPOSITORIO-INTERFACE-SERVICIO.php');
require_once(dirname(__FILE__,4).'\MIC-SENSORES\CAPA-APLICACION\QUERY\REPOSITORIO-QUERY.php');


class RepositorioServicioSensores implements IRepositorioServicioSensores{

    public $query;

    public function __construct(){
        $this->query= new RepositorioQuerySensores();
    }

}
