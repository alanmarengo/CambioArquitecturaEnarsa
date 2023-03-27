<?php


ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
require_once(dirname(__FILE__).'/CAPA-APLICACION/SERVICIO/REPOSITORIO-SERVICIO.php');
include_once(dirname(__FILE__).'/CAPA-DOMINIO/CLASES/clase_request.php');
include_once(dirname(__FILE__).'/CAPA-DOMINIO/CLASES/clase_respuesta.php');
include_once(dirname(__FILE__).'/CAPA-DOMINIO/CLASES/clases.php');


$_respuesta = new Respuesta_mediateca();
$datos_respuesta; // variable que almacenara la respuesta final. 
/*
$_POST['action'] = 'get_recursos_mediateca';
$_POST['si_tengo_que_filtrar'] = 1;
$_POST['o'] = 1;
$_POST['salto'] = 10;
$_POST['user_id'] = "";
$_POST['solapa'] = 1;
$_POST['s'] = 'ahrsc';
$_POST['pagina'] = 0;
$_POST['tipo_temporalidad'] = 2;
$_POST['ds'] ='01/01/2020'; // desde 
$_POST['de'] = '01/03/2023'; // hasta
$_POST['ft'] = 1;
 

//print_r($_SERVER);exit;


s=&
o=4&
ds=24%2F03%2F2023&
de=24%2F03%2F2023&
ft=2&
proyecto=&
documento=&
tema=&
subtema=&
mode=-1&
mode_id=0&
solapa=0&
pagina=0&
salto=20&
tipo_elemento='' 
$_GET['s'] = ""; // search- busqueda
$_GET['o'] = 4;
$_GET['ds'] ='01/01/2020'; // desde 
$_GET['de'] = '01/03/2023'; // hasta
$_GET['ft'] =1;
$_GET['proyecto'] = null;
$_GET['documento'] = null;
$_GET['tema'] = null;
$_GET['subtema'] = null;
$_GET['mode'] = '-1';
$_GET['mode_id'] = '';
$_GET['solapa'] = '0';
$_GET['pagina'] = '0';
$_GET['salto'] = 20;
$_GET['tipo_elemento'] = null;
$_GET['user_id'] = null;
$_GET['si_tengo_que_filtrar'] = "1";



*/

//if($_SERVER['REQUEST_METHOD'] == "POST")
//{

    if(isset($_POST['action']) && !empty($_POST['action']))
    {
        $datos_respuesta = "";

        switch ($_POST['action'])
        {

            case 'get_recursos_mediateca'; 
                    
              

                $filtros_recibidos = new request_filtros();        
                if(!empty($_POST['s'])){$filtros_recibidos->busqueda = $_POST['s']; }
                if(!empty($_POST['ds'])){$filtros_recibidos->desde = $_POST['ds']; }
                if(!empty($_POST['de'])){$filtros_recibidos->hasta = $_POST['de']; }
                if(!empty($_POST['ft'])){$filtros_recibidos->filtro_temporalidad = $_POST['ft']; }
                if(!empty($_POST['proyecto'])){$filtros_recibidos->proyecto = $_POST['proyecto']; }
                if(!empty($_POST['tema'])){$filtros_recibidos->clase = $_POST['tema']; }
                if(!empty($_POST['subtema'])){$filtros_recibidos->subclase = $_POST['subtema']; }
                if(!empty($_POST['documento'])){$filtros_recibidos->tipo_doc = $_POST['documento']; }
                if(!empty($_POST['o'])){$filtros_recibidos->orden = $_POST['o']; }
                if(!empty($_POST['estudio_id'])){$filtros_recibidos->estudio_id = $_POST['estudio_id']; }
                if(!empty($_POST['ra'])){$filtros_recibidos->ra = $_POST['ra']; }
                if(!empty($_POST['solapa'])){$filtros_recibidos->solapa = $_POST['solapa']; }
                if(!empty($_POST['mode'])){$filtros_recibidos->mode = $_POST['mode']; }
                if(!empty($_POST['mode_id'])){$filtros_recibidos->mode_id = $_POST['mode_id']; }
                if(!empty($_POST['mode_label'])){$filtros_recibidos->mode_label = $_POST['mode_label']; }
                if(!empty($_POST['tipo_elemento'])){$filtros_recibidos->tipo_elemento = $_POST['tipo_elemento']; }
                if(!empty($_POST['user_id'])){$filtros_recibidos->usuario_id = $_POST['user_id']; }
                if(!empty($_POST['pagina'])){$filtros_recibidos->pagina = $_POST['pagina']; }
                if(!empty($_POST['salto'])){$filtros_recibidos->salto = $_POST['salto']; }
                if(!empty($_POST['tipo_temporalidad'])){$filtros_recibidos->tipo_temporalidad = $_POST['tipo_temporalidad']; }
                if(!empty($_POST['si_tengo_que_filtrar'])){$filtros_recibidos->si_tengo_que_filtrar = $_POST['si_tengo_que_filtrar']; }
                

                $servicio_mediateca = new RepositorioServicioMediateca();

                $respuesta = $servicio_mediateca->get_Recursos($filtros_recibidos->user_id, $filtros_recibidos->solapa, $filtros_recibidos->pagina,$filtros_recibidos->salto,
                $filtros_recibidos->busqueda, $filtros_recibidos->desde, $filtros_recibidos->hasta, $filtros_recibidos->proyecto, $filtros_recibidos->clase, $filtros_recibidos->subclase,
                $filtros_recibidos->tipo_elemento, $filtros_recibidos->filtro_temporalidad, $filtros_recibidos->tipo_temporalidad,$filtros_recibidos->si_tengo_que_filtrar,
                $filtros_recibidos->calculo_estadistica,$filtros_recibidos->orden);

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

                break;

            
            case 'busqueda_mediateca':

                
                if(!empty($_POST['texto_busqueda']))
                {                    
                    $servicio_mediateca = new RepositorioServicioMediateca();
                    $datos_respuesta = $servicio_mediateca->busqueda_mediateca($_POST['texto_busqueda']);
                                  
                    if($datos_respuesta->flag)
                    {
                        http_response_code(200);                
                        $datos_respuesta = $_respuesta->error_200($datos_respuesta->detalle); 
                        echo json_encode($datos_respuesta);

                    }else{

                        http_response_code(400);                
                        $datos_respuesta = $_respuesta->error_400($datos_respuesta->detalle); 
                        echo json_encode($datos_respuesta);

                    }                 
                    $servicio_mediateca = null;

                }else{

                    http_response_code(400);                
                    $datos_respuesta = $_respuesta->error_400('Variable texto_busqueda vacia.'); 
                    echo json_encode($datos_respuesta);
                }

                break;                                 
                
            case 'carrusel_represas':

                if(!empty($_POST['represa']))
                {                    
                    $servicio_mediateca = new RepositorioServicioMediateca();

                    $datos_respuesta = $servicio_mediateca->carrusel_represas($_POST['represa']);
                                  
                    if($datos_respuesta->flag)
                    {

                        http_response_code(200);                
                        $datos_respuesta = $_respuesta->error_200($datos_respuesta->detalle); 
                        echo json_encode($datos_respuesta);

                    }else{

                        http_response_code(400);                
                        $datos_respuesta = $_respuesta->error_400($datos_respuesta->detalle); 
                        echo json_encode($datos_respuesta);

                    } 
                
                    $servicio_mediateca = null;

                }else{

                    http_response_code(400);                
                    $datos_respuesta = $_respuesta->error_400('Variable represa vacia.'); 
                    echo json_encode($datos_respuesta);

                }

                break;                             

            case 'noticias_mediateca':

                $servicio_mediateca = new RepositorioServicioMediateca();

                $datos_respuesta = $servicio_mediateca->noticias_mediateca();
                                  
                if($datos_respuesta->flag)
                {

                    http_response_code(200);                
                    $datos_respuesta_server = $_respuesta->error_200($datos_respuesta->detalle); 
                    print_r($datos_respuesta_server);

                }else{

                    http_response_code(400);                
                    $datos_respuesta_server = $_respuesta->error_400("No se encontraron resultados"); 
                    echo json_encode($datos_respuesta_server);

                } 

                $servicio_mediateca = null;

                break;
            
            default: 

                http_response_code(400);                
                $datos_respuesta = $_respuesta->error_400('Peticion Incorrecta '); 
                echo json_encode($datos_respuesta);

                break;
        }

    }else{
        
        http_response_code(400);                
        $datos_respuesta = $_respuesta->error_400('Peticion Incorrecta.'); 
        echo json_encode($datos_respuesta);
    }
//}



/*



if($_SERVER['REQUEST_METHOD'] == "GET")
{   

    //print_r($_GET);

    $filtros_recibidos = new request_filtros();        
    if(!empty($_GET['s'])){$filtros_recibidos->busqueda = $_GET['s']; }
    if(!empty($_GET['ds'])){$filtros_recibidos->desde = $_GET['ds']; }
    if(!empty($_GET['de'])){$filtros_recibidos->hasta = $_GET['de']; }
    if(!empty($_GET['ft'])){$filtros_recibidos->filtro_temporalidad = $_GET['ft']; }
    if(!empty($_GET['proyecto'])){$filtros_recibidos->proyecto = $_GET['proyecto']; }
    if(!empty($_GET['tema'])){$filtros_recibidos->clase = $_GET['tema']; }
    if(!empty($_GET['subtema'])){$filtros_recibidos->subclase = $_GET['subtema']; }
    if(!empty($_GET['documento'])){$filtros_recibidos->tipo_doc = $_GET['documento']; }
    if(!empty($_GET['o'])){$filtros_recibidos->orden = $_GET['o']; }
    if(!empty($_GET['estudio_id'])){$filtros_recibidos->estudio_id = $_GET['estudio_id']; }
    if(!empty($_GET['ra'])){$filtros_recibidos->ra = $_GET['ra']; }
    if(!empty($_GET['solapa'])){$filtros_recibidos->solapa = $_GET['solapa']; }
    if(!empty($_GET['mode'])){$filtros_recibidos->mode = $_GET['mode']; }
    if(!empty($_GET['mode_id'])){$filtros_recibidos->mode_id = $_GET['mode_id']; }
    if(!empty($_GET['mode_label'])){$filtros_recibidos->mode_label = $_GET['mode_label']; }
    if(!empty($_GET['tipo_elemento'])){$filtros_recibidos->tipo_elemento = $_GET['tipo_elemento']; }
    if(!empty($_GET['user_id'])){$filtros_recibidos->usuario_id = $_GET['user_id']; }
    if(!empty($_GET['pagina'])){$filtros_recibidos->pagina = $_GET['pagina']; }
    if(!empty($_GET['salto'])){$filtros_recibidos->salto = $_GET['salto']; }
    if(!empty($_GET['tipo_temporalidad'])){$filtros_recibidos->tipo_temporalidad = $_GET['tipo_temporalidad']; }
    if(!empty($_GET['si_tengo_que_filtrar'])){$filtros_recibidos->si_tengo_que_filtrar = $_GET['si_tengo_que_filtrar']; }
    

    $servicio_mediateca = new RepositorioServicioMediateca();

    $respuesta = $servicio_mediateca->get_Recursos($filtros_recibidos->user_id, $filtros_recibidos->solapa, $filtros_recibidos->pagina,$filtros_recibidos->salto,
    $filtros_recibidos->busqueda, $filtros_recibidos->desde, $filtros_recibidos->hasta, $filtros_recibidos->proyecto, $filtros_recibidos->clase, $filtros_recibidos->subclase,
    $filtros_recibidos->tipo_elemento, $filtros_recibidos->filtro_temporalidad, $filtros_recibidos->tipo_temporalidad,$filtros_recibidos->si_tengo_que_filtrar,
    $filtros_recibidos->calculo_estadistica,$filtros_recibidos->orden);

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



*/



?>