<div class="jump-block" id="zoom-navbar">		

	<div class="jump-block-inner-toolbar">
	
		<ul>
			<li>
				<a href="javascript:void(0);" class="button" onclick="geomap.map.ol_object.getView().setZoom(geomap.map.ol_object.getView().getZoom() + 1);" title="Acercar">
					<i class="fa fa-plus"></i>
				</a>							
			</li>
			<li>
				<a class="button" href="javascript:void(0);" onclick="geomap.map.ol_object.getView().setZoom(geomap.map.ol_object.getView().getZoom() - 1);" title="Alejar">
					<i class="fa fa-minus"></i>
				</a>        
			</li>
			<li>
				<a class="button" href="javascript:void(0);" onclick="jwindow.open('popup-baselayers');" title="Cambiar capa base">
					<i class="fa fa-layer-group"></i>
				</a>
			</li>
			
		</ul>
	
	</div>

</div>