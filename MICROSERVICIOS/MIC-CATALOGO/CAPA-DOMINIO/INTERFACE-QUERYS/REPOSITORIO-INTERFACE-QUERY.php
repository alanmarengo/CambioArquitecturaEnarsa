<?php
interface IRepositorioQuery{
    public function get_info_territorio($territorio_id);
    public function get_filtros($solapa,$consulta_base);//
}
