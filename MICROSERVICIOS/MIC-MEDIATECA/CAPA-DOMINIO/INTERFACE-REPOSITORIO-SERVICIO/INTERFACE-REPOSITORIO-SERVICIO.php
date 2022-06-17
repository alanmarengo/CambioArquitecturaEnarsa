<?php

interface IRepositorioServicioMediateca{
    public function get_Recursos($user_id,$solapa, $current_page,$page_size,$calculo_estadistica);
    
}

?>