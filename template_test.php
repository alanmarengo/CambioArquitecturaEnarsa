<?php include("./fn.php"); ?>
<?php include("./login.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	
	<?php include("./scripts.analytics.php"); ?>

	<title>Inicio</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
		
	<?php include("./scripts.default.php"); ?>
	<?php include("./scripts.onresize.php"); ?>		
	
	<?php include("./scripts.document_ready.php"); ?>
	
	<style>
		.resource-col {
			min-height:50px;
			border:1px solid black;
		}
	</style>
	
</head>
<body>

	<div id="page">
	
		<?php include("./html.navbar-main.php"); ?>
		
		<div class="page-container" style="background-color: #EAEAED; min-height:500px; padding:50px 0px">
		
			<?php include("./" . $_GET["tpl"] . ".php"); ?>
			
		</div>
		
	</div>
	
	<?php //include("./widget-links.php"); ?>

</body>
</html>
