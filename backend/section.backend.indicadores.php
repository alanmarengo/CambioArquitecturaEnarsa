

<script type="text/javascript" src="./js/abm-indicadores.js"></script>

<div class="row pv-30">

	<div class="col hidden-xs hidden-sm col-md-1 col-lg-1"></div>
	<div class="col col-xs-12 col-sm-12 col-md-10 col-lg-10 backend-wrapper">	
					
		<div class="row">				
			
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="current_id">
				<span>Sin Panel Seleccionado</span>
			</div>
		
		</div>
		
		<ul class="nav nav-tabs mt-20">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" id="tab-link-busqueda" href="#tab-buscar">Buscar</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab-link-b" href="#tab-b">Datos del indicador</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab-link-c" href="#tab-c">Configuración del indicador</a></li>
			<!--<li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab-link-d" href="#tab-d">Variables</a></li>-->
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
								<label for="ind_id">Id del Panel</label>
								<input type="text" class="form-control" name="ind_id" id="ind_id" aria-describedby="ind_id"  readonly="readonly" placeholder="ID del panel...">
							</div>
							
							<div class="form-group">
								<label for="ind_titulo">Titulo</label>
								<input type="text" class="form-control" name="ind_titulo" id="ind_titulo" aria-describedby="ind_titulo" placeholder="Titulo...">
							</div>
							<div class="form-group">
								<label for="ind_desc">Descripción</label>
								<input type="text" class="form-control" name="ind_desc" id="ind_desc" aria-describedby="ind_desc" placeholder="Descripción...">
							</div>
							<div class="form-group">
								<label for="clase_id">Template</label>
								<?php get_combo_db("mod_indicadores","template","template_id","template_desc",null,"template_id"); ?>
							</div>
							<div class="form-group">
								<label for="clase_id">Perfil</label>
								<?php get_combo_db("mod_catalogo","clase","clase_id","clase_desc",null,"clase_id"); ?>
							</div>
												
							<button type="button" class="btn btn-primary" onclick="guardar();">Guardar</button>
							<button type="button" class="btn btn-danger" onclick="borrar_panel();">Eliminar panel</button>
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
			
			<div class="tab-pane" id="tab-c">
				
				<div class="row mt-30">
				
					<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
						
						<p>Lista de capas en este dataset (Click para desvincular)</p>
						
						<div id="grid-items-panel" class="mt-30">
						
						</div>
				
					</div>
				
					<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
						
						<p>Datos del item a agregar</p>
						
						<div class="form-group">
								<label for="posicion">Posición</label>
								<input type="text" class="form-control" name="posicion" id="posicion" aria-describedby="posicion"  placeholder="Posición en el template...">
						</div>
						<div class="form-group">
								<label for="titulo">Titulo</label>
								<input type="text" class="form-control" name="titulo" id="titulo" aria-describedby="titulo"  placeholder="Titulo...">
						</div>
						<div class="form-group">
								<label for="desc">Descripción</label>
								<input type="text" class="form-control" name="desc" id="desc" aria-describedby="desc"  placeholder="Descripción...">
						</div>
						<div class="form-group">
								<label for="ficha_metodo_path">Ficha metodológica (path)</label>
								<input type="text" class="form-control" name="ficha_metodo_path" id="ficha_metodo_path" aria-describedby="desc"  placeholder="Ficha metodológica...">
						</div>
						<div class="form-group">
								<label for="extent">Extent (EPSG:3857 solo capas)</label>
								<input type="text" class="form-control" name="extent" id="extent" aria-describedby="extent"  placeholder="Extent...">
						</div>
						
						 <label for="dt_cruce_etiqueta">Item a asignar(Click para agregar)</label>
						 <div class="input-group mb-1 col col-xs-12 col-sm-12 col-md-4 col-lg-4 p0">
						 <input id="buscar_items" type="text" class="form-control" placeholder="Buscar items">
						 <div class="input-group-append">
							<button class="btn btn-primary" type="button" id="buscar_items_b" onclick="$('#grid-items').jsGrid('loadData');">
								<i class="fa fa-search"></i>
							</button>
						</div>
						</div>
						 <div id="grid-items" class="mt-30">
	
									  
						
						</div>
				
					</div>
				
				</div>
			
			</div> <!-- FIN TAB C-->
			
		
				
			
			</div>
		</div>
		
		</div>
				<p class="mt-30"><a class="btn btn-primary" href="./backend-index.php">Volver</a></p>
	</div>
	
</div>




