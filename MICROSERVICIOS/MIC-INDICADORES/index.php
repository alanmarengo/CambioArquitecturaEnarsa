<?php


error_reporting(E_ALL);
ini_set('display_errors', '1');


include_once(dirname(__FILE__).'/CAPA-APLICACION/SERVICIOS/REPOSITORIO-SERVICIOS.php'); // Implementamos la interfaz de servicio del microservicio
include_once(dirname(__FILE__).'/CAPA-DOMINIO/CLASES/Clases.php');

$_respuesta_indicadores = new Respuesta_Indicadores();

if($_SERVER['REQUEST_METHOD'] == "POST") // si el request es de tipo post
{           
    if(isset($_POST['action']) && !empty($_POST['action'])) // evaluo que contenga la variable action(contiene la funcion a requerir)
    {   
        $datos_respuesta; // variable que almacenara la respuesta final. 
        
        $servicio_indicadores = new RepositorioServicioIndicadores();
        // evaluo la variable action. 
        switch ($_POST['action']) 
        {
            case 'DrawAbrInd' :

                if(!empty($_POST['user_id']))
                {                             
                     
                    $datos_respuesta = $servicio_indicadores->DrawAbrInd($_POST['user_id']);
                              
                    if($datos_respuesta->flag)
                    {

                        http_response_code(200);                
                        $datos_respuesta = $_respuesta_indicadores->error_200($datos_respuesta->detalle); 
                        echo json_encode($datos_respuesta);

                    }else{

                        http_response_code(400);                
                        $datos_respuesta = $_respuesta_indicadores->error_400($datos_respuesta->detalle); 
                        echo json_encode($datos_respuesta);

                    }    

                }else{

                    http_response_code(400);                
                    $datos_respuesta = $_respuesta_indicadores->error_400('Variable user_id Vacia'); 
                    echo json_encode($datos_respuesta);
                }

                $servicio_indicadores = null;

                break;
            case 'DrawContainersInd' :

                if(!empty($_POST['user_id']))
                {

                    $datos_respuesta = $servicio_indicadores->DrawContainersInd($_POST['user_id']);
                              
                    if($datos_respuesta->flag)
                    {

                        http_response_code(200);                
                        $datos_respuesta = $_respuesta_indicadores->error_200($datos_respuesta->detalle); 
                        echo json_encode($datos_respuesta);

                    }else{

                        http_response_code(400);                
                        $datos_respuesta = $_respuesta_indicadores->error_400($datos_respuesta->detalle); 
                        echo json_encode($datos_respuesta);

                    }                

                }else{

                    http_response_code(400);                
                    $datos_respuesta = $_respuesta_indicadores->error_400('Variable user_id Vacia'); 
                    echo json_encode($datos_respuesta);
                }

                $servicio_indicadores = null;

                break;


            case 'DrawIndicadoresSearch' :

                if(!empty($_POST['user_id']))
                {   
                    if(!empty($_POST['pattern']))
                    {                                    

                        $datos_respuesta = $servicio_indicadores->DrawIndicadoresSearch($_POST['user_id'],$_POST['pattern']);
                                  
                        if($datos_respuesta->flag)
                        {

                            http_response_code(200);                
                            $datos_respuesta = $_respuesta_indicadores->error_200($datos_respuesta->detalle); 
                            echo json_encode($datos_respuesta);

                        }else{

                            http_response_code(400);                
                            $datos_respuesta = $_respuesta_indicadores->error_400($datos_respuesta->detalle); 
                            echo json_encode($datos_respuesta);

                        } 

                    }else{

                        http_response_code(400);                
                        $datos_respuesta = $_respuesta_indicadores->error_400('Variable pattern Vacia'); 
                        echo json_encode($datos_respuesta);


                    }                     

                }else{

                    http_response_code(400);                
                    $datos_respuesta = $_respuesta_indicadores->error_400('Variable user_id Vacia'); 
                    echo json_encode($datos_respuesta);
                }

                $servicio_indicadores = null;

                break;

            case 'ComboCruce':

                $datos_respuesta = $servicio_indicadores->ComboCruce();
                          
                if($datos_respuesta->flag)
                {

                    http_response_code(200);                
                    $datos_respuesta = $_respuesta_indicadores->error_200($datos_respuesta->detalle); 
                    echo json_encode($datos_respuesta);

                }else{

                    http_response_code(400);                
                    $datos_respuesta = $_respuesta_indicadores->error_400($datos_respuesta->detalle); 
                    echo json_encode($datos_respuesta);

                } 

                $servicio_indicadores = null;
 
                break;

            default :  
            
                http_response_code(400);                
                $datos_respuesta = $_respuesta_indicadores->error_400("Solicitud Incorrecta"); 
                echo json_encode($datos_respuesta); 

            break;
        }      

    } else {
        
        http_response_code(400);                
        $datos_respuesta = $_respuesta_indicadores->error_400("Solicitud Incorrecta"); 
        echo json_encode($datos_respuesta); 

    }
}






?>