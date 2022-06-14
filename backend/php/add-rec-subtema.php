<?php

error_reporting(0);

include("../pgconfig.php");
include("../fn.datasets.php");

header('Content-Type: application/json');

echo add_rec_subtema($_POST["recurso_id"],$_POST["subtema_id"]);

?>