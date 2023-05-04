<?php

//include("./pgconfig.php");
//$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;	
//$conn = pg_connect($string_conn);

require_once(dirname(__FILE__).'/MICROSERVICIOS/MIC-MEDIATECA/CAPA-APLICACION/SERVICIO/REPOSITORIO-SERVICIO.php');

$_GET['represa'] = 'NK';

// POST
$represa= $_GET['represa']; 

$servicio_mediateca = new RepositorioServicioMediateca();

$Array_recursos = $servicio_mediateca->carrusel_represas($represa);

// se devuelve el array en formato JSON 
echo json_encode($Array_recursos->detalle); 

/*

class Imagen{ // clase para guardar la info de las imagenes 
	var $recurso_id;
    var $recurso_desc;
    var $presa;
    var $recurso_path_url;
    var $recurso_fecha;
	var $formato_id;
 
	public function __construct($recurso_id,$recurso_desc,$presa,$recurso_path_url,$recurso_fecha,$formato_id){
	  $this->recurso_id=$recurso_id;
      $this->recurso_desc=$recurso_desc;
      $this->presa=$presa;
      $this->recurso_path_url=$recurso_path_url;
      $this->recurso_fecha=$recurso_fecha;
      $this->formato_id=$formato_id;
	}
 }

 //consulta filtrando por la represa 
$QUERY="SELECT * FROM mod_mediateca.fotos_proyectos as fp WHERE fp.presa = '$represa' ORDER BY fp.recurso_fecha DESC;";
$RESULT=pg_query($conn,$QUERY);


$Array_recursos=array(); // array contenedor 
while($row=pg_fetch_assoc($RESULT))
{   
    $aux_recurso_id = $row['recurso_id'];
    $aux_recurso_desc = $row['recurso_desc'];
    $aux_presa = $row['presa'];
    $aux_recurso_path_url = $row['recurso_path_url'];
    $aux_recurso_fecha = $row['recurso_fecha'];
    $aux_formato_id = $row['formato_id'];
    
    // se graba cada fila de la consulta en un objeto
    $record= new Imagen($aux_recurso_id, $aux_recurso_desc, $aux_presa, $aux_recurso_path_url, $aux_recurso_fecha, $aux_formato_id);
	array_push($Array_recursos,$record); // se agrega el objeto al array 
} */



?>



             