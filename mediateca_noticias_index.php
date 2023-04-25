<?php

header('Content-Type: application/json');

require_once(dirname(__FILE__).'/MICROSERVICIOS/MIC-MEDIATECA/CAPA-APLICACION/SERVICIO/REPOSITORIO-SERVICIO.php');

//include("./pgconfig.php");


function limpiar($str)
{
	return str_replace(array("\n","\r","\""),'',$str);
};



//$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;

//$conn = pg_connect($string_conn);

//$SQL = "SELECT ('./cache/'||recurso_id::TEXT||'.jpg')::text AS path_img, recurso_titulo as titulo,
//        recurso_fecha as fecha,recurso_path_url as path_pdf,recurso_desc as desc,recurso_id,(recurso_fecha-30) AS fecha_menos_30,recurso_preview_path as path_img2  
//        from  mod_mediateca.recurso r where formato_id in(102) order by recurso_fecha desc limit 7";



$servicio_mediateca_noticias = new RepositorioServicioMediateca();

$recordset = $servicio_mediateca_noticias->noticias_mediateca();

// echo $SQL;
//echo "[".print_r($recordset->detalle)."]";


//$recordset = pg_query($conn,$SQL);


function draw_tupla($row)
{
  $path_img= $row->path_img;

  echo '{';
  echo '"path_img":"'.$path_img.'",';
  echo '"titulo":"'.limpiar($row->titulo).'",';
  echo '"fecha":"'.$row->fecha.'",';
  echo '"path_pdf":"'.$row->path_pdf.'",';
  echo '"desc":"'.limpiar($row->desc).'",';
  echo '"fecha_inicial":"'.$row->fecha_inicial.'"';
  echo '}';
  
   return true;
};

$fflag = false;

echo "[";

//$row = pg_fetch_row($recordset);

foreach($recordset->detalle as $row) 
{
  if ($fflag)
  {
      echo ',';
  }
  else
  {
      $fflag = true;
  };
  
  draw_tupla($row);
  
  //$row = pg_fetch_row($recordset);//NEXT
};

echo "]";
//pg_close($conn);


?>

