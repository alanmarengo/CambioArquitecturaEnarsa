<?php


error_reporting(E_ALL);
ini_set('display_errors', '1');

//require_once 'CAPA-APLICACION/SERVICIOS/REPOSITORIO-SERVICIO.php';
include_once(dirname(__FILE__).'/CAPA-APLICACION/SERVICIOS/REPOSITORIO-SERVICIO.php'); //\ Implementamos la interfaz de servicio del microservicio
include_once(dirname(__FILE__).'/CAPA-DOMINIO/CLASES/Clases.php');

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
                            $datos_respuesta_geovisor = $_respuesta_geovisor->error_200($datos_respuesta_geovisor->detalle); 
                            echo json_encode($datos_respuesta_geovisor);

                        }else{

                            http_response_code(400);                
                            $datos_respuesta_geovisor = $_respuesta_geovisor->error_400($datos_respuesta_geovisor->detalle); 
                            echo json_encode($datos_respuesta_geovisor);

                        } 

                    }else{      

                        http_response_code(400);                
                        $datos_respuesta_geovisor = $_respuesta_geovisor->error_400('Dato Incorrecto para layer_id'); 
                        echo json_encode($datos_respuesta_geovisor);
                    }

                }else{      

                    http_response_code(400);                
                    $datos_respuesta_geovisor = $_respuesta_geovisor->error_400('Dato Incorrecto para usuario_id'); 
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
                    $datos_respuesta_geovisor = $_respuesta_geovisor->error_400('Dato Incorrecto para layer_name'); 
                    echo json_encode($datos_respuesta_geovisor);
                }     

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
                            $datos_respuesta_geovisor = $_respuesta_geovisor->error_400($datos_respuesta_geovisor->detalle); 
                            echo json_encode($datos_respuesta_geovisor);

                        }
                        
                    }else{      

                        http_response_code(400);                
                        $datos_respuesta_geovisor = $_respuesta_geovisor->error_400('Dato Incorrecto para layer_id'); 
                        echo json_encode($datos_respuesta_geovisor);
                    }       

                    $servicio_geovisor = null; 

                break;

           
            
            default :
            
                http_response_code(400);                
                $datos_respuesta_geovisor = $_respuesta_geovisor->error_400("Solicitud Incorrecta"); 
                echo json_encode($datos_respuesta_geovisor);
               
            break;
        }      

    } else {

        http_response_code(400);                
        $datos_respuesta_geovisor = $_respuesta_geovisor->error_400("Solicitud Incorrecta"); 
        echo json_encode($datos_respuesta_geovisor);
       
    }
    
}





