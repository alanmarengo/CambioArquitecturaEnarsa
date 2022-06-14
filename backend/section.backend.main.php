<?php 

$dt_data = array(); 

?>

<script>
function abrir_preview()
{
	var url = window.location.origin+'/mediateca_preview.php?r='+document.getElementById("recurso_id").value+'&origen_id=5';//Siempre mediateca
	window.open(url,'','_blank');
};

function regenerar_preview()
{
	if(confirm('Esta seguro desea regenerar la preview?'))
	{
		
	var retorno = $.ajax
				({
					url: "./regen_p.php",
					async:false,
					data:
					{
								r:document.getElementById("recurso_id").value								
					},
					dataType: "json"
				});
	
	//console.log(retorno.responseText);
	
	s = JSON.parse(retorno.responseText); /* status */
	
	if(s.status_code=="0")
	{
		alert('Se quiaron correctamente los datos');
		
		$("#grid-perfiles-recurso").jsGrid('loadData');
		
		
		return true;
	}
	else
	{
		alert('Hubo problemas para quitar los datos. Mensaje:'+s.error_desc);
		return false;
	};
	
	}else return false;
	
};


</script>

<div class="row pv-30">

	<div class="col hidden-xs hidden-sm col-md-1 col-lg-1"></div>
	<div class="col col-xs-12 col-sm-12 col-md-10 col-lg-10 backend-wrapper">	
					
		<div class="row">				
			
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="recurso_current">
				<span>Sin Recurso Seleccionado</span>
			</div>
		
		</div>
		
		<ul class="nav nav-tabs mt-20">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" id="tab-link-busqueda" href="#tab-busqueda">Búsqueda</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab-link-dataset" href="#tab-dataset">Recurso</a></li>
			<!--<li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab-link-permisos" href="#tab-permisos">Permisos</a></li>-->
		</ul>
		
		<div class="tab-content p30">	
		
			<div class="tab-pane active" id="tab-busqueda">
				
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
			
			</div>
		
			<div class="tab-pane fade" id="tab-dataset">
			
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
							
							<div class="form-group">
								<label for="recurso_categoria_id">Tipo Recurso</label>
								<?php get_combo_db("mod_mediateca","tipo_recurso","tipo_recurso_id","tipo_recurso_desc",test_get_var($recurso_data["tipo_recurso_id"],"1"),"tipo_recurso_id"); ?>
							</div>
							<div class="form-group">
								<label for="recurso_categoria_id">Formato</label>
								<?php get_combo_db("mod_mediateca","formato","formato_id","formato_desc",test_get_var($recurso_data["formato_id"],"1"),"formato_id"); ?>
							</div>
							<div class="form-group">
								<label for="recurso_categoria_id">Estudios</label>
								<?php get_combo_db("mod_catalogo","estudios","estudios_id","nombre",test_get_var($recurso_data["estudios_id"],"1"),"estudios_id"); ?>
							</div>
							<div class="form-group">
								<label for="recurso_titulo">Título</label>
								<input type="text" class="form-control" name="recurso_titulo" id="recurso_titulo" aria-describedby="recurso_titulo" placeholder="Titulo...">
							</div>
							<div class="form-group">
								<label for="recurso_autores">Autores</label>
								<input type="text" class="form-control" name="recurso_autores" id="recurso_autores" aria-describedby="recurso_autores" placeholder="Recurso Autores...">
							</div>
							<div class="form-group">
								<label for="recurso_desc">Descripción</label>
								<input type="text" class="form-control" name="recurso_desc" id="recurso_desc" aria-describedby="recurso_desc" placeholder="Descripción...">
							</div>
							<div class="form-group">
								<label for="recurso_fecha">Fecha</label>
								<input type="text" class="datepicker form-control" name="recurso_fecha" id="recurso_fecha" aria-describedby="recurso_fecha" placeholder="Fecha...">
							</div>	
							<div class="form-group">
								<label for="recurso_categoria_id">Sub Proyecto</label>
								<?php get_combo_db("mod_catalogo","sub_proyecto","sub_proyecto_id","sub_proyecto_desc",test_get_var($recurso_data["sub_proyecto_id"],"1"),"sub_proyecto_id"); ?>
							</div>
							<div class="form-group">
								<label for="subclase_id">Sub Clase</label>
								<?php get_combo_db("mod_catalogo","subclase","subclase_id","subclase_desc",test_get_var($recurso_data["subclase_id"],"1"),"subclase_id"); ?>
							</div>
							<div class="form-group">
								<label for="cod_temporalidad_id">Cod. Temporalidad</label>
								<?php get_combo_db("mod_catalogo","cod_temporalidad","cod_temporalidad_id","descripcion",test_get_var($recurso_data["cod_temporalidad_id"],"1"),"cod_temporalidad_id"); ?>
							</div>
							<div class="form-group">
								<label for="territorio_id">Territorio</label>
								<?php get_combo_db("mod_catalogo","territorio","territorio_id","descripcion",test_get_var($recurso_data["territorio_id"],"1"),"territorio_id"); ?>
							</div>
							<div class="form-group">
								<label for="recurso_path_url">URL Recurso</label>
								<input type="text" class="form-control" name="recurso_path_url" id="recurso_path_url" aria-describedby="recurso_path_url" placeholder="URL Recurso...">
							</div>
							<div class="form-group">
								<label for="recurso_size">Tamaño Recurso</label>
								<input type="text" class="form-control" name="recurso_size" id="recurso_size" aria-describedby="recurso_size" placeholder="Tamaño de Recurso...">
							</div>
							<div class="form-group">
								<label for="recurso_preview_path">Recurso Vista Previa <span id="rec-vp"> </span></label>
								<input type="text" class="form-control" name="recurso_preview_path" id="recurso_preview_path" aria-describedby="recurso_preview_path" placeholder="Recurso Vista Previa...">
							</div>
							<button type="button" class="btn btn-primary" id="btnSubmitRec" onclick="dataset_ob.save(document.getElementById('frm-backend-main'));">Guardar</button>
							<button type="button" class="btn btn-danger" onclick="dataset_ob.drop();">Eliminar Recurso</button>
						</form>
					
					</div>
					
					<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3 backend-files-wrapper mt-30">
						
						<!--<h5>Archivos para este Recurso</h5>-->
						
						<div style="display:none;" id="recursos_archivos" class="file-dropper mt-30">
							
							<div class="file-dropper-hint">Arrastre un archivo para asignarlo a este recurso</div>
								
						
						</div>
							
							<div style="display:none;" id="recurso_lista_archivos" class="directory-reader mt-30"></div>
						<br>
						<br>
						<button type="button" style="width:100%;" class="btn btn-primary" onclick="abrir_preview();">Ver Preview</button>
						<br>
						<br>
						<button type="button" style="width:100%;" class="btn btn-primary" onclick="regenerar_preview();">Regenerar Preview</button>
							
					</div>
					
			    
					
				</div>
							 
				
			</div> <!-- END PANEL 1 -->
			
		
			
			
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
<script type="text/javascript">

$('#recurso_path_url').on('change', function(){
	check_rec_and_prev()
})
$('#recurso_preview_path').keyup(function(){
	check_rec_and_prev()
})


function check_rec_and_prev() {
	const urlRec = $('#recurso_path_url').val()
	const urlPrev = $('#recurso_preview_path').val()
	const divPrev = $('#rec-vp')
	const btmSubmit = $('#btnSubmitRec')

	let tipoRec = urlRec.split('.')
	tipoRec = tipoRec[tipoRec.length - 1]
	tipoRec = tipoRec.toLowerCase()
	
	 if(tipoRec == 'jpg' || tipoRec == 'jpeg' || tipoRec == 'png' || tipoRec == 'pdf'){
		$('#campo_requerido_txt').remove()
		btmSubmit.removeClass('disabled')
	 }else{
		if(urlPrev == ''){
			divPrev.html('<i class="text-danger ml-1" id="campo_requerido_txt"> *Campo requerido* </i>')
			btmSubmit.addClass('disabled')
		}else{
			$('#campo_requerido_txt').remove()
			btmSubmit.removeClass('disabled')
		}
		
	 }
	
}
</script>