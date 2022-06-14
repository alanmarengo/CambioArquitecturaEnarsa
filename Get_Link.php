<?php
include("./pgconfig.php");
$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;	
$conn = pg_connect($string_conn);

$getId = $_GET['id'];

function GET_LINK($ID){
    $link;
    global $conn;
    $SQL="SELECT RRA.link FROM mod_catalogo.redireccion_recursos_asociados as RRA WHERE RRA.id =$ID";
    $RESULT=pg_query($conn,$SQL);
    while($obj= pg_fetch_object($RESULT)){
         $link=$obj->link;
    }
    return $link;
}

echo GET_LINK($getId)
?>