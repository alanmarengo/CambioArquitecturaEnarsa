


<script type="text/javascript" src="./js/abm-estadistico.js"></script>

<div class="row pv-30">

	<div class="col hidden-xs hidden-sm col-md-1 col-lg-1"></div>
	<div class="col col-xs-12 col-sm-12 col-md-10 col-lg-10 backend-wrapper">	
					
		<div class="row">				
			
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="current_id">
				<span>Sin dataset Seleccionado</span>
			</div>
		
		</div>
		
		<ul class="nav nav-tabs mt-20">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" id="tab-link-busqueda" href="#tab-buscar">Buscar</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab-link-b" href="#tab-b">Datos del dataset</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab-link-c" href="#tab-c">Cruces espaciales</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab-link-d" href="#tab-d">Variables</a></li>
		</ul>
		
		<div class="tab-content p30">	
		
			<div class="tab-pane active" id="tab-buscar">   <!-- INICIO TAB A -->
				
				<div class="row">
			
					<div class="input-group mb-1 col col-xs-12 col-sm-12 col-md-4 col-lg-4 p0">
						<input id="dtBusqueda" type="text" class="form-control" placeholder="Buscar">
						<div class="input-group-append">
							<button class="btn btn-primary" type="button" id="boton_buscar" onclick="$('#grid-busqueda').jsGrid('loadData');">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</div>
					
					<div class="input-group mb-1 col col-xs-12 col-sm-12 col-md-1 col-lg-1 p0"></div>
				
					<div class="mb-1 col col-xs-12 col-sm-12 col-md-4 col-lg-4 p0">
						<button class="btn btn-primary" type="button" id="dtNuevoBtnBusqueda" onclick="nuevo();">
							<i class="fa fa-plus"></i> Nuevo
						</button>
					</div>
				
				</div>		
			
				<div class="row">
				
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						
						<div id="grid-busqueda" class="mt-30"></div>
				
					</div>
				
				</div>
			
			</div> <!-- FIN TAB A -->
		
			<div class="tab-pane fade" id="tab-b">   <!-- INICIO TAB B -->
			
				<div class="row">
			
					<div class="col col-xs-12 col-sm-12 col-md-9 col-lg-9">
					
						<form name="frm-backend-main" id="frm-backend-main">
							<div class="form-group">
								<label for="dt_id">Id</label>
								<input type="text" class="form-control" name="dt_id" id="dt_id" aria-describedby="dt_id"  readonly="readonly" placeholder="ID del dataset...">
							</div>
							<div class="form-group">
								<label for="clase_id">Clase</label>
								<?php get_combo_db("mod_catalogo","clase","clase_id","clase_desc",null,"clase_id"); ?>
							</div>
							<div class="form-group">
								<label for="dt_titulo">Titulo</label>
								<input type="text" class="form-control" name="dt_titulo" id="dt_titulo" aria-describedby="dt_titulo" r placeholder="Titulo...">
							</div>
							<div class="form-group">
								<label for="dt_desc">Descripción</label>
								<input type="text" class="form-control" name="dt_desc" id="dt_desc" aria-describedby="dt_desc" r placeholder="Descripción...">
							</div>
							<div class="form-group">
								<label for="dt_table_source">Tabla Fuente</label>
								<input type="text" class="form-control" name="dt_table_source" id="dt_table_source" aria-describedby="dt_table_source"  placeholder="Tabla fuente...">
							</div>
							<div class="form-group">
								<label for="dt_geom_base_table">Tabla espacial de base</label>
								<input type="text" class="form-control" name="dt_geom_base_table" id="dt_geom_base_table" aria-describedby="dt_geom_base_table" r placeholder="Tabla espacial de base...">
							</div>
							<div class="form-group">
								<label for="dt_geom_column_display">Columna descripción de tabla espacial de base</label>
								<input type="text" class="form-control" name="dt_geom_column_display" id="dt_geom_column_display" aria-describedby="dt_geom_column_display"  placeholder="Columna descripción de tabla espacial de base...">
							</div>
			
						
						
							<button type="button" class="btn btn-primary" onclick="guardar();">Guardar</button>
							<button type="button" class="btn btn-danger" onclick="borrar_geovisor();">Eliminar dataset</button>
						</form>
					
					</div>
					
					<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3 backend-files-wrapper mt-30">
						
						<h5>Operaciones</h5>
						<!--<img src="" id="preview_id" width="100%" height="200px">-->
						<div style="display:none;" id="recursos_archivos" class="file-dropper mt-30" style="display:none;">
														
							<div class="file-dropper-hint">Arrastre un archivo para asignarlo a este recurso</div>
						
						</div>
							<div style="display:none;" id="recurso_lista_archivos" class="directory-reader mt-30"></div>
						<button type="button" style="width:100%;" class="btn btn-primary" onclick="generar_vairables();">Registrar Variables</button>
						<br>
						<br>
						<button type="button" style="width:100%;" class="btn btn-primary" onclick="abrir_en_est();">Ver en Mod. Estadistico</button>

						
					</div>
					
			    
					
				</div>
							 
				
			</div> <!-- FIN TAB B -->
			 <!-- INICIO TAB C -->
			
			<div class="tab-pane" id="tab-c"> 
								
				<div class="row mt-30">
				
					<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
						
						<p>Lista de capas en este dataset (Click para desvincular)</p>
						
						<div id="grid-dt-capas" class="mt-30">
						
						</div>
				
					</div>
				
					<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
						
						<p>Datos para cruce</p>
						
						<div class="form-group">
								<label for="dt_cruce_table">Tabla para cruce (schema.tabla)</label>
								<input type="text" class="form-control" name="dt_cruce_table" id="dt_cruce_table" aria-describedby="dt_cruce_table"  placeholder="Table para cruce...">
						</div>
						<div class="form-group">
								<label for="dt_cruce_column_display">Columna a mostrar</label>
								<input type="text" class="form-control" name="dt_cruce_column_display" id="dt_cruce_column_display" aria-describedby="dt_cruce_column_display"  placeholder="Columna a mostrar...">
						</div>
						<div class="form-group">
								<label for="dt_cruce_etiqueta">Etiqueta a mostra para columna</label>
								<input type="text" class="form-control" name="dt_cruce_etiqueta" id="dt_cruce_etiqueta" aria-describedby="dt_cruce_etiqueta"  placeholder="Etiqueta a mostra para columna...">
						</div>
	
						<button type="button" class="btn btn-primary" onclick="guardar_capa_dt();">Agregar</button>
									
					   <!--<div id="grid-capas" class="mt-30">-->
						
						</div>
				
					</div>
				
				</div>
				
				
				<!-- GRIDS -->
				
				<div class="tab-pane" id="tab-d"> 
								
				<div class="row mt-30">
				
					<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
						
						<p>Lista de Variables (Click para editar)</p>
						
						<div id="grid-dt-variables" class="mt-30">
						
						</div>
				
					</div>
				
					<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
						
						<p>Datos de variable</p>
						
						<div class="form-group">
								<label for="dt_variable_id">Id Variable</label>
								<input type="text" class="form-control" name="dt_variable_id" id="dt_variable_id" aria-describedby="dt_variable_id"  readonly="readonly" placeholder="Id de variable...">
						</div>
						<div class="form-group">
								<label for="dt_variable_nombre">Nombre columna</label>
								<input type="text" class="form-control" name="dt_variable_nombre" id="dt_variable_nombre" aria-describedby="dt_variable_nombre"  placeholder="Nombre de variable...">
						</div>
						<div class="form-group">
								<label for="dt_variable_defincion">Definición de la variable</label>
								<input type="text" class="form-control" name="dt_variable_defincion" id="dt_variable_defincion" aria-describedby="dt_variable_defincion"  placeholder="Definición de la variable...">
						</div>
						<div class="form-group">
								<label for="dt_variable_origen">Agrupamiento</label>
								<input type="text" class="form-control" name="dt_variable_origen" id="dt_variable_origen" aria-describedby="dt_variable_origen"  placeholder="Agrupamiento...">
						</div>
	
						<button type="button" class="btn btn-primary" onclick="guardar_variable();">Guardar cambios</button>
						<button type="button" class="btn btn-primary" onclick="borrar_variable();">Eliminar</button>
									
					   <!--<div id="grid-capas" class="mt-30">-->
						
						</div>
				
					</div>
				
				</div>
				
				<!-- GRIDS -->
				
			
			</div> <!-- FIN TAB D -->
				
			
			</div>
		</div>

		<p class="mt-30"><a class="btn btn-primary" href="./backend-index.php">Volver</a></p>
		
	</div>
	
</div>




