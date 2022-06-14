<?php

include("../pgconfig.php");
include("../tools.php");

$query_string = "SELECT * FROM obra.ca_escombreras WHERE gid IN (10)";

$encrypted = encrypt($query_string);
$decrypted = decrypt($encrypted);

echo "<p> ENCRIPTADO " . $encrypted . "</p>";
echo "<p> DECRIPTADO " . $decrypted . "</p>";

?>