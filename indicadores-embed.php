<?php

//include("pgconfig.php");
//include("geovisor.fn.php");
//include("indicadores.fn.php"); 
//include("./fn.php");

$_GET["ind_id"] = 6;

require_once(dirname(__FILE__).'/MICROSERVICIOS/MIC-GEOVISOR/CAPA-APLICACION/SERVICIOS/REPOSITORIO-SERVICIO.php');
require_once(dirname(__FILE__).'/MICROSERVICIOS/MIC-INDICADORES/CAPA-APLICACION/SERVICIOS/REPOSITORIO-SERVICIOS.php');


//$servicio_geovisor = new RepositorioServicioGeovisor();


?>


<!DOCTYPE html>
<html lang="es">
<head>
	
	<?php include("./scripts.analytics.php"); ?>

	<title>Indicadores</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
		
	<?php include("./scripts.default-indicadores.php"); ?>	
	<?php include("./scripts.indicadores.php"); ?>	
	<?php include("./scripts.openlayers.php"); ?>	
	<?php include("./scripts.highcharts.php"); ?>	
	<?php include("./scripts.onresize.php"); ?>	
	<?php include("./scripts.document_ready.indicadores.php"); ?>
	
	<?php // include("./scripts.default.php"); ?>
	
	
	
</head>
<body>

	<div style="display:none;">
		<?php include("./html.panel-indicadores.php"); ?>
	</div>
	
	<div id="page">
	
		<div style="display:none;">
			<?php include("./html.navbar-main.php"); ?>
			<?php include("./html.navbar-tools-indicadores.php"); ?>
		</div>
		
		<div class="page-container">
		
			<?php //include("./section.index.php"); ?>
			
			<div style="display:none;">
				<?php include("./html.navs.php"); ?>				
				<?php include("./html.nav.popup.php"); ?>
			</div>
			
			<div class="row jump-row">
				
				<div id="template-wrapper" class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="padding:5px;">
				
					
				
				</div>
				
			</div>
			
		</div>
		
	</div>
	
	<div class="jump-alert-modal"></div>
	
	<?php include("./popup.share.php"); ?>	
	<?php include("./popup.fmetodologica.php"); ?>	
	<?php // include("./widget-links.php"); ?>
	<?php include("./html.jalert.php"); ?>

</body>
</html>