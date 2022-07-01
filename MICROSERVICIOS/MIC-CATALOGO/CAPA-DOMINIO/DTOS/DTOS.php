<?php

class FiltroDTO{
   public $filtro_nombre;
   public $filtro_id;
   public $valor_id;
   public $valor_desc;
   public $total;
   public $parent_valor_id;

   public function __construct($filtro_nombre,$filtro_id,$valor_id,$valor_desc,$total,$parent_valor_id){
    $this->filtro_nombre=$filtro_nombre;
    $this->filtro_id=$filtro_id;
    $this->valor_id=$valor_id;
    $this->valor_desc=$valor_desc;
    $this->parent_valor_id=$parent_valor_id;
    $this->total=$total;

   }
 
}