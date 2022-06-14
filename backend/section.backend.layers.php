
<script type="text/javascript" src="./js/abm-layers.js"></script>

<div class="row pv-30">

	<div class="col hidden-xs hidden-sm col-md-1 col-lg-1"></div>
	<div class="col col-xs-12 col-sm-12 col-md-10 col-lg-10 backend-wrapper">	
					
		<div class="row">				
			
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="current_capa_id">
				<span>Sin Capa Seleccionada</span>
			</div>
		
		</div>
		
		<ul class="nav nav-tabs mt-20">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" id="tab-link-busqueda" href="#tab-buscar">Buscar</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab-link-b" href="#tab-b">Datos Capa</a></li>
			<!--<li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab-link-c" href="#tab-c">Preview</a></li>-->

		</ul>
		
		<div class="tab-content p30">	
		
			<div class="tab-pane active" id="tab-buscar">   <!-- INICIO TAB A -->
				
				<div class="row">
			
					<div class="input-group mb-1 col col-xs-12 col-sm-12 col-md-4 col-lg-4 p0">
						<input id="dtBusqueda" type="text" class="form-control" placeholder="Buscar">
						<div class="input-group-append">
							<button class="btn btn-primary" type="button" id="boton_buscar" onclick="$('#grid-layers').jsGrid('loadData');">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</div>
					
					<div class="input-group mb-1 col col-xs-12 col-sm-12 col-md-1 col-lg-1 p0"></div>
				
					<div class="mb-1 col col-xs-12 col-sm-12 col-md-4 col-lg-4 p0">
						<button class="btn btn-primary" type="button" id="dtNuevoBtnBusqueda" onclick="nueva_capa();">
							<i class="fa fa-plus"></i> Nuevo
						</button>
					</div>
				
				</div>		
			
				<div class="row">
				
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						
						<div id="grid-layers" class="mt-30">
						
						</div>
				
					</div>
				
				</div>
			
			</div> <!-- FIN TAB A -->
		
			<div class="tab-pane fade" id="tab-b">   <!-- INICIO TAB B -->
			
				<div class="row">
			
					<div class="col col-xs-12 col-sm-12 col-md-9 col-lg-9">
					
						<form name="frm-backend-main" id="frm-backend-main">
							<div class="form-group">
								<label for="layer_id">Id de la capa</label>
								<input type="text" class="form-control" name="layer_id" id="layer_id" aria-describedby="layer_id"  readonly="readonly" placeholder="ID de Capa...">
							</div>
							<div class="form-group">
								<label for="preview_desc">Descripción para preview</label>
								<input type="text" class="form-control" name="preview_desc" id="preview_desc" aria-describedby="preview_desc"  placeholder="Descripción para preview...">
							</div>
							<div class="form-group">
								<label for="preview_titulo">Titulo para preview</label>
								<input type="text" class="form-control" name="preview_titulo" id="preview_titulo" aria-describedby="preview_titulo"  placeholder="Titulo para preview...">
							</div>
							<div class="form-group">
								<label for="layer_desc">Descripción</label>
								<input type="text" class="form-control" name="layer_desc" id="layer_desc" aria-describedby="layer_desc" r placeholder="Descripción...">
							</div>
							<div class="form-group">
								<label for="tipo_layer_id">Tipo capa</label>
								<?php get_combo_db("mod_geovisores","tipo_layer","tipo_layer_id","tipo_layer_desc",null,"tipo_layer_id"); ?>

							</div>
							<div class="form-group">
								<label for="layer_schema">Schema de la capa en DB</label>
								<input type="text" class="form-control" name="layer_schema" id="layer_schema" aria-describedby="layer_schema"  placeholder="Schema de la capa en db...">
							</div>
							<div class="form-group">
								<label for="layer_table">Tabla de la capa</label>
								<input type="text" class="form-control" name="layer_table" id="layer_table" aria-describedby="layer_table"  placeholder="Tabla de la capa...">
							</div>
							
							<div class="form-group">
								<label for="layer_wms_server">Servidor WMS</label>
								<input type="text" class="form-control" name="layer_wms_server" id="layer_wms_server" aria-describedby="layer_wms_server"  placeholder="Servidor WMS...">
							</div>
							<div class="form-group">
								<label for="layer_wms_layer">Nombre capa en el WMS</label>
								<input type="text" class="form-control" name="layer_wms_layer" id="layer_wms_layer" aria-describedby="layer_wms_layer"  placeholder="Nombre capa en el WMS...">
							</div>
							<div class="form-group">
								<label for="layer_wms_server_alter">Servidor WMS alternativo</label>
								<input type="text" class="form-control" name="layer_wms_server_alter" id="layer_wms_server_alter" aria-describedby="layer_wms_server_alter"  placeholder="Servidor WMS alternativo...">
							</div>
							<div class="form-group">
								<label for="layer_wms_layer_alter">Nombre capa en el WMS alternativo</label>
								<input type="text" class="form-control" name="layer_wms_layer_alter" id="layer_wms_layer_alter" aria-describedby="layer_wms_layer_alter"  placeholder="Nombre capa en el WMS alternativo...">
							</div>
							<div class="form-group">
								<label for="layer_alter_activo">Recurso WMS Alternativo activo?</label>
								<select name="layer_alter_activo" id="layer_alter_activo" class="form-control">
									<option value="f">Desactivado</option>
									<option value="t">Activado</option>
								</select>
							</div>
							<div class="form-group">
								<label for="layer_metadata_url">URL GeoNetWork Metadatos</label>
								<input type="text" class="form-control" name="layer_metadata_url" id="layer_metadata_url" aria-describedby="layer_metadata_url"  placeholder="URL GeoNetWork Metadatos...">
							</div>
							
							
							
							<!--<div class="form-group">
								<label for="recurso_categoria_id">Categoría de Recurso</label>
								<?php get_combo_db("mod_mediateca","recurso_categoria","recurso_categoria_id","recurso_categoria_desc",test_get_var($recurso_data["recurso_categoria_id"],"1"),"recurso_categoria_id"); ?>
							</div>-->
							
							<button type="button" class="btn btn-primary" onclick="guardar_capa();">Guardar</button>
							<button type="button" class="btn btn-danger" onclick="borrar_capa();">Eliminar Capa</button>
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
						<button type="button" style="width:100%;" class="btn btn-primary" onclick="abrir_en_geobi();">Ver en Geobi</button>
						
						<br>
						<br>
						<button type="button" style="width:100%;" title="Es necesario registrar los datos en el catalogo, esto permite buscar, categorizar la capa" class="btn btn-primary" onclick="guardar_catalogo();">Registrar en Catálogo</button>

					</div>
					
			    
					
				</div>
							 
				
			</div> <!-- FIN TAB B -->
			 <!-- INICIO TAB C -->
			<!-- 
			<div class="tab-pane" id="tab-c"> 
				
				<div class="row">
							
				</div>		
			
				<div class="row">
					
				</div>
			
			</div> --> <!-- FIN TAB C -->
			
			
		</div>

		<p class="mt-30"><a class="btn btn-primary" href="./backend-index.php">Volver</a></p>
		
	</div>
	
</div>




