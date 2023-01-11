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


 class Noticia_mediateca{

    private $path_img;
    private $titulo;
    private $fecha;           
    private $path_pdf;           
    private $desc;            
    private $fecha_inicial; 
    
    public function __construct($path_img,$titulo,$fecha,$path_pdf,$desc,$fecha_inicial){

      $this->path_img = $path_img;            
      $this->titulo = $titulo;             
      $this->fecha = $fecha;           
      $this->path_pdf = $path_pdf;           
      $this->desc = $desc;            
      $this->fecha_inicial = $fecha_inicial; 
    }
  
 }

?>