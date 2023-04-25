<?php

require_once(dirname(__FILE__).'/MICROSERVICIOS/MIC-INDICADORES/CAPA-APLICACION/SERVICIOS/REPOSITORIO-SERVICIOS.php');

//include("./pgconfig.php");

//$_POST["ind_id"] = 6;

$ind_id = $_POST["ind_id"];

//$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
//$conn = pg_connect($string_conn);

//$query = pg_query($conn,$query_string);

//$data = pg_fetch_assoc($query);

$query_string = 'SELECT template_id FROM "MIC-INDICADORES".ind_panel WHERE ind_id = '. $ind_id;

$servicio_indicadores_template = new RepositorioServicioIndicadores();

$data = $servicio_indicadores_template->get_consulta($query_string);



$template_id = $data[0]["template_id"];

$query_string_2 = 'SELECT * FROM "MIC-INDICADORES".template WHERE template_id = '. $template_id;

//$query_2 = pg_query($conn,$query_string_2);
//$data_2 = pg_fetch_assoc($query_2);
//$file = file_get_contents($data_2["template_path"]);

//$servicio_indicadores_template = new RepositorioServicioIndicadores();

$data_2= $servicio_indicadores_template->get_consulta($query_string_2);

$file = file_get_contents($data_2[0]["template_path"]);

if ($file !== false && !empty($file)) {

	echo $file;

}/*else{
	
	echo "CADENA VACIA " . $data_2["template_path"];
	
}*/

?>