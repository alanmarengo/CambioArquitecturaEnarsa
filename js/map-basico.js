function ol_map() {

	this.container = {};
	this.nav = {};
	this.panel = {};
	this.map = {};
	this.popup = {};
	this.map.baselayers = {};
	
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
			$(".panel").height(newHeight+2);
			$(".panel").css("top",$(this.div).offset().top);
		}
		
	
	}
	
	// MAP SCRIPTS 
	
	this.map.create = function() {
		
		this.baselayers.openstreets = new ol.layer.Tile({
			name: 'openstreets',
			title: 'OSM',
			type: 'base',
			visible: true,
			source: new ol.source.XYZ({
				url: '//{a-c}.tile.openstreetmaps.org/{z}/{x}/{y}.png'
			})
		})
		
		this.ol_object = new ol.Map({
			layers:[this.baselayers.openstreets],
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
		
		this.proylayer = new ol.layer.Tile({
			visible:true,
			source: new ol.source.TileWMS({
				url: "http://observatorio.atic.com.ar/cgi-bin/mapserver?map=wms_atic",
				params: {
					'LAYERS': 'proyectos',
					'VERSION': '1.1.1',
					'FORMAT': 'image/png',
					'TILED': false,
					'proyecto_id':-1,
					'tipo':-1,
					'estado':-1
				}
			})
		});
		
		this.ol_object.addLayer(this.proylayer);	
		
		this.ol_object.map_object = this;
		
		this.ol_object.addEventListener("click",function(evt) {
				
			$("#popup-results").empty();
			$("#info-wrapper").empty();
			
			var view = this.getView();
			var map = this.map_object;
			
			var viewResolution = (view.getResolution());
			var url = '';
			
			this.getLayers().forEach(function (layer, i, layers) {				
				
				if (layer.getVisible() && layer.get('name')!='openstreets') {
					
					if(layer.getSource().getGetFeatureInfoUrl) {
					
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
					
				}
				
			});
			
		});
		
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
				url:"./php/get-layer-info-basico.php",
				success:function(d) {}
				
			});
			
			document.getElementById("panel-basico-inner").innerHTML = req.responseText;
	
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
	
	this.map.updateParams = function() {
		
		var proyecto = $("#navbarDropdown-proy").attr("data-val");
		var infra = $("#navbarDropdown-infra").attr("data-val");
		var estado = $("#navbarDropdown-estado").attr("data-val");
		
		this.proylayer.getSource().updateParams({
			'proyecto_id':proyecto,
			'tipo':infra,
			'estado':estado
		});
		
		this.proylayer.changed();
		
	}
	
	// PANEL SCRIPTS 
	
	this.panel.map = this.map;
	
	this.panel.start = function() {
		
		var map = this.map;
		
		$(".dropdown-menu").each(function(i,v) {
			
			$(v).find(".dropdown-item").each(function(j,x) {
				
				$(x).bind("click",function() {
					
					$(this).parent().prev().html($(this).text());
					$(this).parent().prev().attr("data-val",($(this).attr("data-id")));
					map.updateParams();
					
				});
				
			});
			
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
		
		var req = $.ajax({
			
			async:false,
			type:"post",
			data:{proyectos:filter},
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
		
		var req = $.ajax({
			
			async:false,
			type:"post",
			data:filter,
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
						'TILED': false
					}
				})
			});
			
			document.getElementById("layer-checkbox-"+layer_id).layer.setVisible(false);
			
			this.map.ol_object.addLayer(document.getElementById("layer-checkbox-"+layer_id).layer);
			
			$("#layer-checkbox-"+layer_id).bind("click",function() {
				
				if (this.checked) {
					
					this.layer.setVisible(true);
					
				}else{
					
					this.layer.setVisible(false);
					
				}
				
			});
			
			document.getElementById("layer-checkbox-"+layer_id).layer.colorpicker = true;
			$("#layer-colorpicker-inner-"+layer_id).ColorPicker({flat: true, width:"100%"});
			
		}
		
		$("#transp-value-"+layer_id).val(100+"%");
		
		$( "#slider-range-"+layer_id ).slider({			
			values: [ 100 ],
			slide: function( event, ui ) {
				$("#transp-value-"+layer_id).val(ui.values[ 0 ]+"%");
				document.getElementById("layer-checkbox-"+layer_id).layer.setOpacity(ui.values[0]/100);				
			}
		});
			
		//$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) + " - $" + $( "#slider-range" ).slider( "values", 1 ) );
		
	}
	
	this.panel.removeLayer = function(layer_id,clase_id) {
		
		$(".layer-group[data-layer="+layer_id+"]").hide();
		document.getElementById("layer-checkbox-"+layer_id).layer.setVisible(false);
		
		var visibles = $(".layer-container[data-cid="+clase_id+"] .layer-group:visible").length;
		
		if (visibles == 0) {
			
			$(".layer-container[data-cid="+clase_id+"]").hide();
			$(".panel-abr[data-cid="+clase_id+"]").hide();
			
		}
		
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
		
	}
	
	this.popup.start = function() {
		
		this.startInterface();
		this.fixSize([document.getElementById("nav-1"),document.getElementById("nav-2")]);
		$(".popup").draggable({handle:".popup-header"});
		
	}
	
}