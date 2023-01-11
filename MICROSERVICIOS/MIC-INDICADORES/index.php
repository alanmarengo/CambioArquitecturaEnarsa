<?php


//if($_SERVER['REQUEST_METHOD'] == "POST") // si el request es de tipo post
//{           
    if(isset($_POST['action']) && !empty($_POST['action'])) // evaluo que contenga la variable action(contiene la funcion a requerir)
    {   
        $datos_respuesta; // variable que almacenara la respuesta final. 
        
        // evaluo la variable action. 
        switch ($_POST['action']) 
        {
            case 'solicitud_servicio':
 
                break;

            default :                
                http_response_code(400);
                echo 'Peticion Incorrecta';
            break;
        }      

    } else {

        http_response_code(200);
        echo 'Peticion Incorrecta';
    }
//}

echo md5("admin24560861");




?>