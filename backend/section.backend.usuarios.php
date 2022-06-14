

<script type="text/javascript" src="./js/abm-usuarios.js"></script>

<div class="row pv-30">

	<div class="col hidden-xs hidden-sm col-md-1 col-lg-1"></div>
	<div class="col col-xs-12 col-sm-12 col-md-10 col-lg-10 backend-wrapper">	
					
		<div class="row">				
			
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="current_id">
				<span>Sin Usuario Seleccionado</span>
			</div>
		
		</div>
		
		<ul class="nav nav-tabs mt-20">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" id="tab-link-busqueda" href="#tab-buscar">Buscar</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab-link-b" href="#tab-b">Datos Usuario</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab-link-c" href="#tab-c">Cambiar password</a></li>
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
								<label for="user_id">Id del usuario</label>
								<input type="text" class="form-control" name="user_id" id="user_id" aria-describedby="user_id"  readonly="readonly" placeholder="ID del usuario...">
							</div>
							
							<div class="form-group">
								<label for="user_name">Nombre login</label>
								<input type="text" class="form-control" name="user_name" id="user_name" aria-describedby="user_name" placeholder="Nombre Login...">
							</div>
							<div class="form-group">
								<label for="user_full_name">Nombre de usuario</label>
								<input type="text" class="form-control" name="user_full_name" id="user_full_name" aria-describedby="user_full_name" placeholder="Nombre Usuario...">
							</div>
							<div class="form-group">
								<label for="clase_id">Estado</label>
								<?php get_combo_db("mod_login","user_estado","user_estado_id","user_estado_desc",null,"user_estado_id"); ?>
							</div>
							<div class="form-group">
								<label for="clase_id">Perfil</label>
								<?php get_combo_db("mod_login","perfil_usuario","perfil_usuario_id","perfil_usuario_desc",null,"perfil_usuario_id"); ?>
							</div>
							
							
							
							<div class="form-group">
								<label for="user_contra_dominio">Se loguea contra dominio?</label>
								<select name="user_contra_dominio" id="user_contra_dominio" class="form-control">
									<option value="f">No</option>
									<option value="t">Si</option>
								</select>
							</div>
							
												
							<button type="button" class="btn btn-primary" onclick="guardar();">Guardar</button>
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
				
				<div class="row">
							
						<div class="input-group mb-1 col col-xs-12 col-sm-12 col-md-4 col-lg-4 p0">
							<div class="form-group">
								<label for="passw">Password</label>
								<input type="password" class="form-control" name="passw" id="passw" aria-describedby="passw" placeholder="Password...">
							</div>
							<div class="form-group">
								<label for="passwc">Repetir Password</label>
								<input style="width:100%;" type="password" class="form-control" name="passwc" id="passwc" aria-describedby="passwc" placeholder="Repita Password...">
							</div>

							<button type="button" style="width:60%;" class="btn btn-primary" onclick="guardar_pw();">Guardar</button>

						</div>
							

				</div>		
			
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div id="grid-permisos" class="mt-30"></div>
					</div>
				</div>
			
			</div> <!-- FIN TAB C-->
			
		
				
			
			</div>
		</div>
		
		</div>
				<p class="mt-30"><a class="btn btn-primary" href="./backend-index.php">Volver</a></p>
	</div>
	
</div>




