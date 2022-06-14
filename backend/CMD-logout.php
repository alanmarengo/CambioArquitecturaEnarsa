<?php
	
session_start();
$_SESSION = array();
session_destroy();
	
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Inicio</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php include("./scripts.default.php"); ?>
	<?php include("./scripts.onresize.php"); ?>		
	<?php include("./scripts.document_ready.php"); ?>
</head>
<body>
	<div id="index">
	
		<div class="page-container">
				
			<?php include("./header.php"); ?>
			
			<div class="row">
			
				<div class="col col-md-4 col-lg-4 col-xs-12 col-sm-12"></div>
				
				<div class="col col-md-4 col-lg-4 col-xs-12 col-sm-12 pv-30">
						
					<h2 class="m-v-50" style="font-size:24px;">
						<p>Su sesión ha sido cerrada con éxito!</p>
					</h2>
							
					<h3 class="text-success" style="font-size:16px;"> Redireccionando por favor espere... </h3>
						
					<script type="text/javascript">
						
						setTimeout(function() {
											
							location.href = "./backend-index.php"
											
						},5000);
									
					</script>
			
				</div>
			
			</div>
			
			<?php include("./footer.php"); ?>
			
		</div>
		
	</div>
	
</body>
</html>