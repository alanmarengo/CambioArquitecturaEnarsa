<?php

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