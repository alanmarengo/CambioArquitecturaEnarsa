<?php

include("../pgconfig.php");
include("../fn.datasets.php");

header('Content-Type: application/json');

get_grilla_coberturas();

?>