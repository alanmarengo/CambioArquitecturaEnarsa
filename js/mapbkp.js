function ol_map() {

	this.container = {};
	this.nav = {};
	this.panel = {};
	this.map = {};
	this.popup = {};
	this.map.baselayers = {};
	
	this.map.geovisor = -1;
	
	this.resize = function() {
		
		geomap.nav.start();
		geomap.nav.reset();
		geomap.container.fixSize([document.getElementById("nav-1"),document.getElementById("nav-2")]);
		
	}
	
	this.nav.start = function() {
		
		var docheight = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
	
		var width_nav = $("#navbarNav").width();
		$("#navbarNav").css("left","-"+width_nav+"px");
		$("#navbarNav").css("display","block");
		$("#navbarNav").height(docheight);
		
		$("#navbarNav .nav-link").bind("click",function() {			
						
			scrollbars.redrawElement(".scrollbar-content");
			
		});
		
		
	}
	
	this.nav.go = function() {
		
		var width_nav = $("#navbarNav").width();
		
		if (document.getElementById("navbarNav").getAttribute("data-state") == "0") {
			
			$("#navbarNav").animate({left:"0px"},700);
			$("#page").animate({left:width_nav+"px"},700);
			
			document.getElementById("navbarNav").setAttribute("data-state","1");
			
			if (document.getElementById("panel-left")) {
				
				if ($("#panel-arrow-link").attr("data-state") == 0) {
					
					$("#panel-left").animate({ left:(width_nav - 370) + "px" });
					
				}else{
					
					$("#panel-left").animate({ left:width_nav + "px" });
					
				}
				
			}
			
		}else{
			
			$("#navbarNav").animate({left:"-"+width_nav+"px"},700);
			$("#page").animate({left:"0px"},700);
			
			document.getElementById("navbarNav").setAttribute("data-state","0");
			
			if (document.getElementById("panel-left")) {
				
				if ($("#panel-arrow-link").attr("data-state") == 0) {
					
					$("#panel-left").animate({ left:"-370px" });
					
				}else{
					
					$("#panel-left").animate({ left:"0px" });
					
				}
				
			}
			
		}
		
	}
	
	this.nav.reset = function() {
		
		var width_nav = $("#navbarNav").width();
		
		if (document.getElementById("navbarNav").getAttribute("data-state") == "0") {			
			
			$("#navbarNav").css({left:"-"+width_nav+"px"});
			$("#page").css({left:"0px"});
			
			if (document.getElementById("panel-left")) {
				
				if ($("#panel-arrow-link").attr("data-state") == 0) {
					
					$("#panel-left").css({ left:"-370px" });
					
				}else{
					
					$("#panel-left").css({ left:"0px" });
					
				}
				
			}
			
		}else{
			
			$("#navbarNav").css({left:"0px"});
			$("#page").css({left:width_nav+"px"});
			
			if (document.getElementById("panel-left")) {
				
				if ($("#panel-arrow-link").attr("data-state") == 0) {
					
					$("#panel-left").css({ left:(width_nav - 370) + "px" });
					
				}else{
					
					$("#panel-left").css({ left:width_nav + "px" });
					
				}
				
			}
			
		}
		
	}
	
	this.container.div = document.getElementById("map");

	this.container.fixSize = function(otherElements) {
		
		var otherElementsTotalHeight = 0;
		var windowTotalHeight = $(document).height();
		
		for (var i=0; i<otherElements.length; i++) {
			
			otherElementsTotalHeight += $(otherElements[i]).outerHeight();
		
		}
	
		var newHeight = windowTotalHeight - otherElementsTotalHeight;
		var oldHeight = $(this.div).height();
		
		/*var percentualHeight = newHeight * 100 / windowTotalHeight;
		
		if (newHeight > oldHeight) {
			$(this.div).height(percentualHeight+"%");
		}*/
		
		if (newHeight > oldHeight) {
			$(this.div).height(newHeight);
			$(".panel").height((newHeight+2)+8);
			$("#map").height((newHeight+2)+8);
			$(".panel").css("top",$(this.div).offset().top);
		}
		
		var lc_top = $("#layers-container").offset().top+42;
		var lc_newheight = $(document).height() - lc_top;
		
		$(".layer-container-body").height(lc_newheight);				
		scrollbars.redrawElement(".scrollbar-content");
		
	
	}
	
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
		
		this.baselayers.collection = [this.baselayers.openstreets,this.baselayers.opentopo,this.baselayers.bing_roads,this.baselayers.bing_aerials,this.baselayers.google];
		
		document.getElementById("baselayer-default-radio").click();
		
		this.ol_object = new ol.Map({
			layers:this.baselayers.collection,
			target: 'map',
			extent: [-13281237.21183002,-7669922.0600572005,-738226.6183457375,-1828910.1066171727],
			controls: [],
			view: new ol.View({
				center: [-7176058.888636417,-4680928.505993671],
				zoom:3.8,
				minZoom: 3.8,
				maxZoom: 21
			})
		});
		
		this.baseLayer = this.baselayers.openstreets;		
		
		this.ol_object_mini = new ol.Map({
			layers:[this.baselayers.openstreets],
			target: 'mini-map',
			extent: [-13281237.21183002,-7669922.0600572005,-738226.6183457375,-1828910.1066171727],
			controls: [],
			view: new ol.View({
				center: [-7176058.888636417,-4680928.505993671],
				zoom:3.8,
				minZoom: 3.8,
				maxZoom: 21
			})
		});
		
		this.ol_object.map_object = this;
		
		this.ol_object.addEventListener("click",function(evt) {
			
			$("#info-wrapper").empty();
			
			this.map_object.gfiAddedLayers = [];
			
			var view = this.getView();
			var map = this.map_object;
			
			var viewResolution = (view.getResolution());
			var url = '';
			
			this.getLayers().forEach(function (layer, i, layers) {		
				
				var baselayer_names = ["openstreets","opentopo","bing","bing_roads","bing_aerials","google_base"];
				var isBase = false;
				
				for (var i=0; i<baselayer_names.length; i++) {
					
					if (layer.get('name') == baselayer_names[i]) {
						
						isBase = true;
						break;
						
					}
					
				}
				
				if ((layer.getVisible()) && (isBase == false)) {
					
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
							success:function(d){}
							
						})
						
						map.parseGFI(req.responseText,"popup-info","info-wrapper");
					
					}
					
					map.gfiAddedLayers.push(layer.layer_id);
				
				}
				
			});
			
		});
		
		this.createLayers = function() {
			
			//
			
		}
		
		this.createPrintLegendDiv = function() {
			
			var div = document.createElement("div");
				div.id = "print-legend-wrapper";
			
			document.getElementById("map").appendChild(div);
			
		}
		
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
		
		var panel = this.panel;
		
		for (var i=0; i<js.data.length; i++) {
			
			if (js.data[i].iniciar_panel == "t") {
				
				var visible = js.data[i].iniciar_visible;
				
				$(".layer-checkbox[data-lid="+js.data[i].layer_id+"]").each(function(i,v) {
					
					panel.AddLayer(v.getAttribute("data-cid"),v.getAttribute("data-lid"));
					
					if (visible == "t") {
						
						v.click();
						
					}
					
				});
				
			}
			
		}
		
		var array_geovisor = [ parseFloat(js.minx), parseFloat(js.maxx), parseFloat(js.miny), parseFloat(js.maxy) ];
		
		this.ol_object.getView().fit(array_geovisor,{size:this.ol_object.getSize()});
		//this.ol_object.getView().fit([ -8149293.741521936, -6378849.225655933, -7812129.881098088, -6226949.882287896 ],{size:this.ol_object.getSize()});
		this.ol_object.updateSize();
		this.ol_object.render();
		
	}
	
	this.map.parseGFI = function(response,containerID,wrapperID) {
						
		document.getElementById("popup-results").innerHTML += response;
		
		var results = [];
		
		var entered = false;
		
		$("#popup-results").children().each(function(i,v) {
			
			var gid = $(v).attr("x");
			var layer_name = $(v).attr("y");
			
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
				url:"./php/get-layer-info.php",
				success:function(d) {}
				
			});
			
			document.getElementById(wrapperID).innerHTML += req.responseText;
					
			$("#"+containerID).show();
			
			scrollbars.redrawElement(wrapperID);
	
		}
		
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
			
		$("#print-legend-wrapper").show();
			
		$(".layer-checkbox[data-added=1]:visible:checked").each(function(i,v) {
			
			$(v).parent().parent().next(".layer-body").children(".layer-legend").clone().appendTo("#print-legend-wrapper");
			
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
			a.href = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
			a.download = 'captura.jpg';
			
			document.body.appendChild(a);
			
			a.click();
			
			$(a).remove();
			
			$("#print-legend-wrapper").empty();
			$("#print-legend-wrapper").hide();
			
		});


		
	}
	
	this.map.activateCoordinates = function() {
		
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
		
		this.ol_object.on("click",this.saveCoordinate);
		
		$("#coord-tbl").show();
		$("#coord-hint").show();
		$("#btn-popup-capturar").hide();
		$("#coord-capture-wrapper").hide();
		
	}
	
	this.map.deactivateCoordinates = function() {
		
		this.ol_object.removeControl(this.mouse_position_3857);
		this.ol_object.removeControl(this.mouse_position_4326);
		
	}
	
	this.map.coordinates = function() {
		
		$(".popup").not("#popup-busqueda").hide();
		$("#popup-coordinates").show();
		
	}
	
	this.map.saveCoordinate = function(e) {
		
		var lon = e.coordinate[0];
		var lat = e.coordinate[1];
		
		var coordarray4326 = ol.proj.transform(e.coordinate,'EPSG:3857', 'EPSG:4326');
		
		var lon4326 = coordarray4326[0];
		var lat4326 = coordarray4326[1];		
		
		var coord_3875 = parseFloat(lon).toFixed(3) + " , " + parseFloat(lat).toFixed(3);
		var coord_4326 = parseFloat(lon4326).toFixed(3) + " , " + parseFloat(lat4326).toFixed(3);
		
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
		$("#cap-coord-100001").html(js.coord100001.lon+" , "+js.coord100001.lat);
		$("#cap-coord-100002").html(js.coord100002.lon+" , "+js.coord100002.lat);
		$("#cap-coord-100003").html(js.coord100003.lon+" , "+js.coord100003.lat);
		
		$("#coord-tbl").hide();
		$("#coord-hint").hide();
		$("#btn-popup-capturar").show();
		$("#coord-capture-wrapper").show();
		
		this.map_object.deactivateCoordinates();
		this.un("click",this.map_object.saveCoordinate);
		
	}
	
	this.map.buffer = function() {
		
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
		
		if (this.bufferdraw) {
				
			this.ol_object.removeInteraction(this.bufferdraw);
				
		}
			
		this.bufferdraw = new ol.interaction.Draw({
			source: this.buffer.source,
			type:"Circle"			
		});
			
		$("#buffer-hint").show();
		$("#info-buffer").empty();
		this.buffer.source.clear();
		
		this.bufferdraw.on('drawend', function (e) {
			
			var format = new ol.format.WKT();			
			
			var circle = ol.geom.Polygon.fromCircle(e.feature.getGeometry());
			
			var wkt = format.writeGeometry(circle.transform('EPSG:3857', 'EPSG:4326'));		
			
			var wkt = format.writeGeometry(circle.transform('EPSG:4326', 'EPSG:3857'));	
			
			this.ol_object.removeInteraction(this.bufferdraw);
			
			var layers = [];
			
			$(".layer-checkbox[data-added=1]:checked:visible").each(function(i,v) {
				
				layers.push(this.getAttribute("data-lid"));
				
			});
			
			$("#popup-info").hide();
			$("#buffer-hint").hide();
			
			var req = $.ajax({
				
				async:false,
				type:"post",
				url:"./php/get-buffer.php",
				data:{wkt:wkt,layers:layers},
				success:function(d){}
				
			});
			
			this.parseGFI(req.responseText,"popup-buffer","info-buffer");
			
		}.bind(this));
		
		this.ol_object.addInteraction(this.bufferdraw);
		
		$(".nav-toolbar-link").not("#navbarDropdown-buffer").each(function(i,v) {
			
			$(v).bind("click",function() {
						
				this.ol_object.removeInteraction(this.bufferdraw);
				
			}.bind(this));
			
		}.bind(this));
		
		$(".popup").not("#popup-busqueda").hide();
		$("#popup-buffer").show();
		
	}
	
	this.map.drawing = function(type) {
		
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
		
		if (this.draw) {
				
			this.ol_object.removeInteraction(this.draw);
				
		}
			
		this.draw = new ol.interaction.Draw({
			source: this.drawing.source,
			type:type			
		});
		
		this.ol_object.addInteraction(this.draw);
		
		$(".nav-toolbar-link").not("#navbarDropdown-drawing").each(function(i,v) {
			
			$(v).bind("click",function() {
						
				this.ol_object.removeInteraction(this.draw);
				
			}.bind(this));
			
		}.bind(this));
		
		$(".popup").not("#popup-busqueda").hide();
		$("#popup-drawing").show();
		
	}
	
	this.map.medicion = function() {
		
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
		
		var draw = new ol.interaction.Draw({
			source: this.medicion.source,
			type:"LineString"			
		});

		draw.on('drawend', function (e) {
			
			var format = new ol.format.WKT();
			
			var wkt = format.writeGeometry(e.feature.getGeometry().transform('EPSG:3857', 'EPSG:4326'));		
			
			var wktext = wkt;
			
			var wkt = format.writeGeometry(e.feature.getGeometry().transform('EPSG:4326', 'EPSG:3857'));	
			
			this.ol_object.removeInteraction(draw);
			
			var req = $.ajax({
				
				async:false,
				type:"post",
				url:"./php/get-medicion.php",
				data:{wkt:wkt},
				success:function(d){}
				
			});
			
			document.getElementById("info-medicion").innerHTML = req.responseText;
			
			$("#popup-medicion").show();
			
		}.bind(this));
		
		this.ol_object.addInteraction(draw);
		
		$(".nav-toolbar-link").not("#navbarDropdown-medicion").each(function(i,v) {
			
			$(v).bind("click",function() {
						
				this.ol_object.removeInteraction(draw);
				
			}.bind(this));
			
		}.bind(this));
		
	}
	
	this.map.ptopografico = function() {
		
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
		
		var draw = new ol.interaction.Draw({
			source: this.ptopografico.source,
			type:"LineString"			
		});
		
		draw.on('drawend', function (e) {
			
			$("#popup-preloader").show();
			
			var format = new ol.format.WKT();
			
			var wkt = format.writeGeometry(e.feature.getGeometry().transform('EPSG:3857', 'EPSG:4326'));		
			
			var wktext = wkt;
			
			var wkt = format.writeGeometry(e.feature.getGeometry().transform('EPSG:4326', 'EPSG:3857'));	
			
			DrawChart(wktext,this.ptopografico.layerVector,this.ptopografico.sourcePoints);
			
			this.ol_object.removeInteraction(draw);
			
			this.ptopografico.layerVector.getSource().clear();	
			
		}.bind(this));
		
		this.ol_object.addInteraction(draw);
		
		$(".nav-toolbar-link").not("#navbarDropdown-ptopografico").each(function(i,v) {
			
			$(v).bind("click",function() {
						
				this.ol_object.removeInteraction(draw);
				
			}.bind(this));
			
		}.bind(this));
		
	}
	
	// PANEL SCRIPTS 
	
	this.panel.map = this.map;
	
	this.panel.start = function() {
		
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
				$(".panel-abr").css("border-color","transparent");
				$(".panel-abr").css("background-color","transparent");
				
				$(this).attr("data-active","1");
				$(this).css("border-color",this.getAttribute("data-color"));
				$(this).css("background-color",this.getAttribute("data-bgcolor"));
				
				$(".layer-container").not(".layer-container[data-cid="+this.getAttribute("data-cid")+"]").hide();
				$(".layer-container[data-cid="+this.getAttribute("data-cid")+"]").show();
				
				$("#abr-container").first(".panel-abr").prepend(this);			
				scrollbars.redrawElement(".scrollbar-content");
				scrollbars.updateSize();
				
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
		
		$("form input").val("");
		$("form select").prop("selectedIndex", 0);
		$("form select").selectpicker("refresh");
		
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
		
		scrollbars.redrawElement(".scrollbar-content");
		scrollbars.updateSize();		
		
		$(".popup-panel-tree-item-header").on("click",function() {
			
			if (this.parentNode.getAttribute("data-state") == 1) {
				
				$(this).find(".popup-panel-tree-item-icon").removeClass("far").removeClass("popup-icon-active").addClass("fas");
				
				$(this).find(".popup-panel-tree-item-label").removeClass("popup-text-active");
				
				$(this).find(".popup-panel-tree-item-icon-toggler").removeClass("fa-minus-circle").addClass("fa-plus-circle");
				
				$(this).next(".popup-panel-tree-item-subpanel").slideToggle("slow",function() {					
					
					scrollbars.redrawElement("#scrollbar-content-basic-2");
					
				});
				
				this.parentNode.setAttribute("data-state",0);
				
			}else{
				
				$(this).find(".popup-panel-tree-item-icon").addClass("far").addClass("popup-icon-active").removeClass("fas");
				
				$(this).find(".popup-panel-tree-item-label").addClass("popup-text-active");
				
				$(this).find(".popup-panel-tree-item-icon-toggler").removeClass("fa-plus-circle").addClass("fa-minus-circle");
				
				$(this).next(".popup-panel-tree-item-subpanel").slideToggle("slow",function() {					
					
					scrollbars.redrawElement("#scrollbar-content-basic-2");
					
				});
				
				this.parentNode.setAttribute("data-state",1);
				
			}
			
		});
	}
	
	this.panel.UpdatePopupListAdvanced = function(mode) {
		
		var filter = $("#frm-adv-search").serialize();
		
		var geovisor = this.map.geovisor;
		
		var req = $.ajax({
			
			async:false,
			type:"post",
			data:filter+"&geovisor="+geovisor,
			url:"./php/filter-proyectos-advanced.php",
			success:function(d){}
			
		});
		
		$("#filtered-layer-list").html(req.responseText);		
		
		scrollbars.redrawElement(".scrollbar-content");
		scrollbars.updateSize();		
		
		$(".popup-panel-tree-item-header").on("click",function() {			
			
			if (this.parentNode.getAttribute("data-state") == 1) {
				
				$(this).find(".popup-panel-tree-item-icon").removeClass("far").removeClass("popup-icon-active").addClass("fas");
				
				$(this).find(".popup-panel-tree-item-label").removeClass("popup-text-active");
				
				$(this).find(".popup-panel-tree-item-icon-toggler").removeClass("fa-minus-circle").addClass("fa-plus-circle");
				
				$(this).next(".popup-panel-tree-item-subpanel").slideToggle("slow",function() {					
					
					scrollbars.redrawElement("#scrollbar-content-basic-2");
					
				});
				
				this.parentNode.setAttribute("data-state",0);
				
			}else{
				
				$(this).find(".popup-panel-tree-item-icon").addClass("far").addClass("popup-icon-active").removeClass("fas");
				
				$(this).find(".popup-panel-tree-item-label").addClass("popup-text-active");
				
				$(this).find(".popup-panel-tree-item-icon-toggler").removeClass("fa-plus-circle").addClass("fa-minus-circle");
				
				$(this).next(".popup-panel-tree-item-subpanel").slideToggle("slow",function() {					
					
					scrollbars.redrawElement("#scrollbar-content-basic-2");
					
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
		
		$("#layer-preview-inner").html(req.responseText);
		
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
			
			if (allLayers[i].get('name') != "openstreets") {
				
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
	
	this.panel.AddLayer = function(clase_id,layer_id) {
		
		$(".abr[data-cid="+clase_id+"]").show();
		$(".abr[data-cid="+clase_id+"]").trigger("click");
		$(".layer-group[data-layer="+layer_id+"]").show();
		
		if (!document.getElementById("layer-checkbox-"+layer_id).layer) {
					
			var layer_name = document.getElementById("layer-checkbox-"+layer_id).getAttribute("data-layer");
			var layer_wms = document.getElementById("layer-checkbox-"+layer_id).getAttribute("data-wms");
			
			document.getElementById("layer-checkbox-"+layer_id).layer = new ol.layer.Tile({
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
					},
					crossOrigin: 'anonymous'
				})
			});
			
			document.getElementById("layer-checkbox-"+layer_id).layer.setVisible(false);
			
			this.map.ol_object.addLayer(document.getElementById("layer-checkbox-"+layer_id).layer);
			
			$("#layer-checkbox-"+layer_id).attr("data-added","1");
			
			$("#layer-checkbox-"+layer_id).bind("click",function() {
				
				if (this.checked) {
					
					this.layer.setVisible(true);
					
				}else{
					
					this.layer.setVisible(false);
					
				}
				
			});
			
			document.getElementById("layer-checkbox-"+layer_id).layer.colorpicker = true;
			$("#layer-colorpicker-inner-"+layer_id).ColorPicker({flat: true, width:"100%"});
			
			$("#layer-legend-"+layer_id).html("<img src=\"" + layer_wms + "&version=1.3.0&service=WMS&request=GetLegendGraphic&sld_version=1.1.0&layer="+layer_name+"&format=image/png&STYLE=default\" width=\"120\">");
			
		}
		
		$("#transp-value-"+layer_id).val(100+"%");
		
		$( "#slider-range-"+layer_id ).slider({			
			values: [ 100 ],
			slide: function( event, ui ) {
				$("#transp-value-"+layer_id).val(ui.values[ 0 ]+"%");
				document.getElementById("layer-checkbox-"+layer_id).layer.setOpacity(ui.values[0]/100);				
			}
		});
		
		this.updateLayerCountPanelLabel(clase_id);
			
		//$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) + " - $" + $( "#slider-range" ).slider( "values", 1 ) );
		
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
		
		this.updateLayerCountPanelLabel(clase_id);
		
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
		
		$("#btn-popup-basic").on("click",function() {
			
			$("#geovisor-popup-search").slideUp();
			$("#popup-panel-section-1").slideDown();
			$("#scrollbar-content-basic-2").css("height","160px");
			$("#scrollbar-content-basic-3").css("height","430px");
			scrollbars.redrawElement("#scrollbar-content-basic-2");
			scrollbars.redrawElement("#scrollbar-content-basic-3");
			
			this.panel.UpdatePopupListBasic();
			
		}.bind(this));
		
		$("#btn-popup-advanced").on("click",function() {
			
			$("#geovisor-popup-search").slideDown();
			$("#popup-panel-section-1").slideUp();
			$("#scrollbar-content-basic-2").css("height","260px");
			$("#scrollbar-content-basic-3").css("height","300px");
			scrollbars.redrawElement("#scrollbar-content-basic-2");
			scrollbars.redrawElement("#scrollbar-content-basic-3");
			
			this.panel.UpdatePopupListAdvanced();
			
		}.bind(this));
		
		$(".popup-panel-tree-item-header").on("click",function() {
			
			if (this.parentNode.getAttribute("data-state") == 1) {
				
				$(this).find(".popup-panel-tree-item-icon").removeClass("far").removeClass("popup-icon-active").addClass("fas");
				
				$(this).find(".popup-panel-tree-item-label").removeClass("popup-text-active");
				
				$(this).find(".popup-panel-tree-item-icon-toggler").removeClass("fa-minus-circle").addClass("fa-plus-circle");
				
				$(this).next(".popup-panel-tree-item-subpanel").slideToggle("slow",function() {					
					
					scrollbars.redrawElement("#scrollbar-content-basic-2");
					
				});
				
				this.parentNode.setAttribute("data-state",0);
				
			}else{
				
				$(this).find(".popup-panel-tree-item-icon").addClass("far").addClass("popup-icon-active").removeClass("fas");
				
				$(this).find(".popup-panel-tree-item-label").addClass("popup-text-active");
				
				$(this).find(".popup-panel-tree-item-icon-toggler").removeClass("fa-plus-circle").addClass("fa-minus-circle");
				
				$(this).next(".popup-panel-tree-item-subpanel").slideToggle("slow",function() {					
					
					scrollbars.redrawElement("#scrollbar-content-basic-2");
					
				});
				
				this.parentNode.setAttribute("data-state",1);
				
			}
			
		});
		
		$(".btn-plus-layer").each(function(i,v) {
			
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
			
		});
		
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
		
		$("#popup-busqueda").width(nwidth);
		$("#popup-busqueda").height(nheight);
		$("#popup-busqueda").css("left",left+"px");
		
		$("#popup-share").width(nwidth);
		$("#popup-share").height(nheight);
		$("#popup-share").css("left",left+"px");
		
		$("#popup-coordinates").width(nwidth/3);
		$("#popup-coordinates").height(210);
		$("#popup-coordinates").css("right","60px");
		$("#popup-coordinates").css("bottom","53px");
		$("#popup-coordinates").css("top","auto");
		$("#popup-coordinates").css("left","auto");
		
		$("#popup-info").width(nwidth/3);
		$("#popup-info").height(400);
		$("#popup-info").css("right","20px");
		
		$("#popup-medicion").width(nwidth/3);
		$("#popup-medicion").height(300);
		$("#popup-medicion").css("right","20px");
		
		$("#popup-drawing").width(nwidth/2);
		$("#popup-drawing").height(300);
		$("#popup-drawing").css("right","20px");
		
		$("#popup-baselayers").width(nwidth/3);
		$("#popup-baselayers").height(400);
		$("#info-baselayers").height(300);
		$("#popup-baselayers").css("right","20px");
		
		$("#popup-buffer").width(nwidth/3);
		$("#popup-buffer").height(400);
		$("#info-buffer").height(300);
		$("#popup-buffer").css("right","20px");
		
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