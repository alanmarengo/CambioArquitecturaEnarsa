<?php
//INJECTAR LA QUERY DE RECURSOS TECNICOS
require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-RECURSOSTECNICOS/CAPA-DOMINIO/INTERFACE-SERVICIOS/REPOSITORIO-INTERFACE-SERVICIO.php');
require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-RECURSOSTECNICOS/CAPA-APLICACION/QUERYS/REPOSITORIO-QUERY.php');
require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-RECURSOSTECNICOS/CAPA-DOMINIO/DTOS/DTOS.php');

class RepositorioServicioRecursosTecnicos implements IRepositorioServicioRecursosTecnicos{

    public $query;

    public function __construct(){
        $this->query= new RepositorioQueryRecursosTecnicos();
    }


    public function get_recursos_tecnicos($lista_recursos_restringidos, $current_page, $page_size)
    {
        return $this->query->get_recursos_tecnicos($lista_recursos_restringidos, $current_page, $page_size);
    }

    public function get_recursos_tecnicos_filtrado($lista_recursos_restringidos, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad)
    {
        return $this->query->get_recursos_tecnicos_filtrado($lista_recursos_restringidos, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad);
    }

}
