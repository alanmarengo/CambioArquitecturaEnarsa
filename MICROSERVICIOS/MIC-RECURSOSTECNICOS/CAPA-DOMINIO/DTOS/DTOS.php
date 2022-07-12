<?php 

class Respuesta{
    public $recordset;
    public $filtros;
    public $solapa = 2;
    public $pagina;
    public $estudio_nombre;
    public $mode_label;
    public $registros_total_0;
    public $registros_total_1;
    public $registros_total_2;
    public $registros_total_3;
    public $rec_per_page;
    public $current_page;

    public function __construct(){} // constructor vacio
}

class Recursos{
    public $recursos;
    public $lista_recursos_restringidos;
    public $CantidadPaginas;
    public $estadistica_solapa;

    public function __construct($recursos,$CantidadPaginas,$lista_recursos_restringidos,$estadistica_solapa){
        $this->recursos=$recursos;
        $this->CantidadPaginas=$CantidadPaginas;
        $this->lista_recursos_restringidos=$lista_recursos_restringidos;
        $this->estadistica_solapa;
    }
}

?>