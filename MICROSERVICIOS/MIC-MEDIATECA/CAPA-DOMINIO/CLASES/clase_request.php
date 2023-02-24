<?php

Class request_filtros{
    //$qt=limpiar_caracteres($_REQUEST['s']);
    public $busqueda;                // reemplaza al filtro -> qt=limpiar_caracteres(pg_escape_string($_REQUEST['s']));
    public $desde;                   //   $desde      	=  pg_escape_string($_REQUEST['ds']);
    public $hasta;                   //   $hasta      	=  pg_escape_string($_REQUEST['de']);
    public $filtro_temporalidad;     //$filtro_temporalidad=pg_escape_string($_REQUEST['ft']);
    public $tipo_temporalidad;
    public $proyecto;   	             //=  pg_escape_string($_REQUEST['proyecto']);
    public $clase;     	             //=  pg_escape_string($_REQUEST['tema']);
    public $subclase;   	             //=  pg_escape_string($_REQUEST['subtema']);
    public $tipo_doc;   	             //=  pg_escape_string($_REQUEST['documento']);
    public $orden;      	             //=  $_REQUEST['o'];
    public $estudio_id;               //	=  pg_escape_string($_REQUEST['estudio_id']);
    public $ra; 	    	             //=  $_REQUEST['ra'];
    public $solapa;		             //=  $_REQUEST['solapa'];
    public $mode;	                 // 	=  $_REQUEST['mode'];
    public $mode_id;	                 //=  $_REQUEST['mode_id'];/* mode_id es un ID relacionado con un mode en particular */
    public $mode_label;               //	=  $_REQUEST['mode_label'];
    public $tipo_elemento;            //= $_REQUEST['tipo_elemento'];
    public $usuario_id;
    public $salto = 20;
    public $pagina = 0;
    public $si_tengo_que_filtrar = 0; // si hay que filtrar 1, si no hay que filtrar 0. por defecto no se aplica. 
    public $calculo_estadistica = 0; // 0 en la primera carga, 1 si hay que calcular y 2 si hay que calcular en recursos tecnicos. 
 
    public function __construct(){
        
        $this->user_id = "-1";
        $this->busqueda = ""; 
        $this->desde = "";
        $this->hasta = ""; 
        $this->filtro_temporalidad = "";
        $this->proyecto = "";
        $this->clase = "";   
        $this->subclase = ""; 
        $this->tipo_doc = ""; 
        $this->orden = "";    
        $this->estudio_id = "";
        $this->ra = "";
        $this->solapa = "0";	
        $this->mode = "-1";
        $this->mode_id = "";
        $this->mode_label = "";
        $this->tipo_elemento = ""; 
        $this->tipo_temporalidad = "";
         
    }


}


class respuesta_server{
    
    public $status = 'ok';
    public $error_code = 200;
    public $detalle;
}


?>