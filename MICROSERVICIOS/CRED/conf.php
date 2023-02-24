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

         // string conexion db_link host=iobs-02.ieasa.com.ar dbname=MIC-MEDIATECA  user=plataforma_readonly password=Plataforma100% port=5432
        $this->string_mic_mediateca = "host=$this->host_obs2  dbname=MIC-MEDIATECA  user=$this->user_readonly password=$this->pass_readonly port=5432";
        $this->string_mic_geovisores = "host=$this->host_obs2  dbname=MIC-GEOVISORES  user=$this->user_readonly password=$this->pass_readonly port=5432";
        $this->string_mic_estadisticas = "host=$this->host_obs2  dbname=MIC-ESTADISTICAS user=$this->user_readonly password=$this->pass_readonly port=5432";
    }
    
}


?>