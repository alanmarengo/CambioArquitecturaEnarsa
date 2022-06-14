<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$db_name = "ahrsc";

if((strpos($_SERVER["SCRIPT_FILENAME"],"wamp64")) || (strpos($_SERVER["SCRIPT_FILENAME"],"wamp")))
{
	define("pg_server","127.0.0.1");
	define("pg_user","postgres");
	define("pg_password","postgres");
	define("pg_portv","5432");
	define("pg_db",$db_name);
	
}else{
	
	define("pg_server","127.0.0.1");
	define("pg_user","postgres");
	define("pg_password","plahe100%");
	define("pg_portv",5432);
	define("pg_db",$db_name);
	
}

function limpiar_global($str)
{
         return str_replace(array("\n","\r","\""),'',$str);
};

function modo_mantenimiento() 
{		

	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT modo_mantenimiento,mensaje FROM mod_catalogo.modo_mantenimiento limit 1";
	
	$query = pg_query($conn,$query_string);
	
	$r = pg_fetch_assoc($query);
	
	if($r["modo_mantenimiento"]=='t')/* Entra en modo mantenimiento */
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
		die('<span style="font-size:30px;color:white;width:100%;display:block;text-align:center;position:absolute;top:50%; ">'.$r["mensaje"].'</span>');
		
	};
	
};

?>
