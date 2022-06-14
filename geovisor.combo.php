<?php include("./fn.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	
	<?php include("./scripts.analytics.php"); ?>

	<style>
	
	#uxVisor {
	
		position: absolute !important;
		z-index: 999 !important;
		padding: 20px !important;
		background:white;
		left: 30px;
		top: 30px;
		display:none !important;

	}
	
	#uxCapa {
	
		position: absolute;
		z-index: 899;
		padding: 20px;
		background:white;
		left: 30px;
		top: 60px;
		width:340px;
		font-size:12px;
		display:none;
		max-height: 300px;
		overflow-y: auto;

	}
	
	/*.bootstrap-select {
		
		width: 340px;
		position: absolute;
		z-index: 999;
		top: 10px;
		left: 10px;
		
	}*/
	
	.bootstrap-select {
		width: 340px !Important;
		height: 20px !Important;
		position: relative !Important;
		z-index: 999 !Important;
		top: 20px !Important;
		left: 30px !Important;
	}
		
	</style>

	<title>PROYECTO</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<?php include("./scripts.default.php"); ?>
	<?php include("./scripts.openlayers.php"); ?>	
	<?php include("./scripts.map.combo.php"); ?>
	<?php include("./scripts.onresize.php"); ?>

	<script src ="./js/geovisorcombo.js" type='text/javascript'></script>
	
</head>
<body style="overflow:hidden;">

	<div id="page" style="background-color: #f4f4f4;" class="h100p">
		
		<div class="page-container h100p">
		
			<?php include("./section.page_geovisor_combo.php"); ?>
			
		</div>
		
	</div>	
	
	<?php include("./html.navbar-geovisor-zoom.php"); ?>
	<?php include("./popup.baselayers.flotant.php"); ?>
	
	<div id="popup-combo">
		<div id="popup-combo-body" class="jump-posrel jump-scroll"></div>
		<div id="popup-combo-caret">
			<div class="inner"></div>
		</div>
	</div>
	<div id="popup-results-preparse"></div>
	<div id="popup-results"></div>

</body>
</html>