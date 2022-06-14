function draw_grafico_1(container,config) {
	
	var series = [];
	var labels = [];
	var arrInd = -1;
	var label = "";
	var data = [];
	
	for (var i=0; i<config.data.length; i++) {
					
		data.push([config.data[i].name,config.data[i].y]);
					
	}
	
	Highcharts.chart(container, {
		credits: { enabled:false },
		chart: {
        type: 'column'
		},
		title: {
			text: config.titulo
		},
		subtitle: {
			text: config.desc
		},
		xAxis: {
			type: 'category',
			labels: {
				rotation: -45,
				style: {
					fontSize: '13px',
					fontFamily: 'Verdana, sans-serif'
				}
			}
		},
		yAxis: {
			min: 0,
			title: {
				text: config.titulo
			}
		},
		legend: {
			enabled: false
		},
		tooltip: {
			pointFormat: config.titulo
		},
		series: [{
			name: config.etiquetas[0],
			data: data,
			dataLabels: {
				enabled: true,
				rotation: -90,
				color: '#FFFFFF',
				align: 'right',
				format: '{point.y:.1f}', // one decimal
				y: 10, // 10 pixels down from the top
				style: {
					fontSize: '13px',
					fontFamily: 'Verdana, sans-serif'
				}
			}
		}]
	
	});
	
} 

function draw_grafico_2(container,config) {
	
	Highcharts.chart(container, {
		credits: { enabled:false },
		chart: {
			type: 'pie'
		},
		title: {
			text: config.titulo
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
		}]
	});
	
} //  BASIC AREA







function draw_grafico_6(container,config) { // BUBBLE CHART
	
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
	});



}

function draw_grafico_13(container,config) { // SEMI CIRCLE DONUT
	
	document.getElementById(container).style.minHeight = "300px";
	
	var series = [];
	
	for (var i=0; i<config.data.length; i++) {
		
		series.push([config.data[i].name,config.data[i].y]);
		
	}
	
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
			data: series
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
	});
	
}

function draw_grafico_14(container,config) { // PIE WITH DRILLDOWN
	
	Highcharts.chart(container, {
		credits: { enabled:false },
		chart: {
			type: 'pie'/*,
			margin:0,
			renderTo:'chart'*/
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
	});

}


function draw_grafico_8(container,config) { // BASIC COLUMNS
	
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
		series:series /*,
		responsive: {
			rules: [{
				condition: {
					maxWidth: 200
				},
				chartOptions: {
					legend: {
						align: 'center',
						verticalAlign: 'bottom',
						layout: 'horizontal', 
						enabled:true
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
		} */
	});
}

function draw_grafico_9(container,config) { // FIXED PLACEMENT
	
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
				
			series.push({
				
				name:config.data[i].name,
				data:[config.data[i].y],
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
	
}

function draw_grafico_12(container,config) { // BASIC LINE
	
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
			
			/*name:config.data[i].name,*/
			value:config.data[i].y
			
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

		yAxis: {
			title: {
				text: config.titulo
			}
		},
		legend: {
			layout: 'vertical',
			align: 'right',
			verticalAlign: 'middle'
		},

		plotOptions: {
			series: {
				label: {
					connectorAllowed: false
				},
				pointStart: 2010
			}
		},

		series: series
	});
	
}



function draw_grafico_11(container,config) {
	
	var series = [];
	var labels = [];
	var arrInd = -1;
	var label = "";
	var data = [];
	
	for (var i=0; i<config.data.length; i++) {
					
		data.push([config.data[i].name,config.data[i].y,i]);
					
	}
	
	Highcharts.chart(container, {
    colorAxis: {
        minColor: '#FFFFFF',
        maxColor: Highcharts.getOptions().colors[0]
    },
    series: [{
        type: 'treemap',
        layoutAlgorithm: 'squarified',
        data: data
    }],
    title: {
        text: config.desc
    }
});
} 

function draw_grafico_4(container,config)  //  BASIC AREA
{
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
	});
	
}







