<?php

include("../pgconfig.php");
include("../fn.datasets.php");

header('Content-Type: application/json');

$dt_id = $_POST["id"];

echo delete_dt($dt_id);

?>