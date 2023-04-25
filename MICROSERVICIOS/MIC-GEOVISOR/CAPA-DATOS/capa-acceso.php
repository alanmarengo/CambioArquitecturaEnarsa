<?php

require_once(dirname(__FILE__,3).'/CRED/conf.php');

// clase para conexion a bd
class ConexionGeovisores {
    
    private $host = "iobs-02.ieasa.com.ar"; 
    private $user = "plataforma_readonly";
    private $pass = "Plataforma100%";
    private $port = "5432";
    private $database = "MIC-GEOVISORES";
    private $conect;
    // public $obj_conexion_db_externas; // objeto de conexion con credenciales. 

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

        // $this->obj_conexion_db_externas = New conect_db_link();

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

    public function get_consulta_ahrsc($query_string)
    {   
        $host_ahrsc = "iobs-02.ieasa.com.ar"; 
        $user_ahrsc = "postgres";
        $pass_ahrsc = "obs@ieasa";
        $port_ahrsc = "5432";
        $database_ahrsc = "ahrsc";
        //$conect;
        $conexion_ahrsc = pg_connect("host=$host_ahrsc dbname=$database_ahrsc user=$user_ahrsc password=$pass_ahrsc");

        if($conexion_ahrsc)
        {
            
            $query_ahrsc = pg_query($conexion_ahrsc, $query_string);

            $datos = pg_fetch_all($query_ahrsc);

            return $datos;

        }else{

            return "No se pudo conectar con la DB.";
        }

    }


}

 // $prueba_conexion = new ConexionGeovisores();
//$prueba_conexion->get_consulta_ahrsc();

?>