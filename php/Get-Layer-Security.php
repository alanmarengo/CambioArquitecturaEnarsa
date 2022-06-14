<?php

include("../pgconfig.php");
include("../login.php");


if ((isset($_SESSION)) && (sizeof($_SESSION) > 0))
{
	$user_id = $_SESSION["user_info"]["user_id"];
}else $user_id = -1; 


$layer_id = $_GET["layer_id"];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$response=true;
$query_string = "SELECT (CASE WHEN mod_login.check_permisos_new(0, $layer_id, $user_id) THEN true ELSE false END) response";


$query = pg_query($conn,$query_string);
while($row=pg_fetch_row($query)){
    if($row[0]){
        $response=$row[0];
    }
   
   
}



echo $response;

?>