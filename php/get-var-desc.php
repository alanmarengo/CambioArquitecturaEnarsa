<?php

include("../pgconfig.php");

$var_name = $_POST["var_name"];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$query_string = "SELECT * FROM mod_estadistica.vw_variables WHERE dt_variable_nombre = '" . $var_name . "'";

$query = pg_query($conn,$query_string);

$data = pg_fetch_assoc($query);

echo "<p><strong>VARIABLE: " . $data["dt_variable_nombre"] . "</strong></p>";
echo "<p>" . $data["dt_variable_defincion"] . "</p>";

?>