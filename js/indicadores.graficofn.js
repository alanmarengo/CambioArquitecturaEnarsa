function draw_grafico_1(container,config) {
	
	Highcharts.chart(container, {
		credits: { enabled:false },
		chart: {
			type: 'area',
			margin:0,
			renderTo:'chart'
		},
		accessibility: {
			description: config.desc
		},
		title: {
			text: ''
		},
		subtitle: {
			text: config.desc
		},
		xAxis: {
			allowDecimals: false,
			labels: {
				formatter: function () {
					return this.value; // clean, unformatted number for year
				}
			}
		},
		yAxis: {
			title: {
				text: config.titulo
			},
			labels: {
				formatter: function () {
					return this.value / 1000 + config.unidad;
				}
			}
		},
		tooltip: {
			pointFormat: '{series.name} series por puntos <b>{point.y:,.0f}</b><br/>estadisticas en {point.x}'
		},
		plotOptions: {
			area: {
				pointStart: 1940,
				marker: {
					enabled: false,
					symbol: 'circle',
					radius: 2,
					states: {
						hover: {
							enabled: true
						}
					}
				}
			}
		},
		series:config.data,
		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					legend: {
						align: 'center',
						verticalAlign: 'bottom',
						layout: 'horizontal',                             
						align: 'center',
						floating:false
					},
					yAxis: {
						labels: {
							align: 'left',
							x: 0,
							y: -5
						},
						title: {
							text: ''
						}
					},
					subtitle: {
						text: ''
					},
					credits: {
						enabled: false
					}
				}
			}]
		}
	});
	
} //  BASIC AREA

function draw_grafico_2(container,config) {
	
	Highcharts.chart(container, {
		credits: { enabled:false },
		chart: {
			type: 'bar',
			margin:0,
			renderTo:'chart'
		},
		title: {
			text: ''
		},
		xAxis: {
			categories: config.etiquetas
		},
		yAxis: {
			min: 0,
			title: {
				text: config.subtitle
			}
		},
		legend: {
			reversed: true,
			align: 'center',
			floating:false
		},
		plotOptions: {
			series: {
				stacking: 'normal'
			}
		},
		series: config.data,
		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					legend: {
						align: 'center',
						verticalAlign: 'bottom',
						layout: 'horizontal',
						align: 'center',
						floating:false
					},
					yAxis: {
						labels: {
							align: 'left',
							x: 0,
							y: -5
						},
						title: {
							text: ''
						}
					},
					subtitle: {
						text: ''
					},
					credits: {
						enabled: false
					}
				}
			}]
		}
	});
	
} 


function draw_grafico_3(container,config) { // BUBBLE CHART
	
	var series = [];
	var arrInd = -1;
	var label = "";
	var data = [];
	
	for (var i=0; i<config.etiquetas.length; i++) {
		
		if (label != config.etiquetas[i]) {
			
			arrInd++;
			
			series.push({
				
				name:config.etiquetas[i]
				
			});
			
			data[arrInd] = [];			
			
			label = config.etiquetas[i];
			
		}
			
		data[arrInd].push({
			
			name:config.data[i].name,
			value:config.data[i].y
			
		});
		
	}
	
	for (var i=0; i<series.length; i++) {
		
		series[i].data = data[i];
		
	}
	
	Highcharts.chart(container, {
		credits: { enabled:false },
		chart: {
			type: 'packedbubble',
			height: '100%',
			margin:0,
			renderTo:'chart'
		},
		title: {
			text: ''
		},
		tooltip: {
			useHTML: true,
			pointFormat: '<b>{point.name}:</b> {point.value} '+config.unidad+'</sub>'
		},
		plotOptions: {
			packedbubble: {
				minSize: '30%',
				maxSize: '120%',
				zMin: 0,
				zMax: 1000,
				layoutAlgorithm: {
					splitSeries: false,
					gravitationalConstant: 0.02
				},
				dataLabels: {
					enabled: true,
					format: '{point.name}',
					filter: {
						property: 'y',
						operator: '>',
						value: 250
					},
					style: {
						color: 'black',
						textOutline: 'none',
						fontWeight: 'normal'
					}
				}
			}
		},
		series: series,
		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					legend: {
						align: 'center',
						verticalAlign: 'bottom',
						layout: 'horizontal',
						align: 'center',
						floating:false
					},
					yAxis: {
						labels: {
							align: 'left',
							x: 0,
							y: -5
						},
						title: {
							text: ''
						}
					},
					subtitle: {
						text: ''
					},
					credits: {
						enabled: false
					}
				}
			}]
		}
	});


}


function draw_grafico_4(container,config) { // BUBBLE CHART
	
	var series = [];
	var arrInd = -1;
	var label = "";
	var data = [];
	var  colores = ['rgba(58, 64, 153, 0.5)', 'rgba(189, 39, 39, 0.5)', 'rgba(147, 153, 58, 0.5)','rgba(66, 153, 58, 0.5)', 'rgba(153, 58, 137, 0.5)', 'rgba(59, 59, 59, 0.5)']
	var i2 = 0
	for (var i=0; i<config.etiquetas.length; i++) {
		if (label != config.etiquetas[i]) {
			
			arrInd++;
		
			series.push({
				
				name:config.etiquetas[i],		
				
			});
			
			data[arrInd] = [];			
			
			label = config.etiquetas[i];			
		}
		

		data[arrInd].push({
			
			name:config.data[i].name,
			value:config.data[i].y
			
		});

		
	}
	let colorEtiqueta = '';
	for (var i=0; i<series.length; i++) {
		config.data.forEach(function(info){
			if(info.name == series[i].name){
				colorEtiqueta = info.color
			}
		})
		series[i].data = data[i];
		series[i].color =  colorEtiqueta
	}
	
	
	Highcharts.chart(container, {
		credits: { enabled:false },
		chart: {
			type: 'packedbubble',
			height: '100%',
			margin:0,
			renderTo:'chart'
		},
		title: {
			text: ''
		},
		tooltip: {
			useHTML: true,
			pointFormat: '<b>{point.name}:</b> {point.value} ' + config.unidad
		},
		plotOptions: {
			packedbubble: {
				minSize: '20%',
				maxSize: '100%',
				zMin: 0,
				zMax: 1000,
				layoutAlgorithm: {
					gravitationalConstant: 0.05,
					splitSeries: true,
					seriesInteraction: false,
					dragBetweenSeries: true,
					parentNodeLimit: true
				},
				dataLabels: {
					enabled: true,
					format: '{point.name}',
					filter: {
						property: 'y',
						operator: '>',
						value: 250
					},
					style: {
						color: 'black',
						textOutline: 'none',
						fontWeight: 'normal'
					}
				}
			}
		},
		series:series,
		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					legend: {
						align: 'center',
						verticalAlign: 'bottom',
						layout: 'horizontal',
						align: 'center',
						floating:false
					},
					yAxis: {
						labels: {
							align: 'left',
							x: 0,
							y: -5
						},
						title: {
							text: ''
						}
					},
					subtitle: {
						text: ''
					},
					credits: {
						enabled: false
					}
				}
			}]
		}
	});

}


function draw_grafico_5(container,config) { // BASIC COLUMNS
	
	var series = [];
	var labels = [];
	var arrInd = -1;
	var label = "";
	var data = [];
	
	for (var i=0; i<config.etiquetas.length; i++) {
		
		if (label != config.etiquetas[i]) {
			
			labels.push(config.etiquetas[i]);
			
			label = config.etiquetas[i];
		
		}
		
	}
	
	for (var i=0; i<config.etiquetas.length; i++) {
		
					
		var found = false;
				
		for (var j=0; j<series.length; j++) {
				
			if (series[j].name == config.data[i].name) {
					
				series[j].data.push(config.data[i].y);
				found = true;
						
			}
		
		}
			
		if (!found) {
				
			series.push({
				color: config.data[i].color,
				name:config.data[i].name,
				data:[config.data[i].y]
					
			});
				
		}
					
	}
	
	Highcharts.chart(container, {
		credits: { enabled:false },
		chart: {
			type: 'column'/*,
			margin:0,
			renderTo:'chart'*/
		},
		title: {
			text: ''
		},
		subtitle: {
			text: config.desc
		},
		xAxis: {
			categories: labels,
			crosshair: true
		},
		yAxis: {
			min: 0,
			title: {
				text: config.titulo
			}
		},
		tooltip: {
			headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
				'<td style="padding:0"><b>{point.y:.1f} '+config.unidad+'</b></td></tr>',
			footerFormat: '</table>',
			shared: true,
			useHTML: true
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
		},
		series:series,
		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					legend: {
						align: 'center',
						verticalAlign: 'bottom',
						layout: 'horizontal',
						align: 'center',
						floating:false
					},
					yAxis: {
						labels: {
							align: 'left',
							x: 0,
							y: -5
						},
						title: {
							text: ''
						}
					},
					subtitle: {
						text: ''
					},
					credits: {
						enabled: false
					}
				}
			}]
		}
	});
}


function draw_grafico_6(container,config) { // FIXED PLACEMENT
	
	var series = [];
	var labels = [];
	var arrInd = -1;
	var label = "";
	var data = [];
	
	for (var i=0; i<config.etiquetas.length; i++) {
		
		if (label != config.etiquetas[i]) {
			
			labels.push(config.etiquetas[i]);
			
			label = config.etiquetas[i];
		
		}
		
	}
	
	for (var i=0; i<config.etiquetas.length; i++) {
					
		var found = false;
				
		for (var j=0; j<series.length; j++) {
				
			if (series[j].name == config.data[i].name) {
					
				series[j].data.push(config.data[i].y);
				found = true;
						
			}
		
		}
			
		if (!found) {
				
			series.push({
				
				name:config.data[i].name,
				data:[config.data[i].y],
				pointPadding: 0.3,
				pointPlacement: -0.2
					
			});
				
		}
					
	}
	
	Highcharts.chart(container, {
		credits: { enabled:false },
		chart: {
			type: 'column'/*,
			margin:0,
			renderTo:'chart'*/
		},
		title: {
			text: ''
		},
		xAxis: {
			categories: labels
		},
		yAxis: [{
			min: 0,
			title: {
				text: config.titulo
			}
		}, {
			title: {
				text: config.desc
			},
			opposite: true
		}],
		legend: {
			shadow: false,
			align: 'center',
			floating:false
		},
		tooltip: {
			shared: true
		},
		plotOptions: {
			column: {
				grouping: false,
				shadow: false,
				borderWidth: 0
			}
		},
		series: series,
		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					legend: {
						align: 'center',
						verticalAlign: 'bottom',
						layout: 'horizontal',
						align: 'center',
						floating:false
					},
					yAxis: {
						labels: {
							align: 'left',
							x: 0,
							y: -5
						},
						title: {
							text: ''
						}
					},
					subtitle: {
						text: ''
					},
					credits: {
						enabled: false
					}
				}
			}]
		}
	});
	
}

function draw_grafico_7(container,config) { // FIXED PLACEMENT
	
	var series = [];
	var arrLabels = [];
	var arrInd = -1;
	var label = "";
	var data = [];
	
	for (var i=0; i<config.etiquetas.length; i++) {
		
		var found = false;
		
		for (j=0; j<arrLabels.length; j++) {
			
			if (config.etiquetas[i] == arrLabels[j]) {
				
				found = true;
				break;
				
			}
			
		}
		
		if (!found) {
			
			arrLabels.push(config.etiquetas[i]);
		
		}
		
	}
	
	for (var i=0; i<config.etiquetas.length; i++) {


					
		var found = false;
				
		for (var j=0; j<series.length; j++) {
				
			if (series[j].name == config.data[i].name) {
					
				series[j].data.push(config.data[i].y);
				found = true;
						
			}
		
		}
			
		if (!found) {
			if(config.data[i].visibilidad_sector == "1"){ //Recorrio el "visibilidad_sector" de cada data para ver si esta visible o no
				ejeText = config.data[i].name;
			}else{
				ejeText = ""
			}
				
			series.push({
				
				name:ejeText,
				data:[config.data[i].y],
				color: config.data[i].color,
				pointPadding: 0.3,
				pointPlacement: -0.2
					
			});
				
		}
					
	}
	
	Highcharts.chart(container, {
		chart: {
			type: 'column'
		},
		title: {
			text: ''
		},
		xAxis: {
			categories: arrLabels
		},
		yAxis: {
			min: 0,
			title: {
				text: config.desc
			}
		},
		tooltip: {
			pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
			shared: true
		},
		plotOptions: {
			column: {
				stacking: 'percent'
			}
		},
		series: series
	});
	
	/*Highcharts.chart(container, {
		credits: { enabled:false },
		chart: {
			type: 'column'/*,
			margin:0,
			renderTo:'chart'--*
		},
		title: {
			text: ""
		},
		xAxis: {
			categories: arrLabels
		},
		yAxis: {
			min: 0,
			title: {
				text: config.desc
			}
		},
		tooltip: {
			pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}'+config.unidad+')<br/>',
			shared: true
		},
		plotOptions: {
			column: {
				stacking: 'percent'
			}
		},
		series: config.data,
		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					legend: {
						align: 'center',
						verticalAlign: 'bottom',
						layout: 'horizontal'
					},
					yAxis: {
						labels: {
							align: 'left',
							x: 0,
							y: -5
						},
						title: {
							text: ''
						}
					},
					subtitle: {
						text: ''
					},
					credits: {
						enabled: false
					}
				}
			}]
		}
	});*/
	
}

function draw_grafico_8(container,config) { // FIXED PLACEMENT
	
	/*var series = [];
	var labels = [];
	var arrInd = -1;
	var label = "";
	var data = [];
	
	for (var i=0; i<config.etiquetas.length; i++) {
		
		if (label != config.etiquetas[i]) {
			
			labels.push(config.etiquetas[i]);
			
			label = config.etiquetas[i];
		
		}
		
	}
	
	for (var i=0; i<config.etiquetas.length; i++) {
					
		var found = false;
				
		for (var j=0; j<series.length; j++) {
				
			if (series[j].name == config.data[i].name) {
					
				series[j].data.push(config.data[i].y);
				found = true;
						
			}
		
		}
			
		if (!found) {
				
			series.push({
				
				name:config.data[i].name,
				data:[config.data[i].y],
				pointPadding: 0.3,
				pointPlacement: -0.2
					
			});
				
		}
					
	}
	
	Highcharts.chart(container, {
        series: [{
            type: 'treemap',
            layoutAlgorithm: 'squarified',
            allowDrillToNode: true,
            animationLimit: 1000,
            dataLabels: {
                enabled: false
            },
            levelIsConstant: false,
            levels: [{
                level: 1,
                dataLabels: {
                    enabled: true
                },
                borderWidth: 3
            }],
            data: points
        }],
        subtitle: {
            text: 'Click points to drill down. Source: <a href="http://apps.who.int/gho/data/node.main.12?lang=en">WHO</a>.'
        },
        title: {
            text: 'Global Mortality Rate 2012, per 100 000 population'
        }
    });*/
	
}

function draw_grafico_9(container,config) { // BASIC LINE
	
	var series = [];
	var arrInd = -1;
	var label = "";
	var data = [];
	
	for (var i=0; i<config.etiquetas.length; i++) {
		
		if (label != config.etiquetas[i]) {
			
			arrInd++;
			
			series.push({
				
				name:config.etiquetas[i]
				
			});
			
			data[arrInd] = [];			
			
			label = config.etiquetas[i];
			
		}
			
		data[arrInd].push({
			
			name:config.data[i].name,
			value:config.data[i].y,
			color:config.data[i].color
			
		});
		
	}
	
	for (var i=0; i<series.length; i++) {
		series[i].data = data[i];
		
	}
	
	document.getElementById(container).style.minHeight = "300px";
	
	Highcharts.chart(container, {
		
		credits: { enabled:false },
		title: {
			text: ''
		},

		subtitle: {
			text: config.desc
		},
		xAxis: {
			categories: config.etiquetasUnique,
    		tickWidth: 1
		},
		yAxis: {
			title: {
				text: config.titulo
			}
		},
		legend: {
			layout: 'vertical',
			align: 'right',
			verticalAlign: 'middle',
			align: 'center',
			floating:false
		},

		/*plotOptions: {
			series: {
				label: {
					connectorAllowed: false
				},
				pointStart: 2010
			}
		},*/

		series: config.data,
		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					legend: {
						align: 'center',
						verticalAlign: 'bottom',
						layout: 'horizontal',
						align: 'center',
						floating:false
					},
					yAxis: {
						labels: {
							align: 'left',
							x: 0,
							y: -5
						},
						title: {
							text: ''
						}
					},
					subtitle: {
						text: ''
					},
					credits: {
						enabled: false
					}
				}
			}]
		}/*,

		responsive: {
			rules: [{
				condition: {
					maxWidth: 500,
					minHeight:300
				},
				chartOptions: {
					legend: {
						layout: 'horizontal',
						align: 'center',
						verticalAlign: 'bottom'
					}
				}
			}]
		}*/

	});
	
}

function draw_grafico_10(container,config) { // SEMI CIRCLE DONUT
	
	document.getElementById(container).style.minHeight = "300px";
	
	var series = [];

	
	for (var i=0; i<config.data.length; i++) {
		console.log(config.data[i].color)
		
		//series.push([ config.data[i].name, config.data[i].y ]);
		series[i]= {name: config.data[i].name, y: config.data[i].y, color: config.data[i].color};

	}
	console.log(series)
	
	Highcharts.chart(container, {
		credits: { enabled:false },
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: 0,
			plotShadow: false,
			margin:0,
			renderTo:'chart'
		},
		title: {
			text: '',
			/*text: config.titulo,*/
			align: 'center',
			verticalAlign: 'middle',
			y: 60
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}'+config.unidad+'</b>'
		},
		plotOptions: {
			pie: {
				dataLabels: {
					enabled: true,
					distance: -50,
					style: {
						fontWeight: 'bold',
						color: 'white'
					}
				},
				startAngle: -90,
				endAngle: 90,
				center: ['50%', '75%'],
				size: '110%'
			}
		},
		series: [{
			type: 'pie',
			name: config.desc,
			innerSize: '50%',
			data: series,
		}],
		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					legend: {
						align: 'center',
						verticalAlign: 'bottom',
						layout: 'horizontal',
						align: 'center',
						floating:false
					},
					yAxis: {
						labels: {
							align: 'left',
							x: 0,
							y: -5
						},
						title: {
							text: ''
						}
					},
					subtitle: {
						text: ''
					},
					credits: {
						enabled: false
					}
				}
			}]
		}
	});
	
}

function draw_grafico_11(container,config) { // PIE WITH DRILLDOWN
	
	Highcharts.chart(container, {
		credits: { enabled:false },
		chart: {
			type: 'pie',
			margin:0,
			renderTo:'chart'
		},
		title: {
			text: ''
		},
		subtitle: {
			text: config.desc
		},
		plotOptions: {
			series: {
				dataLabels: {
					enabled: true,
					format: '{point.name}: {point.y:.1f}'+config.unidad
				}
			}
		},

		tooltip: {
			headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
			pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}'+config.unidad+'+</b><br/>'
		},

		series:[{
            name: config.titulo,
            colorByPoint: true,
			data:config.data
		}],
		responsive: {
			rules: [{
				condition: {
					maxWidth: 300
				},
				chartOptions: {
					legend: {
						align: 'center',
						verticalAlign: 'bottom',
						layout: 'horizontal',
						align: 'center',
						floating:false
					},
					yAxis: {
						labels: {
							align: 'left',
							x: 0,
							y: -5
						},
						title: {
							text: ''
						}
					},
					subtitle: {
						text: ''
					},
					credits: {
						enabled: false
					}
				}
			}]
		}
	});

}

function draw_grafico_12(container,config) { // PIE WITH DRILLDOWN
	container = document.getElementById(container);
	if(config.data[0].color){
		if(config.data[0].color.length < 1){
			container.innerHTML = "<h3 style='font-size:8vw; margin:0; color:#0088cc;'>"+config.data[0].y + "</h3>";
		}else{
			container.innerHTML = "<h3 style='font-size:8vw; margin:0; color:"+config.data[0].color+";'>"+config.data[0].y + "</h3>";
		}	
	}else{
		container.innerHTML = "<h3 style='font-size:8vw; margin:0; color:#0088cc;'>"+config.data[0].y + "</h3>";
	}
	container.innerHTML += "<h4 style='font-size:16px; margin:0;'>"+ config.unidad + "</h4>";
	container.innerHTML += "<h5 style='font-size:12px; margin:10px 0;'>"+config.titulo+"</h5>";

}

function draw_grafico_13(container,config) { // PIE WITH DRILLDOWN
	Highcharts.chart(container, {
		credits: { enabled:false },
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'pie'
		},
		title: {
			text: ''
		},
		subtitle: {
			text: config.desc
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		accessibility: {
			point: {
				valueSuffix: '%'
			}
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: false
				},
				showInLegend: true
			}
		},
		
		series:[{
            name: config.titulo,
            colorByPoint: true,
			data:config.data
		}],
		responsive: {
			rules: [{
				condition: {
					maxWidth: 300
				},
				chartOptions: {
					legend: {
						align: 'center',
						verticalAlign: 'bottom',
						layout: 'horizontal',
						align: 'center',
						floating:false
					},
					yAxis: {
						labels: {
							align: 'left',
							x: 0,
							y: -5
						},
						title: {
							text: ''
						}
					},
					subtitle: {
						text: ''
					},
					credits: {
						enabled: false
					}
				}
			}]
		}
	});

}

function draw_grafico_14(container,config) { // WIND BARB
	/* ### Funcionalidad de colores ### */
		//Colores por defecto :
	let colorViento = Highcharts.getOptions().colors[1]; 
	let colorGrafico =  Highcharts.getOptions().colors[0]; 
		//Colores por base de datos:
	if(config.color_viento != ""){
		colorViento = config.color_viento;
	}
	if(config.color_grafico != ""){
		colorGrafico = config.color_grafico;
	}
	/* ### FIN Funcionalidad de colores ### */
	var series = [];
	var ano;
	var mes;
	var dia;

	Highcharts.seriesTypes.windbarb.prototype.beaufortName = [
		'Calma', 'Aire ligero', 'Brisa ligera',
		'Brisa suave', 'Brisa moderada', 'Brisa fresca',
		'Brisa fuerte', 'Vendaval cercano', 'Vendaval', 'Vendaval fuerte', 'Tormenta',
		'Tormenta violenta', 'Huracán'];

	for (var i=0; i<config.direccion.length; i++) {

		if (i==0) {
			var fechaTemp = config.fecha[i].split("-");
			ano = fechaTemp[0];
			mes = parseInt(fechaTemp[1])-1;
			dia = parseInt(fechaTemp[2]);
		}

		series.push([config.intensidad[i],config.direccion[i]]);

	}

	Highcharts.chart(container, {

		title: {
			text: config.title
		},
	
		xAxis: {
			type: 'datetime',
			offset: 40
		},

		plotOptions: {
			series: {
				pointStart: Date.UTC(ano, mes, dia),
				pointInterval: 36e5,
			}
		},
	
		series: [{
			type: 'windbarb',
			data: series,
			name: 'Viento',
			color: colorViento,
			showInLegend: false,
			tooltip: {
				valueSuffix: ' m/s'
			}
		}, {
			type: 'area',
			keys: ['y', 'rotation'], // rotation is not used here
			data: series,
			color: colorGrafico,
			fillColor: {
				linearGradient: { x1: 0, x2: 0, y1: 0, y2: 1 },
				stops: [
					[0, colorGrafico],
					[
						1,
						Highcharts.color(colorGrafico)
							.setOpacity(0.25).get()
					]
				]
			},
			name: 'Velocidad del Viento',
			tooltip: {
				valueSuffix: ' m/s'
			},
			states: {
				inactive: {
					opacity: 1
				}
			}
		}]
	
	});

}

function draw_grafico_15(container,config) { // POLAR RADAR
	
	var series = [];

	for (var i=0; i<config.data.length; i++) {
		
		if(config.data[i].visibilidad_sector == "1"){ //Recorrio el "visibilidad_sector" de cada data para ver si esta visible o no
			ejeText = config.data[i].name;
		}else{
			ejeText = ""
		}

		let colorData = config.data[i].color
		var o = {
			color: colorData,
			type: config.etiquetas[i],
			name: ejeText,
			data: config.data[i].data
		}

		if (config.data[i].name == 'column') {
			o.pointPlacement = 'between';
		}

		series.push(o);

	}

	Highcharts.chart(container, {

		chart: {
			polar: true
		},
	
		title: {
			text: config.title
		},
	
		subtitle: {
			text: config.subtitle
		},
	
		pane: {
			startAngle: 0,
			endAngle: 360
		},
	
		xAxis: {
			tickInterval: 45,
			min: 0,
			max: 360,
			labels: {
				format: '{value}'
			}
		},
	
		yAxis: {
			min: 0
		},
	
		plotOptions: {
			series: {
				pointStart: 0,
				pointInterval: 45
			},
			column: {
				pointPadding: 0,
				groupPadding: 0
			}
		},
	
		series: series
	});

}

function draw_grafico_16(container,config) { // MULTIPLE AXES
	
	
	var axis = [];
	var series = [];

	for (var i=0; i<config.data.length; i++) {

		if(config.data[i].visibilidad_sector == "1"){ //Recorrio el "visibilidad_sector" de cada data para ver si esta visible o no
			ejeText = config.data[i].name;
		}else{
			ejeText = ""
		}

		let colorData = config.data[i].color
		var o = {
			color: colorData,
			name: config.data[i].name,
			type: config.data[i].type,
			data: config.data[i].data,
			tooltip:{
				valueSuffix:config.data[i].unit
			}
		}

		var y = { // Primary yAxis
			labels: {
				format: '{value}'+config.data[i].unit,
				style: {
					color: Highcharts.getOptions().colors[i]
				}
			},
			title: {
				text: ejeText,
				style: {
					color: Highcharts.getOptions().colors[i]
				}
			}
		}

		if ((i==0) || (i==2)) {
			y.opposite = true;
		}

		if (i>0) {
			y.gridLineWidth = 0;
		}

		series.push(o);
		axis.push(y);

	}

	Highcharts.chart(container, {
		chart: {
			zoomType: 'xy'
		},
		title: {
			text: config.title,
			align: 'left'
		},
		xAxis: [{
			categories: config.etiquetasUnique,
			crosshair: true
		}],
		yAxis: axis,
		tooltip: {
			shared: true
		},
		legend: {
			layout: 'vertical',
			align: 'left',
			x: 80,
			verticalAlign: 'top',
			y: 55,
			floating: true,
			backgroundColor:
				Highcharts.defaultOptions.legend.backgroundColor || // theme
				'rgba(255,255,255,0.25)'
		},
		series: series,
		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					legend: {
						floating: false,
						layout: 'horizontal',
						align: 'center',
						verticalAlign: 'bottom',
						x: 0,
						y: 0
					},
					yAxis: [{
						labels: {
							align: 'right',
							x: 0,
							y: -6
						},
						showLastLabel: false
					}, {
						labels: {
							align: 'left',
							x: 0,
							y: -6
						},
						showLastLabel: false
					}, {
						visible: false
					}]
				}
			}]
		}
	});

}

function draw_grafico_17(container,config) {
	var axis = [];
	var series = [];
	
	let unidadDiferente = false;
	let unidadPrev = '';

	for (var i=0; i<config.data.length; i++) {

		if(i === 0){
			unidadPrev = config.data[i].unit
		}else{
			if(unidadPrev !== config.data[i].unit){
				unidadDiferente = true
			}
		}

		if(config.data[i].visibilidad_sector == "1"){
			ejeText = config.data[i].name;
		}else{
			ejeText = ""
		}

		if(config.data[i].data == undefined){
				if(unidadDiferente === true){
					var o = {
						name: config.data[i].name,
						color: config.data[i].color,
						type: config.data[i].type,
						yAxis: i,
						data: [config.data[i].y],
						tooltip:{
							valueSuffix:config.data[i].unit
						}
					}
				}else{
					var o = {
						name: config.data[i].name,
						color: config.data[i].color,
						type: config.data[i].type,
						data: [config.data[i].y],
						tooltip:{
							valueSuffix:config.data[i].unit
						}
					}
				}
		}else{		
			if(unidadDiferente === true){
				var o = {
					name: config.data[i].name,
					color: config.data[i].color,
					type: config.data[i].type,
					yAxis: i,
					data: config.data[i].data,
					tooltip:{
						valueSuffix:config.data[i].unit
					}
				}
			}else{
				var o = {
					name: config.data[i].name,
					color: config.data[i].color,
					type: config.data[i].type,
					data: config.data[i].data,
					tooltip:{
						valueSuffix:config.data[i].unit
					}
				}
			}		

		}
		var y = { // Primary yAxis
			labels: {
				format: '{value}'+config.data[i].unit,
				style: {
					color: Highcharts.getOptions().colors[i]
				}
			},
			title: {
				text:  ejeText,
				style: {
					color: Highcharts.getOptions().colors[i]
				}
			},
		}

		series.push(o);
		axis.push(y);

	}

	Highcharts.chart(container, {
		chart: {
			zoomType: 'xy'
		},
		title: {
			text: config.title
		},
		subtitle: {
			text: config.subtitle
		},
		xAxis: {
			categories: config.etiquetasUnique
		},
		yAxis:axis,
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
		series: series
	});
	console.log(axis)
	console.log(series)
}

function draw_grafico_18(container,config) {

	var series = [];
	var pieObject = false;
	var pieTitle = "";

	for (var i=0; i<config.data.length; i++) {

		if(config.data[i].visibilidad_sector == "1"){ //Recorrio el "visibilidad_sector" de cada data para ver si esta visible o no
			ejeText = config.data[i].name;
		}else{
			ejeText = ""
		}

		if (config.data[i].type == "pie") {

			if (!pieObject) {

				pieObject = {
					type: config.data[i].type,
					name: config.etiquetasUnique[i],
					data: [],
					center: [100, 80],
					size: 100,
					showInLegend: false,
					dataLabels: {
						enabled: false
					}
				}

				pieTitle = config.etiquetas[i];

			}

			pieObject.data.push({

				name: config.data[i].name,
				y: config.data[i].y,
				color: Highcharts.getOptions().colors[i] // Jane's color

			});

		}else{

			var o = {
				name: config.data[i].name,
				type: config.data[i].type,
				data: config.data[i].data,
				color: config.data[i].color
			}
	
			series.push(o);

		}

	}

	series.push(pieObject);

	Highcharts.chart(container, {
		title: {
			text: ''
		},
		xAxis: {
			categories: config.etiquetasUnique
		},
		labels: {
			items: [{
				html: pieTitle,
				style: {
					left: '50px',
					top: '18px',
					color: ( // theme
						Highcharts.defaultOptions.title.style &&
						Highcharts.defaultOptions.title.style.color
					) || 'black'
				}
			}]
		},
		series: series
	});

}

function draw_grafico_19(container,config) {
	
}

function draw_grafico_20(container,config) {

	config.sector = config.sector.replace(/\[/g, "<");
	config.sector = config.sector.replace(/\]/g, ">");

	Highcharts.chart(container, {

		chart: {
			type: 'bubble',
			plotBorderWidth: 1,
			zoomType: 'xy'
		},
	
		legend: {
			enabled: false
		},
	
		title: {
			text: config.title
		},
	
		accessibility: {
			point: {
				valueDescriptionFormat: '{index}. {point.name}, fat: {point.x}g, sugar: {point.y}g, obesity: {point.z}%.'
			}
		},
	
		xAxis: {
			gridLineWidth: 1,
			title: {
				text: config.etiquetas.x_titulo
			},
			labels: {
				format: '{value} ' + config.etiquetas.x_unidad
			},
			plotLines: [{
				color: 'black',
				dashStyle: 'dot',
				width: 2,
				value:config.etiquetas.x_valor_ref,
				label: {
					rotation: 0,
					y: 15,
					style: {
						fontStyle: 'italic'
					},
					text: config.etiquetas.x_valor_ref_texto
				},
				zIndex: 3
			}],
			accessibility: {
				rangeDescription: config.etiquetas.x_titulo_abcisa
			}
		},
	
		yAxis: {
			startOnTick: false,
			endOnTick: false,
			title: {
				text: config.etiquetas.y_titulo
			},
			labels: {
				format: '{value} ' + config.etiquetas.y_unidad
			},
			maxPadding: 0.2,
			plotLines: [{
				color: 'black',
				dashStyle: 'dot',
				width: 2,
				value: config.etiquetas.y_valor_ref,
				label: {
					align: 'right',
					style: {
						fontStyle: 'italic'
					},
					text: config.etiquetas.y_valor_ref_texto,
					x: -10
				},
				zIndex: 3
			}],
			accessibility: {
				rangeDescription: config.etiquetas.y_titulo_abcisa
			}
		},
	
		tooltip: {
			useHTML: true,
			headerFormat: '<table>',
			pointFormat: config.sector,
			footerFormat: '</table>',
			followPointer: true
		},
	
		plotOptions: {
			series: {
				dataLabels: {
					enabled: true,
					format: '{point.name}'
				}
			}
		},
	
		series: [{
			data: config.valor
		}]
	
	});
	
}

function draw_grafico_21(container,config) {

	var series = [];

	for (var i=0; i<config.values.length; i++) {

		var o = {
			name:config.serietype[i],
			color:config.color[i],
			data:config.values[i]
		}

		series.push(o);

	}

	Highcharts.chart(container, {
		chart: {
			type: 'scatter',
			zoomType: 'xy'
		},
		title: {
			text: config.title
		},
		xAxis: {
			title: {
				enabled: true,
				text: config.axis[0]
			},
			startOnTick: true,
			endOnTick: true,
			showLastLabel: true
		},
		yAxis: {
			title: {
				text: config.axis[1]
			}
		},
		legend: {
			layout: 'vertical',
			align: 'left',
			verticalAlign: 'top',
			x: 100,
			y: 70,
			floating: true,
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
					pointFormat: '{point.x} , {point.y} '
				}
			}
		},
		series: series
	});
	
}