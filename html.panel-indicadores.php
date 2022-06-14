<div id="nav-panel" data-visible="1" class="jump-flotant-heightfill jump-flotant-heightfill-top nav-level-1 col col-nav col-xs-10 col-sm-10 col-md-4 col-lg-3 p0 jump-posabs">
	
	<div id="nav-panel-inner" data-visible="1" style="width:100%;">
		
		<div id="nav-panel-arrow">
		
			<a href="#" id="nav-panel-arrow-a" onclick="flotant.toggle('#nav-panel')" class="jump-toggleimage" data-state="1" data-ini-src="./images/panel.icon.arrow.0.png" data-end-src="./images/panel.icon.arrow.1.png">
			
				<img src="./images/panel.icon.arrow.1.png">
			
			</a>
		
		</div>
		
		<div class="jump-row" style="flex-grow:0;">
		
			<div class="mtb-20 ml-auto mr-auto w-100-p search-wrapper">
				<a href="#" class="plr-10 jump-link-death" style="width: 34px; height: 34px; line-height: 34px;">
					<img src="./images/panel.icon.f2.png">
				</a>
				<input id="panel-seach-input-layers" style="width:220px;" class="panel-input pl-10" name="main-search" type="text" data-jump-placeholder="BUSCAR" placeholder="BUSCAR" 
					onfocus="">
				<span class="layers-visible-count jump-posrel l--30"></span>
			</div>
		
		</div>
		
		<div class="jump-row jump-scroll jump-flotant-height-transform" style="flex-grow:1;">
		
			<div id="layers-wrapper">

				<div id="abr-container">
				
					<?php DrawAbrInd(); ?>
				
				</div>
				
				<div id="layers-container">
				
					<?php DrawContainersInd(); ?>
				
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