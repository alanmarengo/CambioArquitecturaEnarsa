<?php

include("../pgconfig.php");
include("../fn.php");

$cid = $_POST["cid"];

echo ComboSubclase($cid);

?>