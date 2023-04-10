<?php

require_once(dirname(__FILE__,3).'/CRED/conf.php');
 
// clase para conexion a bd 
class ConexionCatalogo {

    // para uso en el host
    private $host = "iobs-02.ieasa.com.ar";
    private $user = "plataforma_readonly";
    private $pass = "Plataforma100%";

    // para uso en local 
    //private $host = "localhost";
    //private $user = "postgres";
    //private $pass = "37159252";



    private $port = "5432";
    private $database = "MIC-CATALOGO";
    private $conect;
    public $obj_conexion_db_externas; // objeto de conexion con credenciales. 

    public function __construct()
    {
        // pgsql:host=localhost;port=5432;dbname=testdb;   (ejemplo dns para pgsql )
        $string_conn = "pgsql:host=" .$this->host.";port=".$this->port.";dbname=".$this->database;
        
        try 
        {
            $this->conect = new PDO($string_conn,$this->user,$this->pass); 
            $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // agrego estos atributos para poder ver el tipo de error si es que se presenta alguno 
            
        } catch(Exception $e){
            $this->conect = "Error en la conexion"; // si no es posible conectarse, mostrara el mensaje.
            echo "ERROR: ".$e->getMessage(); // y el tipo de error devuelto por la db.
        }

        $this->obj_conexion_db_externas = New conect_db_link();
    }

    public function desconectar()// cierra la conexion creada. 
    {
        $this->conect = null;
    }

    public function get_consulta(string $query)
    {
        $consulta = $this->conect->query($query);
        $resultado = $consulta->fetchall(PDO::FETCH_ASSOC);
        
        return $resultado; // 
    }
}

// se instancia una nueva conexion. 
 // $prueba_conexion = new ConexionCatalogo();
// $prueba_conexion->obj_conexion_db_externas->string_con_mic_mediateca; 

 // se realiza la o las consultas que se neseciten. se puede hacer mas de una por conexion. 
 // $prueba_conexion->get_consulta('aqui va la consulta a realizar');

 // y cuando no se realizaran mas consultas es aconsejable utilizar el metodo para destruir la clase. 
 // $prueba_conexion->desconectar();

 

?>