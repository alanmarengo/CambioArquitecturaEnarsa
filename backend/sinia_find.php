<?php

header('Content-Type: application/json');

include_once('./pgconfig.php');

/*** DB ***/

$string_conn = "host=".pg_server." user=".pg_user." port=". pg_portv ." password=".pg_password." dbname=".pg_db;
	
$conn = pg_connect($string_conn);

/*** Parametros ***/

$o 		= pg_escape_string($_REQUEST['o']);		/* Orden */
$c 		= pg_escape_string($_REQUEST['c']);		/* Categoria(Solapa) */
$p 		= pg_escape_string($_REQUEST['p']);		/* Pagina de la solapa */
$j		= pg_escape_string($_REQUEST['j']);		/* Salto o Jump entre paginas dle paginador*/
$mode 		= pg_escape_string($_REQUEST['mode']);		/* Modo */
$mode_id 	= pg_escape_string($_REQUEST['mode_id']);	/* Modo ID, son datos especificos para usar en conjunto con el modo(Opcional)*/

$s 		= pg_escape_string($_REQUEST['s']);		/* Query String - Inicialmente para el modo=0 */

/*** Valores por defecto  y otros ***/

function limpiar($str)//limpia los json's de caracteres no habilitados
{
	return str_replace(array("\n","\r","\""),'',$str);

};

function IsSetVar($var)
{
	if((isset($var))&&(!empty($var)))
	{
		return TRUE;
	}else return FALSE;
};

if (!IsSetVar($p))
{
	$p = 0; /* Página 0*/
};

if(!IsSetVar($j))
{
	$j = 20; /* 20 registros per página */
};

if(!IsSetVar($c))
{
	$c = 1; /* Ejes temáticos */
};

if(!IsSetVar($mode))
{
	$mode = 1; /* Modo busqueda por texto */
};

/*** Variables Globales ***/

$query			= ""; 	/* Consulta final con filtros de paginador etc */
$query_base 		= "";	/* query base sin filtros de base como categoria */
$offset			= 0;	/* Desplazamiento Paginador */
$orden			= "";	/* Orden */
$total_paginas		= 0;	/* Total de paginas en la categoria */

/*** ORDER ***/

switch ($_REQUEST['o'])
{
	case 0: 	$orden = " ORDER BY titulo ASC"; 	break;
	case 1: 	$orden = " ORDER BY titulo DESC"; 	break;
	case 2: 	$orden = " ORDER BY fecha ASC"; 	break;
	case 3: 	$orden = " ORDER BY fecha DESC"; 	break;
	case 4: 	$orden = " ORDER BY categoria ASC"; 	break;
	case 5: 	$orden = " ORDER BY categoria DESC"; 	break;
	default: 	$orden = " ORDER BY titulo ASC"; 	break;
};

/*** Modos ***/

switch($mode)
{	
	case 1: $query 		= "SELECT * FROM sinia_catalogo.buscar('$s') WHERE categoria_id=$c ".$orden;
		$query_base 	= "SELECT * FROM sinia_catalogo.buscar('$s') ";/* query base sin filtros base(categoria) */
		break; 
	case 2: die(); break;
	default :die(); break;
};


/*** funciones calculos paginador  ***/

function get_total_records()
{
	global $query;
	global $conn;

	$q = "SELECT COUNT(*) AS T FROM ($query)T;";
	
	$recordset	= pg_query($conn,$q);
	$row		= pg_fetch_row($recordset);
	
	return $row[0];	
};



function get_total_records_solapa($solapa)/* o categoria */
{
	global $query_base;
	global $conn;

	$q = "SELECT COALESCE(COUNT(*),0) AS T FROM ($query_base)T WHERE categoria_id=$solapa;";
	
	$recordset	= pg_query($conn,$q);
	$row		= pg_fetch_row($recordset);
		
	return $row[0];	
};




$total_registros = get_total_records();

$total_paginas	= ceil(($total_registros-1)/($j-1));/* el total de registros / los saltos por pagina esperados = total de paginas */

$offset_pag 	= (($j-1)*$p); /* según el salto y la pagina requerida, a partir de que resgitros tomar el resultado  */

$paginador_text = " LIMIT $j OFFSET $offset_pag";

/*** Query Final ***/

$query = $query.$paginador_text;

$recordset = pg_query($conn,$query);

$row = pg_fetch_assoc($recordset);
	
$fflag = false;

$buffer = '';

while($row)
{
		if ($fflag)
  		{
      			$buffer .= ',';
  		}
  		else
  		{
      			$fflag = true;
  		};		

  		$buffer .= '{';
		$buffer .= '"origen":"'			.$row['origen'		].'",';
		$buffer .= '"origen_id":"'		.$row['origen_id'	].'",';
		$buffer .= '"origen_id_propio":"'	.$row['origen_id_propio'].'",';
		$buffer .= '"categoria":"'		.limpiar($row['categoria'	]).'",';
		$buffer .= '"categoria_id":"'		.$row['categoria_id'	].'",';
		$buffer .= '"titulo":"'			.limpiar($row['titulo'		]).'",';
		$buffer .= '"categoria_interna":"'	.limpiar($row['categoria_interna']).'",';
		$buffer .= '"descripcion":"'		.limpiar($row['descripcion'	]).'",';
		$buffer .= '"temas":['			.$row['temas'		].'],';
		$buffer .= '"link":"'			.$row['link'		].'",';
		$buffer .= '"fecha":"'			.$row['fecha'		].'",';
		$buffer .= '"ico_path":"'		.$row['ico_path'	].'"';
		$buffer .= '}';

		$row =  pg_fetch_assoc($recordset);
};


echo '{';
echo '"recordset":['.$buffer.'],';
echo '"pagina":"'.$p.'",';
echo '"total_paginas":"'.$total_paginas.'",';
echo '"total_registros":"'.$total_registros.'",';
echo '"total_solapa_1":"'.get_total_records_solapa(1).'",';
echo '"total_solapa_2":"'.get_total_records_solapa(2).'",';
echo '"total_solapa_3":"'.get_total_records_solapa(3).'",';
echo '"total_solapa_4":"'.get_total_records_solapa(4).'",';
echo '"solapa":"'.$c.'"';
echo '}';

//echo $query;
//echo pg_last_error($conn);

pg_close($conn);

?>
