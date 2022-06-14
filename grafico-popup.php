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
		
			var req = $.ajax({
				
				async:false,
				type:"POST",
				url:"./php/get-hs-series-default.php",
				success:function() {}
				
			});
			
			var js = JSON.parse(req.responseText);
		
			console.log(js);
		
			Highcharts.chart('grafico', {
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					type: 'pie',
					defaultSeriesType: 'areaspline'
				},
				title: {
					text: js.titulo
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b>: {point.percentage:.1f} %'
						}
					}
				},
				series: [{
					name: js.etiqueta,
					colorByPoint: true,
					data: js.series
				}]
			}).reflow();
		
		});
	
	</script>
	
</head>

<body style="width:100%; height:100%; overflow:hidden;">

	<div id="grafico" style="width:100%; height:100%;"></div>

</body>

</html>