<?php

include("../pgconfig.php");
include("../fn.datasets.php");

header('Content-Type: application/json');

echo get_new_dt_id();

?>