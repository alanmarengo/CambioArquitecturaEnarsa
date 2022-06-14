<?php include("./fn.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>

	<title>Inicio</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
		
	<?php include("./scripts.default.php"); ?>
	<?php include("./scripts.onresize.php"); ?>		
	
	<?php include("./scripts.document_ready.php"); ?>
	
</head>
<body style="overflow:hidden;">

	<div id="page">
	
		<?php include("./html.navbar-main.php"); ?>
		
		<div class="page-container" style="background-color: #EAEAED; height:100%; padding:100px;">
		
			<?php
						
			session_start();
			$_SESSION = array();
			session_destroy();
				
			?>
				
		<h2 class="m-v-50" style="font-size:12px;">
			<p>Su sesión ha sido cerrada con éxito!</p>
		</h2>
				
		<h3 class="text-success" style="font-size:14px;"> Redireccionando por favor espere... </h3>
			
		<script type="text/javascript">
			
			setTimeout(function() {
								
				location.href = "<?php echo $_SERVER["HTTP_REFERER"]; ?>"
								
			},5000);
						
		</script>
			
		</div>
		
	</div>
			
	<?php include("./html.navs.php"); ?>
			
	<?php include("./footer.php"); ?>
	
	<?php //include("./widget-links.php"); ?>

</body>
</html>