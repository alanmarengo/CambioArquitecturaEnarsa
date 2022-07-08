<?php

interface IRepositorioQueryRecursosTecnicos{
    public function get_recursos_tecnicos($lista_recursos_restringidos,$current_page,$page_size);
}