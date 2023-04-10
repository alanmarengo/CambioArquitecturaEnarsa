<div id="nav-panel" data-visible="1" class="navmenu jump-flotant-nav jump-flotant-heightfill jump-flotant-heightfill-top nav-level-1 col col-nav col-xs-12 col-sm-12 col-md-4 col-lg-3">
				
	<div id="panel-busqueda-geovisor">
		
		<div class="row jump-row jus-right">
			<a href="#" onclick="$('#panel-busqueda-geovisor').hide();" class="panel-close">
				<i class="fa fa-times"></i>
			</a>
		</div>
		<div class="panel-header"></div>
		<div class="panel-body jump-flotant-height-transform jump-scroll"></div>
		
	</div>
	
	<div id="nav-panel-arrow">
		
		<a href="#" onclick="flotant.toggle('#nav-panel')" class="jump-toggleimage" data-state="1" data-ini-src="./images/panel.icon.arrow.0.png" data-end-src="./images/panel.icon.arrow.1.png">
		
			<img src="./images/panel.icon.arrow.1.png">
		
		</a>
	
	</div>
		
	<div class="jump-row" style="background-color:#ececec;">
	
		<div class="mtb-20 ml-auto mr-auto w-100-p search-wrapper">
			<a href="#" class="plr-10 jump-link-death" style="width: 34px; height: 34px; line-height: 34px;">
				<img src="./images/panel.icon.f2.png">
			</a>
			<input id="panel-seach-input-layers-bottom" class="panel-input pl-10" name="main-search" type="text" data-jump-placeholder="BUSCAR EN CAPAS ACTIVAS" placeholder="BUSCAR EN CAPAS ACTIVAS" 
				onfocus="geomap.map.ol_object_mini.updateSize(); geomap.map.ol_object_mini.render(); jwindow.open('#popup-geovisor');">
			<span class="layers-visible-count jump-posrel"></span>
		</div>
	
	</div>
	
	<div id="nav-panel-inner" data-visible="1" style="width:100%;" class="jump-scroll">	
		
		
	
		<!--<div class="jump-row">
		
			<div class="mtb-20 ml-auto mr-auto w-100-p" style="height: 34px; line-height: 34px; background-color:#29363c;">
				<a href="#" class="plr-10 jump-link-death" style="width: 34px; height: 34px; line-height: 34px;">
					<img src="./images/panel.icon.f1.png">
				</a>
				<input id="panel-seach-input" class="panel-input pl-10" name="main-search" readonly="readonly" type="text" value="Agregar Información al Mapa" data-jump-placeholder="Agregar Información al Mapa" placeholder="Agregar Información al Mapa" 
					onfocus="geomap.map.ol_object_mini.updateSize(); geomap.map.ol_object_mini.render(); jwindow.open('popup-geovisor');">							
			</div>
		
		</div>-->
		
		<div class="jump-row">
		
			<div id="layers-wrapper">

				<div id="abr-container">
				
					<?php
					
					$servicio_geovisor = new RepositorioServicioGeovisor();

					echo $servicio_geovisor->DrawAbr();
					
					
					DrawAbr(); ?>
				
				</div>
				
				<div id="layers-container">
				
					<?php DrawContainers(); ?>
				
				</div>

			</div>
		
		</div>
	
	</div>
	
	<div id="layer-group-capas-activas" class="layer-group" data-state="0" data-layer="<?php echo $r["layer_id"]; ?>" data-cid="<?php echo $r["clase_id"]; ?>" data-layer-type="<?php echo $r["tipo_layer_id"]; ?>">
		
		<div class="layer-header">
			<!--<a href="javascript:void(0);">
				<i class="fa fa-eye"></i>
			</a>-->
				
			<a href="#" class="layer-label" onclick="$(this).parent().next().slideToggle('slow'); $(this).toggleClass('layer-label-active')" title="<?php echo $r["layer_desc"]; ?>" title="Capas Activas">
				<span>CAPAS ACTIVAS</span>
			</a>
			
			<a href="#" class="active-layer-button" onclick="jwindow.open('popup-capasactivas');" title="Mostrar">
				<img src="./images/external-link.png">
			</a>
	
		</div>
	
	</div>
	
</div>