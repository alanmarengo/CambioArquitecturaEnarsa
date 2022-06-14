<?php

header('Content-Type: application/json');


include("./pgconfig.php");

$origen_id         =  $_REQUEST['origen_id'];
$id                =  $_REQUEST['id'];

//$conn = pg_connect("host=localhost port=5432 dbname=ahrsc user=postgres password=plahe100%");

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

function limpiar($str)
{
	return str_replace(array("\n","\r","\""),'',$str);

};



/************************** CATEGORIA **********************************/
/*
	1 imagen 
	2 video 
	3 sonido
* */

$SQL_cat = "SELECT recurso_categoria_id FROM mod_catalogo.vw_catalogo_data WHERE origen_id=$origen_id AND origen_id_especifico=$id";

$recordset = pg_query($conn,$SQL_cat);

$row = pg_fetch_row($recordset);

Switch($row[0])
{
	case 20: $cat = 1; break; //IMAGEN
	case 39: $cat = 1; break; //IMAGEN
	case 21: $cat = 2; break; //VIDEO
	case 40: $cat = 2; break; //VIDEO
	case 41: $cat = 2; break; //VIDEO
	case 22: $cat = 2; break; //VIDEO
	case 42: $cat = 3; break; //SONIDO
	case 23: $cat = 3; break; //SONIDO
	default: $cat = 1; break;
	
};


/************************************************************/

$SQL = "SELECT * FROM mod_mediateca.get_ficha_recurso($origen_id, $id) T limit 1";

$recordset = pg_query($conn,$SQL);

$fflag = false;

$row = pg_fetch_row($recordset);

echo "{";
echo "\"origen_id\":\"$row[0]\","; 
echo "\"id\":\"$row[1]\","; 
echo "\"titulo\":\"".limpiar($row[2])."\",";
echo "\"temporal\":\"$row[3]\","; 
echo "\"autores\":\"".limpiar($row[4])."\","; 
echo "\"descripcion\":\"".limpiar($row[5])."\",";  
echo "\"estudio\":\"$row[6]\",";  
echo "\"linkvisor\":\"$row[7]\",";  
echo "\"linkdescarga\":\"$row[8]\",";  
echo "\"fecha\":\"$row[9]\",";  
echo "\"tema_subtema\":\"$row[10]\",";  
echo "\"proyecto\":\"$row[11]\",";  
echo "\"linkimagenes\":$row[12],";
echo "\"categoria_media\":\"$cat\",";  
echo "\"estudio_id\":\"$row[13]\""; 
echo "}";
/*

while($row)
{
  if ($fflag)
  {
      echo ',';
  }
  else
  {
      $fflag = true;
  };
  
  echo $row[0];
  
  $row = pg_fetch_row($recordset);//NEXT
};

echo "]";*/


/********************* LOG REQUEST **************************/

$req_ip = $_SERVER['REMOTE_ADDR'];

$SQL_REQUEST = "INSERT INTO mod_login.recursos_request(recursos_request_fecha, recursos_request_ip, recurso_id, user_id, recurso_origen_id)VALUES(now(),'$req_ip', $id, NULL,$origen_id);";

$recordset = pg_query($conn,$SQL_REQUEST);

pg_close($conn);

?>
