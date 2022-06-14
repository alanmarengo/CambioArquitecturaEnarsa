<div id="nav-panel" data-visible="1" class="jump-flotant-heightfill jump-scroll nav-level-1 col col-nav col-xs-12 col-sm-12  col-md-4 col-lg-3">
	
	<div id="nav-panel-inner" data-visible="1">	
		
		<div class="jump-row">
		
			<div class="mtb-20 ml-auto mr-auto w-100-p search-wrapper">
				<a href="#" class="plr-10 jump-link-death" style="width: 34px; height: 34px; line-height: 34px;">
					<img src="./images/panel.icon.f2.png">
				</a>
				<input id="panel-seach-input-layers" class="panel-input pl-10" name="main-search" type="text" value="BUSCAR" data-jump-placeholder="BUSCAR" placeholder="BUSCAR" 
					onfocus="">
				<span class="layers-visible-count jump-posrel l--30"></span>
			</div>
		
		</div>
		
		<div class="jump-row">
		
			<div id="layers-wrapper">

				<div id="abr-container">
				
					<?php DrawAbrStats(); ?>
				
				</div>
				
				<div id="layers-container">
				
					<?php DrawContainersStats(); ?>
				
				</div>

			</div>
		
		</div>
			
		<div id="panel-busqueda-geovisor">
			
			<div class="row jump-row jus-right">
				<a href="#" onclick="$('#panel-busqueda-geovisor').hide();" class="panel-close">
					<i class="fa fa-times"></i>
				</a>
			</div>
			<div class="panel-header"></div>
			<div class="panel-body jump-flotant-height-transform jump-scroll"></div>
			
		</div>
	
	</div>
	
</div>