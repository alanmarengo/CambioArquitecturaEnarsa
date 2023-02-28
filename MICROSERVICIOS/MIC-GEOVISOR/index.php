<?php

//require_once 'CAPA-APLICACION/SERVICIOS/REPOSITORIO-SERVICIO.php';
include_once(dirname(__FILE__).'\CAPA-APLICACION\SERVICIOS\REPOSITORIO-SERVICIO.php'); //\ Implementamos la interfaz de servicio del microservicio
include_once(dirname(__FILE__).'\CAPA-DOMINIO\CLASES\Clases.php');

// Archivo de evaluacion de peticiones POST
// Este archivo sera el encargado las nueva peticiones post que reciba la pagina,
// verificara la consistencia de los datos recibidos y llamara a los metodos necesarios segun corresponda a la peticion requerida 
// todas las peticiones, de ahora en mas deberan adicionar una variable llamada "action" donde se especificara 
// el metodo requerido del micoservicio Geovisores

// verifica usuario_id en la variable session y si no exitiste, user_id = -1, que corresponde al usuario publico.


$_respuesta_geovisor = new Respuesta_geovisor();

// interfaz donde se implementara la API para consumir los servicios del Microservicio Usuario

if($_SERVER['REQUEST_METHOD'] == "POST") // si el request es de tipo post
{           
    if(isset($_POST['action']) && !empty($_POST['action'])) // evaluo que contenga la variable action(contiene la funcion a requerir)
    {   
        $datos_respuesta_geovisor; // variable que almacenara la respuesta final. 
        $servicio_geovisor = New RepositorioServicioGeovisor;
        // evaluo la variable action. 
        switch ($_POST['action']) 
        {               
            case 'Get_Layer_Security':

                if(!empty($_POST['usuario_id']))
                {  

                    if(!empty($_POST['layer_id']))
                    {  
                        $datos_respuesta_geovisor = $servicio_geovisor->Get_Layer_Security($_POST['usuario_id'],$_POST['layer_id']);

                        if($datos_respuesta_geovisor->flag)
                        {

                            http_response_code(200);                
                            $datos_respuesta_geovisor = $_respuesta->error_200($datos_respuesta_geovisor->detalle); 
                            echo json_encode($datos_respuesta_geovisor);

                        }else{

                            http_response_code(400);                
                            $datos_respuesta_geovisor = $_respuesta->error_400($datos_respuesta_geovisor->detalle); 
                            echo json_encode($datos_respuesta_geovisor);

                        } 

                    }else{      

                        http_response_code(400);                
                        $datos_respuesta_geovisor = $_respuesta->error_400('Dato Incorrecto para layer_id'); 
                        echo json_encode($datos_respuesta_geovisor);
                    }

                }else{      

                    http_response_code(400);                
                    $datos_respuesta_geovisor = $_respuesta->error_400('Dato Incorrecto para usuario_id'); 
                    echo json_encode($datos_respuesta_geovisor);
                }                   
                
                $servicio_geovisor = null;

                break;

            case 'ListaProyectos':

                $datos_respuesta_geovisor = $servicio_geovisor->ListaProyectos();

                if($datos_respuesta_geovisor->flag)
                {

                    http_response_code(200);                
                    $datos_respuesta_geovisor = $_respuesta->error_200($datos_respuesta_geovisor->detalle); 
                    echo json_encode($datos_respuesta_geovisor);

                }else{

                    http_response_code(400);                
                    $datos_respuesta_geovisor = $_respuesta->error_400($datos_respuesta_geovisor->detalle); 
                    echo json_encode($datos_respuesta_geovisor);

                }
                
                $servicio_geovisor = null;

                break;

            case 'DrawAbr':

                $datos_respuesta_geovisor = $servicio_geovisor->DrawAbr();

                if($datos_respuesta_geovisor->flag)
                {

                    http_response_code(200);                
                    $datos_respuesta_geovisor = $_respuesta_geovisor->error_200($datos_respuesta_geovisor->detalle); 
                    echo json_encode($datos_respuesta_geovisor);

                }else{

                    http_response_code(400);                
                    $datos_respuesta_geovisor = $_respuesta_geovisor->error_400($datos_respuesta_geovisor->detalle); 
                    echo json_encode($datos_respuesta_geovisor);

                }
                
                $servicio_geovisor = null;


                break;

            case 'DrawContainers':

                $datos_respuesta_geovisor = $servicio_geovisor->DrawContainers();
                
                $_respuesta_geovisor->error_400($datos_respuesta_geovisor); 

                //echo json_encode($datos_respuesta_geovisor);
                /*
                if($datos_respuesta_geovisor->flag)
                {

                    http_response_code(200);                
                    $datos_respuesta_geovisor = $_respuesta_geovisor->error_200($datos_respuesta_geovisor->detalle); 
                    echo json_encode($datos_respuesta_geovisor);

                }else{

                    http_response_code(400);                
                    $datos_respuesta_geovisor = $_respuesta_geovisor->error_400($datos_respuesta_geovisor->detalle); 
                    echo json_encode($datos_respuesta_geovisor);

                } */
                
                $servicio_geovisor = null;

                break;
            
            case 'DrawLayersSearch':

                if(!empty($_POST['pattern']))
                {  
                    $datos_respuesta_geovisor = $servicio_geovisor->DrawLayersSearch($_POST['pattern']);
                    
                    if($datos_respuesta_geovisor->flag)
                    {                    
                        http_response_code(200);                
                        $datos_respuesta_geovisor = $_respuesta_geovisor->error_200($datos_respuesta_geovisor->detalle); 
                        echo json_encode($datos_respuesta_geovisor);

                    }else{

                        http_response_code(400);                
                        $datos_respuesta_geovisor = $_respuesta_geovisor->error_400($datos_respuesta_geovisor->detalle); 
                        echo json_encode($datos_respuesta_geovisor);

                    } 

                }else{      

                    http_response_code(400);                
                    $datos_respuesta_geovisor = $_respuesta->error_400('Dato Incorrecto para pattern'); 
                    echo json_encode($datos_respuesta_geovisor);
                }                
               
                break;

            case 'DrawDatasetSearch':

                if(!empty($_POST['pattern']))
                {  
                    $datos_respuesta_geovisor = $servicio_geovisor->DrawDatasetSearch($_POST['pattern']);
                    
                    echo $datos_respuesta_geovisor;               
                     

                }else{      

                    http_response_code(400);                
                    $datos_respuesta_geovisor = $_respuesta->error_400('Dato Incorrecto para pattern'); 
                    echo json_encode($datos_respuesta_geovisor);
                }                

                break;
            case 'DrawProyectos':

                $datos_respuesta_geovisor = $servicio_geovisor->DrawProyectos();
                    
                if($datos_respuesta_geovisor->flag)
                {                    
                    http_response_code(200);                
                    $datos_respuesta_geovisor = $_respuesta_geovisor->error_200($datos_respuesta_geovisor->detalle); 
                    echo json_encode($datos_respuesta_geovisor);

                }else{

                    http_response_code(400);                
                    $datos_respuesta_geovisor = $_respuesta_geovisor->error_400($datos_respuesta_geovisor->detalle); 
                    echo json_encode($datos_respuesta_geovisor);

                } 

                break;

            case 'GetLayerLabel':
                
                if(!empty($_POST['layer_name']))
                {  
                    $datos_respuesta_geovisor = $servicio_geovisor->GetLayerLabel($_POST['layer_name']);
                    
                    if($datos_respuesta_geovisor->flag)
                    {                    
                        http_response_code(200);                
                        $datos_respuesta_geovisor = $_respuesta_geovisor->error_200($datos_respuesta_geovisor->detalle); 
                        echo json_encode($datos_respuesta_geovisor);

                    }else{

                        http_response_code(400);                
                        $datos_respuesta_geovisor = $_respuesta_geovisor->error_400($datos_respuesta_geovisor->detalle); 
                        echo json_encode($datos_respuesta_geovisor);

                    } 

                }else{      

                    http_response_code(400);                
                    $datos_respuesta_geovisor = $_respuesta->error_400('Dato Incorrecto para layer_name'); 
                    echo json_encode($datos_respuesta_geovisor);
                }     

                break;
            case 'filter_proyectos_basic':

                if(!empty($_POST['geovisor']))
                {  

                    $datos_respuesta_geovisor = $servicio_geovisor->filter_proyectos_basic($_POST['user_id'], $_POST['proyectos'],$_POST['geovisor']);
                    
                    if($datos_respuesta_geovisor->flag)
                    {
                        http_response_code(200);                
                        $datos_respuesta_geovisor = $_respuesta_geovisor->error_200($datos_respuesta_geovisor->detalle); 
                        echo json_encode($datos_respuesta_geovisor);

                    }else{

                        http_response_code(400);                
                        $datos_respuesta_geovisor = $_respuesta->error_400($datos_respuesta_geovisor->detalle); 
                        echo json_encode($datos_respuesta_geovisor);

                    }
                    
               
    
                }else{      

                    http_response_code(400);                
                    $datos_respuesta_geovisor = $_respuesta->error_400('Dato Incorrecto para geovisor'); 
                    echo json_encode($datos_respuesta_geovisor);
                }                
                $servicio_geovisor = null; 

                break;

            case 'filter_proyectos_advanced':

                if(!empty($_POST['geovisor']))
                {  
                    if(!empty($_POST['user_id']))
                    {  
                        $datos_respuesta_geovisor = $servicio_geovisor->filter_proyectos_advanced($_POST['user_id'], $_POST["adv-search-busqueda"], $_POST["adv-search-fdesde"], 
                                                                                                  $_POST["adv-search-fhasta"],$_POST["adv-search-proyecto-combo"],$_POST["adv-search-clase-combo"],
                                                                                                  $_POST["adv-search-subclase-combo"],$_POST["adv-search-responsable-combo"], $_POST["adv-search-esia-combo"],
                                                                                                  $_POST["adv-search-objeto-combo"], $_POST["geovisor"]);                            
                    
                        if($datos_respuesta_geovisor->flag)
                        {
                            http_response_code(200);                
                            $datos_respuesta_geovisor = $_respuesta_geovisor->error_200($datos_respuesta_geovisor->detalle); 
                            echo json_encode($datos_respuesta_geovisor);
                        }else{
                            http_response_code(400);                
                            $datos_respuesta_geovisor = $_respuesta->error_400($datos_respuesta_geovisor->detalle); 
                            echo json_encode($datos_respuesta_geovisor);
                        }
                        
                    }else{      
                        http_response_code(400);                
                        $datos_respuesta_geovisor = $_respuesta->error_400('Dato Incorrecto para user_id'); 
                        echo json_encode($datos_respuesta_geovisor);
                    }
                    
                }else{      
                    http_response_code(400);                
                    $datos_respuesta_geovisor = $_respuesta->error_400('Dato Incorrecto para geovisor'); 
                    echo json_encode($datos_respuesta_geovisor);
                }      

                $servicio_geovisor = null; 

                break;

            case 'get_layer_extent':

                if(!empty($_POST['layer_id']))
                {  

                    $datos_respuesta_geovisor = $servicio_geovisor->get_layer_extent($_POST['layer_id']);
                    
                    if($datos_respuesta_geovisor->flag)
                    {
                        http_response_code(200);                
                        $datos_respuesta_geovisor = $_respuesta_geovisor->error_200($datos_respuesta_geovisor->detalle); 
                        echo json_encode($datos_respuesta_geovisor);

                    }else{

                        http_response_code(400);                
                        $datos_respuesta_geovisor = $_respuesta->error_400($datos_respuesta_geovisor->detalle); 
                        echo json_encode($datos_respuesta_geovisor);

                    }                    
                  
                }else{      

                    http_response_code(400);                
                    $datos_respuesta_geovisor = $_respuesta->error_400('Dato Incorrecto para layer_id'); 
                    echo json_encode($datos_respuesta_geovisor);
                }                

                $servicio_geovisor = null;    

                break;

            case 'get_coor_transformed':

                if(!empty($_POST['lat']))
                {  

                    if(!empty($_POST['lon']))
                    {  
                        $datos_respuesta_geovisor = $servicio_geovisor->get_coor_transformed($_POST['lon'], $_POST['lat']);
                    
                        if($datos_respuesta_geovisor->flag)
                        {
                            http_response_code(200);                
                            $datos_respuesta_geovisor = $_respuesta_geovisor->error_200($datos_respuesta_geovisor->detalle); 
                            echo json_encode($datos_respuesta_geovisor);

                        }else{

                            http_response_code(400);                
                            $datos_respuesta_geovisor = $_respuesta->error_400($datos_respuesta_geovisor->detalle); 
                            echo json_encode($datos_respuesta_geovisor);

                        }
                        
                    }else{      

                        http_response_code(400);                
                        $datos_respuesta_geovisor = $_respuesta->error_400('Dato Incorrecto para geovisor'); 
                        echo json_encode($datos_respuesta_geovisor);
                    }                           
                       
                }else{      

                    http_response_code(400);                
                    $datos_respuesta_geovisor = $_respuesta->error_400('Dato Incorrecto para geovisor'); 
                    echo json_encode($datos_respuesta_geovisor);
                }                
                $servicio_geovisor = null; 

                break;

            case 'get_medicion':

                if(!empty($_POST["wkt"]) && !empty($_POST["type"]))
                {  
                    $datos_respuesta_geovisor = $servicio_geovisor->get_medicion($_POST['wkt'], $_POST['type']);
                
                    if($datos_respuesta_geovisor->flag)
                    {
                        http_response_code(200);                
                        $datos_respuesta_geovisor = $_respuesta_geovisor->error_200($datos_respuesta_geovisor->detalle); 
                        echo json_encode($datos_respuesta_geovisor);

                    }else{

                        http_response_code(400);                
                        $datos_respuesta_geovisor = $_respuesta->error_400($datos_respuesta_geovisor->detalle); 
                        echo json_encode($datos_respuesta_geovisor);

                    }
                    
                }else{      

                    http_response_code(400);                
                    $datos_respuesta_geovisor = $_respuesta->error_400('Dato Incorrecto para wkt - type'); 
                    echo json_encode($datos_respuesta_geovisor);
                }                                      

                $servicio_geovisor = null; 

                break;

            case 'get_buffer':

                break;

            case 'get_layer_preview':

                    if(!empty($_POST['layer_id']))
                    {  
                        $datos_respuesta_geovisor = $servicio_geovisor->get_layer_preview($_POST['layer_id']);
                    
                        if($datos_respuesta_geovisor->flag)
                        {
                            http_response_code(200);                
                            $datos_respuesta_geovisor = $_respuesta_geovisor->error_200($datos_respuesta_geovisor->detalle); 
                            echo json_encode($datos_respuesta_geovisor);

                        }else{

                            http_response_code(400);                
                            $datos_respuesta_geovisor = $_respuesta->error_400($datos_respuesta_geovisor->detalle); 
                            echo json_encode($datos_respuesta_geovisor);

                        }
                        
                    }else{      

                        http_response_code(400);                
                        $datos_respuesta_geovisor = $_respuesta->error_400('Dato Incorrecto para layer_id'); 
                        echo json_encode($datos_respuesta_geovisor);
                    }       

                    $servicio_geovisor = null; 

                break;

            case 'get_layer_info_pgda':
       
                    $datos_respuesta_geovisor = $servicio_geovisor->get_layer_info_pgda();
                
                    if($datos_respuesta_geovisor->flag)
                    {
                        http_response_code(200);                
                        $datos_respuesta_geovisor = $_respuesta_geovisor->error_200($datos_respuesta_geovisor->detalle); 
                        echo json_encode($datos_respuesta_geovisor);

                    }else{

                        http_response_code(400);                
                        $datos_respuesta_geovisor = $_respuesta->error_400($datos_respuesta_geovisor->detalle); 
                        echo json_encode($datos_respuesta_geovisor);

                    }


                break;
   
            
            default :
            
                http_response_code(400);                
                $datos_respuesta_geovisor = $_respuesta->error_400("Solicitud Incorrecta"); 
                echo json_encode($datos_respuesta_geovisor);
               
            break;
        }      

    } else {

        http_response_code(400);                
        $datos_respuesta_geovisor = $_respuesta->error_400("Solicitud Incorrecta"); 
        echo json_encode($datos_respuesta_geovisor);
       
    }
    
}

