<?php

require_once(dirname(__FILE__).'\CAPA-APLICACION\SERVICIO\REPOSITORIO-SERVICIO.php'); // Implementamos la interfaz de servicio del microservicio

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
                    if(!empty($_POST['clave']))
                    {
                        $servicio_usuario = new RepositorioServicioUsuario();
                        $respuesta = $servicio_usuario->login($_POST['usuario'],$_POST['clave']);

                        if($respuesta->flag)
                        {
                            print_r($respuesta);

                        }else{
                            
                            http_response_code($respuesta->response_code);
                            print_r($respuesta);

                        }

                    }else{

                        http_response_code(400);
                        echo 'Variable Clave Vacia';

                    }

                }else{  

                    http_response_code(400);
                    echo 'Variable Usuario Vacia';
                }

                break;

            default :                
                http_response_code(400);
                echo 'Peticion Incorrecta';
            break;
        }      

    } else {

        http_response_code(400);
        echo 'Peticion Incorrecta';
    }
}else {

    http_response_code(400);
    echo 'Peticion Incorrecta';
}






?>