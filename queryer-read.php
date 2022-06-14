<?php

include("./pgconfig.php");

$proyectos = $_POST["proyectos"];
$geovisor = $_POST["geovisor"];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$query_string = $_POST["q"];
		
$html = "<table>";

$query = pg_query($conn,$query_string);

$i = 0;

while ($r=pg_fetch_assoc($query)) {
	
	$html .= "<tr>";

	foreach ($r as $item => $value){
		
		if ($i==0) {
			$html .= "<th>" . str_replace("_"," ",$item) . "</th>";
		}else{
			$html .= "<td>" . $value . "</td>";
		}
		
	}
		
	$html .= "</tr>";
	
	$i++;

}

$html .= "</table>";

echo $html;

var_dump(pg_last_error($conn));