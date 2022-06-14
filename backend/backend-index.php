<?php 

error_reporting(E_ERROR | E_WARNING | E_PARSE);

include("./fn.php"); 
include("./login.php"); 
include("./pgconfig.php"); 

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Inicio</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php //include("./scripts.default.php"); ?>
	<?php include("./scripts.default.backend.php"); ?>
	<?php include("./scripts.onresize.php"); ?>
	<?php include("./scripts.document_ready.php"); ?>
	
	<script type="text/javascript" src="./js/backend-conf.js"></script>
	
</head>
<body>
	<div id="index">
		<div class="page-container">
			<?php include("./header.php"); ?>
			
			<div class="row">
			
				<div class="col col-xs-12 col-sm-12 col-lg-4 col-md-4"></div>
				<div class="col col-xs-12 col-sm-12 col-lg-4 col-md-4 pv-30">
					<p><a href="./backend-main.php" class="btn btn-primary"><img src="./images/icono-mediateca-relleno.png"  width="24px" height="24px"> Modulo Mediateca</a></p>
					<p><a href="./backend-layers.php" class="btn btn-primary"><img src="./images/icono-geovisores-relleno.png"  width="24px" height="24px"> Catalogo de Capas</a></p>
					<p><a href="./backend-geovisores.php" class="btn btn-primary"><img src="./images/icono-geovisores-relleno.png"  width="24px" height="24px"> Modulo Geovisores</a></p>
					<p><a href="./backend-indicadores.php" class="btn btn-primary"><img src="./images/icono-indicadores-relleno.png"  width="24px" height="24px"> Modulo Indicadores</a></p>
					<p><a href="./backend-graficos.php" class="btn btn-primary"><img src="./images/icono-indicadores-relleno.png"  width="24px" height="24px"> Modulo Gráficos</a> </p>
					<p><a href="./backend-estadistico.php" class="btn btn-primary"><img src="./images/icono-estadisticas-relleno.png"  width="24px" height="24px"> Modulo Estadistico</a></p>
					<p><a href="./backend-usuarios.php" class="btn btn-primary"><img src="./images/user.png"  width="24px" height="24px"> Gestion de Usuarios</a></p>
					<p><a href="./backend-permisos.php" class="btn btn-primary"><img src="./images/file.png"  width="24px" height="24px"> Gestion de Permisos</a></p>
				</div>
			
			</div>
			
			<?php include("./footer.php"); ?>
		</div>
	</div>

</body>
</html>
