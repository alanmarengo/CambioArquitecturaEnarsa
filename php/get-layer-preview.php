<?php

include("../pgconfig.php");

$layer_id = $_POST["layer_id"];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$query_string = "SELECT clase_id,preview_titulo,preview_desc,preview_link FROM mod_geovisores.vw_layers WHERE layer_id = " . $layer_id;

$query = pg_query($conn,$query_string);

$data = pg_fetch_assoc($query);

?>

<p class="title" id="layer-preview-title"><?php echo $data["preview_titulo"]; ?></p>
<p class="content"><?php echo $data["preview_desc"]; ?></p>