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

        $respuesta= new Respuesta(); // objeto que recopilara la informacion        
        $respuesta->current_page = $current_page;
        $respuesta->rec_per_page = $page_size;

        $recursos_tecnicos = $this->query->get_recursos_tecnicos($lista_recursos_restringidos, $current_page, $page_size);
        $respuesta->recordset = $recursos_tecnicos->recursos;
        
        echo "hola";
    }

}

$recursos_tecnicos = new RepositorioServicioRecursosTecnicos();
$array_test = array (1,2,3,4,5); 
$recursos_tecnicos->get_recursos_tecnicos($array_test,1,20);