<?php
interface IRepositorioQuery{
    public function get_info_territorio($territorio_id);
    public function get_filtros($solapa,$aux_cadena_filtros,$si_tengo_que_filtrar);
}
