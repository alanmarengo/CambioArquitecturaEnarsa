<div id="navbar-tools" class="jump-navbar">

	<div class="row jump-row default-row">
		
		<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 ml-10 flexbox col-title">
				
			<h3></h3>
		
		</div>
		
		<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 mr-15 flexbox col-tools">
				
			<ul>
				<li>
					<a class="button button-tools jump-hovimage" 
					data-ini-src="./images/toolbar.icon.addlayer.png"
					data-end-src="./images/toolbar.icon.addlayer.white.png"
					href="javascript:void(0);" title="Agregar capa" onclick="geomap.map.ol_object_mini.updateSize(); geomap.map.ol_object_mini.render(); jwindow.open('popup-geovisor');">
						<img src="./images/toolbar.icon.addlayer.png">
					</a>							
				</li>
				<li class="icon-divisor">
					<span></span>												
				</li>
				<li class="dropdown">
					<a class="button button-tools jump-hovimage" 
					data-ini-src="./images/toolbar.icon.buffer.png"
					data-end-src="./images/toolbar.icon.buffer.white.png" href="javascript:void(0);" title="Búsqueda por selección" onclick="jwindow.close('.geovisor-flotant');" id="navbarDropdown-buffer" role="button" data-toggle="dropdown" aria-expanded="false" onclick="jwindow.close('.geovisor-flotant');">
						<img src="./images/toolbar.icon.buffer.png">
					</a>
					<div class="dropdown-menu dropdown-menu-right" id="dropdown-buffer" aria-labelledby="navbarDropdown-buffer" style="min-width:30px !Important; width:30px;">						
					
						<a href="#" class="dropdown-item toggleable-tool" onclick="geomap.map.buffer('circle',this);">
							<img src="./images/geovisor/icons/buffer-circle.png">
						</a>
						
						<a href="#" class="dropdown-item toggleable-tool" onclick="geomap.map.buffer('polygon',this);">
							<img src="./images/geovisor/icons/buffer-polygon.png">
						</a>
						
					</div> 							
				</li>
				<li class="icon-divisor">
					<span></span>												
				</li>
				<li>
					<a class="button button-tools jump-hovimage" 
					data-ini-src="./images/toolbar.icon.ptopografico.png" 
					data-end-src="./images/toolbar.icon.ptopografico.white.png" href="javascript:void(0);" title="Perfil topográfico" onclick="jwindow.close('.geovisor-flotant'); geomap.map.ptopografico(this);">
						<img src="./images/toolbar.icon.ptopografico.png">
					</a>
				</li>
				<li class="icon-divisor">
					<span></span>												
				</li>
				<li class="dropdown">
					<a class="button button-tools jump-hovimage" 
					data-ini-src="./images/toolbar.icon.medicion.png"
					data-end-src="./images/toolbar.icon.medicion.white.png" href="javascript:void(0);" title="Medición" id="navbarDropdown-medicion" role="button" data-toggle="dropdown" aria-expanded="false" onclick="jwindow.close('.geovisor-flotant');">
						<img src="./images/toolbar.icon.medicion.png">
					</a>
					<div class="dropdown-menu dropdown-menu-right" title="Dibujo" id="dropdown-medicion" aria-labelledby="navbarDropdown-medicion" style="min-width:30px !Important; width:30px;">						
					
						<a href="#" onclick="geomap.map.medicion('LineString',this)" class="dropdown-item toggleable-tool">			
							<img src="./images/geovisor/icons/drawing-bar-line.png">						
						</a>
						<a href="#" onclick="geomap.map.medicion('Polygon',this)" class="dropdown-item toggleable-tool">
							<img src="./images/geovisor/icons/drawing-bar-polygon.png">						
						</a>
						
					</div> 
				</li>
				<li class="icon-divisor">
					<span></span>												
				</li>
				<li>
					<a class="button button-tools jump-hovimage" 
					data-ini-src="./images/toolbar.icon.coordenadas.png"
					data-end-src="./images/toolbar.icon.coordenadas.white.png" href="javascript:void(0);" title="Coordenadas" onclick="jwindow.close('.geovisor-flotant'); jwindow.open('popup-coordinates'); geomap.map.activateCoordinates();">
						<img src="./images/toolbar.icon.coordenadas.png">
					</a>
				</li>
				<li class="icon-divisor">
					<span></span>												
				</li>
				<li class="dropdown">
					<a class="button button-tools jump-hovimage" 
					data-ini-src="./images/toolbar.icon.dibujo.png"
					data-end-src="./images/toolbar.icon.dibujo.white.png" href="javascript:void(0);" title="Dibujar" id="navbarDropdown-draw" role="button" data-toggle="dropdown" aria-expanded="false">
						<img src="./images/toolbar.icon.dibujo.png">
					</a>
					<div class="dropdown-menu dropdown-menu-right" id="dropdown-draw" aria-labelledby="navbarDropdown-draw" style="min-width:30px !Important; width:30px;">						
					
						<a href="#" onclick="geomap.map.drawing('Point',this)" class="dropdown-item" title="Dibujar punto">			
							<img src="./images/geovisor/icons/drawing-bar-point.png">						
						</a>
						<a href="#" onclick="geomap.map.drawing('LineString',this)" class="dropdown-item" title="Dibujar línea">	
							<img src="./images/geovisor/icons/drawing-bar-line.png">						
						</a>
						<a href="#" onclick="geomap.map.drawing('Polygon',this)" class="dropdown-item" title="Dibujar polígono">		
							<img src="./images/geovisor/icons/drawing-bar-polygon.png">						
						</a>
						<a href="#" onclick="geomap.map.drawing('Circle',this)" class="dropdown-item" title="Dibujar círculo">		
							<img src="./images/geovisor/icons/drawing-bar-circle.png">						
						</a>
						<a href="#" onclick="geomap.map.drawing('Select',this)" class="dropdown-item" title="Seleccionar elementos">		
							<img src="./images/geovisor/icons/drawing-bar-select.png">						
						</a>
						<a href="#" onclick="geomap.map.drawing('Modify',this)" class="dropdown-item" title="Editar elementos">		
							<img src="./images/geovisor/icons/drawing-bar-edit.png">						
						</a>
						<a href="#" onclick="geomap.map.deleteFeature(this)" class="dropdown-item" title="Borrador">		
							<img src="./images/geovisor/icons/drawing-bar-delete.png">						
						</a>
						<a href="#" onclick="geomap.map.downloadFeatures(this)" class="dropdown-item" title="Descargar">		
							<img src="./images/geovisor/icons/drawing-bar-download.png">						
						</a>
						
					</div> 
				</li>
				<li class="icon-divisor">
					<span></span>												
				</li>
				<li>
					<a class="button jump-hovimage" 
					data-ini-src="./images/toolbar.icon.print.png"
					data-end-src="./images/toolbar.icon.print.blue.png" href="javascript:void(0);" onclick="geomap.map.print();" title="Imprimir">
						<img src="./images/toolbar.icon.print.png">
					</a>
				</li>
				<li class="icon-divisor">
					<span></span>												
				</li>
				<li class="ml-10">
					<a class="button jump-hovimage" 
					data-ini-src="./images/toolbar.icon.share.png"
					data-end-src="./images/toolbar.icon.share.blue.png" href="javascript:void(0);" title="Compartir" onclick="jwindow.close('.geovisor-flotant'); jwindow.open('popup-share'); geomap.map.share();">
						<img src="./images/toolbar.icon.share.png">
					</a>
				</li>
				<!--				
				<li class="icon-divisor">
					<span></span>												
				</li>
				<li class="ml-10">
					<a class="button jump-hovimage" 
					data-ini-src="./images/stats-fav.png"
					data-end-src="./images/stats-fav.blue.png" href="javascript:void(0);" title="Favoritos">
						<img src="./images/stats-fav.png">
					</a>
				</li>
				-->
				
			</ul>
		
		</div>

	</div>
	
	<div class="row jump-row responsive-row">
	
	</div>

</div>
