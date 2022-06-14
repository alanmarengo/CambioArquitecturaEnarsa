<?php 

$dt_data = array(); 

?>

<div class="row pv-30">

	<div class="col hidden-xs hidden-sm col-md-1 col-lg-1"></div>
	<div class="col col-xs-12 col-sm-12 col-md-10 col-lg-10 backend-wrapper">	
					
		<div class="row">				
			
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="recurso_current">
				<span>Sin Dataset Actual</span>
			</div>
		
		</div>
		
		<ul class="nav nav-tabs mt-20">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" id="tab-link-busqueda" href="#tab-busqueda">Búsqueda</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab-link-dataset" href="#tab-dataset">Recurso</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab-link-subtemas" href="#tab-subtemas">Subtemas</a></li>
		</ul>
		
		<div class="tab-content p30">	
		
			<div class="tab-pane active" id="tab-busqueda">
				
				<div class="row">
			
					<div class="input-group mb-1 col col-xs-12 col-sm-12 col-md-4 col-lg-4 p0">
						<input id="recursoBusqueda" type="text" class="form-control" placeholder="Buscar">
						<div class="input-group-append">
							<button class="btn btn-primary" type="button" id="recursoBtnBusqueda" onclick="$('#grid-dt-recursos-abm').jsGrid('loadData');">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</div>
					
					<div class="input-group mb-1 col col-xs-12 col-sm-12 col-md-1 col-lg-1 p0"></div>
				
					<div class="mb-1 col col-xs-12 col-sm-12 col-md-4 col-lg-4 p0">
						<button class="btn btn-primary" type="button" id="recursoNuevoBtnBusqueda" onclick="dataset_ob.get_new_id(); $('#grid-dt-recursos-abm').jsGrid('loadData'); $('#tab-link-dataset').trigger('click');">
							<i class="fa fa-plus"></i> Nuevo
						</button>
					</div>
				
				</div>		
			
				<div class="row">
				
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						
						<div id="grid-dt-recursos-abm" class="mt-30">
						
						</div>
				
					</div>
				
				</div>
			
			</div>
		
			<div class="tab-pane fade" id="tab-dataset">
			
				<div class="row">
			
					<div class="col col-xs-12 col-sm-12 col-md-9 col-lg-9">
					
						<form name="frm-backend-recursos" id="frm-backend-recursos">
							<div class="form-group">
								<label for="dt_id">ID</label>
								<input type="text" class="form-control" name="recurso_id" id="recurso_id" aria-describedby="recurso_id" readonly="readonly" placeholder="ID Gráfico...">
							</div>
							<div class="form-group">
								<label for="tipo_recurso_id">Formato</label>
								<?php get_combo_db("sinia_recursos","formato","formato_id","formato_desc",test_get_var($dt_data["formato_id"],"1"),"formato_id"); ?>
							</div>
							<div class="form-group">
								<label for="dt_id">Tipo Cobertura</label>
								<?php get_combo_db("sinia_catalogo","tipo_cobertura","tipo_cobertura_id","tipo_cobertura_desc",test_get_var($dt_data["tipo_cobertura_id"],"6"),"tipo_cobertura_id"); ?>
							</div>
							<div class="form-group">
								<label for="tipo_recurso_id">Tipo Recurso</label>
								<?php get_combo_db("sinia_recursos","tipo_recurso","tipo_recurso_id","tipo_recurso_desc",test_get_var($dt_data["tipo_recurso_id"],"6"),"tipo_recurso_id"); ?>
							</div>
							<div class="form-group">
								<label for="recurso_titulo">Título</label>
								<input type="text" class="form-control" name="recurso_titulo" id="recurso_titulo" aria-describedby="recurso_titulo" placeholder="Titulo...">
							</div>
							<div class="form-group">
								<label for="recurso_desc">Descripción</label>
								<input type="text" class="form-control" name="recurso_desc" id="recurso_desc" aria-describedby="recurso_desc" placeholder="Descripción...">
							</div>
							<div class="form-group">
								<label for="recurso_path">Path</label>
								<input type="text" class="form-control" name="recurso_path" id="recurso_path" aria-describedby="recurso_path" placeholder="Path...">
							</div>
							<div class="form-group">
								<label for="palabras_clave">Palabras Clave</label>
								<input type="text" class="form-control" name="palabras_clave" id="palabras_clave" aria-describedby="palabras_clave" placeholder="Palabras Clave...">
							</div>
							<div class="form-group">
								<label for="recurso_fecha">Recurso Fecha</label>
								<input type="text" class="form-control datepicker" name="recurso_fecha" id="recurso_fecha" aria-describedby="recurso_fecha" placeholder="Fecha...">
							</div>
							<div class="form-group">
								<label for="recurso_numero">Recurso Número</label>
								<input type="text" class="form-control" name="recurso_numero" id="recurso_numero" aria-describedby="recurso_numero" placeholder="Número...">
							</div>
							<div class="form-group">
								<label for="recurso_fuente">Recurso Fuente</label>
								<input type="text" class="form-control" name="recurso_fuente" id="recurso_fuente" aria-describedby="recurso_fuente" placeholder="Fuente...">
							</div>
							<button type="button" class="btn btn-primary" onclick="dataset_ob.save(document.getElementById('frm-backend-recursos'));">Guardar</button>
							<button type="button" class="btn btn-danger" onclick="dataset_ob.drop();">Eliminar Recurso</button>
						</form>
					
					</div>
					
					<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3 backend-files-wrapper mt-30">
						
						<h5>Archivos para este Recurso</h5>
						
						<div id="dt_archivos" class="file-dropper mt-30">
					
							<div class="file-dropper-hint">Arrastre un archivo para asignarlo a este recurso</div>
						
						</div>
							
						<div id="dt_lista_archivos" class="directory-reader mt-30">
						
							
						
						</div>
						
					</div>
					
				</div>
				
			</div>
			
			<div class="tab-pane fade" id="tab-subtemas">
				
				<div class="row">
				
					<div class="input-group mb-1 col col-xs-12 col-sm-12 col-md-8 col-lg-8 p0"></div>
					<div class="input-group mb-1 col col-xs-12 col-sm-12 col-md-4 col-lg-4 p0">
						<input id="layersBusqueda" type="text" class="form-control" placeholder="Buscar">
						<div class="input-group-append">
							<button class="btn btn-primary" type="button" id="layersBtnBusqueda" onclick="$('#grid-layers').jsGrid('loadData');">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</div>
				
				</div>
				
				<div class="row mt-30">
				
					<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
						
						<p>Lista de subtemas en este recurso (Click para desvincular)</p>
						
						<div id="grid-dt-rec-subtemas" class="mt-30">
						
						</div>
				
					</div>
				
					<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
						
						<p>Lista completa de subtemas disponibles (Click para agregar al dataset)</p>
						
						<div id="grid-rec-subtemas" class="mt-30">
						
						</div>
				
					</div>
				
				</div>
				
			</div> <!-- END PANEL 2 -->
			
		</div>

		<p class="mt-30"><a class="btn btn-primary" href="./backend-index.php">Volver</a></p>
		
	</div>
	
</div>

<div id="file-info-div" class="roverlay" data-header="Información de Archivo" data-col="4">
			
	<div class="info-box-form w100-p">
	
		<div class="iform-control p0">
			<label for="file-link">Enlace para insertar en sitio web</label>
			<input type="text" readonly="readonly" class="file-link" name="file-link" id="file-link">
		</div>
		
		<p class="mt-10"><a href="#" class="file-open" target="_blank">Abrir Archivo</a></p>
	
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
