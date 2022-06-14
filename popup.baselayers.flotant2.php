<div class="jump-window col col-xs-12 col-sm-12-col-md-4 col-lg-4 geovisor-flotant" style="width:300px;" id="popup-baselayers" data-minimizable="1" data-minimized-title="CAPA BASE">
	
	<div class="jump-window-inner p20">

		<div class="jump-window-header">
			<span>Capa Base</span>
			
			<div class="jump-window-icon-bar">
				<a href="#" class="jump-window-minimize" onclick="jwindow.minimize('popup-baselayers');">
					<i class="fas fa-minus"></i>
				</a>
				<a href="#" class="jump-window-close" onclick="jwindow.close('popup-baselayers');">
					<i class="fas fa-times"></i>
				</a>	
			</div>
		</div>
		
		<div class="jump-window-body p20">
			
			<div id="info-baselayers" class="jump-scrollble">
		
				<div class="pretty p-default p-round" style="font-size:20px;">
					<input type="radio" name="radio-baselayers" onclick="geomap.map.setBaseLayer(geomap.map.baselayers.openstreets);">
					<div class="state">
						<label>Openstreets Maps</label>
					</div>
				</div>
				
				<br>
			
				<div class="pretty p-default p-round" style="font-size:20px;">
					<input type="radio" name="radio-baselayers" onclick="geomap.map.setBaseLayer(geomap.map.baselayers.opentopo);">
					<div class="state">
						<label>Open Topo</label>
					</div>
				</div>
				
				<br>
			
				<div class="pretty p-default p-round" style="font-size:20px;">
					<input type="radio" name="radio-baselayers" onclick="geomap.map.setBaseLayer(geomap.map.baselayers.bing_roads);">
					<div class="state">
						<label>Bing Caminos</label>
					</div>
				</div>
				
				<br>
			
				<div class="pretty p-default p-round" style="font-size:20px;">
					<input type="radio" name="radio-baselayers" onclick="geomap.map.setBaseLayer(geomap.map.baselayers.bing_aerials);">
					<div class="state">
						<label>Bing Satelital</label>
					</div>
				</div>
				
				<br>
			
				<div class="pretty p-default p-round" style="font-size:20px;">
					<input type="radio" name="radio-baselayers" onclick="geomap.map.setBaseLayer(geomap.map.baselayers.argenmap);">
					<div class="state">
						<label>Argenmap</label>
					</div>
				</div>
				
				<br>
			
				<div class="pretty p-default p-round" style="font-size:20px;">
					<input type="radio" checked="checked" name="radio-baselayers" id="baselayer-default-radio" onclick="geomap.map.setBaseLayer(geomap.map.baselayers.google);">
					<div class="state">
						<label>Google Maps</label>
					</div>
				</div>
				
				<br>
			
			</div>
			
		</div>
	
	</div>

</div>