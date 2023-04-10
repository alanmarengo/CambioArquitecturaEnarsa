<?php

require_once(dirname(__FILE__,4).'/MIC-INDICADORES/CAPA-DOMINIO/INTERFACE-SERVICIOS/REPOSITORIO-INTERFACE-SERVICIO.php');
require_once(dirname(__FILE__,4).'/MIC-INDICADORES/CAPA-APLICACION/QUERYS/REPOSITORIO-QUERY.php');
require_once(dirname(__FILE__,4).'/MIC-USUARIO/CAPA-APLICACION/SERVICIO/REPOSITORIO-SERVICIO.php');

class RepositorioServicioIndicadores implements IRepositorioServicioIndicadores{

    public $query;

    public function __construct(){
        $this->query= new RepositorioQueryIndicadores();
    }
    
    public function DrawAbrInd($user_id)
    {         
        $lista_recursos_restringidos = array();
        $servicio_usuario = new RepositorioServicioUsuario();
        
        if(empty($user_id)){ $user_id = -1; } // si el id de usuario viene vacio, se le pone -1.

        if($user_id!=-1){ //se obtiene la lista de recursos restringidos para cada usuario dependiento de su id.
            $lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos_user($user_id);
        }else{
            $lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos();
        }    
        
        return $this->query->DrawAbrInd($lista_recursos_restringidos);

    } // fin DrawAbrInd

    public function DrawContainersInd($user_id)
    {
        $lista_recursos_restringidos = array();
        $servicio_usuario = new RepositorioServicioUsuario();
        
        if(empty($user_id)){ $user_id = -1; } // si el id de usuario viene vacio, se le pone -1.

        if($user_id!=-1){ //se obtiene la lista de recursos restringidos para cada usuario dependiento de su id.
            $lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos_user($user_id);
        }else{
            $lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos();
        }    
        
        return $this->query->DrawContainersInd($lista_recursos_restringidos);
    } // fin DrawContainersInd

    public function DrawIndicadores($user_id,$clase_id)
    {
        $lista_recursos_restringidos = array();
        $servicio_usuario = new RepositorioServicioUsuario();
        
        if(empty($user_id)){ $user_id = -1; } // si el id de usuario viene vacio, se le pone -1.

        if($user_id!=-1){ //se obtiene la lista de recursos restringidos para cada usuario dependiento de su id.
            $lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos_user($user_id);
        }else{
            $lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos();
        }    
        
        return $this->query->DrawIndicadores($lista_recursos_restringidos,$clase_id);
    } // fin DrawContainersInd

    public function DrawIndicadoresSearch($user_id,$pattern)
    {
        $lista_recursos_restringidos = array();
        $servicio_usuario = new RepositorioServicioUsuario();
        
        if(empty($user_id)){ $user_id = -1; } // si el id de usuario viene vacio, se le pone -1.

        if($user_id!=-1){ //se obtiene la lista de recursos restringidos para cada usuario dependiento de su id.
            $lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos_user($user_id);
        }else{
            $lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos();
        }    
        
        return $this->query->DrawIndicadoresSearch($lista_recursos_restringidos,$pattern);
        
    } // fin DrawIndicadoresSearch

    public function ComboCruce(){
        $this->query->ComboCruce();
    }

}


//$test = new RepositorioServicioIndicadores();

//$test->DrawAbrInd(-1);
//$test->DrawContainersInd(-1);