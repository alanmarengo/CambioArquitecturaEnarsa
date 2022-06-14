<?php

include("../pgconfig.php");
include("../fn.php");
include("../fn.grid.php");

//header('Content-Type: application/json');

echo save_item($_POST,"mod_mediateca.recurso");

?>