<?php
require_once 'CAPA-APLICACION/SERVICIOS/REPOSITORIO-SERVICIO.php';
// archivo de evaluacion de peticiones POST
// Este archivo sera el encargado las nueva peticiones post que reciba la pagina,
// verificara la consistencia de los datos recibidos y llamara a los metodos necesarios segun corresponda a la peticion requerida 
// todas las peticiones, de ahora en mas deberan adicionar una variable llamada "action" donde se especificara 
// el metodo requerido del micoservicio Geovisores

// verifica usuario_id en la variable session y si no exitiste, user_id = -1, que corresponde al usuario publico.
 $_POST['action'] = "get_medicion";
 $_POST["type"] = "LineString";
 $_POST["wkt"] = 1000;

if (isset($_POST) && !empty($_POST['action'])) // verifica que existan las variables $_POST y action
{

    // se evalua el tipo de usuario
	if ( (!empty($_SESSION)) && (!empty($_SESSION["user_info"]["user_id"]))) 
    {
        $user_id = $_SESSION["user_info"]["user_id"];

    }else $user_id = -1 ; /* usuario publico, no hay perfil */


    // -- a partir de esta parte, se definiran todos los metodos para implementacion


    //echo $test->filter_proyectos_basic("", [5,3,9,1,8,2,4], -1);

    if($_POST['action'] == 'filter-proyectos-basic')    
    {
       if(!empty($_POST['proyectos']) && !empty($_POST['geovisor']))
       {
        //echo $_POST['proyectos']."  ".$_POST['geovisor'];

        $array_proyectos = array();
        $array_proyectos = json_decode($_POST['proyectos']);

        $servicio_geovisor = new RepositorioServicioGeovisor;

        echo $servicio_geovisor->filter_proyectos_basic($user_id,  $array_proyectos, $_POST['geovisor']);

        // vaciamos el objeto servicio_geovisor
        $servicio_geovisor = null; 

       }         
    }

    if($_POST['action'] == 'filter-proyectos-advanced')    
    {
       if(!empty($_POST['geovisor']))
       {
        //echo".$_POST['geovisor'];
        
        $servicio_geovisor = new RepositorioServicioGeovisor;
    
        echo $servicio_geovisor->filter_proyectos_advanced($user_id, $_POST["adv-search-busqueda"], $_POST["adv-search-fdesde"], 
                                                           $_POST["adv-search-fhasta"],$_POST["adv-search-proyecto-combo"], $_POST["adv-search-subclase-combo"],
                                                           $_POST["adv-search-responsable-combo"], $_POST["adv-search-esia-combo"],
                                                           $_POST["adv-search-objeto-combo"], $_POST["geovisor"]);

        // vaciamos el objeto servicio_geovisor
        $servicio_geovisor = null; 

       }         
    }

    if($_POST['action'] == 'get_layer_extent')
    {
        if(!empty($_POST["layer_id"]))
        {

            $servicio_geovisor = new RepositorioServicioGeovisor;

            echo $servicio_geovisor->get_layer_extent($_POST['layer_id']);
    
            // vaciamos el objeto servicio_geovisor
            $servicio_geovisor = null; 

        }
    }   

    if($_POST['action'] == 'get_coord_transformed')
    {
       if(!empty($_POST["lon"]) &&  !empty($_POST["lat"]))
       {
           $servicio_geovisor = new RepositorioServicioGeovisor;           

           echo $servicio_geovisor->get_coord_transformed($_POST["lon"],$_POST["lat"]);

           // vaciamos el objeto servicio_geovisor
           $servicio_geovisor = null; 

       }
    }

    if($_POST['action'] == 'get_medicion')
    {
        if(!empty($_POST["wkt"]) && !empty($_POST["type"]))
        {
            $servicio_geovisor = new RepositorioServicioGeovisor;           

            echo $servicio_geovisor->get_medicion($_POST["wkt"],$_POST["type"]);
 
            // vaciamos el objeto servicio_geovisor
            $servicio_geovisor = null; 
 
        }
    }

    if($_POST['action'] == 'get_buffer')
    {
        if(!empty($_POST["wkt"]) && !empty($_POST["layers"]))
        {
            $servicio_geovisor = new RepositorioServicioGeovisor;           

            echo $servicio_geovisor->get_buffer($_POST["wkt"],$_POST["layers"]);
 
            // vaciamos el objeto servicio_geovisor
            $servicio_geovisor = null; 
 
        }
    }





} else {
    
    echo "No hay nada para Mostrar.";
}
 





?>