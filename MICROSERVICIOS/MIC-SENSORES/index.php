<?php



include_once(dirname(__FILE__).'/CAPA-APLICACION/SERVICIO/REPOSITORIO-SERVICIO.php'); // Implementamos la interfaz de servicio del microservicio
include_once(dirname(__FILE__).'/CAPA-DOMINIO/CLASES/Clases.php');

$_respuesta_sensor = new Respuesta_sensor();

// interfaz donde se implementara la API para consumir los servicios del Microservicio Usuario

if($_SERVER['REQUEST_METHOD'] == "POST") // si el request es de tipo post
{           
    if(isset($_POST['action']) && !empty($_POST['action'])) // evaluo que contenga la variable action(contiene la funcion a requerir)
    {   
        $datos_respuesta; // variable que almacenara la respuesta final. 
        
        // evaluo la variable action. 
        switch ($_POST['action']) 
        {
            case 'json_sensores':

                $servicio_sensores = new RepositorioServicioSensores();

                    $datos_respuesta = $servicio_sensores->json_sensores();
                                  
                    if($datos_respuesta->flag)
                    {

                        http_response_code(200);                
                        $datos_respuesta_sensor = $_respuesta_sensor->error_200($datos_respuesta->detalle); 
                        echo json_encode($datos_respuesta_sensor);

                    }else{

                        http_response_code(400);                
                        $datos_respuesta_sensor = $_respuesta_sensor->error_400($datos_respuesta->detalle); 
                        echo json_encode($datos_respuesta_sensor);

                    } 
                
                    $servicio_sensores = null;
 
                break;

            case 'csv_redes_hidro';                   
                    
                if(!empty($_POST['parametro_id']))
                {
                    $parametro_id = $_POST['parametro_id'];                    

                    if(!empty($_POST['fd']))
                    {
    
                        $fd = $_POST['fd'];

                        if(!empty($_POST['fh']))
                        {
                            $fh = $_POST['fh'];

                            if(!empty($_POST['estacion_id']))
                            {
            
                                $estacion_id = $_POST['estacion_id'];    
                                
                                if(!empty($_POST['categoria_parametro_id']))
                                {
                
                                    $categoria_parametro_id = $_POST['categoria_parametro_id'];   
                                    
                                    $servicio_sensores = new RepositorioServicioSensores();
            
                                    $datos_respuesta = $servicio_sensores->csv_redes_hidro($parametro_id,$fd, $fh, $estacion_id, $categoria_parametro_id);
                                                    
                                    if($datos_respuesta->flag)
                                    {
                    
                                        http_response_code(200);                
                                        $datos_respuesta_sensor = $_respuesta_sensor->error_200($datos_respuesta->detalle); 
                                        echo json_encode($datos_respuesta_sensor);
                    
                                    }else{
                    
                                        http_response_code(400);                
                                        $datos_respuesta_sensor = $_respuesta_sensor->error_400($datos_respuesta->detalle); 
                                        echo json_encode($datos_respuesta_sensor);
                    
                                    } 

                
                                }else{
                
                                    http_response_code(400);                
                                    $datos_respuesta_sensor = $_respuesta_sensor->error_400('Variable categoria_parametro_id vacia'); 
                                    echo json_encode($datos_respuesta_sensor);
                                }

                            }else{
            
                                http_response_code(400);                
                                $datos_respuesta_sensor = $_respuesta_sensor->error_400('Variable estacion_id vacia.'); 
                                echo json_encode($datos_respuesta_sensor);
                            }
                            
                            

                        
                        }else{
        
                            http_response_code(400);                
                            $datos_respuesta_sensor = $_respuesta_sensor->error_400('Variable fh vacia'); 
                            echo json_encode($datos_respuesta_sensor);
                        }   
    
                    }else{
    
                        http_response_code(400);                
                        $datos_respuesta_sensor = $_respuesta_sensor->error_400('Variable fd vacia'); 
                        echo json_encode($datos_respuesta_sensor);
                    }
    
                    
                    
                                     
                    
                    
                    
                }else{

                    http_response_code(400);                
                    $datos_respuesta_sensor = $_respuesta_sensor->error_400("Variable Parametro_id vacia"); 
                    echo json_encode($datos_respuesta_sensor);

                }

                
               
                
                    $servicio_sensores = null;

                break;

            case 'csv_redes':

                if(!empty($_POST['parametro_id']))
                {

                    $parametro_id = $_POST['parametro_id'];                                    

                }else{

                    http_response_code(400);                
                    $datos_respuesta_sensor = $_respuesta_sensor->error_400('Variable parametro_id vacia'); 
                    echo json_encode($datos_respuesta_sensor);
                }

                if(!empty($_POST['fd']))
                {

                    $fd = $_POST['fd'];                                    

                }else{

                    http_response_code(400);                
                    $datos_respuesta_sensor = $_respuesta_sensor->error_400('Variable fd vacia'); 
                    echo json_encode($datos_respuesta_sensor);
                }

                if(!empty($_POST['fh']))
                {

                    $fh = $_POST['fh'];                                    

                }else{

                    http_response_code(400);                
                    $datos_respuesta_sensor = $_respuesta_sensor->error_400('Variable fh vacia'); 
                    echo json_encode($datos_respuesta_sensor);
                }

                if(!empty($_POST['lista_estaciones']))
                {

                    $lista_estaciones = $_POST['lista_estaciones'];                                    

                }else{

                    http_response_code(400);                
                    $datos_respuesta_sensor = $_respuesta_sensor->error_400('Variable lista_estaciones vacia'); 
                    echo json_encode($datos_respuesta_sensor);
                }

                $servicio_sensores = new RepositorioServicioSensores();

                $datos_respuesta = $servicio_sensores->csv_redes($parametro_id, $fd,$fh,$lista_estaciones);
                                  
                if($datos_respuesta->flag)
                {

                    http_response_code(200);                
                    $datos_respuesta_sensor = $_respuesta_sensor->error_200($datos_respuesta->detalle); 
                    echo json_encode($datos_respuesta_sensor);

                }else{

                    http_response_code(400);                
                    $datos_respuesta_sensor = $_respuesta_sensor->error_400($datos_respuesta->detalle); 
                    echo json_encode($datos_respuesta_sensor);

                } 
                
                $servicio_sensores = null;

                break;

            default :                
                
                $respuesta_op_server = new respuesta_error_sensor();
                $respuesta_op_server->flag = false;
                $respuesta_op_server->detalle = "Solicitud Incorrecta";      

            break;
        }      

    } else {

        http_response_code(400);                
        $datos_respuesta_sensor = $_respuesta_sensor->error_400("Solicitud Incorrecta"); 
        echo json_encode($datos_respuesta_sensor);
       
    }
    
}




?>




