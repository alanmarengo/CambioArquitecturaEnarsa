<?php

include("../pgconfig.php");
include("../fn.datasets.php");

header('Content-Type: application/json');

$grafico_id = $_POST["id"];

echo delete_grafico($grafico_id);

?>