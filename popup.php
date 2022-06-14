<div class="jump-window jump-align-right jump-flotant-heightfill jump-flotant-heightfill-top col col-xs-12 col-sm-12-col-md-8 col-lg-8" id="popup-geovisor"
data-minimizable="1" data-minimized-title="BUSCAR CAPAS">

	<div class="jump-window-inner h-100-p" id="popup-inner">

		<div class="jump-window-header" id="popup-header">
			<a href="#" class="button button-active" id="btn-bus-simple">
				<!--<span>BUSQUEDA</span>-->
				<span>SELECCIÓN</span>
			</a>
			<a href="#" class="button ml-10" id="btn-bus-advanced">
				<span>BÚSQUEDA AVANZADA</span>
			</a>
			<a href="#" class="button ml-10 p0-5" id="btn-bus-reset" title="Resetear Búsqueda">
				<img src="./images/geovisor/icons/search-reset.png">
			</a>
			<div class="jump-window-icon-bar">
				<a href="#" class="jump-window-minimize" onclick="jwindow.minimize('popup-geovisor');">
					<i class="fas fa-minus"></i>
				</a>
				<a href="#" class="jump-window-close" onclick="jwindow.close('popup-geovisor');">
					<i class="fas fa-times"></i>
				</a>	
			</div>
		</div>
		
		<?php if (!isMobile()) { include("./popup.advanced-search.php"); } ?>
		
		<div class="jump-window-body jump-window-full-body" id="popup-body">
			
			<div class="jump-row row p0 m0">
			
				<div class="col col-xs-12 col-sm-12 col-md-5 col-lg-5 p0 m0 flex-column" id="dynbox-popup-basic-search">
					<div class="jump-window-group" id="popup-basic-filters">
						<div class="jump-window-group-header">
							<span>SELECCIONE LA OBRA O PROYECTO</span>
							<a href="javascript:void(0);" class="jump-window-group-header-collapser" onclick="$(this).parent().next().slideToggle('slow'); $(this).children('i').toggleClass('fa-plus-circle');">
								<i class="fa fa-minus-circle"></i>
							</a>
						</div>
						<div class="w100p jump-scroll p-5-20 bfinner">
							<span><?php echo DrawProyectos(); ?></span>
						</div>	
					</div>
					<div class="jump-window-group flex-column flex-grow" id="dynbox-popup-layers">
						<div class="jump-window-group-header">
							<span>SELECCIONE LA CAPA</span>
						</div>
						<div class="jump-window-group-body flex-grow jump-flotant-height-transform">
							<div id="filtered-layer-list">
							</div>
						</div>	
					</div>
				</div>
				<div class="col col-xs-12 col-sm-12 col-md-7 col-lg-7 p20 flex-column" id="dynbox-popup-content">
					<div id="popup-preview-inner">
						<a href="#" class="button" id="btn-layer-preview-addlayer">AGREGAR AL MAPA</a>
						<div id="mini-map" class="ptb-10"></div>
						<div id="layer-preview-block" class="ptb-10">					
							<p class="title" id="layer-preview-title">Datos de Capa</p><br>
							<p class="content">Seleccione una capa para ver su descripci&oacute;n</p>
						</div>
					</div>
				</div>
			
			</div>
			
		</div>
	
	</div>

</div>
