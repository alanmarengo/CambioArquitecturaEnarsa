<?php

interface IRepositorioQueryMediateca{
    public function get_recursos($lista_recursos_restringidos, $solapa, $current_page,$page_size,$order_by);
    public function get_cantidad_recursos_solapa($query, $solapa, $filtros, $extension_consulta_filtro_recursos);
    public function get_recursos_filtrado($lista_recursos_restringidos, $solapa, $current_page,$page_size,$qt,$desde,
                                          $hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$order_by);
    public function get_estadistica_inicial();
    public function get_estadistica_filtrado($aux_cadena_filtros,$extension_consulta_filtro_recursos);
    public function busqueda_mediateca($str_filtro_mediateca);
    public function noticias_mediateca();
}


