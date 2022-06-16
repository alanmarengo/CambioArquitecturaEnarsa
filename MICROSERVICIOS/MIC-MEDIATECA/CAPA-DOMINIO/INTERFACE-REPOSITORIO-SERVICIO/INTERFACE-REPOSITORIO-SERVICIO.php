<?php

interface IRepositorioServicioMediateca{
    public function get_Recursos_idUser($user_id ,$solapa, $current_page,$page_size,$calculo_estadistica);
    public function get_Recursos($solapa, $current_page,$page_size,$calculo_estadistica); // sobrecarga para cuando no hay un id de usuario
    
}

?>