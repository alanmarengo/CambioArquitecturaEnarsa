<?php

include("../pgconfig.php");
include("../stats.fn.php");

$dt_id = $_POST["dt_id"];

echo ComboCruce($dt_id);

?>