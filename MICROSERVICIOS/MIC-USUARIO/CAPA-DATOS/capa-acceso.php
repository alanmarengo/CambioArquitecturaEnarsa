<?php

//CREAR LA CLASE CONEXION CON SUS ATRIBUTOS Y PROPIEDADES CORRESPONDIENTES.

//CREAR LOS METODOS DE : CONECTAR() { PG_CONECT() }   Y DESCONECTAR(){ PG_DISPÓSE()}


class Conexion {
    private $host = "localhost";
    private $user = "postgres";
    private $pass = "37159252";
    private $port = "5432";
    private $database = "MIC-USUARIO";
    private $conect;

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
    }

    public function desconectar()// cierra la conexion creada. 
    {
        $this->conect = null;
    }

    public function get_consulta(string $query)
    {
        $consulta = $this->conect->query($query);
        $resultado = $consulta->fetchall(PDO::FETCH_ASSOC);
        $this->desconectar();
        return $resultado; // 
    }
}
?>