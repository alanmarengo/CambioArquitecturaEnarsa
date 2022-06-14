<?php

include("../pgconfig.php");
include("../geovisor.fn.php");

$pattern = $_POST["pattern"];

echo DrawDatasetSearch($pattern);

?>