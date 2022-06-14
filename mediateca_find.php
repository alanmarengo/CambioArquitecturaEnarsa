<?php

header('Content-Type: application/json');

/*
 * s=condor&o=0&ds=19%2F06%2F2019&de=18%2F06%2F2019&proyecto=1&documento=1%2C3&tema=5&subtema=37
 */
 
 /*
  * 0 A-Z
  * 1 Z-A
  * 2 Más visto
  * 3 Menos Visto
  * 4 Recientes
  * 5 Antiguos
  */

$qt         =  $_REQUEST['s'];
$desde      =  $_REQUEST['ds'];
$hasta      =  $_REQUEST['de'];
$proyecto   =  $_REQUEST['proyecto'];
$clase      =  $_REQUEST['tema'];
$subclase   =  $_REQUEST['subtema'];
$tipo_doc   =  $_REQUEST['documento'];
$orden      =  $_REQUEST['0'];
$estudio_id =  $_REQUEST['estudio_id'];
$ra =  $_REQUEST['ra'];

function IsSetVar($var)
{
	if((isset($var))&&(!empty($var)))
	{
		return TRUE;
	}else return FALSE;
};

$conn = pg_connect("host=localhost port=5432 dbname=ahrsc user=postgres password=plahe100%");

if (!IsSetVar($estudio_id))
{

$SQL = "SELECT row_to_json(T)::text AS r FROM"
        . "("
        . "SELECT "
        . "tipo_formato_solapa AS \"Solapa\","
        . "origen_id,"
        . "origen_id_especifico AS \"Id\","
        . "recurso_titulo AS \"Titulo\","
        . "recurso_desc AS \"Descripcion\","
        . "recurso_path_url AS \"LinkImagen\","
        . "recurso_categoria_desc AS \"MetaTag\","
        . "CASE WHEN recurso_autores IS NULL THEN responsable::TEXT ELSE recurso_autores::TEXT END AS \"Autores\","
        . "MAX(estudios_id) AS estudios_id,"
        . "recurso_fecha AS Fecha,"
        . "subclase_desc AS Tema"
        . " FROM mod_mediateca.mediateca_find('$qt','$desde','$hasta','$proyecto','$clase','$subclase','$tipo_doc') "
        . " GROUP BY recurso_fecha,subclase_desc,tipo_formato_solapa,origen_id,origen_id_especifico,recurso_titulo,recurso_desc,recurso_path_url,recurso_categoria_desc,CASE WHEN recurso_autores IS NULL THEN responsable::TEXT ELSE recurso_autores::TEXT END"
        . " ORDER BY tipo_formato_solapa,recurso_titulo ASC"
        . ")T";
}
else
{
   if ((!IsSetVar($ra))&&($ra==1))
   {
        $SQL = "SELECT row_to_json(T)::text AS r FROM"
        . "("
        . "SELECT "
        . "tipo_formato_solapa AS \"Solapa\","
        . "origen_id,"
        . "origen_id_especifico AS \"Id\","
        . "recurso_titulo AS \"Titulo\","
        . "recurso_desc AS \"Descripcion\","
        . "recurso_path_url AS \"LinkImagen\","
        . "recurso_categoria_desc AS \"MetaTag\","
        . "CASE WHEN recurso_autores IS NULL THEN responsable::TEXT ELSE recurso_autores::TEXT END AS \"Autores\","
        . "estudios_id,"
        . "recurso_fecha AS Fecha,"
        . "subclase_desc AS Tema "
        . " FROM mod_catalogo.vw_catalogo_data C WHERE "
        . " C.estudios_id IN(SELECT sub_estudio_id FROM mod_catalogo.estudio_subestudio WHERE estudios_id=$estudio_id) "
        . " AND C.estudios_id=$estudio_id" /* Tambíen incluye el mismo estudio */
        . " ORDER BY tipo_formato_solapa,recurso_titulo ASC "
        . ")T";
   }
   else
   {
   $SQL = "SELECT row_to_json(T)::text AS r FROM"
        . "("
        . "SELECT "
        . "tipo_formato_solapa AS \"Solapa\","
        . "origen_id,"
        . "origen_id_especifico AS \"Id\","
        . "recurso_titulo AS \"Titulo\","
        . "recurso_desc AS \"Descripcion\","
        . "recurso_path_url AS \"LinkImagen\","
        . "recurso_categoria_desc AS \"MetaTag\","
        . "CASE WHEN recurso_autores IS NULL THEN responsable::TEXT ELSE recurso_autores::TEXT END AS \"Autores\","
        . "estudios_id,"
        . "recurso_fecha AS Fecha,"
        . "subclase_desc AS Tema"
        . " FROM mod_catalogo.vw_catalogo_data C WHERE estudios_id=$estudio_id ORDER BY tipo_formato_solapa,recurso_titulo ASC"
        . ")T";
   };
};

$recordset = pg_query($conn,$SQL);

$fflag = false;
$sflag = null; /* Solapa */

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
  
  echo $row[0];
  
  $row = pg_fetch_row($recordset);//NEXT
};

echo "]";
pg_close($conn);



?>
