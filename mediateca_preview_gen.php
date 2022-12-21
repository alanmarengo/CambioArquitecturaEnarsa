<?php
//header("Content-Type: image/jpg");

include("./pgconfig.php");

$error_preview_img 	= './images/3.jpg';
$preview_path 		= './cache/';

/*******************************************************
 * En caso del servidor de producción de EIASA
 * los datos se impolementaron en un file server.
 * EL mismo se monton en el directorio /mnt/sga,
 * por lo tanto en el sitio observatorio.ieasa.com.ar
 * el path se altera anteponiedo /mn/ al path del
 * archivo.
 ******************************************************/

$dominio = $_SERVER['HTTP_HOST'];

$file_server = '';

if($dominio=='observatorio.energia-argentina.com.ar')
{
	$file_server = '/mnt/';
}
else
{
	$file_server = '';
};

function GenPreview($recursos_extension,$file_server,$recursor_path,$cache_path,$recurso_id)
{
	global $error_preview_img;
	
	switch ($recursos_extension) 
	{
		case 'PDF':
					$imagick = new Imagick();
		
					if(file_exists($file_server.$recursor_path))
					{
						$imagick->readImage($file_server.$recursor_path.'[0]');
						$imagick->scaleImage(300, 300, true);
						$imagick->setImageCompressionQuality(90);
						$imagick->setImageFormat("jpg");
						$imagick = $imagick->flattenImages();
						
						file_put_contents($cache_path.$recurso_id.'.jpg',  $imagick->getImagesBlob());
						echo 'Generando '.$cache_path.$recurso_id.'.jpg<br>';
						
					}
					else
					{
						$imagick->readImage($error_preview_img);
						$imagick->setImageFormat("jpg");
						
						file_put_contents($cache_path.$recurso_id.'.jpg',  $imagick->getImagesBlob());
						echo 'Generando '.$cache_path.$recurso_id.'.jpg<br>';
					};
					
					$imagick->clear();
					$imagick->destroy();
					
					break;
		case 'JPG':
					$imagick = new Imagick();
		
					if(file_exists($file_server.$recursor_path))
					{
						$imagick->readImage($file_server.$recursor_path);
						$imagick->scaleImage(300, 300, true);
						$imagick->setImageCompressionQuality(90);
						$imagick->setImageFormat("jpg");
						
						file_put_contents($cache_path.$recurso_id.'.jpg',  $imagick->getImagesBlob());
						echo 'Generando '.$cache_path.$recurso_id.'.jpg<br>';
					}
					else
					{
						$imagick->readImage($error_preview_img);
						$imagick->setImageFormat("jpg");
						
						file_put_contents($cache_path.$recurso_id.'.jpg',  $imagick->getImagesBlob());
						echo 'Generando '.$cache_path.$recurso_id.'.jpg<br>';
					};
					
					$imagick->clear();
					$imagick->destroy();
					
					break;
		case 'PNG':
					$imagick = new Imagick();
		
					if(file_exists($file_server.$recursor_path))
					{
						$imagick->readImage($file_server.$recursor_path);
						$imagick->scaleImage(300, 300, true);
						$imagick->setImageCompressionQuality(90);
						$imagick->setImageFormat("jpg");
						
						file_put_contents($cache_path.$recurso_id.'.jpg',  $imagick->getImagesBlob());
						echo 'Generando '.$cache_path.$recurso_id.'.jpg<br>';
					}
					else
					{
						$imagick->readImage($error_preview_img);
						$imagick->setImageFormat("jpg");
						
						file_put_contents($cache_path.$recurso_id.'.jpg',  $imagick->getImagesBlob());
						echo 'Generando '.$cache_path.$recurso_id.'.jpg<br>';
					};
					
					$imagick->clear();
					$imagick->destroy();
					
					break;
		 default:
					//DEBERIAN TENER PREVIEW, recurso_preview queda en desuso
					//Las preview especificas tambien se tiene que subir a cache
					
					$imagick = new Imagick();
					$imagick->readImage($error_preview_img);
					$imagick->setImageFormat("jpg");
						
					file_put_contents($cache_path.$recurso_id.'.jpg',  $imagick->getImagesBlob());
					echo 'Generando Defult '.$cache_path.$recurso_id.'.jpg<br>';
					
					$imagick->clear();
					$imagick->destroy();
					
					

	};
	
	


};


$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$SQL = "SELECT recurso_path_url,upper(right(recurso_path_url,3))AS extension,recurso_preview_path,recurso_id FROM mod_mediateca.recurso R;";

$recordset = pg_query($conn,$SQL);

$row = pg_fetch_row($recordset);

while($row)
{
	
	$_recursor_path 		= $row[0];
	$_recursos_extension 	= $row[1];
	$_recurso_preview 		= $row[2];
	$_recurso_id			= $row[3];
	
	GenPreview($_recursos_extension,$file_server,$_recursor_path,$preview_path,$_recurso_id);

	$row = pg_fetch_row($recordset);

};

pg_close($conn);



?> 
