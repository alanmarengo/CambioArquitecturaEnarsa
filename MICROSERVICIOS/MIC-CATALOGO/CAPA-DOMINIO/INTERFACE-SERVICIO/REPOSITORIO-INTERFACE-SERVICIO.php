<?php
 interface IRepositorioServicioCatalogo{
    public function get_info_territorio($territorio_id);
    public function get_filtros($solapa,$aux_cadena_filtros,$recursos_restringidos, $si_tengo_que_filtrar);
    public function get_filtros_activo();
 }
 ?>

