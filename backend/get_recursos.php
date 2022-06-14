<?php

header('Content-Type: application/json');

include_once('./pgconfig.php');
include_once('./get_tabs.php');
include_once('./get_temas.php');

/** Mode 1 **/
$tema_id 	= $_REQUEST['tema_id'];

/** Mode 2 **/
$dt_id 		= $_REQUEST['dt_id'];

/** Mode **/
$mode		= $_REQUEST['mode'];

switch($mode)
{	
	case 1: get_temas($tema_id); /*mode_1();*/ break;
	case 2: get_tabs($dt_id); break;
	default :die(); break;
};

pg_close($conn);


?>

















