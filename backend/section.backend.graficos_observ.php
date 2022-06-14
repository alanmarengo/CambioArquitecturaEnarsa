
<script type="text/javascript" src="./js/abm-graficos.js"></script>

<div class="row pv-30">

	<div class="col hidden-xs hidden-sm col-md-1 col-lg-1"></div>
	<div class="col col-xs-12 col-sm-12 col-md-10 col-lg-10 backend-wrapper">	
					
		<div class="row">				
			
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="current_id">
				<span>Sin grafico Seleccionado</span>
			</div>
		
		</div>
		
		<ul class="nav nav-tabs mt-20">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" id="tab-link-busqueda" href="#tab-buscar">Buscar</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab-link-b" href="#tab-b">Datos del grafico</a></li>
			<!--<li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab-link-c" href="#tab-c">Cruces espaciales</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab-link-d" href="#tab-d">Variables</a></li>-->
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
								<label for="grafico_id">Id del grafico</label>
								<input type="text" class="form-control" name="grafico_id" id="grafico_id" aria-describedby="grafico_id"  readonly="readonly" placeholder="ID del grafico...">
							</div>
							<div class="form-group">
								<label for="grafico_titulo">Titulo</label>
								<input type="text" class="form-control" name="grafico_titulo" id="grafico_titulo" aria-describedby="grafico_titulo" r placeholder="Titulo...">
							</div>
							<div class="form-group">
								<label for="grafico_desc">Descripción</label>
								<input type="text" class="form-control" name="grafico_desc" id="grafico_desc" aria-describedby="grafico_desc" r placeholder="Descripcion...">
							</div>
							
							<div class="form-group">
								<label for="clase_id">Tipo de grafico</label>
								<?php get_combo_db("mod_graficos","grafico_tipo","grafico_tipo_id","grafico_tipo_desc",null,"grafico_tipo_id"); ?>
							</div>
							
							<div class="form-group">
								<label for="grafico_data_schema">Schema</label>
								<input type="text" class="form-control" name="grafico_data_schema" id="grafico_data_schema" aria-describedby="grafico_data_schema"  placeholder="Schema...">
							</div>
							<div class="form-group">
								<label for="grafico_data_tabla">Tabla</label>
								<input type="text" class="form-control" name="grafico_data_tabla" id="grafico_data_tabla" aria-describedby="grafico_data_tabla" r placeholder="Tabla...">
							</div>
												
							<button type="button" class="btn btn-primary" onclick="guardar();">Guardar</button>
							<button type="button" class="btn btn-danger" onclick="borrar();">Eliminar</button>
						</form>
					
					</div>
					
					<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3 backend-files-wrapper mt-30">
						
						<!--<h5>Operaciones</h5>-->
						<!--<img src="" id="preview_id" width="100%" height="200px">-->
						<div style="display:none;" id="recursos_archivos" class="file-dropper mt-30" style="display:none;">
														
							<div class="file-dropper-hint">Arrastre un archivo para asignarlo a este recurso</div>
						
						</div>
							<div style="display:none;" id="recurso_lista_archivos" class="directory-reader mt-30"></div>
						<!--<button type="button" style="width:100%;" class="btn btn-primary" onclick="generar_vairables();">Vista Previa</button>-->
					
						
					</div>
					
			    
					
				</div>
							 
				
			</div> <!-- FIN TAB B -->
		
				
			
			</div>
		</div>
		
		</div>
				<p class="mt-30"><a class="btn btn-primary" href="./backend-index.php">Volver</a></p>
	</div>
	
</div>




