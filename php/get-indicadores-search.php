<?php

include("../pgconfig.php");
include("../indicadores.fn.php");

$pattern = $_POST["pattern"];

echo DrawIndicadoresSearch($pattern);

?>