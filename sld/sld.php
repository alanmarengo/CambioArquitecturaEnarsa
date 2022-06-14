<?php

include("../pgconfig.php");

const _POINT_   =0;
const _LINE_    =1;
const _POLYGON_ =2;

$simbol = 'circle'; 

$type_geom		= $_REQUEST['type_geom'		];
$main_color 	= $_REQUEST['main_color'	];
$layer_name 	= $_REQUEST['layer_name'	];
$size			= $_REQUEST['size'			];
$border_color 	= $_REQUEST['border_color'	];
$border_size 	= $_REQUEST['border_size'	];
$layer_id 		= $_REQUEST['layer_id'		];

$string_conn 	= "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;

$conn 			= pg_connect($string_conn);

$SQL 			= "SELECT UPPER(TL.tipo_layer_desc) AS tg FROM mod_geovisores.layer L INNER JOIN  mod_geovisores.tipo_layer TL ON L.tipo_layer_id=TL.tipo_layer_id WHERE layer_id=$layer_id limit 1";

$recordset 		= pg_query($conn,$SQL);

$row 			= pg_fetch_row($recordset);

$geometria 		= $row[0];

switch ($geometria) 
{
    case 'POINT'			:$sld_file 	= file_get_contents("./point.sld");		break;
    case 'MULTIPOINT'		:$sld_file 	= file_get_contents("./point.sld");		break;
    case 'POLYGON'			:$sld_file 	= file_get_contents("./polygon.sld");	break;
    case 'MULTIPOLYGON'		:$sld_file 	= file_get_contents("./polygon.sld");	break;
    case 'LINESTRING'		:$sld_file 	= file_get_contents("./line.sld");		break;
    case 'MULTILINESTRING'	:$sld_file 	= file_get_contents("./line.sld");		break;
    case 'GEOMETRY'			:$sld_file 	= file_get_contents("./geom.sld");		break;
    default					:$sld_file 	= file_get_contents("./geom.sld");		break;
		
};

/*
switch ($type_geom) 
{
    case _POINT_	:$sld_file 	= file_get_contents("./point.sld");		break;
    case _LINE_		:$sld_file 	= file_get_contents("./line.sld");		break;
    case _POLYGON_	:$sld_file 	= file_get_contents("./polygon.sld");	break;
};
* */

$sld_file	= str_replace("[layer_name]"	, $layer_name	,$sld_file		);
$sld_file	= str_replace("[main_color]"	, '#'.$main_color	,$sld_file	);
$sld_file	= str_replace("[size]"			, $size			,$sld_file		);
$sld_file	= str_replace("[border_color]"	, '#'.$border_color	,$sld_file	);
$sld_file	= str_replace("[border_size]"	, $border_size	,$sld_file		);
$sld_file	= str_replace("[symbol]"		, $simbol		,$sld_file		);

pg_close($conn);

echo $sld_file;

?>
