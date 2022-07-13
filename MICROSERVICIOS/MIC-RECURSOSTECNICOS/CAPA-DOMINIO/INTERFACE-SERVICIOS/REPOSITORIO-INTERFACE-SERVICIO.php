<?php


interface IRepositorioServicioRecursosTecnicos{
       public function get_recursos_tecnicos($lista_recursos_restringidos,$current_page,$page_size);
       public function get_recursos_tecnicos_filtrado($lista_recursos_restringidos, $current_page,$page_size,$qt,$desde,$hasta,$proyecto,$clase,$subclase,$tipo_doc,$filtro_temporalidad,$tipo_temporalidad);
}