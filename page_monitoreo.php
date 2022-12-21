<?php include("./fn.php"); ?>
<!DOCTYPE html>
<html lang="es">

<!-- Script del modal  -->
<script type="text/javascript">
	function cerrarPopup(){
			$('.modalMonitoreo').remove()
	}
</script>

<head></head>

	<link href="./css/popupMonitoreo.css" rel="stylesheet" type="text/css">
	<?php include("./scripts.analytics.php"); ?>

	<title>MONITOREO R&Iacute;O SANTA CRUZ</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<?php include("./scripts.default.php"); ?>
	<?php include("./scripts.onresize.php"); ?>		
	
	<?php include("./scripts.document_ready.php"); ?>
	
</head>
<body>

	<div class="p">
		<div class="modalMonitoreo">
		<div id="basePopup"> 
			<div id="contenedorPopup"> 
<!-- 				<div id="tituloPopup"> <h5> Aclaración </h5></div>
				<div id="contenidoPopup"> 
					Se recuerda a los potenciales usuarios de esta información que en todo momento se debe tener cuidado con las conclusiones que puedan derivarse del análisis de las series de datos hidroambientales pues son el resultado de una reconstrucción y por ende no son mediciones reales en el sentido estrictamente académico. <b>Los datos de los últimos dos meses de estas estaciones son datos en tiempo real y pueden mostrar resultados afectados por problemas técnicos.</b>
				</div>
				<div id="footerPopup">
					<button type="button" class="btn btn-primary" id="botonPopup" onclick="cerrarPopup()">
						Aceptar
					</button>
				</div> -->
				<div id="tituloPopup"> <h5> Atención </h5></div>
				<div id="contenidoPopup"> 
				La página de la Red de Monitoreo Hídrico se encuentra actualmente en mantenimiento. <br> <b>Disculpen las molestias</b>
				</div>
				<div id="footerPopup">
					<!-- <a href="https://observatorio.ieasa.com.ar/" class="btn btn-primary" id="btnMantenimiento"> -->
					<a href="https://observatorio.energia-argentina.com.ar/" class="btn btn-primary" id="btnMantenimiento">
						Volver a la home
					</a>
				</div>
			</div>
		</div>
		 </div>
		<?php include("./html.navbar-main.php"); ?>
		<div class="page-container">



		
			<?php /* include("./section.page_monitoreo.php"); */ ?>
			<div class="pageEnMantenimiento" style="width:100%; height:70vh; text-align:center; background-color:white; display:flex; justify-content:center; align-items:center;"> 
				Esta pagina se encuentra en mantenimiento. <b class="b_mantenimiento">	
				<!-- <a href="https://observatorio.ieasa.com.ar/" > -->	<a href="https://observatorio.energia-argentina.com.ar/" > Volver	</a></b>
			</div>
			
			<?php include("./html.navs.php"); ?>
			
			<?php include("./footer.php"); ?>

			
		</div>
		
	</div>
	
	<?php include("./widget-links.php"); ?>	

</body>



</html>

<script>

	try{
		let locationActual = window.location.href
		locationActual = locationActual.split('page_monitoreo')

		$('#btnMantenimiento').attr('href', locationActual[0])
	}catch(error){
		$('#btnMantenimiento').attr('href', 'https://observatorio.energia-argentina.com.ar/')
	}


</script>
