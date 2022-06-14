<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$db_name = "ahrsc";

switch ($_SERVER['SERVER_NAME'])
{
	case "sinia.net": 	
			define("pg_server","127.0.0.1");
			define("pg_user","postgres");
			define("pg_password","voidpointer");
			define("pg_portv",5432);
			define("pg_db",$db_name);
			break;
	case "sinia.atic.com.ar":
			define("pg_server","127.0.0.1");
			define("pg_user","postgres");
			define("pg_password","plahe100%");
			define("pg_portv",5432);
			define("pg_db",$db_name);
			break;
	default: 
			if((strpos($_SERVER["SCRIPT_FILENAME"],"wamp64")) || (strpos($_SERVER["SCRIPT_FILENAME"],"wamp")))//configuracion servidor juampi
			{
				define("pg_server","127.0.0.1");
				define("pg_user","postgres");
				define("pg_password","postgres");
				define("pg_portv","5433");
				define("pg_db",$db_name);
			}
			else
			{
				define("pg_server","127.0.0.1");
				define("pg_user","postgres");
				define("pg_password","plahe100%");
				define("pg_portv",5432);
				define("pg_db",$db_name);
	
			};
			break;
};



/**********************************************
 pg_csv_visible_path es el path desde el cual 
 postgresql puede ver y tiene permisos para leer
 los csv subidos, los csv se suben al directorio
 ./tmp/ dentro del código de la plataforma(*)
 (por tanto relativo al código).

 Se debe especificar el path completo a estos csv
 subidos para que postgresql pueda leerlos e 
 importalos correctamente.

 Esta implementación se debe a que el directorio
 de instalación puede variar según los criterios
 del cliente como así también la localización
 del servidor postgresql, en cuyo caso entendemos
 se tendra que montar en el servidor de base datos
 el directorio ./tmp/ del codigo a fin de lograr
 la visibilidad de los csv temporales subidos.

 Por ejemplo, en caso del servidor de desarrollo
 de ATIC el path es /SISTEMAS/sinia/tmp/

 (*)section.backend.csv-procesar.php


**********************************************/

define("pg_csv_visible_path","/SISTEMAS/sinia/tmp/"); 







?>
