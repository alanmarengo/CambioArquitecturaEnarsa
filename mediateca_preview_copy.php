<?php
header("Content-Type: image/jpg");

include("./pgconfig.php");

$recurso_id = $_REQUEST['r'];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$SQL = "SELECT recurso_path_url,upper(right(recurso_path_url,3))AS extension,recurso_preview_path FROM mod_mediateca.recurso R WHERE recurso_id=$recurso_id limit 1;";

$recordset = pg_query($conn,$SQL);

$row = pg_fetch_row($recordset);

$recursor_path = $row[0];
$recursos_extension = $row[1];
$recurso_preview = $row[2];

$error_preview_img = './images/3.jpg';

if ($recurso_preview==NULL)
{
	$recurso_preview=$error_preview_img;
};

pg_close($conn);

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

if($dominio=='observatorio.ieasa.com.ar')
{
	$file_server = '/mnt/';
}
else
{
	$file_server = '';
};


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
					echo $imagick->getImagesBlob();
				}
				else
				{
					$imagick->readImage($error_preview_img);
					$imagick->setImageFormat("jpg");
					echo $imagick->getImagesBlob();
				};
				
				break;
    case 'JPG':
				$imagick = new Imagick();
	
				if(file_exists($file_server.$recursor_path))
				{
					$imagick->readImage($file_server.$recursor_path);
					$imagick->scaleImage(300, 300, true);
					$imagick->setImageCompressionQuality(90);
					$imagick->setImageFormat("jpg");
					echo $imagick->getImagesBlob();
				}
				else
				{
					$imagick->readImage($error_preview_img);
					$imagick->setImageFormat("jpg");
					echo $imagick->getImagesBlob();
				};
				
				break;
    case 'PGN':
				$imagick = new Imagick();
	
				if(file_exists($file_server.$recursor_path))
				{
					$imagick->readImage($file_server.$recursor_path);
					$imagick->scaleImage(300, 300, true);
					$imagick->setImageCompressionQuality(90);
					$imagick->setImageFormat("jpg");
					echo $imagick->getImagesBlob();
				}
				else
				{
					$imagick->readImage($error_preview_img);
					$imagick->setImageFormat("jpg");
					echo $imagick->getImagesBlob();
				};
				
				break;
	 default:
				$imagick = new Imagick();
				$imagick->readImage($recurso_preview);
				$imagick->setImageFormat("jpg");
				echo $imagick->getImagesBlob();

};

$imagick->clear();
$imagick->destroy();


/*
if($recursos_extension=='PDF')
{
	$imagick = new Imagick();
	
	if(file_exists($file_server.$recursor_path))
	{
		$imagick->readImage($file_server.$recursor_path.'[0]');
		$imagick->setImageFormat("jpg");
		$imagick = $imagick->flattenImages();
		echo $imagick->getImagesBlob();
	}
	else
	{
		$imagick->readImage($error_preview_img);
		$imagick->setImageFormat("jpg");
		echo $imagick->getImagesBlob();
	};
}
else
{
	$imagick = new Imagick();
	$imagick->readImage($recurso_preview);
	$imagick->setImageFormat("jpg");

	echo $imagick->getImagesBlob();
};

*/
?> 
