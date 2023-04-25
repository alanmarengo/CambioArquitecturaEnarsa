<?php

interface IRepositorioQueryIndicadores{

    public function DrawAbrInd($lista_recursos_restringidos);
    public function DrawContainersInd($lista_recursos_restringidos);
    public function DrawIndicadores($lista_recursos_restringidos,$clase_id); 
    public function DrawIndicadoresSearch($lista_recursos_restringidos,$pattern);
    public function ComboCruce(); 
    public function get_consulta($query_string);
    
}


