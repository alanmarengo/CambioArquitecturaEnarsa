<?php
//upload.php

// CHECKEAR SIEMPRE LOS PERMISOS DE LA CARPETA DONDE SE SUBEN LOS ARCHIVOS!!!!

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$id = $_POST["id"];

$file = $_POST["file"];

$file = explode(",",$file);
$file = $file[1];

if (!is_dir("../../cache/".$id)) {

	mkdir("../../cache/".$id, 0777, true);
	chmod("../../cache/".$id, 0777);
	chmod("../../cache/".$id, 0777);

}

$file_folder = "../../cache/" .$id . "/";

$file_mode = $_POST["PHP_write_mode"];

$file_name = $_POST["file_name"];

$file = base64_decode($file);

$apply_sql = $_POST["apply_sql"];

/*
$date = date('Ymdhms');

$rand = rand();

$file_set_name = $date . $rand . "_" . $file_name;*/

$part = $_POST["part"];

$ellipsis = "";

$i = 1;

if ($part == 1) {
	
	while(file_exists($file_folder . $file_name)) {
		
		if ($i == 1) {
		
			$file_name = "Copia($i) - " . $file_name ;
		
		}else{
			
			$file_name = "Copia($i) - " . substr($file_name,strlen("Copia(" . ($i-1) . ") - "),strlen($file_name));
			
		}
		
		$i++;
		
	}

}

$file_contents = fopen($file_folder . $file_name,'a');

if (strlen($file_name > 15)) $ellipsis = "...";

if (fputs($file_contents,$file,strlen($file))) {
			
	if ($apply_sql) {
			
		echo "{\"status\":1,
			\"icon\":\"accept-hardblue-1.png\",
			\"message\":\"El archivo " . substr($file_name,0,15) . $ellipsis . " fue cargado correctamente\",
			\"file_folder\":\"" . $file_folder . "\",
			\"file_name\":\"" . $file_name . "\"
		}";
		
	}else{
		
		echo "{\"status\":2,
				\"icon\":\"loading_file.gif\",
				\"file_folder\":\"" . $file_folder . "\",
				\"file_name\":\"" . $file_name . "\"
		
		}";
		
	}
	
}else{
	
	echo "{\"status\":0,
			\"icon\":\"deny-red-1.png\",
			\"file_folder\":\"" . $file_folder . "\",
			\"file_name\":\"" . $file_name . "\",
			\"message\":\"Se produjo un error al subir el archivo " . substr($file_name,0,15) . $ellipsis . " al servidor\"}";
	
}

?>