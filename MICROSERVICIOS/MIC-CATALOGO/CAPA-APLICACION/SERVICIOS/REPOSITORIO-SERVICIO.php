<?php

require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-CATALOGO/CAPA-DOMINIO/INTERFACE-SERVICIO/REPOSITORIO-INTERFACE-SERVICIO.php');
require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-CATALOGO/CAPA-APLICACION/QUERYS/REPOSITORIO-QUERY.php');

class RepositorioServicioCatalogo implements IRepositorioServicioCatalogo{
    public $query;

    public function __construct(){
        $this->query= new RepositorioQuery();    }


    public function get_info_territorio($territorio_id){
        return $this->query->get_info_territorio($territorio_id);               
    }

}