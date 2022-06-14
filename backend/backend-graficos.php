



<?php 

error_reporting(E_ERROR | E_WARNING | E_PARSE);

include("./fn.php"); 
include("./login.php"); 
include("./pgconfig.php"); 

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Inicio</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php //include("./scripts.default.php"); ?>
	<?php include("./scripts.default.backend.php"); ?>
	<?php include("./scripts.onresize.php"); ?>
	<?php include("./scripts.document_ready.php"); ?>
	
	<script type="text/javascript" src="./js/backend-conf.js"></script>
	
</head>
<body>
	<div id="index">
		<div class="page-container">
			<?php include("./header.php"); ?>
			<?php include("./section.backend.graficos_observ.php"); ?>
			<?php include("./footer.php"); ?>
		</div>
	</div>	

	<script type="text/javascript" src="./js/jsgrid/jsgrid.min.js"></script>


</body>
</html>
