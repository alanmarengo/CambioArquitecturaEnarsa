function loadComboObra() {
		
		$("#uxVisor").children("option").remove();
		$("#uxVisor").append(
			$("<option></option>")
			.val(-1)
			.text("Seleccione una Obra")
			.attr("selected","selected")
		);
		for (var i=0; i<proyectos.length; i++) {
			
			$("#uxVisor").append(
				$("<option></option>")
				.val(proyectos[i].index)
				.text(proyectos[i].label)
			);
		
		}
		
		$("#uxVisor").selectpicker("refresh");
		
		loadComboComponente(proyectos);
		
		$(".bootstrap-select").css({
			
			"width": "450px",
			"position": "absolute",
			"z-index": "9999",
			"top": "10px",
			"left": "30px"
			
		});
		
		scroll.refresh();
		
	}
	
function loadComboComponente() {
	var obraIndex = $("#uxVisor").val();
	
	$("#uxCapa").empty();
	
	var len = geomap.map.ol_object.noBaseLayers.length;
	
	while (len>0) {
		
		geomap.map.ol_object.removeLayer(geomap.map.ol_object.noBaseLayers[0]);
		geomap.map.ol_object.noBaseLayers.shift();
		
		len = geomap.map.ol_object.noBaseLayers.length;
	
	}
	
	if (obraIndex == -1) { 
	
		obraIndex = 0; 		
		
		$("#uxVisor").val(0);
		$("#uxVisor").selectpicker("refresh");
			
	}
	
	for (var i=0; i<proyectos[obraIndex].layers.length; i++) {
		
		var layer_id = proyectos[obraIndex].layers[i].layer_id;
		var layerData = geomap.map.getLayerData(layer_id);
				
		var input = document.createElement("input");
			input.type = "checkbox";
			input.setAttribute("data-layer-id",proyectos[obraIndex].layers[i].layer_id);
			input.setAttribute("data-oi",obraIndex);
			input.setAttribute("data-i",i);
			input.checked = true;
			input.layer = new ol.layer.Tile({
				name:layerData.layer_wms_layer,
				visible:true,
				source: new ol.source.TileWMS({
					//url: layerData.layer_wms_server,
					url:layerData.layer_wms_server,
					params: {
						'LAYERS': layerData.layer_wms_layer,
						'VERSION': '1.1.1',
						'FORMAT': 'image/png',
						'TILED': false,
						'layer_id':layer_id
					}/*,
					crossOrigin: 'anonymous'*/
				})
			});
			input.onclick = function() {
								
				var layer_id = this.getAttribute("data-layer-id");
				var layerData = geomap.map.getLayerData(layer_id);
				
				if (this.checked) {
				
					this.layer.setVisible(true);
	
					var js = geomap.map.getLayerExtent(layer_id);
					
					var extent = ol.proj.transformExtent(
						[js.minx,js.miny,js.maxx,js.maxy],
						"EPSG:3857", "EPSG:3857"
					);
					
					geomap.map.ol_object.getView().fit(extent,{duration:1000});
					geomap.map.ol_object.updateSize();
					geomap.map.ol_object.render();
					
				
				}else{
					
					this.layer.setVisible(false);
					
				}
				
			}
			
			geomap.map.ol_object.addLayer(input.layer);
			geomap.map.ol_object.noBaseLayers.push(input.layer);
			
		var zoomTool = document.createElement("div");
			zoomTool.className = "d-inline ml-5 jump-posrel";
			zoomTool.style.top = "-2px";
		
		var zoomToolA = document.createElement("a");
			zoomToolA.href = "#";
			zoomToolA.setAttribute("data-layer-id",proyectos[obraIndex].layers[i].layer_id);
			zoomToolA.title = "Ir a extent de capa";
			zoomToolA.onclick = function(e) {
				e.preventDefault()
				var layer_id = this.getAttribute("data-layer-id");
				
				var js = geomap.map.getLayerExtent(layer_id);
					
				var extent = ol.proj.transformExtent(
					[js.minx,js.miny,js.maxx,js.maxy],
					"EPSG:3857", "EPSG:3857"
				);
				
				geomap.map.ol_object.getView().fit(extent,{duration:1000});
				geomap.map.ol_object.updateSize();
				geomap.map.ol_object.render();
				
			}
		
		var zoomToolImg = document.createElement("img");
			zoomToolImg.src = "./images/geovisor/icons/layer-bar-zoom.png";
			
			zoomTool.appendChild(zoomToolA);
			zoomToolA.appendChild(zoomToolImg);
			
		
		$("#uxCapa").append(
			$("<p></p>")					
				.append(input)
				.append(zoomTool)
				.append(
					$("<span></span>")
						.addClass("ml-10")
						.html(proyectos[obraIndex].layers[i].componente)
				)
			/*.val(proyectos[obraIndex].layers[i].layer_id)
			.text(proyectos[obraIndex].layers[i].componente)*/
		);
	
	}
	
	$("#uxCapa").selectpicker("refresh");
	
	scroll.refresh();
	
}

function loadLabels() {
	
	/*var proyectText = $("#uxVisor option:selected").text();
	var layerText = $("#uxCapa option:selected").text();
	
	$("#label-proyecto").html(proyectText);
	$("#label-capa").html(layerText);*/
	
}

function drawLayer() {
	
	/*var layer_id = $("#uxCapa").val();
	
	var layerData = geomap.map.getLayerData(layer_id);
	
	if (geomap.map.uniqueLayer) {
		
		geomap.map.ol_object.removeLayer(geomap.map.uniqueLayer);
		
	}
	
	geomap.map.uniqueLayer = new ol.layer.Tile({
		name:layerData.layer_wms_layer,
		visible:true,
		source: new ol.source.TileWMS({
			url: layerData.layer_wms_server,
			params: {
				'LAYERS': layerData.layer_wms_layer,
				'VERSION': '1.1.1',
				'FORMAT': 'image/png',
				'TILED': false,
				'layer_id':layer_id
			}/*,
			crossOrigin: 'anonymous'
		})
	});
	
	geomap.map.ol_object.addLayer(geomap.map.uniqueLayer);
	
	var js = geomap.map.getLayerExtent(layer_id);
	
	var extent = ol.proj.transformExtent(
		[js.minx,js.miny,js.maxx,js.maxy],
		"EPSG:3857", "EPSG:3857"
	);
	
	geomap.map.ol_object.getView().fit(extent,{duration:1000});
	geomap.map.ol_object.updateSize();
	geomap.map.ol_object.render();*/
	
}

$(document).ready(function() {
	
	/*$("[title]").tooltipster({
		animation: 'fade',
		delay: 200,
		theme: 'tooltipster-default',
		trigger: 'hover'
	});*/
			
	geomap = new ol_map();
		
	geomap.map.create();
	geomap.map.createLayers();
	
	geomap.map.ol_object.noBaseLayers = [];
	
	scroll = new Jump.scroll();
		
	jwindow = new Jump.window();
	jwindow.initialize();
			
	$('.section-sticky a').on('click', function() {
		$('.section-sticky a').removeClass('selected');
		$(this).addClass('selected');

		let selector = $(this).data('target');
		$('html, body').animate({
			scrollTop: $(selector).offset().top - 200
		}, 500)
	});

	let target = $.urlParam('target');
	if (target)
		$('#link-' + target).trigger('click');

	$('.section-footer-button2').hover( 
		function () {
			let key=$(this).data('key');
			$(this).css('background-image', 'url("./images/icono-' + key + '-relleno-hover.png")')
		},
		function () {
			let key=$(this).data('key');
			$(this).css('background-image', 'url("./images/icono-' + key + '-relleno.png")')
		}
	)

	var req = $.ajax({
		
		async:false,
		type:"POST",
		url:"./php/get-geovisor-combo-json.php",
		success:function(d){}
		
	});

	var js = JSON.parse(req.responseText);

	proyectos = js;
	
	document.getElementById("uxVisor").addEventListener("change",function() {
		
		 var optVal = this.options[this.selectedIndex].value;
		
		if (optVal >= 0) {
		
			geomap.map.zoomToZoneExtent(optVal);
		
		}
		
		if (optVal < 1) {
		
			$("#uxCapa").css("display","none");
			//geomap.map.ol_object.infoEnabled = true;
			
		}else{
		
			$("#uxCapa").css("display","block");
			$("#popup-combo").css("display","none");
			//geomap.map.ol_object.infoEnabled = false;
			
		}
		
		loadComboComponente(proyectos);	
		//loadLabels();
		
	});
	
	loadComboObra(proyectos);
		
	$("#uxVisor").val(0);
	$("#uxVisor").selectpicker("refresh");
	
	scroll.refresh();

});