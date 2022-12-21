<?php include("./fn.php"); ?>

<!-- Script del modal  -->
<script type="text/javascript">
/* 	function cerrarPopup(){
			$('.modalMonitoreo').remove()
	} */
</script>


<!DOCTYPE html>
<html lang="es">
<head>
	<link href="./css/popupMonitoreo.css" rel="stylesheet" type="text/css">
	
	<?php include("./scripts.analytics.php"); ?>

	<title>PROYECTO</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<?php include("./scripts.default.php"); ?>
	<?php include("./scripts.onresize.php"); ?>		
	
	<?php include("./scripts.document_ready.php"); ?>
	
</head>
<body>


	<div id="page">
	
		<?php include("./html.navbar-main.php"); ?>

		<!--
		<div class="page-container" id="page-container-1">
				<div class="modalMonitoreo">
						<div id="basePopup"> 
							<div id="contenedorPopup"> 
								<div id="tituloPopup"> <h5> Atención </h5></div>
								<div id="contenidoPopup"> 
								La página de Proyecto se encuentra actualmente en mantenimiento. <br> <b>Disculpen las molestias</b>
								</div>
								<div id="footerPopup">
									<a href="https://observatorio.ieasa.com.ar/" class="btn btn-primary" id="btnMantenimiento">
										Volver a la home
									</a>
								</div>
							</div>
						</div>
				</div>

				<div class="pageEnMantenimiento" style="width:100%; height:70vh; text-align:center; background-color:white; display:flex; justify-content:center; align-items:center;"> 
						Esta pagina se encuentra en mantenimiento. <b class="b_mantenimiento">	<a href="https://observatorio.ieasa.com.ar/" >	Volver	</a></b>
				</div>
		
		</div>
		-->


		<div class="page-container" id="page-container-2" style="margin-bottom: 150px;">
		
				<?php include("./section.page_proyecto.php"); ?>			
			
		</div>

		<?php include("./html.navs.php"); ?>
				
		<?php include("./footer.php"); ?>
	</div>
	
	<?php include("./widget-links.php"); ?>	

</body>
</html>


<script>
	/*
	const pageContainer1 = document.getElementById('page-container-1')
	const pageContainer2= document.getElementById('page-container-2')
	if(window.location.origin.includes('http://localhost') || window.location.origin.includes('observatorio-dev') ){
		pageContainer1.style.display = 'none'	
	}else{
		 pageContainer2.style.display = 'none' 
		pageContainer1.style.display = 'none'	
	}
	*/

/* 
	try{
		let locationActual = window.location.href
		locationActual = locationActual.split('page_proyecto')

		$('#btnMantenimiento').attr('href', locationActual[0])
	}catch(error){
		$('#btnMantenimiento').attr('href', 'https://observatorio.ieasa.com.ar/')
	}
	
 */



</script>
