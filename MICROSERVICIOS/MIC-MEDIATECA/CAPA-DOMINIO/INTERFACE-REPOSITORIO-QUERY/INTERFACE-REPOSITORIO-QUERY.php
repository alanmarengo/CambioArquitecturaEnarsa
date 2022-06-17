<?php

interface IRepositorioQueryMediateca{
    public function get_recursos($lista_recursos_restringidos /* y va a recibir todos los filtros del front end */, $solapa, $current_page,$page_size);
    public function get_cantidad_recursos_solapa($solapa,$extension_consulta_filtro_recursos);
    public function get_estadistica_inicial();
}