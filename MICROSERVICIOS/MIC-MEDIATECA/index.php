<?php

require_once(dirname(__FILE__).'\CAPA-APLICACION\SERVICIO\REPOSITORIO-SERVICIO.php');
require_once(dirname(__FILE__).'\clase_request.php');

/*

$_REQUEST['s'] = null;
$_REQUEST['o'] =4;
$_REQUEST['ds'] =null;
$_REQUEST['de'] = null;
$_REQUEST['ft'] =2;
$_REQUEST['proyecto'] = null;
$_REQUEST['documento'] = null;
$_REQUEST['tema'] = null;
$_REQUEST['subtema'] = null;
$_REQUEST['mode'] = '-1';
$_REQUEST['mode_id'] = '';
$_REQUEST['solapa'] = '0';
$_REQUEST['pagina'] = null;
$_REQUEST['salto'] = null;
$_REQUEST['tipo_elemento'] = null;
$_REQUEST['user_id'] = null;
*/


if($_SERVER['REQUEST_METHOD'] == "GET")
{

    //print_r($_REQUEST);

    $filtros_recibidos = new request_filtros();        
    if(!empty($_REQUEST['s'])){$filtros_recibidos->busqueda = $_REQUEST['s']; }
    if(!empty($_REQUEST['ds'])){$filtros_recibidos->desde = $_REQUEST['ds']; }
    if(!empty($_REQUEST['de'])){$filtros_recibidos->hasta = $_REQUEST['de']; }
    if(!empty($_REQUEST['ft'])){$filtros_recibidos->filtro_temporalidad = $_REQUEST['ft']; }
    if(!empty($_REQUEST['proyecto'])){$filtros_recibidos->proyecto = $_REQUEST['proyecto']; }
    if(!empty($_REQUEST['tema'])){$filtros_recibidos->clase = $_REQUEST['tema']; }
    if(!empty($_REQUEST['subtema'])){$filtros_recibidos->subclase = $_REQUEST['subtema']; }
    if(!empty($_REQUEST['documento'])){$filtros_recibidos->tipo_doc = $_REQUEST['documento']; }
    if(!empty($_REQUEST['o'])){$filtros_recibidos->orden = $_REQUEST['o']; }
    if(!empty($_REQUEST['estudio_id'])){$filtros_recibidos->estudio_id = $_REQUEST['estudio_id']; }
    if(!empty($_REQUEST['ra'])){$filtros_recibidos->ra = $_REQUEST['ra']; }
    if(!empty($_REQUEST['solapa'])){$filtros_recibidos->solapa = $_REQUEST['solapa']; }
    if(!empty($_REQUEST['mode'])){$filtros_recibidos->mode = $_REQUEST['mode']; }
    if(!empty($_REQUEST['mode_id'])){$filtros_recibidos->mode_id = $_REQUEST['mode_id']; }
    if(!empty($_REQUEST['mode_label'])){$filtros_recibidos->mode_label = $_REQUEST['mode_label']; }
    if(!empty($_REQUEST['tipo_elemento'])){$filtros_recibidos->tipo_elemento = $_REQUEST['tipo_elemento']; }
    if(!empty($_REQUEST['user_id'])){$filtros_recibidos->usuario_id = $_REQUEST['user_id']; }
    if(!empty($_REQUEST['pagina'])){$filtros_recibidos->pagina = $_REQUEST['pagina']; }
    if(!empty($_REQUEST['salto'])){$filtros_recibidos->salto = $_REQUEST['salto']; }
    if(!empty($_REQUEST['tipo_temporalidad'])){$filtros_recibidos->tipo_temporalidad = $_REQUEST['tipo_temporalidad']; }
    

    $servicio_mediateca = new RepositorioServicioMediateca();

    $respuesta = $servicio_mediateca->get_Recursos($filtros_recibidos->user_id,$filtros_recibidos->solapa,$filtros_recibidos->pagina,$filtros_recibidos->salto,$filtros_recibidos->busqueda,
                                                    $filtros_recibidos->desde,$filtros_recibidos->hasta,$filtros_recibidos->proyecto,$filtros_recibidos->clase,$filtros_recibidos->subclase,$filtros_recibidos->tipo_elemento,
                                                    $filtros_recibidos->filtro_temporalidad,$filtros_recibidos->tipo_temporalidad,$filtros_recibidos->si_tengo_que_filtrar,$filtros_recibidos->calculo_estadistica,$filtros_recibidos->orden);

    if($respuesta->flag)
    {
        $respuesta_final = new respuesta_server();
        http_response_code($respuesta_final->error_code);
        $respuesta_final->detalle = $respuesta->detalle;
        echo json_encode($respuesta_final);
    }else{

        http_response_code(400);
        echo $respuesta->detalle;
    }
    
    //print_r($filtros_recibidos);
}







?>