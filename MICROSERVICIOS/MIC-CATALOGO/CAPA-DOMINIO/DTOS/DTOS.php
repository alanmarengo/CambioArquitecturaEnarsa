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


class Estudio{

	var $Estudio;
	var $Estudio_ID;
 
	public function __construct($Estudio,$Estudio_ID){
	  $this->Estudio=$Estudio;
	  $this->Estudio_ID=$Estudio_ID;
	}
}


//NO HACER LA MISMA QUERY, REALIZAR QUERY MAS OPTIMA DIRECTAMENTE A MIC CATALOGO.ESTUDIOS
//CREAR ESTE METODO EN : SERVICIO CATALOGO, INTERFAZ SERVVICIO, SERVICIO QUERY, INTERFACE SERVICIO QUERY.
/*
function Get_Estudios_Y_Relleno_de_Coleccion($CAPAID)
{
	global $conn;
	$Array_Estudios=array();
    $SQLESTUDIOS="SELECT DISTINCT(CES.nombre) as Estudio,CES.estudios_id as Estudio_ID FROM mod_geovisores.catalogo as GCA INNER JOIN mod_catalogo.estudios as CES ON CES.estudios_id=GCA.estudios_id WHERE GCA.origen_id_especifico=$CAPAID";
	$SQLAUXILIAR = "SELECT row_to_json(T)::text AS r FROM ($SQLESTUDIOS)T";
    $RESULT=pg_query($conn,$SQLAUXILIAR);
	while($row=pg_fetch_row($RESULT)){
		$Objeto=json_decode($row[0]);
		$record= new Estudios($Objeto->estudio,$Objeto->estudio_id);
		array_push($Array_Estudios,$record);
	}
	return $Array_Estudios;
}
 */
