<?php

error_reporting(0);

include("../pgconfig.php");
include("../fn.datasets.php");

header('Content-Type: application/json');

echo add_layer($_POST["dt_id"],$_POST["layer_id"]);

?>