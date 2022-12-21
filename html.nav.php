<div id="nav-main" data-visible="0" class="navmenu nav-main jump-flotant-nav jump-flotant-heightfill jump-flotant-heightfill-top jump-scroll nav-level-1 col col-nav col-xs-12 col-sm-12 col-md-3 col-lg-3">
	<ul>
		<li class="start-option">
			<a href="<?php echo startLink($_SERVER["SCRIPT_FILENAME"]); ?>" class="jump-link-death"><span>Inicio</span></a>
		</li>
		<li>
			<a href="./page_acercade.php">Acerca del Observatorio de AHRSC</a>
		</li>
		<li>
			<a href="javascript:void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="flotant.toggle('#nav-herramientas-ieasa',true,false,this);">
				Herramientas del Observatorio <i class="fa fa-angle-right nav-item-count"></i>
			</a>
		</li>
		<li id="proyecto_ahrsc">
			<!-- <a href="./page_proyecto.php">Proyecto - AHRSC</a> -->
			<!-- <a class="inactive" title="Pagina en mantenimiento">Proyecto - AHRSC</a> -->
		</li>
		<li>
			<a href="./page_pdga.php">Plan Director de Gestión Ambiental - PDGA</a>
		</li>
		<li>
			<a href="./page_antecedentes.php">Antecedentes y Marco Legal</a>
		</li>
		<li>
			<!--<a href="./page_endesarrollo.php?q=Participación Pública y Gestión Social">Participación Pública y Gestión Social</a>-->
			<a href="./page_participacion.php">Participación Pública y Gestión Social</a>
		</li>
		<li>
			<!--<a href="./page_endesarrollo.php?q=Patrimonio Natural y Cultural">Patrimonio Natural y Cultural</a>-->
			<a href="./page_huella.php">Huellas del pasado</a>
			
		</li>
		<li>
			<!--<a href="./page_monitoreo.php">Monitoreo hidrosedimentológico e hidroambiental</a>--> 
			<a class="inactive" title="Pagina en mantenimiento"> Monitoreo hidrosedimentológico e hidroambiental </a>
			<!--<a href="./page_endesarrollo.php?q=Monitoreo hidrosedimentológico e hidroambiental del río Santa Cruz">Monitoreo hidrosedimentológico e hidroambiental</a>-->
			<!--<a href="./page_endesarrollo.php?q=Gestión Ambiental de Obra">Gestión Ambiental de Obra</a> -->			
		</li>
		
		<!--
		<li>
			<a href="javascript:void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="flotant.toggle('#nav-int-cuenca',true,false,this);">
				Manejo Integrado de Cuenca <i class="fa fa-angle-right nav-item-count"></i>
			</a>
		</li>
		-->
		<!--
		<li>
			<a href="./page_endesarrollo.php?q=Plan Gestión de Calidad">Plan Gestión de Calidad</a>
		</li>
		-->
		<li>
			<a href="./page_herramientas.php">Herramientas geográficas</a>
		</li>
		<li>
			<a href="./page_herramientas.php?target=geoservicios">Servicios Geográficos</a>
		</li>
		<li>
			<!-- <a href="http://observatorio.ieasa.com.ar:8080/geonetwork" target="_blank" >Datos Abiertos</a> -->
			<a href="http://observatorio.energia-argentina.com.ar:8080/geonetwork" target="_blank" >Datos Abiertos</a>
		</li>
		<li>
			<a href="./contacto.php">Contacto</a>
		</li>
	</ul>
</div>
<script>
	
	let ahrscContainer = document.getElementById('proyecto_ahrsc');
	let html = ``;
	if(window.location.origin.includes('http://localhost') || window.location.origin.includes('observatorio-dev') ){
		html = `
			<a href="./page_proyecto.php"> Obra AHRSC </a>
		`
	}else{
/* 		html = `
			<a class="inactive" title="Pagina en mantenimiento"> Obra AHRSC </a>
		` */
		html = `
			<a href="./page_proyecto.php"> Obra AHRSC </a>
		`
	}
	ahrscContainer.innerHTML = html

</script>
