<?php include("./fn.php"); ?>

<!DOCTYPE html>
<html lang="es" style="background-color: #f4f4f4 !important;">
<head>
	
	<?php include("./scripts.analytics.php"); ?>

	<style></style>

	<title>PROYECTO</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<?php include("./scripts.default.php"); ?>
	<?php include("./scripts.openlayers.php"); ?>	
	<?php include("./scripts.highcharts.php"); ?>	
	<?php include("./scripts.map.estaciones.php"); ?>
	<?php include("./scripts.onresize.php"); ?>

	<script src ="./js/geovisorredesbox.js" type='text/javascript'></script>
	<link rel="stylesheet" href="./css/geovisorredesbox.css" type="text/css">
	
</head>
<body style="height:auto;">

	<div class="container">
		<!--<p class="title">REGISTRO ESTADÍSTICO Y GRÁFICO DE LA RED DE MONITOREO HÍDRICO DE LA CUENCA DEL RÍO SANTA CRUZ</p>		-->

		<ul class="nav nav-tabs type2">
			<li class="active"><a class="btn-tab active show" data-toggle="tab" id="tab-redes-1" href="#panel-redes-1" aria-expanded="true" data-tab="1">MONITOREO HIDROAMBIENTAL</a></li>
			<li class="m0"><a class="btn-tab" data-toggle="tab" id="tab-redes-2" href="#panel-redes-2" aria-expanded="true" data-tab="2">MONITOREO HIDROSEDIMENTOLÓGICO</a></li>
		</ul>

		<div class="row mt-20">
			<div class="col col-md-4 col-lg-4">
				<div class="form-group">
					<label>Parámetro:</label>
					<select id="combo-parametros-redes"></select>
				</div>
			</div>
				<div class="col col-md-4 col-lg-4">
				<div class="form-group">
					<label>Desde:</label>
					<input type="text" class="datepicker" id="tab-redes-fdesde">
					<i class="fa fa-calendar-alt" style="cursor:pointer;" onclick="$(this).prev().focus();"></i>
				</div>
			</div>
			<div class="col col-md-4 col-lg-4">
				<div class="form-group">
					<label>Hasta:</label>
					<input type="text" class="datepicker" id="tab-redes-fhasta">
					<i class="fa fa-calendar-alt" style="cursor:pointer;" onclick="$(this).prev().focus();"></i>
				</div>
			</div>
		</div>

		<div class="row mt-20">
			
			<div class="form-group">
				<label>Seleccionar las estaciones (click para agregar/quitar, puede seleccionar hasta 5):</label>
			</div>
					
		</div>

		<div class="row est-switcher">

			<div class="col-md-6 col-lg-6">
				<div class="switcher-box">
					<div class="switcher-item header">ESTACIONES</div>
					<div id="estaciones-lista"></div>				
				</div>
			</div>

			<div class="col-md-6 col-lg-6">
				<div class="switcher-box">
					<div class="switcher-item header">SELECCIONADAS</div>
					<div id="estaciones-lista-seleccionadas"></div>
				</div>
			</div>

		</div>
		
		<!--<div class="row m0 mt-30">
			<a href="javascript:void(0);" class="btn-2" onclick="getData();">VER RESULTADOS</a>
		</div>-->

		<div class="row est-tabla m0 mt-20" id="est-tabla-inner">
			
			

		</div>

		<div class="row est-tabla m0 mt-20" id="est-chart-inner">
			
			

		</div>
		
		<div class="row mt-20">
			<div id="chart"></div>
		</div>
		
		<div class="row m0">
			<a href="./estadisticas.php?mode=1&cid=16" target="_blank" class="btn-2">VER DATOS COMPLETOS</a>
		</div>

	</div>

</body>
</html>