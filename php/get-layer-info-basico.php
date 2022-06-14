<?php

include("../pgconfig.php");

$results = $_POST["results"];

$results = explode(";",$results[0]);

$id_proyecto = $results[1];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$query_string = "SELECT proyecto_titulo,proyecto_desc FROM mod_geovisores.proyectos WHERE proyecto_id = " . $id_proyecto;

$query = pg_query($conn,$query_string);

$data = pg_fetch_assoc($query);

?>

<h1 id="layer-title"><?php echo $data["proyecto_titulo"]; ?></h1>

<p id="layer-desc"><?php echo $data["proyecto_desc"]; ?></p>