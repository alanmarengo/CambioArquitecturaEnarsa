<?php include("./fn.php"); ?>
<?php //include("./login.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>

	<title>Inicio</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php include("./scripts.default.php"); ?>
	<?php include("./scripts.default.ext_geovisor.php"); ?>
	<?php include("./scripts.openlayers.php"); ?>
	<?php include("./scripts.onresize.php"); ?>		
	<?php include("./scripts.document_ready.ext_geovisor.php"); ?>
	
</head>

<body>

	<div id="ext_map"></div>
	
	<div id="tools-baselayers" class="jump-posabs top-30 right-30">
		<div class="icon-36 alphalink" id="icon-baselayer">
			<img src="./images/icons/baselayers.png">
		</div>
	</div>
	<div id="tools-zoom" class="jump-posabs bottom-30 right-30">
		<div class="icon-container w-36">
			<div class="icon-36 alphalink" id="icon-zoom-layers">
				<img src="./images/icons/zoom_layers.png">
			</div>
			<div title="ACERCAR" class="icon-36 alphalink" onclick="ol_map.ol_object.getView().setZoom(ol_map.ol_object.getView().getZoom() + 1);">
				<img src="./images/icons/zoom_in.png">
			</div>
			<div title="ALEJAR" class="icon-36 alphalink" onclick="ol_map.ol_object.getView().setZoom(ol_map.ol_object.getView().getZoom() - 1);">
				<img src="./images/icons/zoom_out.png">
			</div>
		</div>
	</div>
	
</body>

</html>
