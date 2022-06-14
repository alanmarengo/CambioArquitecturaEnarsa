<?php
$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
$conn = pg_connect($string_conn);	
class Estudios{
	var $Estudio;
	var $Estudio_ID;
 
	public function __construct($Estudio,$Estudio_ID){
	  $this->Estudio=$Estudio;
	  $this->Estudio_ID=$Estudio_ID;
	}
 }
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

class Record{
      var $solapa;
	  var $origen_id;
	  var $Id;
	  var $Titulo;
	  var $Descripcion;
	  var $LinkImagen;
	  var $MetaTag;
	  var $Autores;
	  var $estudios_id;
	  var $fecha;
	  var $tema;
	  var $ico;
	  var $estudios=array();
	  

	  public function __construct($solapa, $origen_id,$Id,$Titulo,$Descripcion,$LinkImagen,$MetaTag,$Autores,$estudio_id,$fecha,$tema,$ico)
    {
        $this->Solapa = $solapa;
        $this->origen_id = $origen_id;
		$this->Id=$Id;
		$this->Titulo=$Titulo;
		$this->Descripcion=$Descripcion;
		$this->LinkImagen=$LinkImagen;
		$this->MetaTag=$MetaTag;
		$this->Autores=$Autores;
		$this->estudios_id=$estudio_id;
		$this->fecha=$fecha;
		$this->tema=$tema;
		$this->ico=$ico;
		$this->estudios=Get_Estudios_Y_Relleno_de_Coleccion($this->Id);
    }
}
?>