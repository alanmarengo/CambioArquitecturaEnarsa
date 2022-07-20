<?php

interface IRepositorioServicioMediateca{
    
    public function get_Recursos($lista_recursos_restringidos, $solapa, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,$si_tengo_que_filtrar,$calculo_estadistica);

}

?>