<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

// se importa la libreria 
require_once(dirname(__FILE__).'/MICROSERVICIOS/MIC-CATALOGO/CAPA-APLICACION/SERVICIO/REPOSITORIO-SERVICIO.php');

 // la funcion modo mantenimiento sigue comportandose igual con la diferencia que cambia la relacion a la que apunta 
function modo_mantenimiento() 
{		

	$servicio_catalogo = new RepositorioServicioCatalogo();
	
	$query_string = 'SELECT modo_mantenimiento,mensaje FROM "MIC-CATALOGO".modo_mantenimiento limit 1;';

	$r = $servicio_catalogo->get_consulta($query_string);	
	
	if($r[0]["modo_mantenimiento"]=='t')/* Entra en modo mantenimiento */
	{
		include("./scripts.default.php");
		include("./scripts.onresize.php");
		//include("./scripts.document_ready.php");
		//include("./html.navbar-main.php");
		echo '<div id="brand" class="inline-b ml-15">';
		echo '		<a href="./index.php">';
		echo '			<img src="./images/logo_observatorio_ieasa.png" height="60">';
		echo '			<!--<img src="./images/logo_observatorio_ieasa.png" height="40">-->';
		echo '		</a>';
		echo '	</div>';
		die('<span style="font-size:30px;color:white;width:100%;display:block;text-align:center;position:absolute;top:50%; ">'.$r[0]["mensaje"].'</span>');
		
	};
	
	$servicio_catalogo = null;
};

?>
