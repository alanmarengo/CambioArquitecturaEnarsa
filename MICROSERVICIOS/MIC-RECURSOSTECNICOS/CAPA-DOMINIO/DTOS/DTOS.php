<?php 

class RecursosTecnicos{
    public $recursos;
    public $lista_recursos_restringidos;
    public $CantidadPaginas;


    public function __construct($recursos,$CantidadPaginas,$lista_recursos_restringidos){
        $this->recursos=$recursos;
        $this->CantidadPaginas=$CantidadPaginas;
        $this->lista_recursos_restringidos=$lista_recursos_restringidos;

    }
}

class RecursosTecnicosFiltrado{
    public $recursos;
    public $lista_recursos_restringidos;
    public $CantidadPaginas;
    public $aux_cadena_filtros;


    public function __construct($recursos,$CantidadPaginas,$lista_recursos_restringidos,$aux_cadena_filtros){
        $this->recursos=$recursos;
        $this->CantidadPaginas=$CantidadPaginas;
        $this->lista_recursos_restringidos=$lista_recursos_restringidos;
        $this->aux_cadena_filtros=$aux_cadena_filtros;

    }
}

?>