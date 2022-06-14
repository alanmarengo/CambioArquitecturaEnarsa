<?php

include("../pgconfig.php");
include("../fn.grid.php");

header('Content-Type: application/json');

echo get_grilla($_POST,"mod_mediateca.recurso");
//echo get_grilla($_POST,"mod_mediateca.vw_recurso_backend");

?>
