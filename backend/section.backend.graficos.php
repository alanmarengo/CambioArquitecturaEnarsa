<?php 

$dt_data = array(); 

?>

<div class="row pv-30">

	<div class="col hidden-xs hidden-sm col-md-1 col-lg-1"></div>
	<div class="col col-xs-12 col-sm-12 col-md-10 col-lg-10 backend-wrapper">	
					
		<div class="row">				
			
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="grafico_current">
				<span>Sin Dataset Actual</span>
			</div>
		
		</div>
		
		<ul class="nav nav-tabs mt-20">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" id="tab-link-busqueda" href="#tab-busqueda">Búsqueda</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab-link-dataset" href="#tab-dataset">Gráfico</a></li>
		</ul>
		
		<div class="tab-content p30">	
		
			<div class="tab-pane active" id="tab-busqueda">
				
				<div class="row">
			
					<div class="input-group mb-1 col col-xs-12 col-sm-12 col-md-4 col-lg-4 p0">
						<input id="graficoBusqueda" type="text" class="form-control" placeholder="Buscar">
						<div class="input-group-append">
							<button class="btn btn-primary" type="button" id="graficoBtnBusqueda" onclick="$('#grid-dt-graficos-abm').jsGrid('loadData');">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</div>
					
					<div class="input-group mb-1 col col-xs-12 col-sm-12 col-md-1 col-lg-1 p0"></div>
				
					<div class="mb-1 col col-xs-12 col-sm-12 col-md-4 col-lg-4 p0">
						<button class="btn btn-primary" type="button" id="graficoNuevoBtnBusqueda" onclick="dataset_ob.get_new_id(); $('#grid-dt-graficos-abm').jsGrid('loadData'); $('#tab-link-dataset').trigger('click');">
							<i class="fa fa-plus"></i> Nuevo
						</button>
					</div>
				
				</div>		
			
				<div class="row">
				
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						
						<div id="grid-dt-graficos-abm" class="mt-30">
						
						</div>
				
					</div>
				
				</div>
			
			</div>
		
			<div class="tab-pane fade" id="tab-dataset">
			
				<div class="row">
			
					<div class="col col-xs-12 col-sm-12 col-md-9 col-lg-9">
					
						<form name="frm-backend-graficos" id="frm-backend-graficos">
							<div class="form-group">
								<label for="dt_id">ID</label>
								<input type="text" class="form-control" name="grafico_id" id="grafico_id" aria-describedby="grafico_id" readonly="readonly" placeholder="ID Gráfico...">
							</div>
							<div class="form-group">
								<label for="tipo_grafico_id">Tipo Gráfico</label>
								<?php get_combo_db("sinia_graficos","tipo_grafico","tipo_grafico_id","tipo_grafico_desc",test_get_var($dt_data["tipo_grafico_id"],"6"),"tipo_grafico_id"); ?>
							</div>
							<div class="form-group">
								<label for="grafico_titulo">Título</label>
								<input type="text" class="form-control" name="grafico_titulo" id="grafico_titulo" aria-describedby="grafico_titulo" placeholder="Titulo...">
							</div>
							<div class="form-group">
								<label for="grafico_desc">Descripción</label>
								<input type="text" class="form-control" name="grafico_desc" id="grafico_desc" aria-describedby="grafico_desc" placeholder="Descripción...">
							</div>
							<!--<div class="form-group">
								<label for="grafico_tabla">Tabla</label>
								<input type="text" class="form-control" readonly="readonly" name="grafico_tabla" id="grafico_tabla" aria-describedby="grafico_tabla" placeholder="Tabla...">
							</div>-->
							<div class="form-group">
								<label for="grafico_tabla">Tabla</label>
								<input type="text" class="form-control" name="grafico_tabla" id="grafico_tabla" aria-describedby="grafico_tabla" readonly="readonly" placeholder="Tabla...">
							</div>
							<div class="form-group">
								<label for="grafico_col_etiqueta">Col Etiqueta</label>
								<input type="text" class="form-control dt_tabla_col" name="grafico_col_etiqueta" id="grafico_col_etiqueta" aria-describedby="grafico_col_etiqueta" readonly="readonly" placeholder="Etiqueta...">
							</div>
							<div class="form-group">
								<label for="grafico_col_sector">Col Sector</label>
								<input type="text" class="form-control dt_tabla_col" name="grafico_col_sector" id="grafico_col_sector" aria-describedby="grafico_col_sector" readonly="readonly" placeholder="Sector...">
							</div>
							<div class="form-group">
								<label for="grafico_col_valor">Col Valor</label>
								<input type="text" class="form-control dt_tabla_col" name="grafico_col_valor" id="grafico_col_valor" aria-describedby="grafico_col_valor" readonly="readonly" placeholder="Valor...">
							</div>
							<input type="hidden" id="col_selector">
							<button type="button" class="btn btn-primary" onclick="dataset_ob.save(document.getElementById('frm-backend-graficos'));">Guardar</button>
							<button type="button" class="btn btn-danger" onclick="dataset_ob.drop();">Eliminar Gráfico</button>
							<button type="button" class="btn btn-primary" onclick='window.open("./get_grafico.php?grafico_id="+document.getElementById("grafico_id").value, ""," _blank");'>Ver Grafico</button>
						</form>
					
					</div>
					
				</div>
				
			</div>
			
		</div>

		<p class="mt-30"><a class="btn btn-primary" href="./backend-index.php">Volver</a></p>
		
	</div>
	
</div>

<div id="dt-columnas-lista" class="roverlay" data-header="Seleccionar Columna" data-col="8">
			
	<div class="row w100-p flex-jus-left pl-15">
			
		<div class="input-group mb-1 col col-xs-12 col-sm-12 col-md-4 col-lg-4 p0">
			<input id="dt_columnaBusqueda" type="text" class="form-control" placeholder="Buscar">
			<div class="input-group-append">
				<button class="btn btn-primary" type="button" id="dt_columnaBtnBusqueda" onclick="$('#grid-dt-columnas').jsGrid('loadData');">
					<i class="fa fa-search"></i>
				</button>
			</div>
		</div>
	
	</div>
			
	<div class="row w100-p mt-20">
				
		<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<div id="grid-dt-columnas">
	
			</div>
	
		</div>
		
	</div>
	
</div>

<div id="dt-tabla-lista" class="roverlay" data-header="Seleccionar Tabla" data-col="8">
			
	<div class="row w100-p flex-jus-left pl-15">
			
		<div class="input-group mb-1 col col-xs-12 col-sm-12 col-md-4 col-lg-4 p0">
			<input id="dt_tablaBusqueda" type="text" class="form-control" placeholder="Buscar">
			<div class="input-group-append">
				<button class="btn btn-primary" type="button" id="dt_tablaBtnBusqueda" onclick="$('#grid-dt-tabla').jsGrid('loadData');">
					<i class="fa fa-search"></i>
				</button>
			</div>
		</div>
	
	</div>
			
	<div class="row w100-p mt-20">
				
		<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<div id="grid-dt-tabla">
	
			</div>
	
		</div>
		
	</div>
	
</div>
