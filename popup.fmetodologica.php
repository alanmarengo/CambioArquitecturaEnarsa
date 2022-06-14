<style>
.ficha-met-reborn{
	position: absolute;
	bottom: 30px;
	left: 30px;
}
.ind-iconbar-reborn{
	position: absolute;
	bottom: 28px;
	right: -5px;
}
#ficha-metodologica-titulo-prev{
	position: absolute;
	top: 20px;
	left: 30px;
}

.jump-window-close-reborn{
	position: absolute !important; 
	top: 2px !important;
	right: 30px !important;
	left: auto !important;
}
.jump-window-header-reborn{
	line-height: 20px !important;
	height: 23%;
	padding-left:8%;
	padding-top:15px;
}
hr{
	margin-top: 0;
}
#btnFormMediateca{
	border: none;
	background-color: transparent;
}
</style>
<div class="jump-window col col-xs-12 col-sm-12-col-md-4 col-lg-4 geovisor-flotant" id="popup-fmetodologica"
 data-minimizable="0">
	
	<div class="jump-window-inner" style="padding-top: 0px;">
		<!-- ICONO TARJETA -->
		<span id="ficha-metodologica-titulo-prev"><img src="./images/ficha-icono-2.png" id="img-ind-reborn"></span>

		<!-- HEADER -->
		<div class="jump-window-header jump-window-header-reborn">
			<span id="ficha-metodologica-titulo-reborn">Ficha Metodologica</span>
			<div class="jump-window-icon-bar">
				<a href="#" class="jump-window-icon" id="ficha-metodologica-download" onclick="jwindow.close('popup-fmetodologica');" download>
					<img src="./images/ficha-download.png" class="tooltipstered" title="DESCARGAR FICHA ASOCIADA">
				</a>
			</div>
			<!-- BTN CERRAR -->
			<a href="#" class="jump-window-close jump-window-close-reborn" onclick="jwindow.close('popup-fmetodologica'); $('.jump-alert-modal').hide();">
				<i class="fas fa-times"></i>
			</a>
			<hr>
		</div>
		
		<div class="jump-window-body">							
				<div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12">			
					<div id="info-fmetodologica" class="pt-10">					
						<p id="ficha-metodologica-desc">						
							Seleccione un Indicador para ver su descripción.						
						</p>					
					</div>				
				</div>

				<div class="ficha-met-reborn">
					<a href="#" id="ficha-metodologica-view">					
								<img src="./images/ficha-button.png">					
					</a>
				</div>
				<div class="col col-md-2 col-sm-2 col-xs-2 col-lg-2 ind-iconbar-reborn">									
						<div class="indicadores-icon-bar">
							<p class="d-none" id="btnMediateca"></p>
							<p class="d-none" id="btnGeovisores"><a href="#"><img src="./images/icono-geovisores-br.png" class="tooltipstered" title="VER RECURSO ASOCIADO EN GEOVISORES"></a></p>
							<p class="d-none" id="btnEstadisticas"><a href="#"><img src="./images/icono-estadisticas-br.png" class="tooltipstered" title="VER RECURSO ASOCIADO MODULO ESTADISTICOS"></a></p>					
						</div>					
				</div>
			
		</div>
	
	</div>

</div>