<?php
//upload.php

// CHECKEAR SIEMPRE LOS PERMISOS DE LA CARPETA DONDE SE SUBEN LOS ARCHIVOS!!!!

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$id = $_POST["id"];

$dir = $_POST["dir"];

$dir = explode("/",$dir);

array_shift($dir);

$dir = implode("/",$dir);

$dir_lib_prefix = "../../";

$dir_output_prefix = "./";

$readable_dir = $dir; // SOLO PARA IEASA BACKEND, LEE REPO ABSOLUTO DE LINUX

$filetype_icons["jpg"] = "filetype-image-1.png";
$filetype_icons["png"] = "filetype-image-1.png";
$filetype_icons["gif"] = "filetype-image-1.png";
$filetype_icons["pdf"] = "filetype-pdf-1.png";

if (is_dir($readable_dir)) {
	
	if ($gestor = opendir($readable_dir)) {
		
	 
		/* Esta es la forma correcta de iterar sobre el directorio. */
		while (false !== ($entrada = readdir($gestor))) {
			if ($entrada != "." && $entrada != "..") {
				
				$filetype = explode(".",$entrada);
				$filetype = strtolower($filetype[sizeof($filetype)-1]);
				
				if (is_null($filetype_icons[$filetype])) {
					
					$ico = "filetype-default-1.png";
					
				}else{
					
					$ico = $filetype_icons[$filetype];
					
				}
				
				?>
				
				<div class="directory-item">
					
					<div class="icon-link-3">
						<img src="./images/<?php echo $ico; ?>">
						<a href="#" class="link" data-dir="<?php echo $dir_output_prefix . $dir . $id . "/"; ?>" data-filetype="<?php echo $filetype; ?>" data-filename="<?php echo $entrada; ?>" data-filepath="<?php echo $dir_output_prefix . $dir . $id . $entrada; ?>"><span class="text-hardblue-2 ml-5"><?php echo $entrada; ?></span></a>
					</div>
				
				</div>
				
				<?php
				
			}
		}
	 
		closedir($gestor);
	}
	
}else{
	
	echo "<p class=\"m0 p0\">Este directorio aún no posee archivos</p>";
	
}
 


?>