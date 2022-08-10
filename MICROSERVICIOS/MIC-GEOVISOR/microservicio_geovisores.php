<?php
require_once 'CAPA-APLICACION/SERVICIOS/REPOSITORIO-SERVICIO.php';
// archivo de evaluacion de peticiones POST
// Este archivo sera el encargado las nueva peticiones post que reciba la pagina,
// verificara la consistencia de los datos recibidos y llamara a los metodos necesarios segun corresponda a la peticion requerida 
// todas las peticiones, de ahora en mas deberan adicionar una variable llamada "action" donde se especificara 
// el metodo requerido del micoservicio Geovisores

// verifica usuario_id en la variable session y si no exitiste, user_id = -1, que corresponde al usuario publico.


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

} else {
    
    echo "No hay nada para Mostrar.";
}
 





?>