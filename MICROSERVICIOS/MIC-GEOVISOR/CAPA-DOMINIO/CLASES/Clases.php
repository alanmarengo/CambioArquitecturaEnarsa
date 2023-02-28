<?php

class Respuesta_geovisor{

  private $response = [
      'status' => "ok",
      'result' => array()
  ];

  public function error_405(){
      $this->response['status'] = 'error';
      $this->response['result'] = array(
          "error_id" => "405",
          "error_msg" => "Solicitud no Admitida"
      );

      return $this->response;
  }

  public function error_200($string = ""){
      $this->response['status'] = 'success';
      $this->response['result'] = array(
          "error_id" => "200",
          "error_msg" => $string
      );

      return $this->response;
  }

  public function error_400($string){
      $this->response['status'] = 'error';
      $this->response['result'] = array(
          "error_id" => "400",
          "error_msg" => "$string"
      );

      return $this->response;
  }
}

Class respuesta_error_geovisor{
  public $flag;
  public $detalle;
}




class Imagen{ // clase para guardar la info de las imagenes 
	var $recurso_id;
    var $recurso_desc;
    var $presa;
    var $recurso_path_url;
    var $recurso_fecha;
	var $formato_id;
 
	public function __construct($recurso_id,$recurso_desc,$presa,$recurso_path_url,$recurso_fecha,$formato_id){
	  $this->recurso_id=$recurso_id;
      $this->recurso_desc=$recurso_desc;
      $this->presa=$presa;
      $this->recurso_path_url=$recurso_path_url;
      $this->recurso_fecha=$recurso_fecha;
      $this->formato_id=$formato_id;
	}
 }

?>