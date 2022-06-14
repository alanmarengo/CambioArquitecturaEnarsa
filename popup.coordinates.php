<div class="jump-window jump-align-right jump-flotant-heightfill-top col col-xs-12 col-sm-12-col-md-3 col-lg-3 geovisor-flotant" id="popup-coordinates" 
data-minimizable="1" data-minimized-title="COORDENADAS">
	
	<div class="jump-window-inner p20">

		<div class="jump-window-header">
			<span>Coordenadas</span>
			<div class="jump-window-icon-bar">
				<a href="#" class="jump-window-minimize" onclick="jwindow.minimize('popup-coordinates');">
					<i class="fas fa-minus"></i>
				</a>
				<a href="#" class="jump-window-close" onclick="geomap.map.drawing.source.clear(); jwindow.close('popup-coordinates')">
					<i class="fas fa-times"></i>
				</a>
			</div>
		</div>
		
		<div class="jump-window-body p20">
			
			
			<table id="coord-tbl" class="mt-10">
				<tr id="coord-hint">
					<td colspan="2">(Click en el mapa para capturar)</td>
				</tr>
				<tr>
					<td>EPSG:3857 &nbsp;&nbsp;</td>
					<td><span id="coord-3857"></td>
				</td>
				<tr>
					<td>EPSG:4326 &nbsp;&nbsp;</td>
					<td><span id="coord-4326"></td>
				</td>
			</table>
		
			<div id="coord-capture-wrapper">
			
				<table id="coord-capture-table">
					
					<tr>
						<td colspan="2">
							<a class="popup-header-button popup-header-button-toggleable popup-header-button-active-fixed" href="#" onclick="geomap.map.activateCoordinates()" id="btn-popup-capturar">
								<span>CAPTURAR</span>
							</a>
						</td>
					</tr>
					<tr>
						<td colspan="2"><br></td>
					</tr>
					<tr>
						<td>EPSG:3857 &nbsp;&nbsp;</td>
						<td><span id="cap-coord-3857"></td>
					</td>
					<tr>
						<td>EPSG:4326 &nbsp;&nbsp;</td>
						<td><span id="cap-coord-4326"></td>
					</td>			
					<tr>
						<td>Condor Cliff &nbsp;&nbsp;</td>
						<td><span id="cap-coord-100001"></td>
					</td>
					<tr>
						<td>Barrancosa &nbsp;&nbsp;</td>
						<td><span id="cap-coord-100002"></td>
					</td>
					<tr>
						<td>Lambert &nbsp;&nbsp;</td>
						<td><span id="cap-coord-100003"></td>
					</td>
					
				</table>
				
			</div>
	
		</div>
	
	</div>

</div>