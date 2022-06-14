<?php

interface IRepositorioServicioMediateca{
    public function get_Recursos_idUser($user_id ,$solapa);
    public function get_Recursos($solapa); // sobrecarga para cuando no hay un id de usuario
    
}

?>