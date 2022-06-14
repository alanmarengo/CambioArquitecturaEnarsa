<?php include("./fn.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	
	<?php include("./scripts.analytics.php"); ?>

	<title>PROYECTO</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<?php include("./scripts.default.php"); ?>
	<?php include("./scripts.openlayers.php"); ?>	
	<?php include("./scripts.map.pdga.php"); ?>
	<?php include("./scripts.onresize.php"); ?>

	<script src ="./js/geovisorpdga.js" type='text/javascript'></script>
	
	<style>
	
		#popup-results,#popup-results-preparse {
			
			display:none;
			
		}
		
	</style>
	
</head>
<body style="overflow:hidden;">

	<div id="page" style="background-color: #f4f4f4;" class="h100p">
		
		<div class="page-container h100p">
		
			<?php include("./section.page_geovisor_pdga.php"); ?>
			
		</div>
		
	</div>
	
	<div id="popup-results"></div>	
	<div id="popup-results-preparse"></div>
	
</body>
</html>