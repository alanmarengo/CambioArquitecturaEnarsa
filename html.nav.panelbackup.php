<div class="col col-md-10 col-lg-10 col-xs-12 col-sm-12 p20 mr-auto text-center">
	
	<div class="button-input-group ml-auto mr-auto w-100-p" style="height: 34px; line-height: 34px; background-color:#29363c;">
		<a href="#" class="button button-input jump-link-death" style="width: 34px; height: 34px; line-height: 34px;">
			<i class="fa fa-search"></i>
		</a>
		<input id="panel-seach-input" class="jump-input jump-input pl-10" name="main-search" readonly="readonly" type="text" value="Buscar Información" data-jump-placeholder="Buscar Información" placeholder="Buscar Información" 
			onfocus="geomap.map.ol_object_mini.updateSize(); geomap.map.ol_object_mini.render(); jwindow.open('#popup-geovisor');">							
	</div>

</div>

<div id="layers-wrapper">

	<div id="abr-container">
	
		<?php DrawAbr(); ?>
	
	</div>
	
	<div id="layers-container">
	
		<?php DrawContainers(); ?>
	
	</div>

</div>