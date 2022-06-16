<?php

interface IRepositorioServicioMediateca{
    public function get_Recursos_idUser($user_id ,$solapa, $current_page,$page_size);
    public function get_Recursos($solapa, $current_page,$page_size); // sobrecarga para cuando no hay un id de usuario
    
}

?>