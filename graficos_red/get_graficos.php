<html>
<head>

<script src="../js/jquery-3.2.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<link href="https://fonts.googleapis.com/css?family=Dosis:400,600" rel="stylesheet">
<script src="../js/highcharts.theme.js"></script>
<script type="text/javascript">

	$(document).ready(function() {
		
		Highcharts.setOptions({
			lang: {
				contextButtonTitle:"Menu Contextual",
				viewFullscreen:"Pantalla Completa",
				printChart:"Imprimir Gráfico",
				downloadPNG:"Descargar PNG",
				downloadJPEG:"Descargar JPG",
				downloadPDF:"Descargar PDF",
				downloadSV:"Descargar SVG"
			}
		});
		
	});

</script>

<?php

include("../pgconfig.php");

function clear_json($str) 
{
	
	$bad = array("\n","\r","\"");
	
	$good = array("","","");
	
	return str_replace($bad,$good,$str);
	
};

$mode 					= $_REQUEST["mode"];

$estacion_id			= clear_json(pg_escape_string($_REQUEST["estacion_id"]));
$parametro_id			= clear_json(pg_escape_string($_REQUEST["parametro_id"]));
$tipo_estacion_id 		= clear_json(pg_escape_string($_REQUEST["tipo_estacion_id"]));
$solapa 				= clear_json(pg_escape_string($_REQUEST["solapa"]));
$categoria_parametro_id = clear_json(pg_escape_string($_REQUEST["categoria_parametro_id"]));

function get_curva_hq($estacion_id)
{
	/*
	 * alt_escala el parámetro de altura del río
	 * Q1_tot_m3s para caudal líquido
	 * */
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string    = "select estacion_id,tipo_estacion_id,P.parametro_tabla ";
	$query_string   .= "from ";
	$query_string   .= "mod_sensores.red_estacion_parametro P ";
	$query_string   .= "inner join ";
	$query_string   .= "mod_sensores.red_categoria_parametro C ON C.categoria_parametro_id=P.categoria_parametro_id ";
	$query_string   .= "WHERE C.tipo_estacion_id=5 AND estacion_id=$estacion_id limit 1;";
	
	$query = pg_query($conn,$query_string);
	
	$r = pg_fetch_assoc($query);
	
	$tabla = $r['parametro_tabla'];
	
	$query_string_base   = "(SELECT alt_escala AS altura,ql_tot_m3s AS caudal,
					   (select descripcion from mod_catalogo.cod_temporalidad where cod_temporalidad_id::bigint=D.cod_temporalidad_id::bigint LIMIT 1) AS campaña
					   FROM $tabla D WHERE alt_escala IS NOT NULL AND ql_tot_m3s IS NOT NULL ORDER BY campaña ASC)";
	
	$query_string   = "SELECT 
						c.*,
						CONCAT('01-',REPLACE(
							REPLACE(
								REPLACE(
									REPLACE(
										REPLACE(
											REPLACE(
												REPLACE(
													REPLACE(
														REPLACE(
															REPLACE(
																REPLACE(
																	REPLACE(
																		c.campaña,'ene-','01-20'
																	),'feb-','02-20'
																),'mar-','03-20'
															),'abr-','04-20'
														),'may-','05-20'
													),'jun-','06-20'
												),'jul-','07-20'
											),'ago-','08-20'
										),'sep-','09-20'
									),'oct-','10-20'
								),'nov-','11-20'
							),'dic-','12-20'
						))
					FROM $query_string_base c
					ORDER BY CONCAT('01-',REPLACE(
							REPLACE(
								REPLACE(
									REPLACE(
										REPLACE(
											REPLACE(
												REPLACE(
													REPLACE(
														REPLACE(
															REPLACE(
																REPLACE(
																	REPLACE(
																		c.campaña,'ene-','01-20'
																	),'feb-','02-20'
																),'mar-','03-20'
															),'abr-','04-20'
														),'may-','05-20'
													),'jun-','06-20'
												),'jul-','07-20'
											),'ago-','08-20'
										),'sep-','09-20'
									),'oct-','10-20'
								),'nov-','11-20'
							),'dic-','12-20'
						)):: DATE ASC";
	
	//echo $query_string_base;

	$query = pg_query($conn,$query_string);
	
	//echo pg_last_error($conn);
	
	$entered = false;
	
	$data = '[';
	
	$cat = '';
	
	$flag = false;
		
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$alt = $r['altura'];
		$cau = $r['caudal'];
		
		if($cat!=$r['campaña'])
		{
				$cat 	= $r['campaña'];
				if ($flag)
				{
					$data .= "]},";
				}else $flag = true;
				
				$color = '#'.substr(str_shuffle('ABCDEF0123456789'), 0, 6);
				
				$data .= "{name:'$cat', color:'$color' ,data: ["; //rgba(223, 83, 83, .5)
		}
		else
		{
			$data .= ",";
		};
		
		$data .= "[$cau,$alt]";

	};
	
	$data .= ']}]';
		
	pg_close($conn);
		
	$grafico = "
	function loadgrafico()
	{
					
			Highcharts.chart('container', {
				chart: {
					type: 'scatter',
					zoomType: 'xy'
				},
				title: {
					text: ''
				},
				subtitle: {
					text: ''
				},
				xAxis: {
					title: {
						enabled: true,
						text: 'Caudal (m3s)' 
					},
					startOnTick: true,
					endOnTick: true,
					showLastLabel: true
				},
				yAxis: {
					title: {
						text: 'Altura del río' 
					}
				},
				legend: {
					layout: 'horizontal',/*vertical*/
					align: 'center',/*left*/
					verticalAlign: 'bottom',/*top*/
					x: 0, /*100*/
					y: 0,  /*70*/
					floating: false,/*true*/
					backgroundColor: Highcharts.defaultOptions.chart.backgroundColor,
					borderWidth: 1
				},
				plotOptions: {
					scatter: {
						marker: {
							radius: 5,
							states: {
								hover: {
									enabled: true,
									lineColor: 'rgb(100,100,100)'
								}
							}
						},
						states: {
							hover: {
								marker: {
									enabled: false
								}
							}
						},
						tooltip: {
							headerFormat: '<b>{series.name}</b><br>',
							pointFormat: '{point.x} Caudal, {point.y} Altura'
						}
					}
				},
				series: $data
			});
	};
	
	Highcharts.setOptions({
		lang:{
			viewFullscreen:\"Pantalla Completa\",
			printChart:\"Imprimir\",
			downloadCSV:\"Descargar en CSV\",
			downloadJPEG:\"Descargar en JPG\",
			downloadPDF:\"Descargar en PDF\",
			downloadPNG:\"Descargar en PNG\",
			downloadSVG:\"Descargar en SVG\",
			downloadXLS:\"Descargar en XLS\",
			viewData:\"Ver Tabla de Datos\"
		}
	});
	
	";
	echo $grafico; 
	
	
};



function get_estacion_parametro_grafico_30_dias($estacion_id,$categoria_parametro_id,$parametro_id)
{
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string   = "SELECT * FROM mod_sensores.get_estacion_parametro_grafico_30_dias($estacion_id,$categoria_parametro_id,$parametro_id,30) ";
	$query_string  .= "ORDER BY fecha ASC;";

	$query = pg_query($conn,$query_string);
	
	//echo pg_last_error($conn);
	
	$entered = false;
	
	$categorias = '[';
	$serie_min  = '[';
	$serie_max  = '[';
	$serie_med  = '[';
	
	$parametro_nombre = '';
	
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$categorias .= "'".$r['dia']."',";
		$serie_min	.= $r['min_dato'].",";
		$serie_max	.= $r['max_dato'].",";
		$serie_med	.= $r['med_dato'].",";
		
		$parametro_nombre = $r["parametro_nombre"];

		$entered = true;
	};
	
	if($entered) 
	{
		$categorias 	= substr($categorias,0,strlen($categorias)-1);
		$serie_min 		= substr($serie_min,0,strlen($serie_min)-1);
		$serie_max 		= substr($serie_max,0,strlen($serie_max)-1);
		$serie_med 		= substr($serie_med,0,strlen($serie_med)-1);
	};
	
	$categorias .= ']';
	$serie_min	.= ']';
	$serie_max	.= ']';
	$serie_med	.= ']';
	
	preg_match('/\([a-zA-Z0-9°º]{1,}\)/',$parametro_nombre, $parametro_unidad);
		
	$parametro_unidad = $parametro_unidad[0];
	
	
	pg_close($conn);
		
	$grafico = "
	function loadgrafico()
	{
		Highcharts.chart('container', 
		{

		title: { text: '$parametro_nombre - Datos de los últimos 30 días' },
		legend: { itemDistance: 50 },
		yAxis: {
				title: {
						text: 'Valores en $parametro_unidad'
						}
				},
		xAxis: { categories: $categorias },

		series: 
		[
			{
			 name:'Minimo',
			 data: $serie_min
			}, 
			{
			 name:'Maximo',
			 data: $serie_max
			}, 
			{
			 name:'Promedio',
			 data: $serie_med
			}
		]
		});
	};
	";
	
	echo $grafico; 
	
	
};


function get_estacion_lluvias_grafico_30_dias($estacion_id,$categoria_parametro_id,$parametro_id)
{
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string   = "SELECT * FROM mod_sensores.get_estacion_lluvias_grafico_30_dias($estacion_id,$categoria_parametro_id,$parametro_id,30) ";
	$query_string  .= "ORDER BY fecha ASC;";

	$query = pg_query($conn,$query_string);
	
	//echo pg_last_error($conn);
	
	$entered = false;
	
	$categorias = '[';
	$serie_min  = '[';
	$serie_max  = '[';
	$serie_med  = '[';
	$serie_sum_dia = '[';
	$serie_acomulado = '[';
	
	$acum = (float)0.0;
	
	$parametro_nombre = '';
	
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$categorias .= "'".$r['dia']."',";
		$serie_min	.= $r['min_dato'].",";
		$serie_max	.= $r['max_dato'].",";
		$serie_med	.= $r['med_dato'].",";
		$serie_sum_dia	.= (float)$r['sum_dato'].",";
		
		$acum = $acum + (float)$r['sum_dato'];
		
		$serie_acomulado	.= $acum.",";
		
		$parametro_nombre = $r["parametro_nombre"];

		$entered = true;
	};
	
	if($entered) 
	{
		$categorias 	= substr($categorias,0,strlen($categorias)-1);
		$serie_min 		= substr($serie_min,0,strlen($serie_min)-1);
		$serie_max 		= substr($serie_max,0,strlen($serie_max)-1);
		$serie_med 		= substr($serie_med,0,strlen($serie_med)-1);
		$serie_sum_dia 		= substr($serie_sum_dia,0,strlen($serie_sum_dia)-1);
		$serie_acomulado 		= substr($serie_acomulado,0,strlen($serie_acomulado)-1);
	};
	
	$categorias .= ']';
	$serie_min	.= ']';
	$serie_max	.= ']';
	$serie_med	.= ']';
	$serie_sum_dia .= ']';
	$serie_acomulado .= ']';
	
	preg_match('/\([a-zA-Z0-9°º]{1,}\)/',$parametro_nombre, $parametro_unidad);
		
	$parametro_unidad = $parametro_unidad[0];
	
	
	pg_close($conn);
		
	$grafico = "
	function loadgrafico()
	{
			Highcharts.chart('container', {
				chart: {
					zoomType: 'xy'
				},
				title: {
					text: 'PRECIPITACIÓN ACUMULADA DIARIA'
				},
				subtitle: {
					text: ''
				},
				xAxis: [{
					categories: $categorias,
					crosshair: true
				}],
				yAxis: [{ // Primary yAxis
					type:'number',
					labels: {
						format: '{value} mm',
						style: {
							color: Highcharts.getOptions().colors[1]
						}
					},
					title: {
						text: 'Total acumulado del día',
						style: {
							color: Highcharts.getOptions().colors[1]
						}
					}
				}, { // Secondary yAxis
					type:'number',
					title: {
						text: 'Lluvias acumuladas',
						style: {
							color: Highcharts.getOptions().colors[0]
						}
					},
					labels: {
						format: '{value} mm',
						style: {
							color: Highcharts.getOptions().colors[0]
						}
					},
					opposite: true
				}],
				tooltip: {
					shared: true
				},
				legend: {
					layout: 'vertical',
					align: 'left',
					x: 120,


					verticalAlign: 'top',
					y: 100,
					floating: true,
					backgroundColor:
						Highcharts.defaultOptions.legend.backgroundColor || // theme
						'rgba(255,255,255,0.25)'
				},
				series: [{
					name: 'Total precipitación diaria',
					type: 'column',
					yAxis: 0,
					data: $serie_sum_dia,
					tooltip: {
						valueSuffix: ' mm'
					}

				}, {
					name: 'Acumulado',
					type: 'spline',
					yAxis: 0,
					data: $serie_acomulado,
					tooltip: {
						valueSuffix: ' mm'
					}
				}]
			});
	};/*Fin load*/
	";
	
	echo $grafico; 
	
	
};



?>

<script>
		<?php
		
		switch ($mode) 
		{
			case 0:
				//http://observ.net/graficos_red/get_graficos.php?estacion_id=7&categoria_parametro_id=4&parametro_id=1&mode=0
				if($parametro_id!=16)/* Todos menos precipitaciones */
				{
					get_estacion_parametro_grafico_30_dias($estacion_id,$categoria_parametro_id,$parametro_id);
				}
				else
				{
					get_estacion_lluvias_grafico_30_dias($estacion_id,$categoria_parametro_id,$parametro_id);
				};
			break;
			case 1:
				//http://observ.net/graficos_red/get_graficos.php?estacion_id=7&categoria_parametro_id=4&parametro_id=1&mode=0
				get_estacion_lluvias_grafico_30_dias($estacion_id,$categoria_parametro_id,$parametro_id);
			break;
			case 2:
				//http://observ.net/graficos_red/get_graficos.php?estacion_id=9&mode=2
				get_curva_hq($estacion_id);
			break;
		
		};
		
		?>
	
</script>

</head>

<body onload="loadgrafico();">
	<div id="container" style="height: 100%; width: 100%"></div>
</body>	

</html>
