<?php

//namespace credenciales_dblink;

// clase de definicion de credenciales a bases de datos remotas 
class Conect_db_link{

    private $host_obs2 = 'iobs-02.ieasa.com.ar';
    private $user_readonly = 'plataforma_readonly';
    private $pass_readonly = 'Plataforma100%';
    public $string_conn_mic_mediateca = "";
    public $string_conn_mic_geovisores = "";
    public $string_conn_mic_estadisticas = "";


    public function __construct(){

         // string conexion db_link 
        $this->string_conn_mic_mediateca = "hostaddr=$this->host_obs2 dbname=MIC-MEDIATECA  user=$this->user_readonly password=$this->pass_readonly port=5432";
        $this->string_conn_mic_geovisores = "hostaddr=$this->host_obs2 dbname=MIC-GEOVISORES  user=$this->user_readonly password=$this->pass_readonly port=5432";
        $this->string_conn_mic_estadisticas = "hostaddr=$this->host_obs2 dbname=MIC-ESTADISTICAS user=$this->user_readonly password=$this->pass_readonly port=5432";
    }
    
}

// prueba implementacion 
/*
$test = new Conect_db_link();
echo $test->string_conn_mic_mediateca;
echo $test->string_conn_mic_geovisores;
echo $test->string_conn_mic_estadisticas; 
*/

?>