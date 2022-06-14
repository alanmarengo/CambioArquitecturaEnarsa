function ol_map() {

	this.container = {};
	this.nav = {};
	this.panel = {};
	this.panel.div = document.getElementById("nav-panel");
	this.map = {};
	this.map.infoEnabled = true;
	this.popup = {};
	this.map.baselayers = {};
	this.map.layersBuffer = [];
	this.map.layersBufferIndex = 0;
	this.map.layersStats = [];
	this.map.layersStatsIndex = 200000;
	
	this.map.geovisor = -1;
		
	$(".datepicker").datepicker({
		
		language: 'es'
		
	});
	
	// MAP SCRIPTS 
	
	this.map.create = function() {
		
		this.baselayers.openstreets = new ol.layer.Tile({
			name: 'openstreets',
			title: 'OSM',
			type: 'base',
			visible: false,
			source: new ol.source.XYZ({
				url: '//{a-c}.tile.openstreetmaps.org/{z}/{x}/{y}.png',
				crossOrigin: 'anonymous'
			})
		})
	
		this.baselayers.opentopo = new ol.layer.Tile({
			name: 'opentopo',
			title: 'OpenTopo',
			type: 'base',
			visible: false,
			source: new ol.source.XYZ({
				url: '//{a-c}.tile.opentopomap.org/{z}/{x}/{y}.png',
				crossOrigin: 'anonymous'
			})
		})

		this.baselayers.bingmaps = new ol.source.BingMaps({
			name:'bing',
			key: 'AmqIEhx8ko1O3p1Npagu9_Egw7e8quBgM03p6_xdFqjSfJa6kWv_iUU2nO1htz1G',
			imagerySet: 'Road',
			culture: 'ar-ES',
			visible:false,
			crossOrigin: 'anonymous'
		})

		this.baselayers.bing_roads = new ol.layer.Tile({
			name:'bing_roads',
			preload: Infinity,
			source: this.baselayers.bingmaps,
			visible:false,
			crossOrigin: 'anonymous'
		})

		this.baselayers.bing_aerials = new ol.layer.Tile({
			name:'bing_aerials',
			preload: Infinity,
			visible:false,
			source: new ol.source.BingMaps({
				key: 'AmqIEhx8ko1O3p1Npagu9_Egw7e8quBgM03p6_xdFqjSfJa6kWv_iUU2nO1htz1G',
				imagerySet: 'Aerial',
				crossOrigin: 'anonymous'
			})
		})

		this.baselayers.google = new ol.layer.Tile({
			name:'google_base',
			visible:true,
			source: new ol.source.TileImage({ 
				url: 'http://mt{0-3}.googleapis.com/vt?&x={x}&y={y}&z={z}&hl=es&gl=AR',
				crossOrigin: 'anonymous'
			})
		})		
	
		this.baselayers.argenmap = new ol.layer.Tile({
			name:"capabaseargenmap",
			visible:false,
			source: new ol.source.TileWMS({
				url: "https://wms.ign.gob.ar/geoserver/ows",
				params: {
					'LAYERS': 'capabaseargenmap',
					'VERSION': '1.1.1',
					'FORMAT': 'image/png',
					'TILED': false
				}/*,
				crossOrigin: 'anonymous'*/
			})
		})
	
		/*this.baselayers.argenmap = new ol.layer.Tile({
			name:'capabaseargenmap',
			visible:true,
			source: new ol.source.TileImage({ 
				url: 'https://wms.ign.gob.ar/geoserver/ows',
				crossOrigin: 'anonymous'
			})
		})*/
		
		this.baselayers.collection = [this.baselayers.openstreets,this.baselayers.opentopo,this.baselayers.bing_roads,this.baselayers.bing_aerials,this.baselayers.google,this.baselayers.argenmap];
		
		///////document.getElementById("baselayer-default-radio").click();
		
		var i = new ol.interaction.MouseWheelZoom();

		var oldFn = i.handleEvent;
		i.handleEvent = function(e) {
		  var type = e.type;
		  if (type !== "wheel" && type !== "wheel" ) {
			return true;
		  }
		  
		  if (!e.originalEvent.altKey) {
			return true
		  }

		  oldFn.call(this,e);
		}
		
		this.ol_object = new ol.Map({
			interactions: ol.interaction.defaults({ dragPan:true, mouseWheelZoom: false }).extend([i]),
			layers:this.baselayers.collection,
			target: 'map',
			extent: [-13281237.21183002,-7669922.0600572005,-738226.6183457375,-1828910.1066171727],
			controls: [],
			view: new ol.View({
				center: [-7845071.804914552,-6485168.6121456055],
				zoom:8.8,
				minZoom: 3.8,
				maxZoom: 21
			})
		});
		
		this.baseLayer = this.baselayers.openstreets;
		
		this.ol_object.map_object = this;
		this.ol_object.infoEnabled = true;
		
		this.ol_object.on("movestart",function(evt) {
			
			$("#popup-combo").hide();
			
		});
		
		this.ol_object.on("click",function(evt) {
			
			if (this.infoEnabled ) {
				
				this.lastClicked = evt.coordinate;
				
				var pos = evt.coordinate;
				
				var pos4326 = ol.proj.transform(evt.coordinate,'EPSG:3857', 'EPSG:4326');
				
				var coord = String(pos4326).split(",");
				var pixel = this.getPixelFromCoordinate(evt.coordinate);
				this.map_object.gfiAddedLayers = [];
				
				var view = this.getView();
				var map = this.map_object;
				
				var viewResolution = (view.getResolution());
				var url = '';
				
				this.getLayers().forEach(function (layer, i, layers) {					
					
					if ((layer.getVisible()) && (layer.get('name') == "ahrsc:vp_geo_prcpr_proyectoahrsc_otr1")) {
						
						if(layer.getSource().getGetFeatureInfoUrl) {						
				
							$("#popup-results").empty();
						
							url = layer.getSource().getGetFeatureInfoUrl(evt.coordinate, viewResolution, 'EPSG:3857', {
								'INFO_FORMAT': 'text/html',
									'FEATURE_COUNT': '300'
							});	
							
							var req = $.ajax({
								
								async:false,
								type:"GET",
								url:url,
								//url:"urldeprueba.php",
								success:function(d){}
								
							})
							
							if (req.responseText != "") {
							
								var html = req.responseText;
									html = html.split("body>");
								
								if (html.length > 0) {
								
									html = html[1].substring(0,html[1].length-2);
									html = html.trim();
									
									$("#popup-combo").hide();
									map.ol_object.lastClicked = evt.coordinate;
									map.preparseGFI(html,"popup-info","info-wrapper"); // PARA ACOMODAR RESPUESTA A ESTRUCTURA DE IEASA
									
								
								}
								
								$("#popup-combo").css("left",(pixel[0]-112)+"px");
								$("#popup-combo").css("top",(pixel[1]-85)+"px");
								$("#popup-combo").attr("data-xy",evt.coordinate);

							
							}
							
							//map.parseGFI(req.responseText,"popup-info","info-wrapper");
						
							scroll.refresh();
						
						}
						
						map.gfiAddedLayers.push(layer.layer_id);
					
					}
					
				});
			
			}
			
		});	
		
		/*this.ol_object.on("click",function(evt) {
			
			if (this.infoEnabled ) {
			
				var pos = evt.coordinate;
				
				var pos4326 = ol.proj.transform(evt.coordinate,'EPSG:3857', 'EPSG:4326');
				
				var req = $.ajax({
					
					async:false,
					url:"./php/get-geovisorcombo-popup.php",
					type:"post",
					data:{
						lon:pos4326.lon,
						lat:pos4326.lat
					},
					success:function(d){}
					
				});
			
			}
			
		});	*/	
		
		this.global_mouse_position_4326 = new ol.control.MousePosition({
			coordinateFormat: function(coordinate) {
			  return "EPSG:4326 | " + ol.coordinate.format(coordinate, '{y}, {x}', 4);
			},
			projection: 'EPSG:4326',
			className: 'custom-mouse-position',
			target: document.getElementById('global-coordinates-span')
		});
		
		this.ol_object.addControl(this.global_mouse_position_4326);
		
		this.createLayers = function() {
			
			//
			
		}
		
		this.createPrintLegendDiv = function() {
			
			var div = document.createElement("div");
				div.id = "print-legend-wrapper";
			
			document.getElementById("map").appendChild(div);
			
		}		
		
	}
	
	this.map.startSearch = function() {
		
		$("#panel-seach-input-layers-bottom").val("");
		
		$("#panel-seach-input-layers-bottom").bind("focus",function() {
			
			$(this).parent().animate({
				
				"background-color":"#31cbfd"
				
			},"fast");
			
		});
		
		$("#panel-seach-input-layers-bottom").bind("blur",function() {
			
			$(this).parent().animate({
				
				"background-color":"#4c4b4b"
				
			},"fast");
			
		});
		
		$("#panel-seach-input-layers-bottom").bind("keyup",function(e) {
			
			if ($("#panel-seach-input-layers-bottom").val().trim() == "") {
				
				$("#panel-busqueda-geovisor").hide();
				
			}else{
				
				if (e.which == 13) {
					
					this.searchInLayers($("#panel-seach-input-layers-bottom").val());				
					$("#panel-busqueda-geovisor").css("display","flex");
					
				}
				
			}
			
		}.bind(this));
		
	}
	
	this.map.searchGlobal = function() {
		
		var pattern = $("#main-search").val();
		var url = "./mediateca.php?s="+pattern;
		var flink = document.createElement("a");
			flink.href = url;
			flink.target = "_blank";
			document.body.appendChild(flink);
			flink.click();
			$(flink).remove();
		
	}
	
	this.map.searchInLayers = function(pattern) {
		
		$("#panel-busqueda-geovisor").css("display","flex");
		$("#panel-busqueda-geovisor .panel-header").html("Resultados de Búsqueda");
		
		var req = $.ajax({
			
			async:false,
			url:"./php/get-layers-search.php",
			type:"post",
			data:{
				pattern:pattern
			},
			success:function(d){}
			
		});		
		
		$("#panel-busqueda-geovisor .panel-body").html(req.responseText);
		
		scroll.refresh();
		
	}
	
	this.map.setBaseLayer = function(layerObj) {
		
		for (var i=0; i<this.baselayers.collection.length; i++) {
				
			this.baselayers.collection[i].setVisible(false);
		
		}
		
		layerObj.setVisible(true);
		this.baseLayer = layerObj;
		
	}	
	
	this.map.getBaseLayer = function() {
		
		return this.baseLayer;
		
	}
	
	this.map.activateClases = function(arrid) {
		
		for (var i=0; i<arrid.length; i++) {
			
			$(".panel-abr[data-cid="+arrid[i]+"]").attr("data-active",1);
			$(".panel-abr[data-cid="+arrid[i]+"]").show();
			
		}
		
	}
	
	this.map.updateLayerCount = function() {
		
		var count = $(".layer-checkbox[data-added=1]").length;
		$(".layers-visible-count").html("("+count+")");
		
	}
	
	this.map.panel = this.panel;
	
	this.map.loadGeovisor = function(geovid) {
		
		var req = $.ajax({
			
			async:false,
			type:"POST",
			url:"./php/get-geovisor.php",
			data:{geovid:geovid},
			success:function(d){}
			
		});
		
		this.geovisor = geovid;
		
		var js = JSON.parse(req.responseText);
		
		$("#navbar-tools h3").html(js.geovisor_desc);
		
		var panel = this.panel;
		
		for (var i=0; i<js.data.length; i++) {
			
			//if (js.data[i].iniciar_panel == "t") {
				
				if (js.data[i].iniciar_panel == "t") { js.data[i].iniciar_panel = true; } else { js.data[i].iniciar_panel = false; }
				if (js.data[i].iniciar_visible == "t") { js.data[i].iniciar_visible = true; } else { js.data[i].iniciar_visible = false; }
				
				var cid = $(".layer-checkbox[data-lid="+js.data[i].layer_id+"]").attr("data-cid");
				
				var lid = $(".layer-checkbox[data-lid="+js.data[i].layer_id+"]").attr("data-lid");
					
				panel.AddLayer(cid,lid,js.data[i].iniciar_panel,js.data[i].iniciar_visible);
				
				if (js.data[i].iniciar_visible) {
					
					$(".layer-checkbox[data-lid="+js.data[i].layer_id+"]").prop("checked",true);
					
				}
				
			//}
			
		}
		
		var array_geovisor = [ parseFloat(js.minx), parseFloat(js.maxx), parseFloat(js.miny), parseFloat(js.maxy) ];
		
		this.ol_object.getView().fit(array_geovisor,{size:this.ol_object.getSize()});
		//this.ol_object.getView().fit([ -8149293.741521936, -6378849.225655933, -7812129.881098088, -6226949.882287896 ],{size:this.ol_object.getSize()});
		this.ol_object.updateSize();
		this.ol_object.render();
		
	}
	
	this.map.preparseGFI = function(response,containerID,wrapperID) {
		
		$("#popup-results-preparse").empty();
		$("#popup-results-preparse").html(response);
		
		var newnodes = "";
		
		$("#popup-results-preparse table[class=featureInfo] tbody").children("tr").each(function(i,v) {
			
			if ($(v).children("th").length == 0) {
			
				var node = $(v).children("td").first();
				var val = $(node).text().split(".");
				
				var gid = $(v).children("td:nth-child(2)");
					gid = $(gid).text();
				
				var newnode = "<img src=\"../img/t.gif\" x=\"" + gid + "\" y=\"" + val[0] + "\" z=\"1\" />";
				
				newnodes += newnode;
			
			}
			
		});
		
		this.parseGFI(newnodes,containerID,wrapperID);
	
	}
	
	this.map.parseGFI = function(response,containerID,wrapperID) {
		
		document.getElementById("popup-results").innerHTML += response;
		
		var results = [];
		
		var entered = false;
		
		$("#popup-results").children().each(function(i,v) {
			
			var gid = $(v).attr("x");
			var layer_name = "ahrsc:"+$(v).attr("y");
			
			results.push(layer_name + ";" + gid);
			
			entered = true;
			
		});
		
		if (entered) {
			
			var req = $.ajax({
				
				async:false,
				type:"POST",
				data:{
					results:results
				},
				url:"./php/get-layer-info-combo.php",
				success:function(d) {}
				
			});
			
			if (req.responseText.trim() != "") {
			
				$("#popup-combo").show();
				document.getElementById("popup-combo-body").innerHTML = req.responseText;
			
			}else{
				
				$("#popup-combo").hide();
				
			}
	
		}
		
	}
	
	this.map.parseGFIbuffer = function(response,containerID,wrapperID) {
		
		document.getElementById("popup-results-buffer").innerHTML = response;
		
		var results = [];
		
		var entered = false;
		
		$("#popup-results-buffer").children().each(function(i,v) {
			
			var gid = $(v).attr("x");
			var layer_name = $(v).attr("y");
			
			results.push(layer_name + ";" + gid);
			
			entered = true;
			
		});
		
		if (entered) {
			
			jwindow.close("popup-info");
			
			$("#info-wrapper").empty();
		
			var req = $.ajax({
				
				async:false,
				type:"POST",
				data:{
					results:results
				},
				url:"./php/get-layer-info.php",
				success:function(d) {}
				
			});
			
			document.getElementById(wrapperID).innerHTML = req.responseText;
					
			jwindow.open(containerID);
			
			scroll.refresh();
			
			$("[title]").tooltipster({
				animation: 'fade',
				delay: 200,
				theme: 'tooltipster-default',
				trigger: 'hover'
			});
	
		}
		
	}
	
	this.map.zoomToZoneExtent = function(index) {
		
		var extents = [
			{
				minx:-8059334.63851867,
				miny:-6549600.00520834,
				maxx:-7604071.34389932,
				maxy:-6340610.43756053
			},
			{
				minx:-7883025.60540804,
				miny:-6494756.13103644,
				maxx:-7875148.75334871,
				maxy:-6478882.4540154
			},
			{
				minx:-7812318.55059425,
				miny:-6497163.88563083,
				maxx:-7801734.03063953,
				maxy:-6476479.99752537
			},
			{
				minx:-7890225.54049351,
				miny:-6525918.33485518,
				maxx:-7671642.89584723,
				maxy:-6433640.83392161
			}
		];
		
		var js = extents[index];
		
		var extent = ol.proj.transformExtent(
			[js.minx,js.miny,js.maxx,js.maxy],
			"EPSG:3857", "EPSG:3857"
		);
		
		this.ol_object.getView().fit(extent,{duration:1000});
		this.ol_object.updateSize();
		this.ol_object.render();
		
	}
	
	this.map.zoomToLayerExtent = function(layer_id) {
		
		var js = this.getLayerExtent(layer_id);
		
		var extent = ol.proj.transformExtent(
			[js.minx,js.miny,js.maxx,js.maxy],
			"EPSG:3857", "EPSG:3857"
		);
		
		this.ol_object.getView().fit(extent,{duration:1000});
		this.ol_object.updateSize();
		this.ol_object.render();
		
	}
	
	this.map.getLayerExtent = function(layer_id) {
		
		var reqExtent = $.ajax({
			
			async:false,
			url:"./php/get-layer-extent.php",
			type:"post",
			data:{layer_id:layer_id},
			success:function(d){}
				
		});
		
		var js = JSON.parse(reqExtent.responseText);
		
		return js;
		
	}
	
	this.map.getLayerData = function(layer_id) {
		
		var reqExtent = $.ajax({
			
			async:false,
			url:"./php/get-layer-data.php",
			type:"post",
			data:{layer_id:layer_id},
			success:function(d){}
				
		});
		
		var js = JSON.parse(reqExtent.responseText);
		
		return js;
		
	}
	
	this.map.setupTools = function() {
		
		$(".toggleable-tool").each(function(i,v) {
			
			$(v).bind("click",function() {
				
				if ($(v).closest("#dropdown-draw").length == 0) {
					
					if ((this.drawing) && (this.drawing.source)) {
						
						this.drawing.source.clear();
						
					}
					
				}
				
				
			}.bind(this));
			
		}.bind(this));
		
	}
	
	this.map.disableTools = function() {			
			
		if (this.deleteSelect) { this.ol_object.removeInteraction(this.deleteSelect); }
		if (this.select) { this.ol_object.removeInteraction(this.select); }
		if (this.modify) { this.ol_object.removeInteraction(this.modify); }
		if (this.draw) { this.ol_object.removeInteraction(this.draw); }
		if (this.medi_draw) { this.ol_object.removeInteraction(this.medi_draw); }
		if (this.bufferdraw) { this.ol_object.removeInteraction(this.bufferdraw); }
		if (this.ptopo_draw) { this.ol_object.removeInteraction(this.ptopo_draw); }
		
		if ((this.drawing) && (this.drawing.source)) {
			
			var vectorLayer = this.drawing;
			var source = this.drawing.source;
			var features = this.drawing.source.getFeatures();
				
				features.forEach((feature) => {
					source.removeFeature(feature);
				});			
						
			this.drawing.source.clear();
		}
		
		if ((this.buffer) && (this.buffer.source)) {
			
			var vectorLayer = this.buffer;
			var source = this.buffer.source;
			var features = this.buffer.source.getFeatures();
				
				features.forEach((feature) => {
					source.removeFeature(feature);
				});			
						
			this.buffer.source.clear();
			
		}
		
		if ((this.medicion) && (this.medicion.source)) {
			
			var vectorLayer = this.medicion;
			var source = this.medicion.source;
			var features = this.medicion.source.getFeatures();
				
				features.forEach((feature) => {
					source.removeFeature(feature);
				});			
						
			this.medicion.source.clear();
			
		}
		
		if ((this.ptopografico) && (this.ptopografico.source)) {
			
			var vectorLayer = this.ptopografico;
			var source = this.ptopografico.source;
			var features = this.ptopografico.source.getFeatures();
				
				features.forEach((feature) => {
					source.removeFeature(feature);
				});			
						
			this.ptopografico.source.clear();
			
		}
		
		this.ol_object.infoEnabled = true;
		
		$(".toggleable-tool-active").removeClass("toggleable-tool-active");
		
		if (this.markersLayer) {
		
			this.markersLayer.getSource().clear();
		
		}
		
	}
	
	this.map.setupDisableTools = function() {
		
		$("body").on("keyup",function(event) {
			
			if (event.which == 27) {				
			
				this.disableTools();
				
			}
			
		}.bind(this));
		
	}
	
	this.map.share = function() {
		
		var s_layers = [];
		var s_visibles = [];
		var s_clase = [];
		var clase_active = $(".panel-abr[data-active=1]").attr("data-cid");
		
		if (clase_active == undefined) {
			
			clase_active = "";
			
		}
		
		var zoom = this.ol_object.getView().getZoom();
		var center = this.ol_object.getView().getCenter();
		
		$(".panel-abr:visible").each(function(i,v) {
			
			s_clase.push(this.getAttribute("data-cid"));
			
		});
		
		$(".layer-checkbox[data-added=1]").each(function(i,v) {
			
			if (v.layer) {
								
				var visible = 0;
				
				if (v.layer.getVisible()) { visible = 1; }
				
				s_layers.push(v.getAttribute("data-lid"));
				s_visibles.push(visible);
				s_clase.push(v.getAttribute("data-cid"));
				
			}
			
		});
		
		var s_link = SITEURL+"geovisor.php?";
			s_link += "fk=0";
			s_link += "&c=" + s_clase.join(",");
			s_link += "&ca=" + clase_active;
			s_link += "&l=" + s_layers.join(",");
			s_link += "&v=" + s_visibles.join(",");
			s_link += "&cen=" + center;
			s_link += "&z=" + zoom;
		
		$("#input-share").val(s_link);
		
		$(".popup").not("#popup-busqueda").hide();
		$("#popup-share").show();
		
	}
	
	this.map.print = function() {					
			
		$("#print-legend-wrapper").empty();
		$("#print-legend-wrapper").show();
		
		var state = $("#nav-panel-arrow").children(".jump-toggleimage").first().attr("data-state");
		
		if (state == 1) {
			
			flotant.toggle('#nav-panel');
			
			$("#nav-panel-arrow").children(".jump-toggleimage").children("img").first().attr("src","./images/panel.icon.arrow.0.png");
			
		}
			
		$(".layer-checkbox[data-added=1]:checked").each(function(i,v) {
			
			var layer_name = $(v).closest(".layer-group").attr("data-layer-name");
			
			var src = "http://observatorio.ieasa.com.ar/geoserver/ows?&version=1.3.0&service=WMS&request=GetLegendGraphic&sld_version=1.1.0&layer="+layer_name+"&format=image/png&";
			
			var newImage = document.createElement("img");
				newImage.setAttribute("src",src);
			
			$("#print-legend-wrapper").append(newImage);
			
			//$(v).parent().parent().next(".layer-body").children(".layer-legend").clone().appendTo("#print-legend-wrapper");
			
		});/*
		
		this.ol_object.once('rendercomplete', function(event) {
			
			var canvas = event.context.canvas;
			
			if (navigator.msSaveBlob) {
				navigator.msSaveBlob(canvas.msToBlob(), 'map.png');
			} else {
				canvas.toBlob(function(blob) {
					saveAs(blob, 'map.png');
				});
			}
        });
		
        this.ol_object.renderSync();*/

		html2canvas(document.querySelector("#map")).then(canvas => {
			
			var a = document.createElement('a');
			// toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
			a.href = canvas.toDataURL();
			a.download = 'captura.png';
			
			document.body.appendChild(a);
			
			a.click();
			
			$(a).remove();
			
			$("#print-legend-wrapper").hide();
			
		});
			
		this.ol_object.infoEnabled = true;
		
		/*var node = document.getElementById('map');

		domtoimage.toPng(node)
			.then(function (dataUrl) {
				var img = new Image();
				img.crossOrigin = "Anonymous";
				img.src = dataUrl;
				document.body.appendChild(img);
			})
			.catch(function (error) {
				console.error('oops, something went wrong!', error);
			});*/
		
	}
	
	this.map.mapear = function(query_id) {
		
		sld_result = '';		
		
		/**** Generar el SLD ****/
		s = new sldlib();
		capa = s.sld_get_intervalos(query_id); /* Retorna la capa que corresponde por tipo de geometria */
		
		var layer = new ol.layer.Tile({
				visible:true,
				singleTile: true,
				source: new ol.source.TileWMS({
					url: "http://observatorio.ieasa.com.ar:8080/geoserver/ows?",
					params: {
						'LAYERS': capa,//'intervalos_polygons',
						'id':query_id,
						//'VERSION': '1.1.1',
						'FORMAT': 'image/png',
						'TILED': false,
						'SLD':'http://'+window.location.hostname+'/sld/'+query_id+'.sld' /* EL SLD CREADO ES SIEMPRE EL ID_MAPEO.SLD */,
						'viewparams':'id:'+query_id
					}
				})
			});
		
		this.ol_object.addLayer(layer);
		
		var reqExtent = $.ajax({
			
			async:false,
			url:"./php/get-layer-extent-mapeo.php",
			type:"post",
			data:{query_id:query_id},
			success:function(d){}
				
		});
		
		var js = JSON.parse(reqExtent.responseText);
		
		var extent = ol.proj.transformExtent(
			[js.minx,js.miny,js.maxx,js.maxy],
			"EPSG:3857", "EPSG:3857"
		);
		
		this.ol_object.getView().fit(extent,{duration:1000});
		this.ol_object.updateSize();
		this.ol_object.render();
		
		this.panel.AddLayerActiveFromStats(query_id,layer);
		
	}
	
	this.map.deactivateCoordinates = function() {
		
		this.ol_object.removeControl(this.mouse_position_3857);
		this.ol_object.removeControl(this.mouse_position_4326);
		
	}
	
	this.map.activateCoordinates = function() {
		
		this.disableTools();
		
		document.getElementById('coord-3857').innerHTML = "";
		document.getElementById('coord-4326').innerHTML = "";
		
		this.mouse_position_3857 = new ol.control.MousePosition({
			coordinateFormat: ol.coordinate.createStringXY(3),
			projection: 'EPSG:3857',
			className: 'custom-mouse-position',
			target: document.getElementById('coord-3857')
		});
		
		this.mouse_position_4326 = new ol.control.MousePosition({
			coordinateFormat: ol.coordinate.createStringXY(3),
			projection: 'EPSG:4326',
			className: 'custom-mouse-position',
			target: document.getElementById('coord-4326')
		});
		
		this.ol_object.addControl(this.mouse_position_3857);
		this.ol_object.addControl(this.mouse_position_4326);
		
		this.ol_object.infoEnabled = false;
		
		this.ol_object.on("click",this.saveCoordinate);
		
		$("#coord-tbl").show();
		$("#coord-hint").show();
		$("#btn-popup-capturar").hide();
		$("#coord-capture-wrapper").hide();
		
	}
	
	this.map.saveCoordinate = function(e) {
		
		var lon = e.coordinate[0];
		var lat = e.coordinate[1];
		
		var coordarray4326 = ol.proj.transform(e.coordinate,'EPSG:3857', 'EPSG:4326');
		
		var lon4326 = coordarray4326[0];
		var lat4326 = coordarray4326[1];		
		
		var coord_3875 = "Long: " + parseFloat(lon).toFixed(3) + " &nbsp;&nbsp;Lat: " + parseFloat(lat).toFixed(3);
		var coord_4326 = "Long: " + parseFloat(lon4326).toFixed(3) + " &nbsp;&nbspLat: " + parseFloat(lat4326).toFixed(3);
		
		var req = $.ajax({
			
			async:false,
			type:"POST",
			url:"./php/get-coord-transformed.php",
			data:{lon:lon,lat:lat},
			success:function(d){}
			
		});
		
		var js = JSON.parse(req.responseText);
		
		$("#cap-coord-3857").html(coord_3875);
		$("#cap-coord-4326").html(coord_4326);
		$("#cap-coord-100001").html("Long: " + js.coord100001.lon+" &nbsp;&nbspLat: " + js.coord100001.lat);
		$("#cap-coord-100002").html("Long: " + js.coord100002.lon+" &nbsp;&nbspLat: " + js.coord100002.lat);
		$("#cap-coord-100003").html("Long: " + js.coord100003.lon+" &nbsp;&nbspLat: " + js.coord100003.lat);
		
		$("#coord-tbl").hide();
		$("#coord-hint").hide();
		$("#btn-popup-capturar").show();
		$("#coord-capture-wrapper").show();
		
		this.map_object.deactivateCoordinates();
		
		this.map_object.ol_object.infoEnabled = true;
		
		this.un("click",this.map_object.saveCoordinate);
		
	}
	
	this.map.buffer = function(type,node) {
		
		if ($(node).hasClass("toggleable-tool-active")) {
			
			this.buffer.source.clear();
			
			if (this.bufferdraw) { 	this.ol_object.removeInteraction(this.bufferdraw); }
			
			$(node).removeClass("toggleable-tool-active");
			
			this.ol_object.infoEnabled = true;
			
			jwindow.close("popup-buffer");
			
		}else{
			
			$(".toggleable-tool-active").not(node).trigger("click");
			$(node).addClass("toggleable-tool-active");
			this.ol_object.infoEnabled = false;
			
			if (!this.buffer.source) {
				
				this.buffer.source = new ol.source.Vector({
					wrapX: false
				});
				
				var source = this.buffer.source;
				
				this.buffer.layerVector = new ol.layer.Vector({
					source: source
				});
				
				this.ol_object.addLayer(this.buffer.layerVector);
				
			}
			
			var format = new ol.format.WKT();		
			
			if (this.bufferdraw) {
					
				this.ol_object.removeInteraction(this.bufferdraw);
					
			}
			
			if (type == "circle") {
				
				this.bufferdraw = new ol.interaction.Draw({
					source: this.buffer.source,
					type:"Circle"			
				});
				
				this.buffer.type = "circle";
			
			}else{
				
				this.bufferdraw = new ol.interaction.Draw({
					source: this.buffer.source,
					type:"Polygon"			
				});
				
				this.buffer.type = "polygon";
				
			}
			
			$("#buffer-hint").show();
			$("#info-buffer").empty();
			
			this.buffer.source.clear();
			
			this.bufferdraw.on("drawstart",function(e) {
				
				this.ol_object.infoEnabled = false;
				
			}.bind(this));
			
			this.bufferdraw.on('drawend', function (e) {
				
				var format = new ol.format.WKT();			
				
				if (this.buffer.type == "circle") {
					
					var circle = ol.geom.Polygon.fromCircle(e.feature.getGeometry());
				
				}else{
					
					var circle = e.feature.getGeometry();
					
				}
				
				var wkt = format.writeGeometry(circle.transform('EPSG:3857', 'EPSG:4326'));		
				
				var wkt = format.writeGeometry(circle.transform('EPSG:4326', 'EPSG:3857'));	
				
				var layers = [];

				var mapLayers = geomap.map.ol_object.getLayers().getArray();

				for (var i=0; i<mapLayers.length; i++) {
				  
				  if ((mapLayers[i].getVisible()) && (mapLayers[i].getSource().params_)) {
					
					layers.push(mapLayers[i].getSource().params_.layer_id);
					
				  }
				  
				}
				
				var req = $.ajax({
					
					async:false,
					type:"post",
					url:"./php/get-buffer.php",
					data:{wkt:wkt,layers:layers},
					success:function(d){}
					
				});
				
				$("#buffer-hint").hide();
				
				this.parseGFIbuffer(req.responseText,"popup-buffer","info-buffer");

			}.bind(this));
			
			this.ol_object.addInteraction(this.bufferdraw);
			
		}
		
	}
	
	this.map.addBuffer = function(layer_id,dlurl,addLink) {
		
		var distance = $("#buffer-input-"+layer_id).val();
		var dlurl = dlurl += "viewparams=layer_id:"+layer_id+";distancia:"+distance;
		
		if ((isNaN(parseInt(distance))) || (distance.trim() == "")) {
			
			alert("La distancia ingresada es incorrecta o está vacía");
			
		}else{
		
			$("#dlbuffer-link-"+layer_id).attr("href",dlurl);
			
			//addLink.innerHTML = "ACTUALIZAR";
			
			this.readBuffer(layer_id,distance,true);
		
		}
		
	}
	
	this.map.readBuffer = function(layer_id,distance,visible) {
		
		if ((isNaN(parseInt(distance))) || (distance.trim() == "")) {
			
			alert("La distancia ingresada es incorrecta o está vacía");
			
		}else{
			
			var layer = new ol.layer.Tile({
					name:'get_buffer',
					visible:false,
					source: new ol.source.TileWMS({
						url: "http://observatorio.ieasa.com.ar:8080/geoserver/ows?",
						params: {
							'LAYERS': 'get_buffer',
							'VERSION': '1.1.1',
							'FORMAT': 'image/png',
							'TILED': false,
							'viewparams':'layer_id:'+layer_id+";distancia:"+distance
							/*'distancia':distance,
							'layer_id':layer_id*/
						}/*,
						crossOrigin: 'anonymous'*/
					})
				});			
			
			this.layersBuffer[this.layersBufferIndex] = layer;
			
			this.ol_object.addLayer(this.layersBuffer[this.layersBufferIndex]);
			
			this.layersBuffer[this.layersBufferIndex].setVisible(visible);
			this.layersBufferIndex++;
			this.panel.AddLayerActive(-1,layer_id,true,layer,distance);
			
			this.layersBufferIndex++;
			
		}
		
	}
	
	this.map.downloadFeatures = function() {
		
		var features = this.drawing.source.getFeatures();
		
		var writer = new ol.format.GeoJSON();
		var geojsonStr = writer.writeFeatures(features);	
		
		var vectorSource = new ol.source.Vector({
			features: (new ol.format.GeoJSON()).readFeatures(geojsonStr)
		});
		
		var format = new ol.format.KML();
		var kml = format.writeFeatures(vectorSource.getFeatures(), {featureProjection: 'EPSG:3857'});
				
		//var dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(geojsonStr));
		//var blob = new Blob(kml, {type : 'text/html'});
		//var url = URL.createObjectURL(blob);
		
		var req = $.ajax({
			async:false,
			url:"php/create-kml.php",
			type:"post",
			data:{kml:kml},
			success:function(d){}
		});
		
		var js = JSON.parse(req.responseText);
		
		var dlAnchorElem = document.createElement("a");
		
		dlAnchorElem.setAttribute("id","jsondltemp");		
		dlAnchorElem.setAttribute("href",     js.fileurl     );
		dlAnchorElem.setAttribute("download", "content.kml");
		
		document.body.appendChild(dlAnchorElem);	
		
		dlAnchorElem.click();
		
		$("body").remove("#jsondltemp");
	
		if (this.deleteSelect) { this.ol_object.removeInteraction(this.deleteSelect); }
		if (this.select) { this.ol_object.removeInteraction(this.select); }
		if (this.modify) { this.ol_object.removeInteraction(this.modify); }
		if (this.draw) { this.ol_object.removeInteraction(this.draw); }
		if (this.medi_draw) { this.ol_object.removeInteraction(this.medi_draw); }
		if (this.buffer_draw) { this.ol_object.removeInteraction(this.buffer_draw); }
		if (this.ptopo_draw) { this.ol_object.removeInteraction(this.ptopo_draw); }
	
	}
	
	this.map.deleteFeature = function() {		
		
		if (this.deleteSelect) { this.ol_object.removeInteraction(this.deleteSelect); }
		if (this.select) { this.ol_object.removeInteraction(this.select); }
		if (this.modify) { this.ol_object.removeInteraction(this.modify); }
		if (this.draw) { this.ol_object.removeInteraction(this.draw); }
		if (this.medi_draw) { this.ol_object.removeInteraction(this.medi_draw); }
		if (this.buffer_draw) { this.ol_object.removeInteraction(this.buffer_draw); }
		if (this.ptopo_draw) { this.ol_object.removeInteraction(this.ptopo_draw); }
		
		if (this.drawing.source) {
			
			if (!this.deleteSelect) {			
			
				this.deleteSelect = new ol.interaction.Select({
					wrapX: false
				});
				
				var layer = this.drawing.layerVector;
				
				this.deleteSelect.on("select",function(evt) {
					
					var l = evt.target.getFeatures().getLength();
					
					evt.target.getFeatures().forEach(function(f) {
						
						layer.getSource().removeFeature(f);
						
					});;
					
				});
			
			}
			
			this.ol_object.addInteraction(this.deleteSelect);
			
		}
		
	}
	
	this.map.drawing = function(type,node) {
		
		if ($(node).hasClass("toggleable-tool-active")) {
			
			//this.drawing.source.clear();
			
			if (this.draw) { 	this.ol_object.removeInteraction(this.draw); }
			
			$(node).removeClass("toggleable-tool-active");
			
			this.ol_object.infoEnabled = true;
			
		}else{
			
			$(".toggleable-tool-active").not(node).trigger("click");
			$(node).addClass("toggleable-tool-active");
			this.ol_object.infoEnabled = false;
		
			if (!this.drawing.source) {
				
				this.drawing.source = new ol.source.Vector({
					wrapX: false
				});
				
				var source = this.drawing.source;
				
				this.drawing.layerVector = new ol.layer.Vector({
					source: source
				});
				
				this.ol_object.addLayer(this.drawing.layerVector);
				
			}
				
			if (!type) { type = "Point"; }
			
			switch(type) {
				
				case "Select":
				
				if (this.select) {
					
					this.ol_object.removeInteraction(this.select);	
				
				}else{
				
					this.select = new ol.interaction.Select({
						wrapX: false
					});
				
				}
				
				this.select.on('select', function(e) {
				
					var features = e.target.getFeatures().getArray();
					var len = e.target.getFeatures().getLength();
					
					if (len>0) {
						
						jwindow.open("popup-features");
						
						$("#info-features").empty();
						
						for(var i=0; i<len; i++) {
							
							var html = "<div class=\"tarjeta-features\">";
							
							if (features[i].getGeometry().getType() == "Point") {
								
								html += "<p>Geometría de Punto</p>";
								html += "<p>Coordenadas: "+features[i].getGeometry().getCoordinates()+"</p>";
								
							}
							
							if (features[i].getGeometry().getType() == "LineString") {
								
								html += "<p>Geometría de Líneas</p>";
								html += "<p>Largo: "+((features[i].getGeometry().getLength())/1000)+" Km.</p>";
								
							}
							
							if (features[i].getGeometry().getType() == "Circle") {
								
								html += "<p>Geometría Circular</p>";
								html += "<p>Radio: "+((features[i].getGeometry().getRadius())/1000)+" Km.</p>";
								html += "<p>Centro: "+features[i].getGeometry().getCenter()+"</p>";
								html += "<p>Coordenada Inicial: "+features[i].getGeometry().getFirstCoordinate()+"</p>";
								html += "<p>Coordenada Final: "+features[i].getGeometry().getLastCoordinate()+"</p>";
								
							}
							
							if (features[i].getGeometry().getType() == "Polygon") {
								
								html += "<p>Geometría de Polígono</p>";
								html += "<p>Coordenadas: "+features[i].getGeometry().getCoordinates()+"</p>";
								html += "<p>Extent: "+features[i].getGeometry().getExtent()+"</p>";
								html += "<p>Área: "+((features[i].getGeometry().getArea())/1000)+" Km.</p>";
								
							}
							if (i!=(len-1)) { html += "<hr>"; }
							html += "</div>";
							
							document.getElementById("info-features").innerHTML += html;
						 
						}
					
					}
					 
				});
				
				this.ol_object.addInteraction(this.select);	
				this.ol_object.removeInteraction(this.draw);
				this.ol_object.removeInteraction(this.modify);	
				
				break;
				
				case "Modify":
				
				if (this.modify) {
					
					this.ol_object.removeInteraction(this.modify);			
				
				}else{
				
					if (!this.select) {
						
						this.select = new ol.interaction.Select({
							wrapX: false
						});
						
					}
					
					var select = this.select;
				
					this.modify = new ol.interaction.Modify({
						features: select.getFeatures()
					});
					
				}			
				
				this.ol_object.addInteraction(this.select);
				this.ol_object.addInteraction(this.modify);	
				this.ol_object.removeInteraction(this.draw);
				
				break;
				
				default:
				
				this.draw = new ol.interaction.Draw({
					source: this.drawing.source,
					type:type			
				});
					
				this.ol_object.addInteraction(this.draw);	
				this.ol_object.removeInteraction(this.select);
				this.ol_object.removeInteraction(this.modify);	
				
				break;
				
			}			
			
		}
	
	}
	
	this.map.medicion = function(type,node) {
		
		if ($(node).hasClass("toggleable-tool-active")) {
			
			this.medicion.source.clear();
			
			if (this.medi_draw) { this.ol_object.removeInteraction(this.medi_draw); }
			
			$(node).removeClass("toggleable-tool-active");
			
			this.ol_object.infoEnabled = true;
			
			jwindow.close("popup-medicion");
			
		}else{
			
			$(".toggleable-tool-active").not(node).trigger("click");
			$(node).addClass("toggleable-tool-active");		
			this.ol_object.infoEnabled = false;
			
			if (!this.medicion.source) {
			
				this.medicion.source = new ol.source.Vector({
					wrapX: false
				});
				
				this.medicion.sourcePoints = new ol.source.Vector({
					wrapX: false
				});
				
				this.medicion.layerVector = new ol.layer.Vector({
					source: this.medicion.source
				});
				
				this.medicion.layerPointVector = new ol.layer.Vector({
					source: this.medicion.sourcePoints
				});
				
				this.ol_object.addLayer(this.medicion.layerVector);
				this.ol_object.addLayer(this.medicion.layerPointVector);
			
			}
			
			this.medicion.source.clear();
			
			this.medi_draw = new ol.interaction.Draw({
				source: this.medicion.source,
				type:type	
			});

			this.medi_draw.on('drawend', function (e) {
				
				var format = new ol.format.WKT();
				
				var wkt = format.writeGeometry(e.feature.getGeometry().transform('EPSG:3857', 'EPSG:4326'));
				
				var wktext = wkt;
				
				var wkt = format.writeGeometry(e.feature.getGeometry().transform('EPSG:4326', 'EPSG:3857'));	
								
				var req = $.ajax({
					
					async:false,
					type:"post",
					url:"./php/get-medicion.php",
					data:{wkt:wkt,type:type},
					success:function(d){}
					
				});
				
				document.getElementById("info-medicion").innerHTML = req.responseText;
				
				jwindow.open("popup-medicion");
				
			}.bind(this));
			
			this.ol_object.addInteraction(this.medi_draw);
		
		}
		
	}
	
	this.map.ptopografico = function(node) {
		
		if ($(node).hasClass("toggleable-tool-active")) {
			
			this.ptopografico.source.clear();
			
			if (this.ptopo_draw) { this.ol_object.removeInteraction(this.ptopo_draw); }
			
			$(node).removeClass("toggleable-tool-active");
			
			this.ol_object.infoEnabled = true;
			
			jwindow.close("popup-ptopografico");
			
		}else{
			
			$(".toggleable-tool-active").not(node).trigger("click");
			$(node).addClass("toggleable-tool-active");
			this.ol_object.infoEnabled = false;
			
			if (!this.ptopografico.source) {
			
				this.ptopografico.source = new ol.source.Vector({
					wrapX: false
				});
				
				this.ptopografico.sourcePoints = new ol.source.Vector({
					wrapX: false
				});
				
				this.ptopografico.layerVector = new ol.layer.Vector({
					source: this.ptopografico.source
				});
				
				this.ptopografico.layerPointVector = new ol.layer.Vector({
					source: this.ptopografico.sourcePoints
				});
				
				this.ol_object.addLayer(this.ptopografico.layerVector);
				this.ol_object.addLayer(this.ptopografico.layerPointVector);
			
			}
			
			this.ptopo_draw = new ol.interaction.Draw({
				source: this.ptopografico.source,
				type:"LineString"			
			});
			
			this.ptopo_draw.on('drawend', function (e) {
				
				jwindow.open("popup-preloader");
				
				var format = new ol.format.WKT();
				
				var wkt = format.writeGeometry(e.feature.getGeometry().transform('EPSG:3857', 'EPSG:4326'));		
				
				var wktext = wkt;
				
				var wkt = format.writeGeometry(e.feature.getGeometry().transform('EPSG:4326', 'EPSG:3857'));	
				
				DrawChart(wktext,this.ptopografico.layerVector,this.ptopografico.sourcePoints);
				
			}.bind(this));
			
			this.ol_object.addInteraction(this.ptopo_draw);
		
		}
		
	}
	
	this.map.fixPopup = function(adv) {
		
		if (adv) {
		
			// ARREGLAR FIX POPUP
			var pb_h = $("#popup-body").height();
			var s_h = $("#geovisor-popup-search").height();
			
			var n_h = (pb_h-s_h-300);
			
			$("#dynbox-popup-layers").css("height",n_h+"px");
			
		}else{		
		
			// ARREGLAR FIX POPUP
			var pb_h = $("#popup-body").height();
			var s_h = $("#geovisor-popup-search").height();
			
			var n_h = (pb_h-s_h-300);
			
			$("#dynbox-popup-layers").css("height",n_h+"px");
			
		}
		
	}
	
	this.map.togglePopupLayers = function(node) {
		
		var nodeState = $(node).closest(".popup-layer-node").attr("data-state");
		
		if (nodeState == 0) {
			
			$(node).closest(".popup-layer-node").addClass("popup-layer-node-active");
			
			$(node).closest(".popup-layer-node").each(function(i,v) {
				
				$(v).find(".layer-icon").each(function(j,x) {
					
					var srcSource = $(x).children("a").children("img").attr("data-active");
					
					$(x).children("a").children("img").attr("src",srcSource);
					
				});
				
			});
			
			$(node).closest(".popup-layer-node").attr("data-state","1");
		
		}else{
			
			$(node).closest(".popup-layer-node").removeClass("popup-layer-node-active");
			
			$(node).closest(".popup-layer-node").each(function(i,v) {
				
				$(v).find(".layer-icon").each(function(j,x) {
					
					var srcSource = $(x).children("a").children("img").attr("data-inactive");
					
					$(x).children("a").children("img").attr("src",srcSource);
					
				});
				
			});
			
			$(node).closest(".popup-layer-node").attr("data-state","0");
			
		}
		
		$(node).closest(".popup-layer-node").next(".popup-layer-content").slideToggle("fast");
		
	}
	
	this.map.fixLegend = function(layer_id) {
		
		var node = $("#layer-legend-"+layer_id);

		var nodeWidth = $(node).width();

		var nodeSon = $(node).children("img");
		
		var nodeSonWidth = $(node).children("img").width();
		
		if (nodeSonWidth >= nodeWidth) {
			
			$(nodeSon).attr("width","95%");
			
		}
		
	}
	
	// PANEL SCRIPTS 
	
	this.panel.map = this.map;
	
	this.panel.start = function() {
		
		var height = $("#nav-panel").height();
		
		$("#nav-panel-inner").height(height-34);
		
		$("#layer-bullet").on("click",function() {
			
			var navWidth = $("#nav-panel").width();
			var navState = $("#nav-panel").attr("data-visible");
			
			flotant.toggle('#nav-panel',true,function() {
				
				if (navState == 1) {
					
					$("#layer-bullet").animate({"left":"0px"},"fast");
					
				}else{
					
					$("#layer-bullet").animate({"left":(navWidth-59)+"px"},"fast");
					
				}
				
			});
			
		});
		
		$("#btn-bus-simple").on("click",function() {
			
			$("#geovisor-popup-search").slideUp();
			$("#geovisor-popup-search-mobile").slideUp();
			$("#popup-basic-filters").slideDown();
			$("#popup-header .button").removeClass("button-active");
			$(this).addClass("button-active");
			
			geomap.map.fixPopup(false);
			scroll.refresh();
			
		});
		
		$("#btn-bus-advanced").on("click",function() {
			
			$("#geovisor-popup-search").slideDown();
			$("#geovisor-popup-search-mobile").slideDown();
			$("#popup-basic-filters").slideUp();
			$("#popup-header .button").removeClass("button-active");
			$(this).addClass("button-active");
			
			geomap.map.fixPopup(true);
			scroll.refresh();
			
		});
		
		$("#btn-bus-reset").on("click",function() {
			
			$("#frm-adv-search input[type=text]").val("");
			$("#frm-adv-search select").val(-1);
			$("#frm-adv-search select").selectpicker("refresh");

			$("#popup-basic-filters input[type=checkbox]:checked").trigger("click");
			
			$("#filtered-layer-list").empty();
			
			geomap.map.fixPopup(true);
			scroll.refresh();
			
		});
		
		$(".default-empty-checkbox").each(function(i,v) {
			
			v.checked = false;
			
		});
		
		$(".phanel .panel-arrow-link").each(function(i,v) {
			
			$(v).on("click",function() {
				
				if (v.getAttribute("data-state") == 1) {
													
					$(v).parent().parent().parent().animate({
						
						left:$("#page").offset().left-370 + "px"
						
					},1000,function() {
						
						$(v).children("img").attr("src","./images/panel.icon.arrow.0.png");
						
					});
					
					$(v).attr("data-state",0);
					
				}else{
					
					$(v).parent().parent().parent().animate({
						
						left:$("#page").css("left")
						
					},1000,function() {
						
						$(v).children("img").attr("src","./images/panel.icon.arrow.1.png");
						
					});
					
					$(v).attr("data-state",1);
				}
				
			});
			
		});
		
		$(".panel-abr").on("click",function() {
			
			if (this.getAttribute("data-active") == 0) {
				
				$(".panel-abr").attr("data-active","0");
				//$(".panel-abr").css("border-color","transparent");
				//$(".panel-abr").css("background-color","transparent");
				$(".panel-abr").css("background-color","#F5F5F5");
				$(".panel-abr").css("color","#888888");
				
				$(this).attr("data-active","1");
				//$(this).css("border-color",this.getAttribute("data-color"));
				//$(this).css("background-color",this.getAttribute("data-bgcolor"));
				$(this).css("background-color","#31cbfd");
				$(this).css("color","#FFFFFF");
				
				$(".layer-container").not(".layer-container[data-cid="+this.getAttribute("data-cid")+"]").hide();
				$(".layer-container[data-cid="+this.getAttribute("data-cid")+"]").show();
				
				//$("#abr-container").first(".panel-abr").prepend(this);			
				scroll.refresh();
				
			}
			
		});
		
		$("#panel-seach-input").on("focus",function() {
			
			$(".popup").hide();
			$("#popup-busqueda").show();
			
			this.map.ol_object_mini.updateSize();
			this.map.ol_object_mini.render();
			
		}.bind(this));
		
		$(".basic-filter-checkbox").each(function(i,v) {
			
			$(v).on("click",function() {
			
				this.UpdatePopupListBasic();
				
			}.bind(this));
			
		}.bind(this));
		
		$("#btn-adv-search").on("click",function() {
			
			this.UpdatePopupListAdvanced();
			
		}.bind(this));
		
		$("#btn-adv-search-mobile").on("click",function() {
			
			this.UpdatePopupListAdvanced();
			
		}.bind(this));
		
		$(".simple-tree-pm-button").each(function(i,v) {
			
			$(v).on("click",function() {
			
				if ($(v).children("i").hasClass("fa-angle-up")) {
					
					$(v).children("i").removeClass("fa-angle-up");
					$(v).children("i").addClass("fa-angle-down");
					
				}else{
					
					$(v).children("i").removeClass("fa-angle-down");
					$(v).children("i").addClass("fa-angle-up");
					
				}
				
				$(v).parent().next('.layer-body').slideToggle('slow');
			
			});
			
		});
		
		$("form input").val("");
		$("form select").prop("selectedIndex", 0);
		$("form select").selectpicker("refresh");
		
		$(".layer-icon-buffer").each(function(i,v) {
			
			$(v).bind("click",function() {
				
				if ($(v).attr("data-state") == 1) {
					
					var layer_id = $(v).attr("data-lid");
					
					if (this.map.layersBuffer[layer_id]) {
						this.map.layersBuffer[layer_id].destroy();
						this.map.layersBuffer[layer_id] = false;
					}
					
					
				}
				
			}.bind(this));
			
		}.bind(this));
		
	}
	
	this.panel.UpdatePopupListBasic = function() {
		
		var filter = [];
		
		$(".basic-filter-checkbox").each(function() {
			
			if (this.checked) {
				
				filter.push(this.getAttribute("data-spid"));
				
			}
			
		});
		
		var geovisor = this.map.geovisor;
		
		var req = $.ajax({
			
			async:false,
			type:"post",
			data:{proyectos:filter,geovisor:geovisor},
			url:"./php/filter-proyectos-basic.php",
			success:function(d){}
			
		});
		
		$("#filtered-layer-list").html(req.responseText);		
		
		scroll.refresh();		
		
		$(".popup-panel-tree-item-header").on("click",function() {
			
			if (this.parentNode.getAttribute("data-state") == 1) {
				
				$(this).find(".popup-panel-tree-item-icon").removeClass("far").removeClass("popup-icon-active").addClass("fas");
				
				$(this).find(".popup-panel-tree-item-label").removeClass("popup-text-active");
				
				$(this).find(".popup-panel-tree-item-icon-toggler").removeClass("fa-angle-up").addClass("fa-angle-down");
				
				$(this).next(".popup-panel-tree-item-subpanel").slideToggle("slow",function() {					
					
					scroll.refresh();
					
				});
				
				this.parentNode.setAttribute("data-state",0);
				
			}else{
				
				$(this).find(".popup-panel-tree-item-icon").addClass("far").addClass("popup-icon-active").removeClass("fas");
				
				$(this).find(".popup-panel-tree-item-label").addClass("popup-text-active");
				
				$(this).find(".popup-panel-tree-item-icon-toggler").removeClass("fa-angle-down").addClass("fa-angle-up");
				
				$(this).next(".popup-panel-tree-item-subpanel").slideToggle("slow",function() {					
					
					scroll.refresh();
					
				});
				
				this.parentNode.setAttribute("data-state",1);
				
			}
			
		});
	}
	
	this.panel.UpdatePopupListAdvanced = function(mode) {
		
		if ($("#frm-adv-search:visible").length > 0) {
			
			var filter = $("#frm-adv-search").serialize();
			
		}else{
			
			var filter = $("#frm-adv-search-mobile").serialize();
			
		}
		
		var geovisor = this.map.geovisor;
		
		var req = $.ajax({
			
			async:false,
			type:"post",
			data:filter+"&geovisor="+geovisor,
			url:"./php/filter-proyectos-advanced.php",
			success:function(d){}
			
		});
		
		$("#filtered-layer-list").html(req.responseText);		
		
		scroll.refresh();		
		
		$(".popup-panel-tree-item-header").on("click",function() {			
			
			if (this.parentNode.getAttribute("data-state") == 1) {
				
				$(this).find(".popup-panel-tree-item-icon").removeClass("far").removeClass("popup-icon-active").addClass("fas");
				
				$(this).find(".popup-panel-tree-item-label").removeClass("popup-text-active");
				
				$(this).find(".popup-panel-tree-item-icon-toggler").removeClass("fa-minus-circle").addClass("fa-plus-circle");
				
				$(this).next(".popup-panel-tree-item-subpanel").slideToggle("slow",function() {					
					
					scroll.refresh();
					
				});
				
				this.parentNode.setAttribute("data-state",0);
				
			}else{
				
				$(this).find(".popup-panel-tree-item-icon").addClass("far").addClass("popup-icon-active").removeClass("fas");
				
				$(this).find(".popup-panel-tree-item-label").addClass("popup-text-active");
				
				$(this).find(".popup-panel-tree-item-icon-toggler").removeClass("fa-plus-circle").addClass("fa-minus-circle");
				
				$(this).next(".popup-panel-tree-item-subpanel").slideToggle("slow",function() {					
					
					scroll.refresh();
					
				});
				
				this.parentNode.setAttribute("data-state",1);
				
			}
			
		});
		
	}
	
	this.panel.PreviewLayer = function(layer_id) {
		
		var req = $.ajax({
			
			async:false,
			url:"./php/get-layer-preview.php",
			type:"post",
			data:{layer_id:layer_id},
			success:function(d){}
			
		});
		
		$("#layer-preview-block").html(req.responseText);
		
		var clase_id = $(".layer-group[data-layer="+layer_id+"]").attr("data-cid");		
		$("#btn-layer-preview-addlayer").attr("onclick","geomap.panel.AddLayer(" + clase_id + "," + layer_id + ",true,true)");
		
		$("#btn-layer-preview-addlayer").show();
		$("#btn-layer-preview-gomap").show();
		
		if (!document.getElementById("layer-checkbox-"+layer_id).layer_preview) {
			
			var layer_name = document.getElementById("layer-checkbox-"+layer_id).getAttribute("data-layer");
			var layer_wms = document.getElementById("layer-checkbox-"+layer_id).getAttribute("data-wms");
			
			document.getElementById("layer-checkbox-"+layer_id).layer_preview = new ol.layer.Tile({
				visible:true,
				source: new ol.source.TileWMS({
					url: layer_wms,
					params: {
						'LAYERS': layer_name,
						'VERSION': '1.1.1',
						'FORMAT': 'image/png',
						'TILED': false
					}
				})
			});
			
			this.map.ol_object_mini.addLayer(document.getElementById("layer-checkbox-"+layer_id).layer_preview);

		}
		
		var js = this.map.getLayerExtent(layer_id);
		
		var allLayers = geomap.map.ol_object_mini.getLayers().getArray();
		
		for (var i=0; i<allLayers.length; i++) {
			
			if (allLayers[i].get('name') != "google_base") {
				
				allLayers[i].setVisible(false);
			
			}
			
		}
		
		document.getElementById("layer-checkbox-"+layer_id).layer_preview.setVisible(true);
		
		var extent = ol.proj.transformExtent(
			[js.minx,js.miny,js.maxx,js.maxy],
			"EPSG:3857", "EPSG:3857"
		);
		
		this.map.ol_object_mini.getView().fit(extent,{duration:1000});
		this.map.ol_object_mini.updateSize();
		this.map.ol_object_mini.render();
		
	}
	
	this.panel.SetLayerActive = function(layer_id) {
		
		$(".layer-group[data-layer="+layer_id+"] .layer-label").addClass("layer-label-active");
		$(".layer-group[data-layer="+layer_id+"] .layer-body").show();
		
	}
	
	this.panel.AddLayer = function(clase_id,layer_id,startActive,visible) {
		
		$(".abr[data-cid="+clase_id+"]").show();
		$(".abr[data-cid="+clase_id+"]").trigger("click");
		$(".layer-group[data-layer="+layer_id+"]").show();
		
		if (startActive) {
			
			//$(".layer-group[data-layer="+layer_id+"] .layer-label").addClass("layer-label-active");
			//$(".layer-group[data-layer="+layer_id+"] .layer-body").show();
			
		}else{
			
			//$(".layer-group[data-layer="+layer_id+"] .layer-label").removeClass("layer-label-active");
			//$(".layer-group[data-layer="+layer_id+"] .layer-body").hide();
			
		}
					
		if (document.getElementById("layer-checkbox-"+layer_id)) {
			var layer_name = document.getElementById("layer-checkbox-"+layer_id).getAttribute("data-layer");
		}
		
		if (document.getElementById("layer-checkbox-"+layer_id)) {
			var layer_wms = document.getElementById("layer-checkbox-"+layer_id).getAttribute("data-wms");
		}
		
		if (visible) {
		
			this.CreateLayer(layer_id,layer_wms,layer_name,clase_id);
			
		}
		
		//document.getElementById("layer-checkbox-"+layer_id).layer.setVisible(false);
		
		$("#layer-checkbox-"+layer_id).bind("click",function() {
			
			if (document.getElementById("layer-checkbox-"+layer_id).checked) {
				
				if (!document.getElementById("layer-checkbox-"+layer_id).layer) {
					
					this.CreateLayer(layer_id,layer_wms,layer_name,clase_id);
					
				}else{
				
					document.getElementById("layer-checkbox-"+layer_id).layer.setVisible(true);
				
				}
				
			}else{
				
				document.getElementById("layer-checkbox-"+layer_id).layer.setVisible(false);
				
			}
			
		}.bind(this));
			
		//$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) + " - $" + $( "#slider-range" ).slider( "values", 1 ) );
		
	}
	
	this.panel.CreateLayer = function(layer_id,layer_wms,layer_name,clase_id) {
					
		document.getElementById("layer-checkbox-"+layer_id).layer = new ol.layer.Tile({
			name:layer_name,
			visible:true,
			source: new ol.source.TileWMS({
				url: layer_wms,
				params: {
					'LAYERS': layer_name,
					'VERSION': '1.1.1',
					'FORMAT': 'image/png',
					'TILED': false,
					'clase_id':clase_id,
					'layer_id':layer_id
				}/*,
				crossOrigin: 'anonymous'*/
			})
		});
		
		this.map.ol_object.addLayer(document.getElementById("layer-checkbox-"+layer_id).layer);
		
		$("#layer-checkbox-"+layer_id).attr("data-added","1");
		
		document.getElementById("layer-checkbox-"+layer_id).layer.colorpicker = true;

		var colorpickerInput = $("#layer-colorpicker-inner-"+layer_id);
		
		colorpickerInput.spectrum({
			color: "#ECC",
			flat: true,
			showInput: true,
			className: "full-spectrum",
			showInitial: true,
			showPalette: true,
			showSelectionPalette: true,
			maxPaletteSize: 10,
			preferredFormat: "hex",
			localStorageKey: "spectrum.example",
			chooseText: "Seleccionar",
			cancelText: "Cancelar",
			move: function (color) {
			},
			show: function () {

			},
			beforeShow: function () {

			},
			hide: function (color) {
			},
			change: function(color) {
				
				var layer = document.getElementById("layer-checkbox-"+layer_id).layer;
				var layer_name = document.getElementById("layer-checkbox-"+layer_id).getAttribute("data-layer");
				var type = document.getElementById("layer-checkbox-"+layer_id).getAttribute("data-layer-type");
				var layer_types = ['',0,1,2,2,1,0,0];
				var cl = String(color);
					cl = cl.substring(1,cl.length).trim();
				
				s = new sldlib();
				
				s.set_geometria(layer_types[type]);
				s.set_fill_color(cl);
				s.set_border_color('CCCCCC');
				s.set_border_size(1);
				s.set_size(8.3444);
				s.set_simbolo('circle');
				s.set_titulo(layer_name);
				
				sld_result = s.sld_get(layer_id);
				
				layer.getSource().updateParams({
					
					'sld_body':sld_result
					
				})
				
				//layer.changed();
				layer.getSource().tileCache.expireCache({});
				layer.getSource().tileCache.clear();
				layer.getSource().refresh();
				
				$("#palette-clear-layer").remove();
				
				$(".sp-palette-row-selection").append(
					$("<span></span>")
						.attr("class","sp-thumb")
						.attr("id","palette-clear-layer")
						.attr("title","Reiniciar Estilo")
						.css({
							display:"inline-flex",
							justifyContent:"center",
							alignItems:"center",
							cursor:"pointer",
							width:"18px",
							height:"18px"
						})
						.append($("<i></i>").attr("class","fas fa-ban").css("color","red"))
						.on("click",function() {
							
							var layer = document.getElementById("layer-checkbox-"+layer_id).layer;
							var layer_name = document.getElementById("layer-checkbox-"+layer_id).getAttribute("data-layer");
							var type = document.getElementById("layer-checkbox-"+layer_id).getAttribute("data-layer-type");
							var layer_types = ['',0,1,2,2,1,0,0];
							var cl = String(color);
								cl = cl.substring(1,cl.length).trim();
							
							s = new sldlib();
							
							sld_result = s.sld_get(layer_id);
							
							s.clear();
							
							layer.getSource().updateParams({
								
								'sld_body':sld_result
								
							})
							
							//layer.changed();
							layer.getSource().tileCache.expireCache({});
							layer.getSource().tileCache.clear();
							layer.getSource().refresh();
							
						})
				);
				
			},

			palette: [
				["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)","rgb(255, 255, 255)",
				"rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
				"rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)",
				"rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
				"rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",
				"rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
				"rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",
				"rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
				"rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
				"rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
				"rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
				"rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
				"rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
			]
		});
		
		/*$("#layer-colorpicker-inner-"+layer_id).ColorPicker({
			flat: true, 
			width:"100%",
			onSubmit: function (hsb, hex, rgb) {
				
				//var layer_types = ["","GEOMETRY","LINESTRING","POLYGON","MULTIPOLYGON","MULTILINESTRING","POINT","MULTIPOINT");
				var layer = document.getElementById("layer-checkbox-"+layer_id).layer;
				var color = hex;
				var layer_name = document.getElementById("layer-checkbox-"+layer_id).getAttribute("data-layer");
				var type = document.getElementById("layer-checkbox-"+layer_id).getAttribute("data-layer-type");
				var layer_types = ['',0,1,2,2,1,0,0];
				
				s = new sldlib();
				
				s.set_geometria(layer_types[type]);
				s.set_fill_color("#"+hex);
				s.set_border_color('#CCCCCC');
				s.set_border_size(1);
				s.set_size(8.3444);
				s.set_simbolo('circle');
				s.set_titulo(layer_name);
				
				sld_result = s.sld_get();
				
				layer.getSource().updateParams({
					
					'sld_body':sld_result
					
				})
				
				//layer.changed();
				layer.getSource().tileCache.expireCache({});
				layer.getSource().tileCache.clear();
				layer.getSource().refresh();
				
			}
		});*/
		
		$(".layer-group[data-layer="+layer_id+"] .layer-label").bind("click",function() {
			
			$("#layer-legend-"+layer_id).html("<img onload=\"geomap.map.fixLegend("+layer_id+")\"; src=\"" + layer_wms + "&version=1.3.0&service=WMS&request=GetLegendGraphic&sld_version=1.1.0&layer="+layer_name+"&format=image/png&\">");
			
		});
		
		
		if ($("#nav-panel").attr("data-visible") == 0) {
			
			$("#layer-bullet").trigger("click");
			
		}
		
		$("#layer-checkbox-"+layer_id).attr("data-added","1");
		
		$("#transp-value-"+layer_id).val(100+"%");
		
		$( "#slider-range-"+layer_id ).slider({			
			values: [ 100 ],
			slide: function( event, ui ) {
				$("#transp-value-"+layer_id).val(ui.values[ 0 ]+"%");
				document.getElementById("layer-checkbox-"+layer_id).layer.setOpacity(ui.values[0]/100);				
			}
		});
		
		this.AddLayerActive(clase_id,layer_id,false,-1,-1);
		this.map.updateLayerCount();
		this.updateLayerCountPanelLabel(clase_id);
		
		document.getElementById("layer-checkbox-"+layer_id).click();
		
	}
	
	this.panel.bufferIndex = 0;
	this.panel.statsLayerIndex = 0;
	
	this.panel.AddLayerActive = function(clase_id,layer_id,isBuffer,bufferLayer,distance) {
		
		$("#nolayer-active").remove();
		
		var dataLidLabel = "data-lid";
		
		var container = document.getElementById("info-capasactivas-inner");
		
		var node = document.createElement("div");
			node.className = "active-layer-node";	
			node.setAttribute(dataLidLabel,layer_id);
			node.setAttribute("data-cid",clase_id);
			
		var nodeicons = document.createElement("div");
			nodeicons.className = "active-layer-node-icons";
			
		var nodeupdown = document.createElement("div");
			nodeupdown.className = "updown-layer-icon-ca";
			
		var nodeup = document.createElement("div");
			nodeup.className = "up-layer-icon-ca";
			nodeup.node = node;
			nodeup.panel = this;
			nodeup.onclick = function() {
				
				$(this.node).prev(".active-layer-node").before(node);				
				this.panel.RefreshActiveZIndex();
				
			}
			
		var nodedown = document.createElement("div");
			nodedown.className = "down-layer-icon-ca";
			nodedown.node = node;
			nodedown.panel = this;
			nodedown.onclick = function() {
				
				$(this.node).next(".active-layer-node").after(node);				
				this.panel.RefreshActiveZIndex();
				
			}
			
			nodeupdown.appendChild(nodeup);
			nodeupdown.appendChild(nodedown);
		
		var new_id = "active-layer-clone-" + clase_id + "-" + layer_id;
		
		if ($("#info-capasactivas").find("#"+new_id).length == 0) {
		
			$(".abr[data-cid="+clase_id+"]").first().clone().attr("id",new_id).addClass("abr-cloned").width(32).css("background-color","rgb(245, 245, 245)").css("color","rgb(136, 136, 136)").appendTo(node);
				
			if (isBuffer) {
				
				this.bufferIndex++;
				
				sublayer_id = "layer-buffer-" + layer_id + "-" + this.bufferIndex;
				
				$("#layer-checkbox-"+layer_id).parent().clone().attr("id",sublayer_id).on("click",function() {
					
					if (bufferLayer.getVisible()) {
						
						bufferLayer.setVisible(false);
							
					}else{
							
						bufferLayer.setVisible(true);
							
					}
					
				}).appendTo(node);
			
			}else{
								
				$("#layer-checkbox-"+layer_id).parent().clone().on("click",function() {
					
					$("#layer-checkbox-"+layer_id).trigger("click");
					
				}).appendTo(node);
				
			}
			
			var text = $("#layer-checkbox-"+layer_id).parent().next().text();
			
			/*if (text.length > 33) {
				
				text = text.substring(0,33) + "...";
				
			}*/
			
			if (isBuffer) { text = "Buffer: " + text + ", Distancia: " + distance }
			
			$("#layer-checkbox-"+layer_id).parent().next().clone().attr("onclick","").text(text).css("cursor","text").appendTo(node);	
			
			nodeicons.appendChild(nodeupdown);
			
			$("#layer-checkbox-"+layer_id).parent().next().next().clone().removeAttr("id").removeAttr("onclick").addClass("remove-layer-icon-ca").bind("click",function() {
				
				if (isBuffer) {
					
					geomap.map.ol_object.removeLayer(layerBuffer);
					$("#"+sublayer_id).parent().remove();
				
				}else{
					
					$("#remove-layer-icon-"+layer_id).trigger("click");
					
				}
				
				if ($("#info-capasactivas-inner").children(".active-layer-node").length == 0) {
					
					$("#info-capasactivas-inner").html("<p id=\"nolayer-active\" class=\"p20\">No hay capas activas, para agregar capas al mapa utilice el botón correspondiente ubicado en la barra de herramientas.</p>");
					
				}
				
			}).appendTo(nodeicons);		
			
			$("#layer-icon-zoomext-"+layer_id).clone().removeAttr("id").addClass("zoomext-layer-icon-ca").bind("click",function() {
				
				$("#layer-icon-zoomext-"+layer_id).trigger("click");
				
			}).appendTo(nodeicons);
			
			node.appendChild(nodeicons);
			
					
		}		
			
		container.appendChild(node);
		
		this.RefreshActiveZIndex();
		
	}
	
	this.panel.AddLayerActiveFromStats = function(query_id,layer) {
		
		$("#nolayer-active").remove();
		
		var layer_id = this.map.layersStatsIndex;
		var clase_id = this.map.layersStatsIndex;
		this.map.layersStats[this.map.layersStatsIndex] = layer;
		
		this.map.layersStatsIndex++;
		
		var dataLidLabel = "data-lid";
		
		var container = document.getElementById("info-capasactivas-inner");
		
		var node = document.createElement("div");
			node.className = "active-layer-node";	
			node.setAttribute(dataLidLabel,layer_id);
			node.setAttribute("data-cid",clase_id);
			
		var nodeicons = document.createElement("div");
			nodeicons.className = "active-layer-node-icons";
			
		var nodeupdown = document.createElement("div");
			nodeupdown.className = "updown-layer-icon-ca";
			
		var nodeup = document.createElement("div");
			nodeup.className = "up-layer-icon-ca";
			nodeup.node = node;
			nodeup.panel = this;
			nodeup.onclick = function() {
				
				$(this.node).prev(".active-layer-node").before(node);				
				this.panel.RefreshActiveZIndex();
				
			}
			
		var nodedown = document.createElement("div");
			nodedown.className = "down-layer-icon-ca";
			nodedown.node = node;
			nodedown.panel = this;
			nodedown.onclick = function() {
				
				$(this.node).next(".active-layer-node").after(node);				
				this.panel.RefreshActiveZIndex();
				
			}
			
			nodeupdown.appendChild(nodeup);
			nodeupdown.appendChild(nodedown);
			
		var nodezoomext = document.createElement("div");
			nodezoomext.className = "layer-icon zoomext-layer-icon-ca";
		
		var nodezoomexta = document.createElement("a");
			nodezoomexta.href = "javascript:void(0);";
			nodezoomexta.onclick = function() {
				
				var reqExtent = $.ajax({
			
					async:false,
					url:"./php/get-layer-extent-mapeo.php",
					type:"post",
					data:{query_id:query_id},
					success:function(d){}
						
				});
				
				var js = JSON.parse(reqExtent.responseText);
				
				var extent = ol.proj.transformExtent(
					[js.minx,js.miny,js.maxx,js.maxy],
					"EPSG:3857", "EPSG:3857"
				);
				
				this.map.ol_object.getView().fit(extent,{duration:1000});
				this.map.ol_object.updateSize();
				this.map.ol_object.render();
				
			}.bind(this);
			
		var nodezoomextimg = document.createElement("img");
			nodezoomextimg.src = "./images/geovisor/icons/layer-bar-zoom.png";
			
			nodezoomext.appendChild(nodezoomexta);
			nodezoomexta.appendChild(nodezoomextimg);
			
		var noderemove = document.createElement("a");
			noderemove.className = "simple-tree-pm-button remove-layer-icon-ca";
			noderemove.href = "javascript:void(0);";
			noderemove.onclick = function() {
				
				$(noderemove).closest(".active-layer-node").remove();
				this.map.ol_object.removeLayer(layer);
				
				if ($("#info-capasactivas-inner").children(".active-layer-node").length == 0) {
					
					$("#info-capasactivas-inner").html("<p id=\"nolayer-active\" class=\"p20\">No hay capas activas, para agregar capas al mapa utilice el botón correspondiente ubicado en la barra de herramientas.</p>");
					
				}
				
			}.bind(this);
			
		var noderemovei = document.createElement("i");
			noderemovei.className = "fa fa-trash popup-panel-tree-item-icon-toggler popup-icon";
			
			noderemove.appendChild(noderemovei);
			
			nodeicons.appendChild(nodeupdown);
			nodeicons.appendChild(nodezoomext);
			nodeicons.appendChild(noderemove);
		
		var abr = document.createElement("div");
			abr.className = "abr panel-abr abr-cloned";
			abr.style.width = "32px";
			abr.style.backgroundColor = "rgb(245, 245, 245)";
			abr.style.color = "rgb(136, 136, 136)";
			abr.innerHTML = "<span>DT</span>";
			abr.id = "active-layer-fromstats-"+this.statsLayerIndex;
		
			//$(".abr").first().clone().attr("id",new_id).addClass("abr-cloned").width(32).css("background-color","rgb(245, 245, 245)").css("color","rgb(136, 136, 136)").html("<span>DT</span>").appendTo(node);
		
		var pretty = document.createElement("div");
			pretty.className = "pretty p-default p-curve p-toggle";
			
		var layerCheck = document.createElement("input");
			layerCheck.id = "layer-checkbox-"+layer_id;
			layerCheck.className = "layer-checkbox default-empty-checkbox";
			layerCheck.style.display = "block";
			layerCheck.setAttribute("data-added","1");
			layerCheck.setAttribute("type","checkbox");
			layerCheck.layer = layer;
			layerCheck.onclick = function() {
				
				if (layer.getVisible()) {
					
					layer.setVisible(false);
						
				}else{
						
					layer.setVisible(true);
						
				}
				
			}
			
		var layerCheckDivon = document.createElement("div");
			layerCheckDivon.className = "state p-success p-on";
			layerCheckDivon.title = "Mostrar Capa";
			
		var layerCheckDivonIcon = document.createElement("i");
			layerCheckDivonIcon.className = "fa fa-eye";
			
			layerCheckDivon.appendChild(layerCheckDivonIcon);
			
		var layerCheckDivoff = document.createElement("div");
			layerCheckDivoff.className = "state p-danger p-off";
			layerCheckDivoff.title = "Ocultar Capa";
			
		var layerCheckDivoffIcon = document.createElement("i");
			layerCheckDivoffIcon.className = "fa fa-eye-slash";
			
			layerCheckDivoff.appendChild(layerCheckDivoffIcon);
			
			pretty.appendChild(layerCheck);
			pretty.appendChild(layerCheckDivoff);
			pretty.appendChild(layerCheckDivon);
			
		var layerLabel = document.createElement("a");
			layerLabel.className = "layer-label";
			layerLabel.style.cursor = "text";
			layerLabel.innerHTML = "Capa mapeada desde módulo estadístico";			
			
			node.appendChild(abr);
			node.appendChild(pretty);
			node.appendChild(layerLabel);
			node.appendChild(nodeicons);
			
			this.statsLayerIndex++;
			
			container.appendChild(node);
		
			this.RefreshActiveZIndex();
		
	}
	
	this.panel.RefreshActiveZIndex = function() {
		
		var nodes = document.getElementsByClassName("active-layer-node");
				
		for (var i=0, j=nodes.length; i<nodes.length; i++,j--) {
			
			var layer_id = nodes[i].getAttribute("data-lid");
			
			if (document.getElementById("layer-checkbox-"+layer_id)) {
			
				document.getElementById("layer-checkbox-"+layer_id).layer.setZIndex(j);
			
			}else{
				
				if (document.getElementById("layer-buffer-"+layer_id)) {
					
					document.getElementById("layer-buffer-"+layer_id).layer.setZIndex(j);
					
				}
				
			}
						
		}
		
		if (this.map.markersLayer) {
			
			this.map.markersLayer.setZIndex(j+10000);
			
		}
		
	}
	
	this.panel.removeLayer = function(layer_id,clase_id) {
		
		$(".layer-group[data-layer="+layer_id+"]").hide();
		document.getElementById("layer-checkbox-"+layer_id).layer.setVisible(false);
		
		$("#layer-checkbox-"+layer_id).attr("data-added","0");
		
		var visibles = $(".layer-container[data-cid="+clase_id+"] .layer-group:visible").length;
		
		if (visibles == 0) {
			
			$(".layer-container[data-cid="+clase_id+"]").hide();
			$(".panel-abr[data-cid="+clase_id+"]").hide();
			$(".panel-abr[data-cid="+clase_id+"]").attr("data-active","0");
			
		}
		
		if (this.map.layersBuffer[layer_id]) {
		
			var layer = this.map.layersBuffer[layer_id];
			
			this.map.ol_object.removeLayer(layer);
			
			this.map.layersBuffer[layer_id] = false;
			
			$("#buffer-input-"+layer_id).val("");
			$("#buffer-input-"+layer_id).next().html("AGREGAR");
		
		}
		
		$(".active-layer-node[data-lid="+layer_id+"]").remove();
		
		if ($("#info-capasactivas-inner").children(".active-layer-node").length == 0) {
					
			$("#info-capasactivas-inner").html("<p id=\"nolayer-active\" class=\"p20\">No hay capas activas, para agregar capas al mapa utilice el botón correspondiente ubicado en la barra de herramientas.</p>");
			
		}
		
		this.updateLayerCountPanelLabel(clase_id);
		
	}
	
	this.panel.checkBuffer = function(layer_id,clase_id,node) {
		
		var state = node.getAttribute("data-state");
		
		if (state == 1) {
			
			var layer = this.map.layersBuffer[layer_id];
			
			this.map.ol_object.removeLayer(layer);
			
			this.map.layersBuffer[layer_id] = false;
			
			$("#buffer-input-"+layer_id).val("");
			$("#buffer-input-"+layer_id).next().html("AGREGAR");
			
		}
		
	}
	
	this.panel.updateLayerCountPanelLabel = function(clase_id) {
		
		var cant = $(".layer-container[data-cid="+clase_id+"]:visible").find(".layer-group:visible").length;
		$("#abr-layer-count-"+clase_id).html(cant);
		
	}
	
	// POPUP SCRIPTS
	
	this.popup.panel = this.panel;
	
	this.popup.startInterface = function() {
		
		$(".popup-header-button-toggleable").on("click",function() {
			
			var thistar = this.getAttribute("data-target");
			
			$(this).closest(".nav").find(".popup-header-button-toggleable").not(this).removeClass("popup-header-button-active");
			
			$(this).addClass("popup-header-button-active");
			
		});
		
		$(".popup-panel-tree-item-header").on("click",function() {
			
			if (this.parentNode.getAttribute("data-state") == 1) {
				
				$(this).find(".popup-panel-tree-item-icon").removeClass("far").removeClass("popup-icon-active").addClass("fas");
				
				$(this).find(".popup-panel-tree-item-label").removeClass("popup-text-active");
				
				$(this).find(".popup-panel-tree-item-icon-toggler").removeClass("fa-minus-circle").addClass("fa-plus-circle");
				
				$(this).next(".popup-panel-tree-item-subpanel").slideToggle("slow",function() {					
					
					scroll.refresh();
					
				});
				
				this.parentNode.setAttribute("data-state",0);
				
			}else{
				
				$(this).find(".popup-panel-tree-item-icon").addClass("far").addClass("popup-icon-active").removeClass("fas");
				
				$(this).find(".popup-panel-tree-item-label").addClass("popup-text-active");
				
				$(this).find(".popup-panel-tree-item-icon-toggler").removeClass("fa-plus-circle").addClass("fa-minus-circle");
				
				$(this).next(".popup-panel-tree-item-subpanel").slideToggle("slow",function() {					
					
					scroll.refresh();
					
				});
				
				this.parentNode.setAttribute("data-state",1);
				
			}
			
		});
		
		/*$(".btn-plus-layer").each(function(i,v) {
			
			$(v).on("click",function() {
				
				$(v).parent().next().slideToggle("slow");
					
				if ($(v).children("i").hasClass("fa-minus-circle")) {
					
					$(v).children("i").removeClass("fa-minus-circle");
					$(v).children("i").addClass("fa-plus-circle");
					
				}else{
						
					$(v).children("i").removeClass("fa-plus-circle");
					$(v).children("i").addClass("fa-minus-circle");
						
				}
				
			});
			
		});*/
		
		$("#btn-popup-basic").trigger("click");
		
		$(".layer-container-header .pretty .layer-checkbox").each(function(i,v) {
			
			$(v).on("click",function() {
				
				if (v.checked) {
					
					$(v).closest(".layer-container").find(".layer-container-body").find(".layer-checkbox:visible:not(:checked)").trigger("click");
					
				}else{
					
					$(v).closest(".layer-container").find(".layer-container-body").find(".layer-checkbox:visible:checked").trigger("click");				
					
				}
				
			});
			
		});
		
	}
	
	this.popup.fixSize = function(otherElements) {
		
		var docheight = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
		var docwidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
		
		var otherElementsTotalHeight = 0;
		
		var left = $("#panel-left").width()+50;
		var nwidth = docwidth - left - 50;
		
		var windowTotalHeight = $(document).height();
		
		for (var i=0; i<otherElements.length; i++) {
			
			otherElementsTotalHeight += $(otherElements[i]).outerHeight();
		
		}
		
		var nheight = docheight - otherElementsTotalHeight;
		
		$("#popup-preloader").width(nwidth/3);
		$("#popup-preloader").css("top","50%");
		$("#popup-preloader").css("margin-top","-200px");
		$("#popup-preloader").css("left","50%");
		$("#popup-preloader").css("margin-left","-" + ((nwidth/3)/2) + "px");
		
		$("#print-legend-wrapper").width(nwidth/3);
		$("#print-legend-wrapper").height(300);
		
		$("#popup-buffer").css("right","20px");
		
		$("#info-wrapper").height(400);
		
	}

	this.popup.start = function() {
		
		this.startInterface();
		this.fixSize([document.getElementById("nav-1"),document.getElementById("nav-2")]);
		$(".popup").draggable({handle:".popup-header"});
		
	}
	
}