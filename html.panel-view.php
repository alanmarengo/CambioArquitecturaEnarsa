<div id="dataset-view" data-visible="1" class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
	
	<div class="row jump-row">
		
		<div class="dataset-agroup">
		
			<select class="selectpicker group-combo-view" id="group-combo-view" data-group-by-column="0" data-group-column-index="-1" data-group-column-val="-1">
				<option value="1">AGRUPAR POR TODOS</option>
				<option value="2">AGRUPAR TODO</option>
				<option value="3">NO AGRUPAR</option>
			</select>			
		
			<div class="date-filters">
			
				<ul>
					<li style="padding-left:15px;">
						PERÍODO: &nbsp;
					</li>
					<li>						
						<input id="dated-search" class="datepicker" name="dated-search" type="text" data-jump-placeholder="Desde" placeholder="Desde">
						<a href="#">
							<i class="fas fa-calendar"></i>
						</a>							
					</li>
					<li>						
						<input id="dateh-search" class="datepicker" name="dateh-search" type="text" data-jump-placeholder="Hasta" placeholder="Hasta">
						<a href="#" >
							<i class="fas fa-calendar"></i>
						</a>							
					</li>
				</ul>
			
			</div>
		
		</div>
		
		<div class="view-update-wrapper">
			
			<input class="black-button" type="button" value="ACTUALIZAR VISTA" id="update-view" disabled="disabled">
			<i class="fa fa-sync-alt"></i>
			
		</div>
	
	</div>
	
	<div id="dataset-wrapper">
		
		<div id="dataset-inner">
		
			<div id="dataset-header">
			
			</div>
			
			<div id="dataset-content">
			
			</div>
		
		</div>
	
	</div>
	
	<!--<div class="row jump-row jus-between jump-posrel" style="top:30px;">
		
		<div>
			<a href="./estadisticas.php" id="stats-proceed">&lt; VOLVER</a>
		</div>
		
		<div>
			<div class="mr-20 inline">	
				<a href="#" class="button black-button" onclick="stats.view.premapear()">MAPEAR</a>
			</div>
			<div class="mr-20 inline">	
				<a href="#" class="button black-button" onclick="stats.view.pregraficar()">GRAFICAR</a>
			</div>	
		</div>
	
	</div>-->
	
</div>