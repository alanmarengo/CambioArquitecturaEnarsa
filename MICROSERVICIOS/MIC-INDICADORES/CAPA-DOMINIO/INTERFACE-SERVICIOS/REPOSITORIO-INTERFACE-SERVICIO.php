<?php


interface IRepositorioServicioIndicadores{
    
    public function DrawAbrInd($user_id);
    public function DrawContainersInd($user_id);
    public function DrawIndicadores($user_id,$clase_id);
    public function DrawIndicadoresSearch($user_id,$pattern);
    public function ComboCruce();
    public function get_consulta($query_string);

}


