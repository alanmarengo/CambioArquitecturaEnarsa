<?php
//INJECTAR LA QUERY DE RECURSOS TECNICOS


class RepositorioServicioRecursosTecnicos implements IRepositorioServicioRecursosTecnicos{

    public $query;

    public function __construct(){
        $this->query= new RepositorioQueryRecursosTecnicos();
    }


    public function get_recursos_tecnicos($lista_recursos_restringidos, $current_page, $page_size)
    {
        return $this->query->get_recursos_tecnicos($lista_recursos_restringidos, $current_page, $page_size);
    }

}