<?php
interface IRepositorioQuery{
    public function get_info_territorio($territorio_id);
    public function get_filtros($solapa,$lista_recursos_restringidos,$si_tengo_que_filtrar, $filtro_id);
    public function get_filtros_activo();
}
