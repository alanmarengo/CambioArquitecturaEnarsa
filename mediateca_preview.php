<?php
//header("Content-Type: image/jpg");

include("./pgconfig.php");

$error_preview_img 	= './images/3.jpg';

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

$recurso_id = $_REQUEST['r'];
$origen_id  = $_REQUEST['origen_id'];


$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$SQL = "SELECT R.origen_id_especifico,R.origen,R.origen_id,R.recurso_path_url,upper(right(R.recurso_path_url,3))AS extension,re.recurso_preview_path FROM mod_catalogo.vw_catalogo_data R INNER JOIN mod_mediateca.recurso re ON R.origen_id_especifico=re.recurso_id WHERE R.origen_id_especifico=$recurso_id  AND R.origen_id=$origen_id limit 1;";

$recordset = pg_query($conn,$SQL);

$row = pg_fetch_row($recordset);

$recurso_id 	= $row[0];
$origen		 	= $row[1];
$origen_id	 	= $row[2];
$_recursor_path 		= $row[3];
$_recursos_extension 	= $row[4];
$recurso_preview_path= $row[5];

if(!$row){
	if($_REQUEST['origen_id']==3){
	$recurso_id = $_REQUEST['r'];
	$origen_id  = $_REQUEST['origen_id'];
	}
}



pg_close($conn);

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
						
						file_put_contents($cache_path.$recurso_id.'.jpg',  $imagick->getImagesBlob(),LOCK_EX);
						//echo 'Generando '.$cache_path.$recurso_id.'.jpg<br>';
						
					}
					else
					{
						$imagick->readImage($error_preview_img);
						$imagick->setImageFormat("jpg");
						
						file_put_contents($cache_path.$recurso_id.'.jpg',  $imagick->getImagesBlob(),LOCK_EX);
						//echo 'Generando '.$cache_path.$recurso_id.'.jpg<br>';
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
						
						file_put_contents($cache_path.$recurso_id.'.jpg',  $imagick->getImagesBlob(),LOCK_EX);
						//echo 'Generando '.$cache_path.$recurso_id.'.jpg<br>';
					}
					else
					{
						$imagick->readImage($error_preview_img);
						$imagick->setImageFormat("jpg");
						
						file_put_contents($cache_path.$recurso_id.'.jpg',  $imagick->getImagesBlob(),LOCK_EX);
						//echo 'Generando '.$cache_path.$recurso_id.'.jpg<br>';
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
						
						file_put_contents($cache_path.$recurso_id.'.jpg',  $imagick->getImagesBlob(),LOCK_EX);
						//echo 'Generando '.$cache_path.$recurso_id.'.jpg<br>';
					}
					else
					{
						$imagick->readImage($error_preview_img);
						$imagick->setImageFormat("jpg");
						
						file_put_contents($cache_path.$recurso_id.'.jpg',  $imagick->getImagesBlob(),LOCK_EX);
						//echo 'Generando '.$cache_path.$recurso_id.'.jpg<br>';
					};
					
					$imagick->clear();
					$imagick->destroy();
					
					break;
		/* default:
					//DEBERIAN TENER PREVIEW, recurso_preview queda en desuso
					//Las preview especificas tambien se tiene que subir a cache
					
					$imagick = new Imagick();
					$imagick->readImage($error_preview_img);
					$imagick->setImageFormat("jpg");
						
					file_put_contents($cache_path.$recurso_id.'.jpg',  $imagick->getImagesBlob(),LOCK_EX);
					//echo 'Generando Defult '.$cache_path.$recurso_id.'.jpg<br>';
					
					$imagick->clear();
					$imagick->destroy(); */
					
					

	};
	
	


};


function wms_preview($capa_id)
{

 $wms_request = "";

 global $string_conn;
 global $error_preview_img;
 
 $conn = pg_connect($string_conn);

 $SQL = "SELECT layer_wms_server,layer_wms_layer,layer_schema,layer_table FROM mod_geovisores.layer L WHERE L.layer_id = $capa_id limit 1";

 $recordset = pg_query($conn,$SQL);

 $row = pg_fetch_row($recordset);

 $wms_server 		= $row[0];
 $wms_layer		 	= $row[1];
 $schema	 		= $row[2];
 $tabla				= $row[3];
 
 $SQL = "";
 $SQL = $SQL."SELECT ";
 $SQL = $SQL."st_xmin(st_expand(st_extent(st_transform(T.geom, 4326)), 1::double precision)::box3d) AS minx,";
 $SQL = $SQL."st_ymin(st_expand(st_extent(st_transform(T.geom, 4326)), 1::double precision)::box3d) AS miny,";
 $SQL = $SQL."st_xmax(st_expand(st_extent(st_transform(T.geom, 4326)), 1::double precision)::box3d) AS maxx,";
 $SQL = $SQL."st_ymax(st_expand(st_extent(st_transform(T.geom, 4326)), 1::double precision)::box3d) AS maxy";
 $SQL = $SQL." FROM \"$schema\".\"$tabla\" T";
 
 $recordset = pg_query($conn,$SQL);

 $row = pg_fetch_row($recordset);
 
 $minx 		= $row[0];
 $miny		= $row[1];
 $maxx	 	= $row[2];
 $maxy		= $row[3];
 
 pg_close($conn);
 
 $wms_request = $wms_server."&SERVICE=WMS&VERSION=1.1.0&REQUEST=GetMap&LAYERS=$wms_layer&STYLES=&SRS=EPSG:4326&BBOX=$minx,$miny,$maxx,$maxy&WIDTH=300&HEIGHT=300&FORMAT=image/png&";
 //echo $wms_request;
 
 header("Content-Type: image/jpg");
 $data = file_get_contents($wms_request);
 
 if($data)
 {
	echo $data; 
 }
 else
 {
	$data = file_get_contents($error_preview_img);
	echo $data;
 };
 
 
};


$cache_path = './cache/';

/*
 * 5: Mediateca
 * 0: GIS
 */

switch($origen_id)
{
	case  5:
		   header("Content-Type: image/jpg");
		   $data = file_get_contents($cache_path.$recurso_id.'.jpg');
		    if($recurso_preview_path==null){
				header("Content-Type: image/jpg");
				$data = file_get_contents($cache_path.$recurso_id.'.jpg');
			}
			else{
				header("Content-Type: image/jpg");
				$data=file_get_contents($recurso_preview_path);
			}

			if($data){
				echo $data;
			}	
			
			 else
			{
				
				GenPreview($_recursos_extension,$file_server,$_recursor_path,$cache_path,$recurso_id);
				
				//$data = file_get_contents($error_preview_img);
				$data = file_get_contents($cache_path.$recurso_id.'.jpg');//CREA LA PREVIEW Y LA LLEVA A CACHE
				echo $data;
				
			}; 
			
		break;
	case 0: 
		$recurso_id=$_REQUEST['r'];
		wms_preview($recurso_id); break;
	case 1: break;
	case 2: header("Content-Type: image/png");
			$data = file_get_contents('./images/icono-estadisticas-relleno.png');
			echo $data; 
			break;
	case 3: 
			header("Content-Type: image/png");
			$data = file_get_contents('./images/icono-indicadores-relleno.png');
			echo $data; 
			break;
	case 4: break;
	
	default:
};

//http://observatorio.net/mediateca_preview.php?r=443&origen_id=0
//http://observatorio.net/mediateca_preview.php?r=4&origen_id=5


?> 
