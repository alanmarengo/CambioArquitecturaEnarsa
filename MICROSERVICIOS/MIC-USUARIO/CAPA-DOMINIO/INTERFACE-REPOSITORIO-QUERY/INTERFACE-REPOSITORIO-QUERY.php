<?php

interface IRepositorioQueryUsuario{
    public function get_recursos_id();
    public function get_recursos_id_user($user_id);
    public function login($user_name,$user_pass);
}


