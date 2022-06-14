<div class="popup-modal" id="popup-modal-gm"></div>
<div class="popup-stats" id="popup-stats-gm" data-action="-1">

	<div class="row jump-row jus-between">

		<div class="subheader">
	
			<a href="#" onclick="$('#popup-modal-gm').hide(); $('#popup-stats-gm').hide();" class="ib-vt">
				<i class="fa fa-times"></i>
			</a>		
			<h3 id="gm-title" class="ib-vt ml-5 mt-5n">Mapear Variable</h3>
		
		</div>
		<div class="icons">
			<a href="#" onclick="stats.view.mapearImprimir();">
				<i class="fa fa-print"></i>
			</a>
			<a href="#" id="gm-mapear-download">
				<i class="fa fa-download"></i>
			</a>
		</div>
	
	</div>

	<div class="row jump-row popup-stats-gm-row">
		
		<hr>
		
		<div class="col col-md-4 col-lg-4">
			<span class="gm-highlight">Dataset: &nbsp;</span>
			<span class="gm-text mt-3" id="labelgm-dataset-name">Nombre del Dataset</span>
		</div>
		
		<div class="col col-md-4 col-lg-4">
			<span class="gm-highlight">Agrupamiento: &nbsp;</span>
			<span class="gm-text mt-3" id="labelgm-dataset-agroup">Nombre del Agrupamiento</span>
		</div>
		
		<div class="col col-md-4 col-lg-4">
			<span class="gm-highlight">Período: &nbsp;</span>
			<span class="gm-text mt-3" id="labelgm-dataset-period">Desde 00/00/00 Hasta 00/00/00</span>
		</div>
	
	</div>

	<div class="row jump-row popup-stats-gm-row" style="top:30px;">
		
		<div class="col col-md-4 col-lg-4" style="display:block; width:100%;" id="gm-combo-container">
			
			<div class="row jump-row" style="height:30px;">
				<select class="selectpicker" id="gm-combo" onchange="stats.view.processGM();"></select>
			</div>
			<div id="var-desc" style="display:none;">
				<div class="row jump-row">
					<div id="var-desc-inner">
					
					</div>
				</div>
				
				<div class="row jump-row" id="graph-types" style="display:none;">
					<div id="graph-list">
						<div class="row jump-row">
							<div class="col col-md-3 ">
								<a href="#" onclick="stats.view.graficarTipo(1);">
									<img src="./images/graph-samples/01.jpg" width="100%">
								</a>
							</div>
							<div class="col col-md-3 ">
								<a href="#" onclick="stats.view.graficarTipo(2);">
									<img src="./images/graph-samples/02.jpg" width="100%">
								</a>
							</div>
							<div class="col col-md-3 ">
								<a href="#" onclick="stats.view.graficarTipo(3);">
									<img src="./images/graph-samples/03.jpg" width="100%">
								</a>
							</div>
							<div class="col col-md-3 ">
								<a href="#" onclick="stats.view.graficarTipo(4);">
									<img src="./images/graph-samples/04.jpg" width="100%">
								</a>
							</div>
						</div>
						<div class="row jump-row">
							<div class="col col-md-3 ">
								<a href="#" onclick="stats.view.graficarTipo(5);">
									<img src="./images/graph-samples/05.jpg" width="100%">
								</a>
							</div>
							<div class="col col-md-3 ">
								<a href="#" onclick="stats.view.graficarTipo(6);">
									<img src="./images/graph-samples/06.jpg" width="100%">
								</a>
							</div>
							<div class="col col-md-3 ">
								<a href="#" onclick="stats.view.graficarTipo(8);">
									<img src="./images/graph-samples/08.jpg" width="100%">
								</a>
							</div>
						</div>
					</div>
				</div>
				
			</div>
			
			<!--<div class="row jump-row jump-posrel" style="top:90px;">
				<div class="mr-20">	
					<a href="#" id="gm-graficar-process" class="button black-button" onclick="stats.view.processGM();">PROCESAR</a>
				</div>
			</div>-->
		</div>
		
		<div class="col col-md-8 col-lg-8 mt-20">			
		
			<div id="gm-stats-mediawrapper">
			</div>	
			
			<div class="jus-right row jump-row" id="btn-ver-geovisor">
				<div style="width:200px;">
					<a href="javascript:void(0);" class="black-button" id="veg-btn" target="_blank">VER EN GEOVISOR</a>
				</div>
			</div>		
			
		</div>
	
	</div>

</div>