function DrawChart(wkt,layerVector,sourcePoints) {
	
	$.getJSON('./php/CMD-get-mde.php?wkt='+wkt, function (data) {
		
		jwindow.open("popup-preloader");
		
		$("#perfil_topografico_min_max").html("<p>Altura Máxima: "+data.max+" Mts.</p><p>Altura Mínima: "+data.min + " Mts.")
		
		layerVector.points = data.points;
		
		jwindow.open("popup-ptopografico");
		
		//var width = $("#perfil_topografico_chart").width();
		//var height = $("#perfil_topografico_chart").height();
		
		$("#perfil_topografico_chart").highcharts({
			lang:{
				viewFullscreen:"Pantalla Completa",
				printChart:"Imprimir",
				downloadCSV:"Descargar en CSV",
				downloadJPEG:"Descargar en JPG",
				downloadPDF:"Descargar en PDF",
				downloadPNG:"Descargar en PNG",
				downloadSVG:"Descargar en SVG",
				downloadXLS:"Descargar en XLS"
			},
			chart: {
				zoomType: 'x',
				/*margin:0,*/
				backgroundColor:'rgba(255, 255, 255, 0.0)',
				/*height:'50%'*/
				/*,
				width:width*/
			},
			title: {
				//text: 'Perfil Topográfico',
				text: '',
				style: {
					
					fontSize:"15px",
				color:'#FFFFFF'
				
					
				}
			},
			subtitle: {
				//text: 'Distancia Total: ' + data.distancia_total + "Km.",
				text: '',
				style: {
					
					//color:'#FFFFFF'
					color:'#000000'
					
				}
			},
			xAxis: {
				//type: 'distancia',
				title: {
					text: 'Distancia',
					
				}
			},
			yAxis: {
				//type: 'altura',
				title: {
					text: 'Altura'
				}
			},
			legend: {
				enabled: true
			},
			plotOptions: {
				area: {
					fillColor: {
						linearGradient: {
							x1: 0,
							y1: 0,
							x2: 0,
							y2: 1
						},
						stops: [
							[0, Highcharts.getOptions().colors[0]],
							[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
						]
					},
					marker: {
						radius: 2
					},
					lineWidth: 1,
					states: {
						hover: {
							lineWidth: 1
						}
					},
					threshold: null
				}
			},

			series: [{
				type: 'area',
				name: 'Altura',
				data: data.data,
				point:{
					
					events:{
						
						mouseOver:function(event) {
							
							sourcePoints.clear();
							
							var geomwkt = layerVector.points[this.index];
								geomwkt = geomwkt.substring(6,geomwkt.length-1).split(" ");
							
							var feature = new ol.Feature({
								geometry: new ol.geom.Point(geomwkt),
								labelPoint: new ol.geom.Point(geomwkt),
								name:"My Feature"
							});
							
							sourcePoints.addFeature(feature);
							
							feature.setGeometryName("labelPoint");								
							
						},
						mouseOut:function() {
							
							sourcePoints.clear();
							
						}
						
					}
					
				}
			}]
		});	
		
		jwindow.close("popup-preloader");
		
	});
	
	Highcharts.theme = {
	   colors: ['#2b908f', '#90ee7e', '#f45b5b', '#7798BF', '#aaeeee', '#ff0066', '#eeaaee',
		  '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],
	   chart: {
		  backgroundColor: {
			 linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
			 stops: [
				[0, '#FFFFFF'],
				[1, '#FFFFFF']
			 ]
		  },
		  style: {
			 fontFamily: '\'Unica One\', sans-serif'
		  },
		  plotBorderColor: '#606063'
	   },
	   title: {
		  style: {
			 color: '#999999',
			 textTransform: 'uppercase',
			 fontSize: '20px'
		  }
	   },
	   subtitle: {
		  style: {
			 color: '#999999',
			 textTransform: 'uppercase'
		  }
	   },
	   xAxis: {
		  gridLineColor: '#707073',
		  labels: {
			 style: {
				//color: '#999999'
				color: '#000000'
			 }
		  },
		  lineColor: '#707073',
		  minorGridLineColor: '#505053',
		  tickColor: '#707073',
		  title: {
			 style: {
				//color: '#999999'
				color: '#000000'

			 }
		  }
	   },
	   yAxis: {
		  gridLineColor: '#707073',
		  labels: {
			 style: {
				//color: '#999999'
				color: '#000000'
			 }
		  },
		  lineColor: '#707073',
		  minorGridLineColor: '#505053',
		  tickColor: '#707073',
		  tickWidth: 1,
		  title: {
			 style: {
				//color: '#999999'
				color: '#000000'
			 }
		  }
	   },
	   tooltip: {
		  backgroundColor: 'rgba(0, 0, 0, 0.85)',
		  style: {
			 color: '#F0F0F0'
		  }
	   },
	   plotOptions: {
		  series: {
			 dataLabels: {
				//color: '#B0B0B3'
				 color: '#000000'
			 },
			 marker: {
				lineColor: '#333'
			 }
		  },
		  boxplot: {
			 fillColor: '#505053'
		  },
		  candlestick: {
			 lineColor: 'white'
		  },
		  errorbar: {
			 color: 'white'
		  }
	   },
	   legend: {
		  itemStyle: {
			 //color: '#E0E0E3'
			  color: '#000000'
		  },
		  itemHoverStyle: {
			 color: '#FFF'
		  },
		  itemHiddenStyle: {
			 color: '#606063'
		  }
	   },
	   credits: {
		  style: {
			 color: '#666'
		  }
	   },
	   labels: {
		  style: {
			 //color: '#707073'
			 color: '#000000'
		  }
	   },

	   drilldown: {
		  activeAxisLabelStyle: {
			 color: '#F0F0F3'
		  },
		  activeDataLabelStyle: {
			 color: '#F0F0F3'
		  }
	   },

	   navigation: {
		  buttonOptions: {
			 symbolStroke: '#DDDDDD',
			 theme: {
				fill: '#505053'
			 }
		  }
	   },

	   // scroll charts
	   rangeSelector: {
		  buttonTheme: {
			 fill: '#505053',
			 stroke: '#000000',
			 style: {
				color: '#CCC'
			 },
			 states: {
				hover: {
				   fill: '#707073',
				   stroke: '#000000',
				   style: {
					  color: 'white'
				   }
				},
				select: {
				   fill: '#000003',
				   stroke: '#000000',
				   style: {
					  color: 'white'
				   }
				}
			 }
		  },
		  inputBoxBorderColor: '#505053',
		  inputStyle: {
			 backgroundColor: '#333',
			 color: 'silver'
		  },
		  labelStyle: {
			 color: 'silver'
		  }
	   },

	   navigator: {
		  handles: {
			 backgroundColor: '#666',
			 borderColor: '#AAA'
		  },
		  outlineColor: '#CCC',
		  maskFill: 'rgba(255,255,255,0.1)',
		  series: {
			 color: '#7798BF',
			 lineColor: '#A6C7ED'
		  },
		  xAxis: {
			 gridLineColor: '#505053'
		  }
	   },

	   scrollbar: {
		  barBackgroundColor: '#808083',
		  barBorderColor: '#808083',
		  buttonArrowColor: '#CCC',
		  buttonBackgroundColor: '#606063',
		  buttonBorderColor: '#606063',
		  rifleColor: '#FFF',
		  trackBackgroundColor: '#404043',
		  trackBorderColor: '#404043'
	   },

	   // special colors for some of the
	   legendBackgroundColor: 'rgba(0, 0, 0, 0.5)',
	   background2: '#505053',
	   dataLabelsColor: '#B0B0B3',
	   textColor: '#C0C0C0',
	   contrastTextColor: '#F0F0F3',
	   maskColor: 'rgba(255,255,255,0.3)'
	};

	// Apply the theme
	Highcharts.setOptions(Highcharts.theme);	
	
	$("#perfil-topografico-header .flclose").bind("click",function() {
		
		source.clear();
		sourcePoints.clear();			
		
	});
	
	$("#perfil-topografico").draggable({ handle:"#perfil-topografico-header" });
	
}
