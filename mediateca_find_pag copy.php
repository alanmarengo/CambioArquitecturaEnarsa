<?php

header('Content-Type: application/json');

include("./pgconfig.php");

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
$ra 	    =  $_REQUEST['ra'];
$solapa	    =  $_REQUEST['solapa'];
$mode	    =  $_REQUEST['mode'];

/********************Parametros paginador ***************************/

$pagina	= $_REQUEST['pagina'];	//Por defecto Página 1
$salto 	= $_REQUEST['salto'];	//Por defecto 5	

function IsSetVar($var)
{
	if((isset($var))&&(!empty($var)))
	{
		return TRUE;
	}else return FALSE;
};

if (!IsSetVar($pagina))
{
	$pagina = 0;
};

if(!IsSetVar($salto))
{
	$salto = 20;
};

if(!IsSetVar($solapa))
{
	$solapa = 0;
};

if(!IsSetVar($mode))
{
	$mode = -1;
};


$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

if($mode==-1)
{
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
	. " WHERE tipo_formato_solapa=$solapa" 
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
        	. " AND C.estudios_id=$estudio_id  AND  tipo_formato_solapa=$solapa " /* Tambíen incluye el mismo estudio */ 
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
        	. " FROM mod_catalogo.vw_catalogo_data C WHERE estudios_id=$estudio_id AND tipo_formato_solapa=$solapa ORDER BY tipo_formato_solapa,recurso_titulo ASC"
        	. ")T";
   		};
	};
}
else
{
	switch ($mode)
	{
		case 0: 	$SQL = ""; die("Modo desconocido."); break;
		case 1: 	$SQL = ""; die("Modo desconocido."); break;
		case 2: 	$SQL = ""; die("Modo desconocido."); break;
		default: 	$SQL = ""; die("Modo desconocido."); break;
	};

};

/*
 * Data para paginador
 */

//echo $SQL;

$data_query	= "SELECT COUNT(*) registros FROM ($SQL) A;";

//echo $data_query;

$recordset	= pg_query($conn,$data_query);

$row		= pg_fetch_row($recordset);

$registros	= $row[0];

$total_paginas	= ceil(($registros-1)/($salto-1));

$offset_pag 	= (($salto-1)*$pagina);

$paginador_text = " LIMIT $salto OFFSET $offset_pag";

//$SQL = $SQL." WHERE T.\"Solapa\"=$solapa";
$SQL = $SQL.$paginador_text;

echo "{"; // JSON - Inicio
echo "	\"paginas\":$total_paginas,";
echo "	\"solapa\": $solapa,";
echo "	\"pagina\": $pagina,";
echo "	\"registros_total\": $registros,";
echo "	\"rec_per_page\": $salto,";
echo "	\"recordset\":";

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

echo "}";// Fin JSON

pg_close($conn);


?>
