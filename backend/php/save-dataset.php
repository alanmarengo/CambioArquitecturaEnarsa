<?php

include("../pgconfig.php");
include("../fn.php");
include("../fn.datasets.php");

header('Content-Type: application/json');

echo save_dt($_POST);

?>