<?php

include("../pgconfig.php");
include("../fn.datasets.php");

header('Content-Type: application/json');

$grafico_id = $_POST["id"];

echo get_grafico_by_id($grafico_id);

?>