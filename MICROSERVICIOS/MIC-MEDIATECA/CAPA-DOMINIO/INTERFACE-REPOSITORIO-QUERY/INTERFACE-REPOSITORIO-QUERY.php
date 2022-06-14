<?php

interface IRepositorioQueryMediateca{
    public function get_recursos($lista_recursos_restringidos /* y va a recibir todos los filtros del front end */, $solapa);

}