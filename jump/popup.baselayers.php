<div class="jump-window jump-align-right jump-flotant-heightfill-top col col-xs-12 col-sm-12-col-md-3 col-lg-3">
	
	<div class="jump-window-inner p20">

		<div class="jump-window-header">
			<span>Capa Base</span>
			<a href="#" class="jump-window-close">
				<i class="fas fa-times"></i>
			</a>
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
					<input type="radio" name="radio-baselayers" id="baselayer-default-radio" onclick="geomap.map.setBaseLayer(geomap.map.baselayers.google);">
					<div class="state">
						<label>Google Maps</label>
					</div>
				</div>
				
				<br>
			
			</div>
			
		</div>
	
	</div>

</div>