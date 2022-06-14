<!DOCTYPE html>
<html lang="es">
<head>
	
	<?php include("./scripts.analytics.php"); ?>

	<title>Geovisor</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
		
	<?php include("./scripts.default.php"); ?>
	<?php include("./scripts.openlayers.php"); ?>
	<?php include("./scripts.map.php"); ?>	
	
	<script type="text/javascript">
	
		$(document).ready(function() {			
						
			jwindow = new Jump.window();
			jwindow.initialize();
			jwindow.setAllWindowsDraggable();
			jwindow.initMinimizing();			
			
			geomap = new ol_map();
		
			geomap.map.create();
			geomap.map.createLayers();
		
		});
		
		
	
	</script>
	
</head>

<body style="overflow:hidden;">
		
	<div id="map" style="width:100%; height:100%;"></div>
	<?php include("./popup.baselayers.php"); ?>
	<?php include("./html.navbar-geovisor-zoom.php"); ?>

</body>

</html>