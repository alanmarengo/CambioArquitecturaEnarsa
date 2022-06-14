<?php

include("./pgconfig.php");
include("./tools.php");

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=file.csv");

$dtid = pg_escape_string($_REQUEST["dt_id"]);

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$query_string = "SELECT dt_tabla FROM sinia_dataset.dt WHERE dt_id=$dtid limit 1"; /* Obtener la tabla de datos */

$recordset = pg_query($conn,$query_string);

$row = pg_fetch_row($recordset);

$csv_table = "SELECT * FROM ".$row[0]; /* Query con la tabla del dataset */

$recordset = pg_query($conn,$csv_table);

$csv = parseSQLToCSV($recordset); /* trasnformar a CSV */

echo $csv;

pg_close($conn);

?>
