<?php

require_once('C:/xampp/htdocs/atic/obs_nueva_arq/obs_op/MICROSERVICIOS/MIC-CATALOGO/CAPA-DOMINIO/INTERFACE-QUERYS/REPOSITORIO-INTERFACE-QUERY.php');
require_once('C:/xampp/htdocs/atic/obs_nueva_arq/obs_op/MICROSERVICIOS/MIC-CATALOGO/CAPA-DATOS/capa-acceso.php');

class RepositorioQuery implements IRepositorioQuery{
    public function get_info_territorio($territorio_id){
            //aca instancio a la conexion y hago toda la query y la retorno.
            $conexion = new Conexion();

            //SELECT  from MIC-CATALOGO.Territorio WHERE territorio_id= $territorio_id
            
            $query = 'SELECT t.fec_bbdd_date, t.territorio_simpli,t.fec_bbdd,t.descripcion FROM "MIC-CATALOGO".territorio t WHERE t.territorio_id = '.$territorio_id;

            return $conexion->get_consulta($query);

    }


}

