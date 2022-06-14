<?php include("./fn.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	
	<?php include("./scripts.analytics.php"); ?>

	<title>PROYECTO</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<?php include("./scripts.default.php"); ?>
	<?php include("./scripts.openlayers.php"); ?>	
	<?php include("./scripts.map.pdga.visor.php"); ?>
	<?php include("./scripts.onresize.php"); ?>

	<script type='text/javascript'>
	
		$(document).ready(function() {
	
			$("[title]").tooltipster({
				animation: 'fade',
				delay: 200,
				theme: 'tooltipster-default',
				trigger: 'hover'
			});					
		
			jwindow = new Jump.window();
			jwindow.initialize();
		
			geomap = new ol_map(<?php echo $_GET["tema_id"]; ?>);	
			geomap.map.create();
			
			scroll = new Jump.scroll();
			scroll.refresh();
			
		});
	
	</script>
	
	<style>
	
		#popup-results,#popup-results-preparse {
			
			display:none;
			
		}
		
	</style>
	
</head>
<body>

	<div id="page" style="background-color: #f4f4f4;" class="h100p">
		
		<div class="page-container h100p">
		
			<?php include("./section.page_geovisor_pdga_visor.php"); ?>
			
		</div>
		
	</div>
	
	<div id="popup-results"></div>	
	<div id="popup-results-preparse"></div>
	<?php include("./popup.baselayers.flotant.php"); ?>
	
	<?php include("./html.navbar-geovisor-zoom.php"); ?>
	
</body>
</html>