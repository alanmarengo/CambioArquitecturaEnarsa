<?php

class RecursosFiltros{

    public $recursos;
    public $aux_cadena_filtros;


    public function __construct($recursos,$aux_cadena_filtros){
        $this->recursos=$recursos;
        $this->aux_cadena_filtros=$aux_cadena_filtros;       
    }
}
