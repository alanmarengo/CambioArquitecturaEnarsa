<?php

include_once(dirname(__FILE__).'/CAPA-APLICACION/SERVICIO/REPOSITORIO-SERVICIO.php'); // Implementamos la interfaz de servicio del microservicio
include_once(dirname(__FILE__).'/CAPA-DOMINIO/CLASES/Clases.php');

$_respuesta = new Respuesta();

// interfaz donde se implementara la API para consumir los servicios del Microservicio Usuario

if($_SERVER['REQUEST_METHOD'] == "POST") // si el request es de tipo post
{           
    if(isset($_POST['action']) && !empty($_POST['action'])) // evaluo que contenga la variable action(contiene la funcion a requerir)
    {   
        $datos_respuesta; // variable que almacenara la respuesta final. 
        
        // evaluo la variable action. 
        switch ($_POST['action']) 
        {
            case 'login':
                
                if(!empty($_POST['usuario']))
                {                    
                    $servicio_usuario = new RepositorioServicioUsuario();

                    $datos_respuesta = $servicio_usuario->login($_POST['usuario'],$_POST['clave']);
                                  
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
                
                    $servicio_usuario = null;

                }else{

                    http_response_code(400);                
                    $datos_respuesta = $_respuesta->error_400('Variable Usuario Vacia'); 
                    echo json_encode($datos_respuesta);


                }

                break;
            
            case 'get_recursos_restringidos':

                $servicio_usuario = new RepositorioServicioUsuario();

                $datos_respuesta = $servicio_usuario->get_recursos_restringidos();
                
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
                
                $servicio_usuario = null;

                break;
            
            case 'get_recursos_restringidos_user':

                if(!empty($_POST['user_id']))
                {

                    $servicio_usuario = new RepositorioServicioUsuario();

                    $datos_respuesta = $servicio_usuario->get_recursos_restringidos_user($_POST['user_id']);
                    
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
                    
                    $servicio_usuario = null;

                }else{

                    $datos_respuesta = $_respuesta->error_400("Variable user_id no puede ir vacia.");                       
                    http_response_code($datos_respuesta["result"]["error_id"]);
                    echo json_encode($datos_respuesta);  

                }    

                break;

            default :
            
                http_response_code(400);                
                $datos_respuesta = $_respuesta->error_400("Solicitud Incorrecta"); 
                echo json_encode($datos_respuesta);
               
            break;
        }      

    } else {

        http_response_code(400);                
        $datos_respuesta = $_respuesta->error_400("Solicitud Incorrecta"); 
        echo json_encode($datos_respuesta);
       
    }
    
}




?>