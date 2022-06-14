<?php include("./fn.php"); ?>
<?php include("./login.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	
	<?php include("./scripts.analytics.php"); ?>

	<title>Mediateca</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<?php include("./scripts.default.php"); ?>
	<?php include("./scripts.onresize.php"); ?>		
	
	<?php include("./scripts.document_ready.php"); ?>
	
</head>
<body>
	<div id="page">
<!-- FILTROS -->
<div id="background-herramientas" class="d-none closeBTN"> </div>
<div id="filtrar_container" class="d-none">
	<div id="filtrar_header"> 
		<span> FILTROS </span>
		<i class="fas fa-times closeOrdenar closeBTN" id="close"></i>
	</div>

	<div id="filtrar_body"> 
		<div class="filtros-container">
                <div id="uxFilters-box" class="pinned"></div>
        </div>
	</div>

	<div id="filtrar_footer"></div>

</div>
<!-- FIN DE FILTROS -->
	
		<?php include("./html.navbar-main.php"); ?>
		<a name="top"></a>
		<div class="page-container">

			<?php include("./section.mediateca.php"); ?>
			
			<?php include("./html.navs.php"); ?>
			
			<?php include("./footer.php"); ?>
		</div>
		
	</div>	
	
	<?php /* include("./widget-links.php"); */ ?>

</body>
</html>