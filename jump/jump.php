<!DOCTYPE html>
<html lang="es">
<head>

	<title>JUMP</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700" rel="stylesheet">	
	
	<link rel="stylesheet" href="./css/bootstrap.css"/>	
	<link rel="stylesheet" href="./js/jquery-ui/jquery-ui.min.css"/>	
	
	<link rel="stylesheet" href="./css/pretty-checkbox.css"/>
	<link href="https://cdn.materialdesignicons.com/3.6.95/css/materialdesignicons.min.css" rel="stylesheet"> <!-- CHECKBOX FONTS -->
	
	<link rel="stylesheet" href="./css/perfect-scrollbar.css"/>
	<link rel="stylesheet" href="./css/bootstrap-select.css"/>
	    
	<link rel="stylesheet" href="./css/bootstrapfix.navbar.css"/>	
	
	<!-- JUMP CSS -->
	
	<link rel="stylesheet" href="./css/jump.align.css"/>
	<link rel="stylesheet" href="./css/jump.block.css"/>
	<link rel="stylesheet" href="./css/jump.button.css"/>
	<link rel="stylesheet" href="./css/jump.flotant.css"/>
	<link rel="stylesheet" href="./css/jump.hamburguer.css"/>
	<link rel="stylesheet" href="./css/jump.input.css"/>
	<link rel="stylesheet" href="./css/jump.list.css"/>
	<link rel="stylesheet" href="./css/jump.nav.css"/>
	<link rel="stylesheet" href="./css/jump.scroll.css"/>
	<link rel="stylesheet" href="./css/jump.separator.css"/>
	<link rel="stylesheet" href="./css/jump.site.css"/>
	<link rel="stylesheet" href="./css/jump.window.css"/>
	
	<!-- JUMP CSS AUX -->
	
	<link rel="stylesheet" href="./css/jump.spacers.css"/>
	
	<!-- THEME -->
	
	<link rel="stylesheet" href="./css/jump.theme.default.css"/>
	
	<!-- INDEX SCRIPTS -->
	
	<link rel="stylesheet" href="../css/site.css"/>
    <script src="../js/moment.js"></script>
    <script src="../js/moment-es.js"></script>
    <script src="../js/site.js" type="text/javascript"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.css">
    <script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js"></script>
	
	<!-------------------->
	
	<script type="text/javascript" src="./js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="./js/popper-1.12.9.min.js"></script>
	<script type="text/javascript" src="./js/bootstrap.min.js"></script>
	<script type="text/javascript" src="./js/jquery-ui/jquery-ui.min.js"></script>	

	<!--<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/highcharts-more.js"></script>
	<script src="https://code.highcharts.com/modules/funnel.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>-->
	
	<script src="https://kit.fontawesome.com/9bc67720de.js"></script>
	
	<script src="./js/perfect-scrollbar.js"></script>
	<script src="./js/bootstrap-select.js"></script>
	<script src="./js/bootstrap-select-init.js"></script>
	
	<script src="./js/jump.js"></script>
	<script src="./js/jump.block.js"></script>
	<script src="./js/jump.flotant.js"></script>
	<script src="./js/jump.input.js"></script>
	<script src="./js/jump.nav.js"></script>
	<script src="./js/jump.scroll.js"></script>
	<script src="./js/jump.window.js"></script>
	
	<script src="./js/popper-1.12.9.min.js"></script>
	
	<script type="text/javascript">
	
		$(document).ready(function(){		
			
			/*** FLOTANT ***/
				
			flotant = new Jump.flotant();
			flotant.setFitAgainstRule(".jump-navbar"); // default
				
			flotant.initialize();
			
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
			
		});
		
	</script>
	
</head>
<body>

	<div class="jump-site">
	
		<div class="jump-navbar" id="jump-navbar-main">
		
			<div class="row">
		
				<div class="col col-xs-2 col-sm-2 col-md-1 col-lg-1 jump-hamburguer-col">
			
					<div class="jump-hamburguer plr-10">
					
						<div id="jump-hamburguer">
							<span></span>
							<span></span>
							<span></span>
						</div>
					
					</div>
					
				</div>
				
				<div class="col col-xs-10 col-sm-10 col-md-3 col-lg-3" id="brand-logo">
					
					<div class="jump-block">
					
						<div class="jump-block-inner">
						
							<img src="./images/logo_observatorio_ieasa.png" height="20">
						
						</div>
					
					</div>
				
				</div>
				
				<div class="col col-xs-12 col-sm-12 col-md-8 col-lg-8 text-right">
				
					<div class="jump-block">
					
						<div class="jump-block-inner-toolbar">
						
							<ul>
								<li class="button-input-group">
									<a href="#" class="button button-input">
										<i class="fa fa-search"></i>
									</a>
									<input id="main-search" class="jump-input jump-input-bl pl-10" name="main-search" type="text" data-jump-placeholder="Buscar en todo el sitio" placeholder="Buscar en todo el sitio">							
								</li>
								<li>
									<a href="#" class="button">
										<i class="fa fa-question-circle"></i>
									</a>
								</li>
								<li>
									<a href="#" class="button">
										<i class="fa fa-user"></i>
									</a>
								</li>
							
							</ul>
						
						</div>
					
					</div>
				
				</div>
			
			</div>
		
		</div>
		
		<div class="jump-container">
		
			<?php include("./html.site.php"); ?>
		
		</div>
	
	</div>
	
	<div class="jump-flotant-heightfill jump-flotant-nav jump-scroll col col-xs-12 col-sm-12-col-md-3 col-lg-3" data-visible="0" id="nav-main">
	
		<div class="jump-nav-default jump-nav-inner">
		
			<?php include("html.nav.php"); ?>
		
		</div>
	
	</div>
	
	<div class="jump-flotant-heightfill jump-flotant-nav jump-scroll jump-flotant-nav-level-2 col col-xs-12 col-sm-12-col-md-3 col-lg-3" data-visible="0" id="nav-geovisores">
	
		<div class="jump-nav-default jump-nav-inner">
		
			<?php include("html.nav.geovisores.php"); ?>
		
		</div>
	
	</div>
	
	<div class="jump-flotant-heightfill jump-flotant-nav jump-scroll jump-flotant-nav-level-2 col col-xs-12 col-sm-12-col-md-3 col-lg-3" data-visible="0" id="nav-vinculaciones-insterinstitucionales">
	
		<div class="jump-nav-default jump-nav-inner">
		
			<?php include("html.nav.vinculaciones_insterinstitucionales.php"); ?>
		
		</div>
	
	</div>
	
	<div class="jump-flotant-heightfill jump-flotant-nav jump-scroll jump-flotant-nav-level-2 col col-xs-12 col-sm-12-col-md-3 col-lg-3" data-visible="0" id="nav-recursos-hidricos">
	
		<div class="jump-nav-default jump-nav-inner">
		
			<?php include("html.nav.recursos_hidricos.php"); ?>
		
		</div>
	
	</div>
	
	<?php //include("./popup.baselayers.php"); ?>

</body>
</html>