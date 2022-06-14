

<script type="text/javascript" src="./js/abm-geovisores.js"></script>

<div class="row pv-30">

	<div class="col hidden-xs hidden-sm col-md-1 col-lg-1"></div>
	<div class="col col-xs-12 col-sm-12 col-md-10 col-lg-10 backend-wrapper">	
					
		<div class="row">				
			
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="current_geovisor_id">
				<span>Sin Geovisor Seleccionado</span>
			</div>
		
		</div>
		
		<ul class="nav nav-tabs mt-20">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" id="tab-link-busqueda" href="#tab-buscar">Buscar</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab-link-b" href="#tab-b">Datos de Geovisor</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab-link-c" href="#tab-c">Capas del Geovisor</a></li>

		</ul>
		
		<div class="tab-content p30">	
		
			<div class="tab-pane active" id="tab-buscar">   <!-- INICIO TAB A -->
				
				<div class="row">
			
					<div class="input-group mb-1 col col-xs-12 col-sm-12 col-md-4 col-lg-4 p0">
						<input id="dtBusqueda" type="text" class="form-control" placeholder="Buscar">
						<div class="input-group-append">
							<button class="btn btn-primary" type="button" id="boton_buscar" onclick="$('#grid-geovisores').jsGrid('loadData');">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</div>
					
					<div class="input-group mb-1 col col-xs-12 col-sm-12 col-md-1 col-lg-1 p0"></div>
				
					<div class="mb-1 col col-xs-12 col-sm-12 col-md-4 col-lg-4 p0">
						<button class="btn btn-primary" type="button" id="dtNuevoBtnBusqueda" onclick="nuevo_geovisor();">
							<i class="fa fa-plus"></i> Nuevo
						</button>
					</div>
				
				</div>		
			
				<div class="row">
				
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						
						<div id="grid-geovisores" class="mt-30"></div>
				
					</div>
				
				</div>
			
			</div> <!-- FIN TAB A -->
		
			<div class="tab-pane fade" id="tab-b">   <!-- INICIO TAB B -->
			
				<div class="row">
			
					<div class="col col-xs-12 col-sm-12 col-md-9 col-lg-9">
					
						<form name="frm-backend-main" id="frm-backend-main">
							<div class="form-group">
								<label for="geovisor_id">Id del geovisor</label>
								<input type="text" class="form-control" name="geovisor_id" id="geovisor_id" aria-describedby="geovisor_id"  readonly="readonly" placeholder="ID de geovisor...">
							</div>
							<div class="form-group">
								<label for="geovisor_desc">Descripción</label>
								<input type="text" class="form-control" name="geovisor_desc" id="geovisor_desc" aria-describedby="geovisor_desc" r placeholder="Descripción...">
							</div>
							<div class="form-group">
								<label for="geovisor_extent">Extent Inicial (EPSG:3857)</label>
								<input type="text" class="form-control" name="geovisor_extent" id="geovisor_extent" aria-describedby="geovisor_extent"  placeholder="[minx,miny,maxx,maxy]...">
							</div>
						
							<button type="button" class="btn btn-primary" onclick="guardar_geovisor();">Guardar</button>
							<button type="button" class="btn btn-danger" onclick="borrar_geovisor();">Eliminar Geovisor</button>
						</form>
					
					</div>
					
					<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3 backend-files-wrapper mt-30">
						
						<h5>Vista Previa</h5>
						<img src="" id="preview_id" width="100%" height="200px">
						<div id="recursos_archivos" class="file-dropper mt-30" style="display:none;">
														
							<div class="file-dropper-hint">Arrastre un archivo para asignarlo a este recurso</div>
						
						</div>
							
							<div id="recurso_lista_archivos" class="directory-reader mt-30"></div>
						<br>
						<br>
						<button type="button" style="width:100%;" class="btn btn-primary" onclick="abrir_en_geobi();">Ver Geovisor</button>
						
						
					</div>
					
			    
					
				</div>
							 
				
			</div> <!-- FIN TAB B -->
			 <!-- INICIO TAB C -->
			
			<div class="tab-pane" id="tab-c"> 
				<!-- GRIDS -->
				<div class="row">
				
					<div class="input-group mb-1 col col-xs-12 col-sm-12 col-md-8 col-lg-8 p0"></div>
					<div class="input-group mb-1 col col-xs-12 col-sm-12 col-md-4 col-lg-4 p0">
						<input id="layersBusqueda" type="text" class="form-control" placeholder="Buscar capas">
						<div class="input-group-append">
							<button class="btn btn-primary" type="button" id="buscar_capas" onclick="$('#grid-capas').jsGrid('loadData');">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</div>
				
				</div>
				
				<div class="row mt-30">
				
					<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
						
						<p>Lista de capas en este Geovisor (Click para desvincular)</p>
						
						<div id="grid-geovisores-capas" class="mt-30">
						
						</div>
				
					</div>
				
					<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
						
						<label for="layer_alter_activo">Inicia Visible?</label>
								<select name="iniciar_visible" id="iniciar_visible" class="form-control">
									<option value="f">No</option>
									<option value="t">Si</option>
								</select>
							
						<p>Lista de capas (Click para agregar al geovisor)</p>
						<div id="grid-capas" class="mt-30">
						
						</div>
				
					</div>
				
				</div>
				
				<!-- GRIDS -->
				
			
			</div> <!-- FIN TAB C -->
			
			
		</div>

		<p class="mt-30"><a class="btn btn-primary" href="./backend-index.php">Volver</a></p>
		
	</div>
	
</div>




