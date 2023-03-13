<?php

include_once(dirname(__FILE__).'/CAPA-APLICACION/SERVICIO/REPOSITORIO-SERVICIO.php'); // Implementamos la interfaz de servicio del microservicio
include_once(dirname(__FILE__).'/CAPA-DOMINIO/CLASES/Clases.php');

$_respuesta_rectec = new Respuesta_rectec();

// interfaz donde se implementara la API para consumir los servicios del Microservicio Usuario

//if($_SERVER['REQUEST_METHOD'] == "POST") // si el request es de tipo post
//{           
    if(isset($_POST['action']) && !empty($_POST['action'])) // evaluo que contenga la variable action(contiene la funcion a requerir)
    {   
        $datos_respuesta; // variable que almacenara la respuesta final. 
        
        // evaluo la variable action. 
        switch ($_POST['action']) 
        {
            case 'get_recursos_tecnicos' :

                if(empty($_POST['lista_recursos_restringidos']))
                {     
                    http_response_code(400);                
                    $datos_respuesta = $_respuesta_rectec->error_400('Variable lista_recursos_restringidos Vacia'); 
                    echo json_encode($datos_respuesta);
                }

                if(empty($_POST['current_page']))
                {     
                    http_response_code(400);                
                    $datos_respuesta = $_respuesta_rectec->error_400('Variable current_page Vacia'); 
                    echo json_encode($datos_respuesta);
                }

                if(empty($_POST['page_size']))
                {     
                    http_response_code(400);                
                    $datos_respuesta = $_respuesta_rectec->error_400('Variable page_size Vacia'); 
                    echo json_encode($datos_respuesta);
                }

                $servicio_rectec = new RepositorioServicioRecursosTecnicos();

                $datos_respuesta = $servicio_rectec->get_recursos_tecnicos($_POST['lista_recursos_restringidos'],$_POST['current_page'],$_POST['page_size'],$_POST['order_by']);

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
                
                $servicio_rectec = null;

                break;

            case 'get_recursos_tecnicos_filtrado' :

                if(empty($_POST['lista_recursos_restringidos']))
                {     
                    http_response_code(400);                
                    $datos_respuesta = $_respuesta_rectec->error_400('Variable lista_recursos_restringidos Vacia'); 
                    echo json_encode($datos_respuesta);
                }

                if(empty($_POST['current_page']))
                {     
                    http_response_code(400);                
                    $datos_respuesta = $_respuesta_rectec->error_400('Variable current_page Vacia'); 
                    echo json_encode($datos_respuesta);
                }

                if(empty($_POST['page_size']))
                {     
                    http_response_code(400);                
                    $datos_respuesta = $_respuesta_rectec->error_400('Variable page_size Vacia'); 
                    echo json_encode($datos_respuesta);
                }

                $servicio_rectec = new RepositorioServicioRecursosTecnicos();

                $datos_respuesta = $servicio_rectec->get_recursos_tecnicos_filtrado( $_POST['lista_recursos_restringidos'],  $_POST['current_page'], $_POST['page_size'], $_POST['qt'], $_POST['desde'], $_POST['hasta'],
                                                             $_POST['proyecto'], $_POST['clase'], $_POST['subclase'], $_POST['tipo_doc'], $_POST['filtro_temporalidad'], $_POST['tipo_temporalidad'], $_POST['order_by'] );

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
                
                $servicio_rectec = null;

                break;
                
            case 'get_estadistica_recursos_tecnicos' :

                if(empty($_POST['lista_recursos_restringidos']))
                {     
                    http_response_code(400);                
                    $datos_respuesta = $_respuesta_rectec->error_400('Variable lista_recursos_restringidos Vacia'); 
                    echo json_encode($datos_respuesta);
                }
                
                $servicio_rectec = new RepositorioServicioRecursosTecnicos();
                
                $datos_respuesta = $servicio_rectec->get_estadistica_recursos_tecnicos($_POST['lista_recursos_restringidos'],$_POST['qt'],$_POST['desde'],$_POST['hasta'],$_POST['proyecto'],$_POST['clase'],$_POST['subclase'],
                                                                                       $_POST['tipo_doc'],$_POST['filtro_temporalidad'],$_POST['tipo_temporalidad'],$_POST['si_tengo_que_filtrar'],$_POST['calculo_estadistica']);
                
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
                
                $servicio_rectec = null;

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
    
//}




?>