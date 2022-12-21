<?php

// clase de definicion de credenciales a bases de datos remotas 
class conect_db_link{

    private $host_obs2 = 'iobs-02.ieasa.com.ar';
    private $user_readonly = 'plataforma_readonly';
    private $pass_readonly = 'Plataforma100%';
    public $string_mic_mediateca = "";
    public $string_mic_geovisores = "";
    public $string_mic_estadisticas = "";


    public function __construct(){

         // string conexion db_link 
        $this->string_mic_mediateca = "dbname=MIC-MEDIATECA  user=$this->user_readonly password=$this->pass_readonly port=5432";
        $this->string_mic_geovisores = "dbname=MIC-GEOVISORES  user=$this->user_readonly password=$this->pass_readonly port=5432";
        $this->string_mic_estadisticas = "dbname=MIC-ESTADISTICAS user=$this->user_readonly password=$this->pass_readonly port=5432";
    }
    
}


?>