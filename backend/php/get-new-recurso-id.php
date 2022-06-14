<?php

include("../pgconfig.php");
include("../fn.grid.php");

header('Content-Type: application/json');

echo get_new_id("mod_mediateca.recurso","recurso_id",array("recurso_titulo"),array("''"));

?>