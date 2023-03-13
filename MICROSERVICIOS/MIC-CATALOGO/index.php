<?php

require_once(dirname(__FILE__).'\CAPA-APLICACION\SERVICIO\REPOSITORIO-SERVICIO.php');
require_once(dirname(__FILE__).'\CAPA-DOMINIO\CLASES\Clases.php');

$_respuesta_catalogo = new Respuesta();


if($_SERVER['REQUEST_METHOD'] == "POST") // si el request es de tipo post
{           
    if(isset($_POST['action']) && !empty($_POST['action'])) // evaluo que contenga la variable action(contiene la funcion a requerir)
    {   
        $datos_respuesta_catalogo; // variable que almacenara la respuesta final. 
        
        // evaluo la variable action. 
        switch ($_POST['action']) 
        {
            case 'get_info_territorio':

                if(isset($_POST['territorio_id']) && !empty($_POST['territorio_id'])) // evaluo que contenga la variable action(contiene la funcion a requerir)
                {
                    $servicio_catalogo = new RepositorioServicioCatalogo();

                    $respuesta_serv_catalogo = $servicio_catalogo->get_info_territorio($_POST['territorio_id']);
                                
                    if($respuesta_serv_catalogo->flag)
                    {

                        http_response_code(200);                
                        $datos_respuesta_catalogo = $_respuesta_catalogo->error_200($respuesta_serv_catalogo->detalle); 
                        echo json_encode($datos_respuesta_catalogo);

                    }else{

                        http_response_code(400);                
                        $datos_respuesta_catalogo = $_respuesta_catalogo->error_400($respuesta_serv_catalogo->detalle); 
                        echo json_encode($datos_respuesta_catalogo);

                    } 
                
                    $servicio_catalogo = null;

                }else{

                    http_response_code(400);                
                    $datos_respuesta_catalogo = $_respuesta_catalogo->error_400('El parametro territorio_id no puede ir vacio.'); 
                    echo json_encode($datos_respuesta_catalogo);

                }
 
            break;

            case 'get_filtros':

                if((isset($_POST['solapa'])) && (is_numeric($_POST['solapa'])) ) // evaluo que contenga la variable action(contiene la funcion a requerir)
                {   

                    $aux_solapa = $_POST['solapa'];

                    $aux_cadena_filtros = '';
                    $aux_lista_rec_restringidos = '';
                    $aux_si_hay_que_filtrar = ''; // este seria un valor booleadno que indica si hay que aplicar filtros o no. 


                    if(isset($_POST['cadena_filtros']) && !empty($_POST['cadena_filtros'])) { $aux_cadena_filtros = $_POST['cadena_filtros']; }

                    if(isset($_POST['recursos_restringidos']) && !empty($_POST['recursos_restringidos'])) { $aux_lista_rec_restringidos = $_POST['recursos_restringidos']; }

                    if(isset($_POST['hay_que_filtrar']) && !empty($_POST['hay_que_filtrar'])) { $aux_si_hay_que_filtrar = $_POST['hay_que_filtrar']; }

                    
                    $servicio_catalogo = new RepositorioServicioCatalogo();

                    $respuesta_serv_catalogo = $servicio_catalogo->get_filtros($aux_solapa,$aux_cadena_filtros,$aux_lista_rec_restringidos, $aux_si_hay_que_filtrar);
                                
                    if($respuesta_serv_catalogo->flag)
                    {

                        http_response_code(200);                
                        $datos_respuesta_catalogo = $_respuesta_catalogo->error_200($respuesta_serv_catalogo->detalle); 
                        echo json_encode($datos_respuesta_catalogo);

                    }else{

                        http_response_code(400);                
                        $datos_respuesta_catalogo = $_respuesta_catalogo->error_400($respuesta_serv_catalogo->detalle); 
                        echo json_encode($datos_respuesta_catalogo);

                    } 
                
                    $servicio_catalogo = null;            

                }else{

                    http_response_code(400);                
                    $datos_respuesta_catalogo = $_respuesta_catalogo->error_400('El parametro Solapa no puede ir vacio.'); 
                    echo json_encode($datos_respuesta_catalogo);

                }
 
            break;                

            default :  
            
                http_response_code(400);                
                $datos_respuesta_catalogo = $_respuesta_catalogo->error_400("Peticion Incorrecta"); 
                echo json_encode($datos_respuesta_catalogo);

            break;
        }      

    } else {

        http_response_code(400);                
        $datos_respuesta_catalogo = $_respuesta_catalogo->error_400("Solicitud Incorrecta"); 
        echo json_encode($datos_respuesta_catalogo);
    }

}else{
    
    http_response_code(400);                
    $datos_respuesta_catalogo = $_respuesta_catalogo->error_400("Solicitud Incorrecta"); 
    echo json_encode($datos_respuesta_catalogo);

}






?>