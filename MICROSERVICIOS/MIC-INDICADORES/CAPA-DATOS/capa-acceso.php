<?php

// importacion de archivo de credenciales para uso de db_link()
require_once(dirname(__FILE__,3).'\CRED\conf.php');

// clase para conexion a bd
class ConexionIndicadores {

    private $host = "179.43.126.101";    
    private $pass = "plahe100%";
    private $user = "postgres";
    private $port = "5432";
    private $database = "MIC-INDICADORES";
    private $conect;    
    public $obj_conexion_db_externas; // objeto de conexion con credenciales. 

    public function __construct() // crea una nueva instancia de conexion
    {

        // pgsql:host=localhost;port=5432;dbname=testdb;   (ejemplo string conect para pgsql )
        $string_conn = "pgsql:host=" .$this->host.";port=".$this->port.";dbname=".$this->database;
        
        try 
        {
            $this->conect = new PDO($string_conn,$this->user,$this->pass); 
            $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // agrego estos atributos para poder ver el tipo de error si es que se presenta alguno 
            
        } catch(Exception $e){
            $this->conect = "Error en la conexion"; // si no es posible conectarse, mostrara el mensaje.
            echo "ERROR: ".$e->getMessage(); // y el tipo de error devuelto por la db.
        }

        
        // se importa el objeto con las credenciales definidas,
        // y el objeto ConexionIndicadores podra hacer uso de las credenciales. 
        $this->obj_conexion_db_externas = New conect_db_link();

    }
    public function desconectar()// cierra la conexion creada. 
    {
        $this->conect = null;
    }
    public function get_consulta(string $query)// ejecuta una consulta, la cual recibe por parametro
    {
        $consulta = $this->conect->query($query);
        $resultado = $consulta->fetchall(PDO::FETCH_ASSOC);
        //$this->desconectar();
        return $resultado; // 
    }
}

//$prueba_conexion = new ConexionIndicadores();
//$prueba_conexion->obj_conexion_db_externas->string_con_mic_catalogo;

?>