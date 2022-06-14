<?php include("pgconfig.php"); ?>
<?php include("geovisor.fn.php"); ?>
<?php include("stats.fn.php"); ?>
<?php include("./fn.php"); ?>
<?php include("./login.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	
	<?php include("./scripts.analytics.php"); ?>

	<title>Estadísticas</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
		
	<?php include("./scripts.default-stats.php"); ?>	
	<?php include("./scripts.stats.php"); ?>	
	<?php include("./scripts.onresize.php"); ?>	
	<?php include("./scripts.document_ready.stats.php"); ?>
	
	<?php // include("./scripts.default.php"); ?>
	
	
	
</head>
<body style="overflow:hidden;">

	<div id="page">
	
		<?php include("./html.navbar-main.php"); ?>
		<?php include("./html.navbar-tools-stats.php"); ?>
		
		<div class="page-container">
		
			<?php //include("./section.index.php"); ?>
			
			<?php include("./html.navs.php"); ?>
			
			<?php include("./html.nav.popup.php"); ?>
			
			<div class="row jump-row">
			
				<?php include("./html.panel-stats.php"); ?>
				<?php include("./html.panel-dataset.php"); ?>
				<?php include("./html.panel-dataset-detail.php"); ?>
			
			</div>
			
		</div>
		
	</div>
	
	<?php include("./widget-links.php"); ?>
	<?php include("./html.jalert.php"); ?>
	<?php include("./popup.share.php"); ?>

</body>
</html>