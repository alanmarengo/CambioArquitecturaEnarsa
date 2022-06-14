<div id="nav-panel-dataset" data-visible="1" class="jump-flotant-heightfill jump-scroll nav-level-1 col col-nav col-xs-12 col-sm-12 col-md-6 col-lg-6">
	
	<div class="row jump-row panel-dataset-list-hint">
	
		<p>Seleccione un tema y luego un dataset para comenzar a operar</p>
	
	</div>
	
	<div class="row jump-row">
	
		<form id="dt_form" method="post" action="./estadisticas-vista.php">
	
			<input type="hidden" name="dt_id" id="inp_dt_id">
			<input type="hidden" name="dt_variables" id="inp_dt_variables">
			<input type="hidden" name="dt_cruce" id="inp_dt_cruce">
	
		</form>
	
		<div id="panel-dataset-list" class="jump-scroll jump-posrel">
			
			
		
		</div>
	
	</div>
	
	<div class="row jump-row jus-between">
	
		<select class="selectpicker mt-56" id="combo_cruce">

			<option value="-1" selected>Cruce Espacial</option>
			
		</select>		
	
		<a href="javascript:void(0);" onclick="stats.dataset.proceed();" id="stats-proceed" class="mt-50">VER TABLA ></a>
	
	</div>
	
</div>