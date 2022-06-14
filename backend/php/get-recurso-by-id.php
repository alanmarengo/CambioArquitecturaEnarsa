<?php

include("../pgconfig.php");
include("../fn.grid.php");

header('Content-Type: application/json');

$recurso_id = $_POST["id"];

echo get_item_by_id("mod_mediateca.recurso","recurso_id",$recurso_id);

?>