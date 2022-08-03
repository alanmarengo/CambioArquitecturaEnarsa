<?php

// (dirname(__FILE__,4).'\MIC-MEDIATECA\CAPA-DOMINIO\INTERFACE-REPOSITORIO-SERVICIO\INTERFACE-REPOSITORIO-SERVICIO.php')
require_once(dirname(__FILE__,4).'\MIC-GEOVISOR\CAPA-DOMINIO\INTERFACE-REPOSITORIO-SERVICIO\INTERFACE-REPOSITORIO-SERVICIO.php');
require_once(dirname(__FILE__,4).'\MIC-GEOVISOR\CAPA-APLICACION\QUERYS\REPOSITORIO-QUERY.php');
require_once(dirname(__FILE__,4).'\MIC-USUARIO\CAPA-APLICACION\SERVICIOS\REPOSITORIO-SERVICIOS.php');


//INJECTAR MICROSERVICIO USUARIO

class RepositorioServicioGeovisor implements IRepositorioServicioGeovisor{

    public $servicio_usuario;
    public $query;
    //lo mismo con la querry


    public function __construct(){
        $this->servicio_usuario=new RepositorioServicioUsuario();
        $this->query= new RepositorioQueryGeovisor();
    }
    
    public function Get_Layer_Security($user_id, $layer_id)
    {

        $lista_recursos_restringidos = array(); 

        if(empty($user_id)){ $user_id = -1; } // si el id de usuario viene vacio, se le pone -1.

        if($user_id!=-1){
            $lista_recursos_restringidos = $this->servicio_usuario->get_recursos_restringidos_user($user_id);
        }else{
            $lista_recursos_restringidos = $this->servicio_usuario->get_recursos_restringidos();
        }

        for($x=0; $x<=count($lista_recursos_restringidos)-1; $x++)
        {
           if($lista_recursos_restringidos[$x]['objeto_id'] == $layer_id)
           {
               return true;
           }            
        }
        return false;
    }   

    public function ListaProyectos(){
        return $this->query->ListaProyectos();
    }

    public function DrawAbr() 
    {               
        return $this->query->DrawAbr();        
    }

    public function DrawContainers(){
        return $this->query->DrawContainers();
    }
    
    public function DrawLayers($clase_id){
        return $this->query->DrawLayers($clase_id);
    }

    public function DrawLayersSearch($pattern){
        return $this->query->DrawLayersSearch($pattern);
    }

    public function DrawDatasetSearch($pattern){
        return $this->query->DrawDatasetSearch($pattern);
    }

    public function DrawProyectos(){
        return $this->query->DrawProyectos();
    }

    public function DrawComboSimple($id,$desc,$schema,$table,$opini,$opini_label,$opini_val,$hname,$hid){
        return $this->query->DrawComboSimple($id,$desc,$schema,$table,$opini,$opini_label,$opini_val,$hname,$hid);
    }

    public function DrawComboSimpleFN($id,$desc,$schema,$table,$opini,$opini_label,$opini_val,$hname,$hid,$fn){
        return $this->query->DrawComboSimpleFN($id,$desc,$schema,$table,$opini,$opini_label,$opini_val,$hname,$hid,$fn);
    }



}


$test = new RepositorioServicioGeovisor();
//$test->ListaProyectos();
//echo $test->Get_Layer_Security("", 36453);
// $valor = $test->DrawContainers();
// echo $valor;
//$test->DrawLayersSearch("holamundo");

//echo $test->DrawDatasetSearch("hola mundo");
echo $test->DrawProyectos();