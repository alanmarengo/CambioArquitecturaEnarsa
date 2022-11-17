<?php

interface IRepositorioServicioUsuario{
    public function get_recursos_restringidos();
    public function get_recursos_restringidos_user($user_id);
    public function login($user_name,$user_pass);
}


