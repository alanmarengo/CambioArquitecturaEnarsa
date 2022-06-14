<?php


interface IRepositorioServicioUsuario{
    public function get_recursos_restringidos();
    public function get_recursos_restringidos_user($user_id);
}