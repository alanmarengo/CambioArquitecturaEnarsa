<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

if(strpos($_SERVER["SCRIPT_FILENAME"],"wamp64"))//configuracion servidor juampi
{
	define("pgserver","127.0.0.1");
	define("pguser","postgres");
	define("pgpassword","plahe100%");
	define("pgport",5432);
	define("pgdbname","plahe");
	
}else{	
	if(strpos($_SERVER["SCRIPT_FILENAME"],"wamp"))//configuracion servidor juampi notebook
	{
		define("pgserver","127.0.0.1");
		define("pguser","postgres");
		define("pgpassword","plahe100%");
		define("pgport",5433);
		define("pgdbname","plahe");
		
	}
	else
	{
		if(strpos($_SERVER["SERVER_NAME"],"abm.net")!==false) //configuracion servidor Maxi
		{
			define("pgserver","127.0.0.1");
			define("pguser","max");
			define("pgpassword","95451515");
			define("pgport",5432);
			define("pgdbname","plahe");
		
		}
		else
		{
			if(strpos($_SERVER["SERVER_NAME"],"devel.plahe.atic.com.ar")!==false) //configuracion servidor Martin
			{
				define("pgserver","127.0.0.1");
				define("pguser","postgres");
				define("pgpassword","plahe100%");
				define("pgport",5432);
				define("pgdbname","plahe");
			}
			else //configuracion servidor plahe desarrollo
			{
				define("pgserver","127.0.0.1");
				define("pguser","postgres");
				define("pgpassword","plahe100%");
				define("pgport",5432);
				define("pgdbname","plahe");
			};
		};
	};
};

$glob_meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

?>
