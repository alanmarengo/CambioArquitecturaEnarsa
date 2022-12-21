<!DOCTYPE html>
<html lang="es">
<head>
	
	<?php include("./scripts.analytics.php"); ?>

	<title>Geovisor</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
		
	<?php include("./scripts.default.php"); ?>
	<?php include("./scripts.highcharts.php"); ?>
	
	<script type="text/javascript">
	
		$(document).ready(function() {			
						
			jwindow = new Jump.window();
			jwindow.initialize();
			jwindow.setAllWindowsDraggable();
			jwindow.initMinimizing();
		
			Highcharts.chart('grafico', {
				chart: {
					type: 'timeline',
					backgroundColor: 'rgb(255,255,255)'
				},
				xAxis: {
					visible: false
				},
				yAxis: {
					visible: false
				},
				title: {
					text: ''
				},
				subtitle: {
					text: ''
				},
				series: [{
					data: [
						{
							name: '22/08/12',
							label: 'Se abre el llamado a licitación de las obras de los Aprovechamientos Hidroeléctricos del Río Santa Cruz.',
							description: ''
						},
						{
							name: '11/06/2013',
							label: 'Se adjudica la obra al consorcio Represas Patagonia, integrado por Gezhouba Group (China), Electroingeniería e Hidrocuyo.',
							description: ''
						},
						{
							name: '09/12/2015',
							label: 'Presentación del EsIA elaborado por el Contratista en Audiencia Pública provincial en Comandante Luis Piedra Buena, Santa Cruz.',
							description: ''
						},
						{
							name: '31/08/2016',
							label: 'Se aprueban las modificaciones en el proyecto: reducción de cota de NK, reducción en el número de turbinas, régimen de operación de JC y construcción de la LEAT.',
							description: ''
						},
						{
							name: '21/12/2016',
							label: 'Medida cautelar de la Corte Suprema de Justicia de la Nación suspende las obras principales hasta la realización de un estudio de impacto y audiencia pública en los términos de la Ley 23.879.',
							description: ''
						},
						{
							name: '20/07/2017 y 21/07/2017',
							label: 'Presentación del EsIA elaborado por Ebisa en Audiencia Pública en el Congreso Nacional, Buenos Aires, en el marco de la Ley 23.879.',
							description: ''
						},
						{
							name: '08/01/2018',
							label: 'Luego del levantamiento de la medida cautelar de la Corte se reinician las obras principales de los Aprovechamientos Hidroeléctricos del Río Santa Cruz. ',
							description: ''
						},
						{
							name: '20/02/2019',
							label: 'Presentación del EsIA de la Línea de Alta Tensión en Audiencia Pública en Comandante Luis Piedra Buena, Santa Cruz.',
							description: ''
						},
						{
							name: '09/2020',
							label: 'Inicio de obras de fortalecimiento en los estribos de la presa Néstor Kirchner como medida ante la sensibilidad mostrada ante las excavaciones.',
							description: ''
						},
						{
							name: '09/2021 y 04/2022',
							label: 'Consolidación del proyecto ejecutivo optimizado de las obras de Néstor Kirchner.',
							description: ''
						}
					]
				}]
			}).reflow();
		
		});
	
	</script>
	
</head>

<body style="width:100%; height:100%; overflow:hidden; background:white;">

	<div id="grafico" style="width:100%; height:100%;"></div>

</body>

</html>
