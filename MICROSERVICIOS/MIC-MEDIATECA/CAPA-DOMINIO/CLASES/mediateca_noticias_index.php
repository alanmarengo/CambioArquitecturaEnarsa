<?php

header('Content-Type: application/json');

include("./pgconfig.php");


function limpiar($str)
{
	return str_replace(array("\n","\r","\""),'',$str);
};



$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;

$conn = pg_connect($string_conn);

$SQL = "SELECT ('./cache/'||recurso_id::TEXT||'.jpg')::text AS path_img, recurso_titulo as titulo,recurso_fecha as fecha,recurso_path_url as path_pdf,recurso_desc as desc,recurso_id,(recurso_fecha-30) AS fecha_menos_30,recurso_preview_path as path_img2  
        from  mod_mediateca.recurso r where formato_id in(102) order by recurso_fecha desc limit 7";

$recordset = pg_query($conn,$SQL);

function draw_tupla($row)
{
      $path_img= $row[7];
      if($path_img==null){
        $path_img=$row[0];
      }


       echo '{';
       echo '"path_img":"'.$path_img.'",';
       echo '"titulo":"'.limpiar($row[1]).'",';
       echo '"fecha":"'.$row[2].'",';
       echo '"path_pdf":"'.$row[3].'",';
       echo '"desc":"'.limpiar($row[4]).'",';
       echo '"fecha_inicial":"'.$row[6].'"';
       echo '}';
       
       return true;
};

$fflag = false;

echo "[";

$row = pg_fetch_row($recordset);

while($row) 
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
  
  $row = pg_fetch_row($recordset);//NEXT
};

echo "]";
pg_close($conn);

?>

