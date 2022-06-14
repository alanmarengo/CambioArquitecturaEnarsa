<?php include("pgconfig.php"); ?>
<?php include("geovisor.fn.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>

	<title>JUMP</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<?php include("./scripts.default.php"); ?>	
	<?php include("./scripts.openlayers.php"); ?>	
	<?php include("./scripts.highcharts.php"); ?>	

	<!-- JUMP THEME -->

	<link rel="stylesheet" href="./css/jump.theme.geovisor.css"/>

	<!-- GEOVISOR -->

	<link rel="stylesheet" href="./css/geovisor/forms.css"/>
	<link rel="stylesheet" href="./css/geovisor/layers.css"/>
	<link rel="stylesheet" href="./css/geovisor/map.css"/>
	<link rel="stylesheet" href="./css/geovisor/panel.css"/>
	<link rel="stylesheet" href="./css/geovisor/popup.css"/>
	<link rel="stylesheet" href="./css/geovisor/input.css"/>
	<link rel="stylesheet" href="./css/geovisor/sliders.css"/>
	<link rel="stylesheet" href="./css/geovisor/style.css"/>

	<!-- COLORPICKER CSS -->

	<link rel="stylesheet" href="./js/colorpicker/css/colorpicker.css"/>
	
	<!-- MAP -->
	
	<script src="./js/config.js" type="text/javascript"></script>
	<script src="./js/map.js" type="text/javascript"></script>
	<script src="./js/chart.js" type="text/javascript"></script>

	<!-- COLORPICKER JS -->
	
	<script src="./js/colorpicker/js/colorpicker.js" type="text/javascript"></script>

	<!-- HTML 2 CANVAS -->
	
	<script src="http://html2canvas.hertzen.com/dist/html2canvas.js"></script>

	<script type="text/javascript">
	
		$(document).ready(function(){		
			
			/*** FLOTANT ***/
			
			flotant = new Jump.flotant();
			flotant.setFitAgainstRule(".jump-navbar"); // default
				
			flotant.initialize();
			flotant.fitTopElement("#jump-navbar-geovisor","#jump-navbar-main");
			
			/*** NAV ***/
			
			nav = new Jump.nav();
			nav.hamburguer.fit();
			nav.hamburguer.addBehavior(function() {
				
				var addBackOptionSize = $(".jump-sublevel-backoption:visible").length;
				
				if (addBackOptionSize > 0) {
					
					$(".jump-sublevel-backoption:visible a").trigger("click");
					
				}else{
				
					$(this).toggleClass('open');
					flotant.toggle('#nav-main',false);
				
				}
				
			});			
			
			nav.fitNavLinks();	
			
			/*** FLOTANT ***/
			
			jwindow = new Jump.window();
			jwindow.initialize();
			jwindow.setAllWindowsDraggable();
			
			/*** BLOCK ***/
			
			block = new Jump.block();
			block.refresh();
			
			/*** SCROLL ***/
			
			scroll = new Jump.scroll();
			scroll.refresh();
			
			/*** INPUT ***/
			
			jinput = new Jump.input();
			jinput.initialize();
			
			/*** ONRESIZE ***/
			
			Jump.onresize = function() {
				
				flotant.initialize();
				flotant.fitTopElement("#jump-navbar-geovisor","#jump-navbar-main");
				block.refresh();
				scroll.refresh();
				
			}
			
			window.addEventListener("resize",Jump.onresize);
			
			/*** MAP ***/
			
			geomap = new ol_map();
			
			geomap.map.create();
			geomap.map.createLayers();
			geomap.map.createPrintLegendDiv();
			
			geomap.map.panel.fit();
			geomap.map.panel.start();
		
			<?php if (isset($_GET["geovisor"])) { ?>
			
				geomap.map.loadGeovisor(<?php echo $_GET["geovisor"]; ?>);
			
			<?php }else{ ?>
			
				<?php if (isset($_GET["l"])) { ?>
					
				var s_clase = [<?php echo $_GET["c"]; ?>];
				var s_layers = [<?php echo $_GET["l"]; ?>];
				var s_visibles = [<?php echo $_GET["v"]; ?>];
				
				for (var i=0; i<s_layers.length; i++) { 
					geomap.panel.AddLayer(s_clase[i],s_layers[i]);
					if (s_visibles[i]) { 
						document.getElementById("layer-checkbox-"+s_layers[i]).click(); 
					}
				}
								
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
			 
			// flotant.toggle('#nav-panel',true);
			 
		});
		
	</script>
	
</head>
<body>

	<div class="jump-site">
	
		<div class="jump-navbar" id="jump-navbar-main">
		
			<?php include("./html.navbar-main.php"); ?>
		
		</div>
	
		<div class="jump-navbar jump-flotant-nav jump-flotant-heightfill-top" id="jump-navbar-geovisor" data-visible="1">
		
			<?php include("./html.navbar-tools.php"); ?>
		
		</div>
		
		<div class="jump-container jump-flotant-heightfill jump-flotant-heightfill-top jump-posabs" id="map">
		
		</div>
	
	</div>
	
	<div class="jump-align-right jump-align-bottom jump-window jump-window-visible jump-posfix col col-xs-12 col-sm-12-col-md-3 col-lg-3" id="jump-navbar-zoom">
	
		<div class="jump-nav-default jump-nav-inner">
		
			<?php include("html.navbar-geovisor-zoom.php"); ?>
		
		</div>
	
	</div>
	
	<div class="jump-flotant-heightfill jump-flotant-nav jump-scroll jump-posfix col col-xs-12 col-sm-12-col-md-3 col-lg-3" data-visible="0" id="nav-main">
	
		<div class="jump-nav-default jump-nav-inner">
		
			<?php include("html.nav.php"); ?>
		
		</div>
	
	</div>
	
	<div class="jump-flotant-heightfill jump-flotant-nav jump-scroll jump-posfix col col-xs-10 col-sm-10-col-md-3 col-lg-3" data-visible="0" id="nav-panel">
	
		<div class="jump-nav-default jump-nav-inner">
		
			<?php include("html.nav.panel.php"); ?>
		
		</div>
	
	</div>
	
	<div class="jump-flotant-heightfill jump-flotant-nav jump-scroll jump-posfix jump-flotant-nav-level-2 col col-xs-12 col-sm-12-col-md-3 col-lg-3" data-visible="0" id="nav-geovisores">
	
		<div class="jump-nav-default jump-nav-inner">
		
			<?php include("html.nav.geovisores.php"); ?>
		
		</div>
	
	</div>
	
	<div class="jump-flotant-heightfill jump-flotant-nav jump-scroll jump-posfix jump-flotant-nav-level-2 col col-xs-12 col-sm-12-col-md-3 col-lg-3" data-visible="0" id="nav-vinculaciones-insterinstitucionales">
	
		<div class="jump-nav-default jump-nav-inner">
		
			<?php include("html.nav.vinculaciones_insterinstitucionales.php"); ?>
		
		</div>
	
	</div>
	
	<div class="jump-flotant-heightfill jump-flotant-nav jump-scroll jump-posfix col col-xs-12 col-sm-12-col-md-3 col-lg-3" data-visible="0" id="nav-recursos-hidricos">
	
		<div class="jump-nav-default jump-nav-inner">
		
			<?php include("html.nav.recursos_hidricos.php"); ?>
		
		</div>
	
	</div>
	
	<div id="layer-bullet" class="jump-flotant-heightfill-top">

		<a href="javascript:void(0);">
			<i class="fa fa-layer-group"></i>
		</a>

	</div>
	
	<?php include("./popup.php"); ?>
	<?php include("./popup.baselayers.php"); ?>
	<?php include("./popup.buffer.php"); ?>
	<?php include("./popup.coordinates.php"); ?>
	<?php include("./popup.drawing.php"); ?>
	<?php include("./popup.info.php"); ?>
	<?php include("./popup.medicion.php"); ?>
	<?php include("./popup.preloader.php"); ?>
	<?php include("./popup.ptopografico.php"); ?>
	<?php include("./popup.share.php"); ?>
	
	<?php include("./widget-links.php"); ?>
	
	<div id="popup-results">
	
	</div>

</body>
</html>