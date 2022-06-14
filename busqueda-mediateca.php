<?php
header('Content-Type: application/json');
include("./pgconfig.php");

class Coincidencia{
	var $alias;
	var $palabra_clave;
 
	public function __construct($alias,$palabra_clave){
	  $this->alias=$alias;
	  $this->palabra_clave=$palabra_clave;
	}
 }

$filtro=$_REQUEST['FiltroMediateca'];
$sql="  SELECT ARC.alias_filtro,ARC.palabra_clave
        FROM mod_mediateca.alias_recursos_clave as ARC
        WHERE unaccent(LOWER(ARC.alias_filtro)) LIKE unaccent('%$filtro%')
        ORDER BY ARC.alias_filtro ASC";


$coincidencias= Array();
$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
$conn = pg_connect($string_conn);
$SQLJSON = "SELECT row_to_json(H)::text AS r FROM ($sql)H";
    $RESULT=pg_query($conn,$SQLJSON);
	while($row=pg_fetch_row($RESULT)){
		$Objeto=json_decode($row[0]);
		//$coincidencia=new Coincidencia($Objeto->recurso_titulo,$Objeto->ico);
		array_push($coincidencias,new Coincidencia($Objeto->alias_filtro,$Objeto->palabra_clave));
	}

echo json_encode($coincidencias);
?>