<?php include("./fn.php"); ?>
<?php include("./login.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	
	<?php include("./scripts.analytics.php"); ?>

	<title>Contacto</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<?php include("./scripts.default.php"); ?>
	<?php include("./scripts.onresize.php"); ?>		
	
	<script src="https://www.google.com/recaptcha/api.js"></script>

	<?php include("./scripts.document_ready.php"); ?>
	
	<link rel="stylesheet" type="text/css" href="./css/site2.css" />
	
</head>
<body>

	<div id="page">
	
		<?php include("./html.navbar-main.php"); ?>
		
		<div class="page-container" style="background-color: rgb(234, 234, 237);">
		
			<?php include("./section.contacto.php"); ?>			
			
			<?php include("./html.navs.php"); ?>
			
			<?php include("./footer.php"); ?>
			
		</div>
		
	</div>	
	
	<?php include("./widget-links.php"); ?>

</body>
</html>
