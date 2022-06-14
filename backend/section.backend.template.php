
<div class="row pv-30">

	<div class="col hidden-xs hidden-sm col-md-1 col-lg-1"></div>
	<div class="col col-xs-12 col-sm-12 col-md-10 col-lg-10 backend-wrapper">	
					
		<div class="row">				
			
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="recurso_current">
				<span>Sin Dataset Actual</span>
			</div>
		
		</div>
		
		<ul class="nav nav-tabs mt-20">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" id="tab-link-busqueda" href="#tab-a">TAB A</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab-link-dataset" href="#tab-b">TAB B</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab-link-permisos" href="#tab-c">TAB C</a></li>

		</ul>
		
		<div class="tab-content p30">	
		
			<div class="tab-pane active" id="tab-a">   <!-- INICIO TAB A -->
				
				<div class="row">
			
					<div class="input-group mb-1 col col-xs-12 col-sm-12 col-md-4 col-lg-4 p0">
						<input id="dtBusqueda" type="text" class="form-control" placeholder="Buscar">
						<div class="input-group-append">
							<button class="btn btn-primary" type="button" id="dtBtnBusqueda" onclick="$('#grid-recursos').jsGrid('loadData');">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</div>
					
					<div class="input-group mb-1 col col-xs-12 col-sm-12 col-md-1 col-lg-1 p0"></div>
				
					<div class="mb-1 col col-xs-12 col-sm-12 col-md-4 col-lg-4 p0">
						<button class="btn btn-primary" type="button" id="dtNuevoBtnBusqueda" onclick="dataset_ob.get_new_id(); $('#grid-recursos').jsGrid('loadData'); $('#tab-link-dataset').trigger('click');">
							<i class="fa fa-plus"></i> Nuevo
						</button>
					</div>
				
				</div>		
			
				<div class="row">
				
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						
						<div id="grid-recursos" class="mt-30">
						
						</div>
				
					</div>
				
				</div>
			
			</div> <!-- FIN TAB A -->
		
			<div class="tab-pane fade" id="tab-b">   <!-- INICIO TAB B -->
			
				<div class="row">
			
					<div class="col col-xs-12 col-sm-12 col-md-9 col-lg-9">
					
						<form name="frm-backend-main" id="frm-backend-main">
							<div class="form-group">
								<label for="recurso_id">ID</label>
								<input type="text" class="form-control" name="recurso_id" id="recurso_id" aria-describedby="recurso_id" readonly="readonly" placeholder="ID Recurso...">
							</div>
							<div class="form-group">
								<label for="recurso_categoria_id">Categoría de Recurso</label>
								<?php get_combo_db("mod_mediateca","recurso_categoria","recurso_categoria_id","recurso_categoria_desc",test_get_var($recurso_data["recurso_categoria_id"],"1"),"recurso_categoria_id"); ?>
							</div>
							
							<button type="button" class="btn btn-primary" onclick="">Guardar</button>
							<button type="button" class="btn btn-danger" onclick="">Eliminar Recurso</button>
						</form>
					
					</div>
					
					<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3 backend-files-wrapper mt-30">
						
						<h5>Archivos para este Recurso</h5>
						
						<div id="recursos_archivos" class="file-dropper mt-30">
							
							<div class="file-dropper-hint">Arrastre un archivo para asignarlo a este recurso</div>
								
						
						</div>
							
							<div id="recurso_lista_archivos" class="directory-reader mt-30"></div>
						<br>
						<br>
						<button type="button" style="width:100%;" class="btn btn-primary" onclick="">Generar/Ver Preview</button>
					</div>
					
			    
					
				</div>
							 
				
			</div> <!-- FIN TAB B -->
			
			<div class="tab-pane" id="tab-c">  <!-- INICIO TAB C -->
				
				<div class="row">
							
				</div>		
			
				<div class="row">
					
				</div>
			
			</div> <!-- FIN TAB C -->
			
			
		</div>

		<p class="mt-30"><a class="btn btn-primary" href="./backend-index.php">Volver</a></p>
		
	</div>
	
</div>



