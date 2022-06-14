<?php
include("./pgconfig.php");
$elemento_id=$_POST['elemento_id'];
$tipo_elemento=$_POST['tipo_elemento'];


$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;	
$conn = pg_connect($string_conn);


class Elemento{
	var $Elemento_Id;
	var $Tipo_Elemento;
 
	public function __construct($Elemento_Id,$Tipo_Elemento){
	  $this->Elemento_Id=$Elemento_Id;
	  $this->Tipo_Elemento=$Tipo_Elemento;
	}
 }

$respuesta=null;
switch ($tipo_elemento) {
    case 'grafico':
        $SQLG="SELECT ind_est.elemento_id as ElementoId FROM mod_indicadores.ind_estudio_asociado ind_est WHERE ind_est.elemento_id=$elemento_id and ind_est.tipo_elemento='1' ";
        $RESULT=pg_query($conn,$SQLG);
        while($row=pg_fetch_row($RESULT)){
            if($row[0]){
                $Objeto=json_decode($row[0]);
                $respuesta=new Elemento($elemento_id,'1');
            }
           
           
        }
        break;
    case 'layer':
        $SQLL="SELECT ind_est.elemento_id FROM mod_indicadores.ind_estudio_asociado ind_est WHERE ind_est.elemento_id=$elemento_id and ind_est.tipo_elemento='2' ";
        $RESULT=pg_query($conn,$SQLL);
        while($row=pg_fetch_row($RESULT)){
            if($row[0]){
                $Objeto=json_decode($row[0]);
                $respuesta=new Elemento($elemento_id,'2');
            }
           
           
        }
        break;
    case 'table':
        /* $respuesta = $elemento_id; */
       // $elemento_id = htmlspecialchars($elemento_id);
    $SQL="SELECT mod_indicadores.ind_tabla.ind_tabla_id FROM mod_indicadores.ind_tabla  WHERE mod_indicadores.ind_tabla.ind_tabla_fuente= '$elemento_id'";
        $result=pg_query($conn,$SQL);
        $ID=NULL;
        while($row=pg_fetch_assoc($result)){
            $ID=$row['ind_tabla_id'];
        }
        $SQLT="SELECT ind_est.elemento_id FROM mod_indicadores.ind_estudio_asociado ind_est WHERE ind_est.elemento_id=$ID and ind_est.tipo_elemento='3' ";
        $RESULT=pg_query($conn,$SQLT);
        while($row=pg_fetch_row($RESULT)){
            if($row[0]){
                $Objeto=json_decode($row[0]);
                $respuesta=new Elemento($ID,'3');
            }
           
           
        }
        break;
    case 'slider': 
        $SQLL="SELECT ind_est.elemento_id FROM mod_indicadores.ind_estudio_asociado ind_est WHERE ind_est.elemento_id=$elemento_id and ind_est.tipo_elemento='4' ";
        $RESULT=pg_query($conn,$SQLL);
        while($row=pg_fetch_row($RESULT)){
            if($row[0]){
                $Objeto=json_decode($row[0]);
                $respuesta=new Elemento($elemento_id,'4');
            }
           
           
        }
        break;
}

echo json_encode($respuesta);


?>