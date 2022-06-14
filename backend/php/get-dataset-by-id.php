<?php

include("../pgconfig.php");
include("../fn.datasets.php");

header('Content-Type: application/json');

$dt_id = $_POST["id"];

echo get_dataset_by_id($dt_id);

?>