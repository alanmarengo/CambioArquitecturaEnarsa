<script type="text/javascript">
	
	$(document).ready(function() {
		
		$("[title]").tooltipster({
			animation: 'fade',
			delay: 200,
			theme: 'tooltipster-default',
			trigger: 'hover'
		});
		
		flotant = new Jump.flotant();
		flotant.prepareToggle(".navmenu:not(#nav-panel)");
		flotant.fitTopElement("#navbar-tools","#navbar-main");
		flotant.fitTopElement(".page-container",".jump-navbar");
		flotant.fit();
		
		scroll = new Jump.scroll();
		scroll.refresh();
		
		toggleimage = new Jump.toggleimage();
		toggleimage.refresh();
		
		hovimage = new Jump.hovimage();
		hovimage.refresh();
		
		jwindow = new Jump.window();
		jwindow.initialize();
		jwindow.setAllWindowsDraggable();
		jwindow.initMinimizing();
		
		<?php if ((isset($_GET["source"])) && (isset($_GET["id"]))) { ?>
		
		jwindow.close("popup-geovisor");
		
		<?php } ?>
		
		//resize = new Jump.resizer(document.getElementById("popup-geovisor"));
		
		nav = new Jump.nav();
		nav.hamburguer.addBehavior(function() {
			
			var addBackOptionSize = $(".jump-sublevel-backoption:visible").length;
			
			if (addBackOptionSize > 0) {
				
				$(".jump-sublevel-backoption:visible a").trigger("click");
				
			}else{
			
				$("#hamburguer").toggleClass('open');
				flotant.toggle('#nav-main',false,false,false);
			
			}
			
		});
		
		/*** MAP ***/
		
		geomap = new ol_map();
		
		geomap.map.create();
		geomap.map.createLayers();
		geomap.map.createPrintLegendDiv();
		
		geomap.map.panel.start();
	
		<?php if (isset($_GET["geovisor"])) { ?>
		
			jwindow.close("popup-geovisor");
			
			geomap.map.loadGeovisor(<?php echo $_GET["geovisor"]; ?>);
			
		<?php }else{ ?>
		
			$("#navbar-tools h3").html("Geovisor General de IEASA");
		
			<?php if (isset($_GET["l"])) { ?>
			
			jwindow.close("popup-geovisor");
			
			var s_clase = [<?php echo $_GET["c"]; ?>];
			var s_layers = [<?php echo $_GET["l"]; ?>];
			var s_visibles = [<?php echo $_GET["v"]; ?>];
			
			for (var i=0; i<s_layers.length; i++) 
			{ 
				var reqSecurity = $.ajax({
					async:false,
					url:"./php/Get-Layer-Security.php?layer_id="+s_layers[i],
					type:"get",
					success:function(d){}					
				});	


				if(reqSecurity.responseText === "t")
				{

					geomap.panel.AddLayer(s_clase[i],s_layers[i],true);
					if (s_visibles[i]) { 
							document.getElementById("layer-checkbox-"+s_layers[i]).click(); 
					}

				}


			}
							
			<?php } ?>
		
			<?php if (isset($_GET["qid"])) { ?>
			
			geomap.map.mapear(<?php echo $_GET["qid"]; ?>);
			jwindow.close("popup-geovisor");
			jwindow.open("popup-capasactivas");
							
			<?php } ?>
			
			<?php if ((isset($_GET["ca"])) && (!empty($_GET["ca"]))) { ?> 
				
				var ca = <?php echo $_GET["ca"]; ?>;
				
				$(".panel-abr[data-cid="+ca+"]").trigger("click"); 
				
			<?php } ?>
			
			<?php if ((isset($_GET["z"])) && (!empty($_GET["z"]))) { ?> 
			
			geomap.map.ol_object.getView().setZoom(<?php echo $_GET["z"]; ?>);
							
			<?php } ?>
			
			<?php if ((isset($_GET["cen"])) && (!empty($_GET["cen"]))) { ?> 
			
			geomap.map.ol_object.getView().setCenter(ol.proj.transform([<?php echo $_GET["cen"]; ?>], 'EPSG:3857', 'EPSG:3857'));
							
			<?php } ?>
		
		<?php } ?>
		
		<?php if ((isset($_GET["source"])) && (isset($_GET["id"]))) { ?>
		
		var layer_id = <?php echo $_GET["id"]; ?>;
		var clase_id = $(".layer-group[data-layer="+layer_id+"]").first().attr("data-cid");
		
		geomap.panel.AddLayer(clase_id,layer_id,true,true);
		geomap.panel.SetLayerActive(layer_id);
		
		var layer = document.getElementById("layer-checkbox-"+layer_id).layer;
		var js = geomap.map.getLayerExtent(layer_id);
		
		var extent = ol.proj.transformExtent(
			[js.minx,js.miny,js.maxx,js.maxy],
			"EPSG:3857", "EPSG:3857"
		);
		
		geomap.map.ol_object.getView().fit(extent,{duration:1000});
		geomap.map.ol_object.updateSize();
		geomap.map.ol_object.render();
		
		<?php } ?>
		
		geomap.map.updateLayerCount();
		geomap.map.startSearch();
		
		geomap.map.fixPopup(false);
		
		geomap.popup.startInterface();
		
		geomap.map.setupTools();
		geomap.map.setupDisableTools();
		
		window.addEventListener("resize",onresize);
		onresize();
		
		// SELECCIONAR PROYECTOS AL INICIAR GEOVISOR
		$("#popup-basic-filters input[type=checkbox]").trigger("click");
		
		<?php if (((isset($_GET["source"])) && (isset($_GET["id"]))) || (isset($_GET["geovisor"])) || (isset($_GET["qid"]))) { ?>
		
		jwindow.close("popup-geovisor");
		
		<?php }else{ ?>	
		
		jwindow.open("popup-geovisor");
	
		<?php }?>
		
	});

</script>