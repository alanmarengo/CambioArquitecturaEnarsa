<?php

error_reporting(0);

include("../pgconfig.php");
include("../fn.datasets.php");

header('Content-Type: application/json');

get_grilla_graficos($_POST["busqueda"]);

?>