<?php

interface IRepositorioQueryRecursosTecnicos{

    public function get_recursos_tecnicos($lista_recursos_restringidos,$current_page,$page_size,$order_by);

    public function get_recursos_tecnicos_filtrado($lista_recursos_restringidos, $current_page,$page_size,
                                                   $qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,
                                                   $filtro_temporalidad,$tipo_temporalidad,$order_by);

    public function get_estadistica_recursos_tecnicos($lista_recursos_restringidos,$qt,$desde,$hasta,$proyecto,
                                                      $clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad,
                                                      $si_tengo_que_filtrar,$calculo_estadistica);
}

