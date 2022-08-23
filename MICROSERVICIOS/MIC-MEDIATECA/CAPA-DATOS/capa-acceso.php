<?php

// clase para conexion a bd
class ConexionMediateca {
    private $host = "179.43.126.101"; 
    private $user = "postgres";
    private $pass = "plahe100%";
    private $port = "5432";
    private $database = "MIC-MEDIATECA";
    private $conect;
    public $string_con_mic_catalogo = "dbname=MIC-CATALOGO hostaddr=179.43.126.101 user=postgres password=plahe100% port=5432"; // string de conexion para uso en db link

    public function __construct()//instancia una nueva conexion
    {
        // pgsql:host=localhost;port=5432;dbname=testdb;   (ejemplo dns para pgsql )
        $string_conn = "pgsql:host=$this->host;port=$this->port;dbname=$this->database";
        
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

    public function get_consulta(string $query)// ejecuta una consulta que recibe por parametro
    {
        $consulta = $this->conect->query($query);
        $resultado = $consulta->fetchall(PDO::FETCH_ASSOC); // en este caso se define FETCH_ASSOC, 
                                                            // de manera que la consulta devuelva un array asociativo.            
        return $resultado; // 
    }
}

//$test = New ConexionMediateca(); // se instancia un nuevo objeto de conexion a la mediateca

// en caso de querer hacer uso de alguno de los metodos, se llaman a travez del operador  ->

// si se quisiera realizar una consulta

//$contenedor_respuesta = $test->get_consulta('Aqui iria la consulta a ejecutar');

// si se quisiera anular la conexion a la bd 

//$test->desconectar();

// si quisiera hacer uso de la query_string para db_link()

//$test->string_con_mic_catalogo; 


?>