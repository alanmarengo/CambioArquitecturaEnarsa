<?php // include("./pgconfig.php"); ?>
<?php // include("./fn.php"); ?>
<?php // include("./geovisor.fn.php"); ?>
<?php // include("./login.php"); ?>

<?php 

require_once(dirname(__FILE__).'/MICROSERVICIOS/MIC-GEOVISOR/CAPA-APLICACION/SERVICIOS/REPOSITORIO-SERVICIO.php');


$servicio_geovisor_print = new RepositorioServicioGeovisor();



?>

<!DOCTYPE html>
<html lang="es" style="background-color:white !Important;">
<head>
	
	<?php include("./scripts.analytics.php"); ?>

	<title>Inicio</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
		
	<?php include("./scripts.default.php"); ?>
	<?php include("./scripts.onresize.php"); ?>		
	
	<?php include("./scripts.document_ready.php"); ?>
	
	<style>
		
		.header {
			
			display: flex;
			align-content: center;
			align-items: center;
			justify-content: space-between;
			
		}
		
		.legends img {
			
			max-width:100%;
			
		}
	
	</style>
	
</head>
<body style="background-color:white !Important;">

	<div id="page">
		
		<div class="page-container" style="background-color: #FFFFFF !important; width:1024px;">
			
			<div class="header">
				<!-- Aca cambiar link a la imagen que se podra en reemplazo a la actual  -->
 				<img src="./images/print-header.png" style="margin:10px 0; padding:10px;">
				<a href="#" id="icon-print" onclick="this.style.display='none'; window.print(); this.style.display=''; " style="font-size:24px; color:black; float:right; position: relative; right: 10px;">
				
					<i class="fa fa-print"></i>
					
				</a>
			
			</div>
			
			<div style="margin:10px 0; padding:10px;">
				<img src="<?php echo $_POST["imageblob"]; ?>" width="100%">
			</div>
			
			<div style="margin:10px 0; padding:10px;" class="legends">
				<?php 
					$legends = $_POST["layers"];
					$legends = explode(",",$legends);
					
					for ($i=0; $i<sizeof($legends); $i++) {
						
						if (!empty($legends[$i])) {
						
							/* $image = "https://observatorio.ieasa.com.ar/geoserver/ows?&version=1.3.0&service=WMS&request=GetLegendGraphic&sld_version=1.1.0&layer=".$legends[$i]."&format=image/png&"; */
						$image = "https://observatorio.energia-argentina.com.ar/geoserver/ows?&version=1.3.0&service=WMS&request=GetLegendGraphic&sld_version=1.1.0&layer=".$legends[$i]."&format=image/png&";
							
						?>
						
							<p><?php 
								$result_get_layer_name = $servicio_geovisor_print->GetLayerLabel($legends[$i]);
								
								if($result_get_layer_name->flag)
								{
									echo $result_get_layer_name->detalle;
								}
								
								?></p>
							<p><img src="<?php echo $image; ?>"></p>
							<hr>
						
						<?php
						
						}
						
					}
					
				?>
				
			</div>
			
			
		</div>
		
	</div>

</body>
</html>