<?php


class respuesta_servidor{

    public $flag;
    public $cod_status;
    public $detalle;
}


//esto devuelve get_recursos_filtrado
class RecursosFiltros{
    public $recursos;
    public $aux_cadena_filtros;
    public $lista_recursos_restringidos;
    public $CantidadPaginas;
    public $EstadisticasFiltros;


    public function __construct($recursos,$aux_cadena_filtros,$CantidadPaginas,$EstadisticasFiltros,$lista_recursos_restringidos){
        $this->recursos=$recursos;
        $this->aux_cadena_filtros=$aux_cadena_filtros; 
        $this->CantidadPaginas=$CantidadPaginas;
        $this->EstadisticasFiltros=$EstadisticasFiltros;
        $this->lista_recursos_restringidos=$lista_recursos_restringidos;
    }
}

//esto devuelve get_recursos
class Recursos{
    public $recursos;
    public $lista_recursos_restringidos;
    public $CantidadPaginas;
    public function __construct($recursos,$CantidadPaginas,$lista_recursos_restringidos){
        $this->recursos=$recursos;
        $this->CantidadPaginas=$CantidadPaginas;
        $this->lista_recursos_restringidos=$lista_recursos_restringidos;
    }
}

class EstadisticasFiltros{
    public $estadistica_documentos;
    public $estadistica_recursos_audiovisuales;
    public $estadistica_novedades;

    public function __construct($estadistica_documentos,$estadistica_recursos_audiovisuales,$estadistica_novedades){
        $this->estadistica_documentos=$estadistica_documentos;
        $this->estadistica_recursos_audiovisuales=$estadistica_recursos_audiovisuales;
        $this->estadistica_novedades=$estadistica_novedades;

    }
}


class Respuesta{
    public $recordset;
    public $filtros;    
    public $solapa;
    public $estudio_nombre;
    public $mode_label;
    public $registros_total_0;
    public $registros_total_1;
    public $registros_total_2;
    public $registros_total_3;
    public $rec_per_page;
    public $current_page ;

    public function __construct(){
        
    }


}


class Coincidencia{
    var $alias;
    var $palabra_clave;
 
    public function __construct($alias,$palabra_clave){
      $this->alias=$alias;
      $this->palabra_clave=$palabra_clave;
    }
 }