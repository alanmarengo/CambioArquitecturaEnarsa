<?php


require_once(dirname(__FILE__,4).'\MIC-GEOVISOR\CAPA-DOMINIO\INTERFACE-REPOSITORIO-SERVICIO\INTERFACE-REPOSITORIO-SERVICIO.php');
require_once(dirname(__FILE__,4).'\MIC-GEOVISOR\CAPA-APLICACION\QUERYS\REPOSITORIO-QUERY.php');
require_once(dirname(__FILE__,4).'\MIC-USUARIO\CAPA-APLICACION\SERVICIO\REPOSITORIO-SERVICIO.php');


class RepositorioServicioGeovisor implements IRepositorioServicioGeovisor{

    public $servicio_usuario;
    public $query;
    
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

        for($x=0; $x<=count($lista_recursos_restringidos->detalle)-1; $x++)
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

    public function DrawComboSimpleClase($id,$desc,$schema,$table,$opini,$opini_label,$opini_val,$hname,$hid){
        return $this->query->DrawComboSimpleClase($id,$desc,$schema,$table,$opini,$opini_label,$opini_val,$hname,$hid);
    }

    public function GetLayerLabel($layer_name){
        return $this->query->GetLayerLabel($layer_name);
    }

    public function filter_proyectos_basic($user_id, $proyectos, $geovisor)
    {
        $lista_recursos_restringidos = array(); 

        if($user_id!=-1){
            $lista_recursos_restringidos = $this->servicio_usuario->get_recursos_restringidos_user($user_id);
        }else{
            $lista_recursos_restringidos = $this->servicio_usuario->get_recursos_restringidos();
        }

        return $this->query->filter_proyectos_basic($lista_recursos_restringidos->detalle, $proyectos, $geovisor);

    }

    public function filter_proyectos_advanced($user_id, $adv_search_busqueda, $adv_search_fdesde, $adv_search_fhasta,
                                              $adv_search_proyecto_combo, $adv_search_clase_combo, $adv_search_subclase_combo, 
                                              $adv_search_responsable_combo, $adv_search_esia_combo, $adv_search_objeto_combo, $geovisor){
   
        $lista_recursos_restringidos = array(); 

        if($user_id != -1){
            $lista_recursos_restringidos = $this->servicio_usuario->get_recursos_restringidos_user($user_id);
        }else{
            $lista_recursos_restringidos = $this->servicio_usuario->get_recursos_restringidos();
        }

        return $this->query->filter_proyectos_advanced($lista_recursos_restringidos, $adv_search_busqueda, $adv_search_fdesde, $adv_search_fhasta, 
                                                       $adv_search_proyecto_combo, $adv_search_clase_combo, $adv_search_subclase_combo, 
                                                       $adv_search_responsable_combo, $adv_search_esia_combo, $adv_search_objeto_combo, $geovisor );

    }

    public function get_layer_extent($layer_id)
    {
        return $this->query->get_layer_extent($layer_id);
    }

    public function get_coor_transformed($lon, $lat){
        return $this->query->get_coor_transformed($lon, $lat);
    }

    public function get_medicion($wkt, $type){
        return $this->query->get_medicion($wkt, $type);
    }

    public function get_buffer($wkt, $layers){
        return $this->query->get_buffer($wkt, $layers);
    }

    public function get_layer_preview($layer_id){
        return $this->query->get_layer_preview($layer_id);
    }
    
    public function get_layer_info_pgda(){

        return $this->query->get_layer_info_pgda();
    }

    public function ComboSubclase($clase_id){
        return $this->query->ComboSubclase($clase_id);
    }

    public function carrusel_represas($represa){
        return $this->query->carrusel_represas($represa);
    }
    

}               	

//$test = new RepositorioServicioGeovisor();
//$test->ListaProyectos();
//echo $test->Get_Layer_Security("", 36453);
// $valor = $test->DrawContainers();
// echo $valor;
//$test->DrawLayersSearch("holamundo");

//echo $test->DrawDatasetSearch("hola mundo");

//test implementacion filter_proyectos_advanced
/*
$test->filter_proyectos_advanced($user_id, $adv_search_busqueda, $adv_search_fdesde, $adv_search_fhasta,
                                $adv_search_proyecto_combo, $adv_search_clase_combo, $adv_search_subclase_combo, 
                                $adv_search_responsable_combo, $adv_search_esia_combo, $adv_search_objeto_combo, $geovisor);

*/

//$test = new RepositorioServicioGeovisor();

// teste filtro $adv_search_busqueda
//$test->filter_proyectos_advanced(-1, "represa",'', '','', '', '','', '', '', 1);

// test filtro $adv_search_fdesde, $adv_search_fhasta, siempre van juntos 
//$test->filter_proyectos_advanced(-1, "",'10/08/2022', '15/08/2022','', '', '','', '', '', 1); 
 

// test filtro 
//$test->filter_proyectos_advanced(-1, "",'', '','', '', '','', '', '', 1); 

// test filtro 
//$test->filter_proyectos_advanced(-1, "represa",'', '','', '', '','', '', '', 1); 

// test filtro 
//$test->filter_proyectos_advanced(-1, "represa",'', '','', '', '','', '', '', 1); 

// test filtro 
//$test->filter_proyectos_advanced(-1, "represa",'', '','', '', '','', '', '', 1); 

// test filtro 
//$test->filter_proyectos_advanced(-1, "represa",'', '','', '', '','', '', '', 1); 

// test filtro 
//$test->filter_proyectos_advanced(-1, "represa",'', '','', '', '','', '', '', 1); 

// test filtro 
//$test->filter_proyectos_advanced(-1, "represa",'', '','', '', '','', '', '', 1); 