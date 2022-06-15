<?php

require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-CATALOGO/CAPA-DOMINIO/INTERFACE-QUERYS/REPOSITORIO-INTERFACE-QUERY.php');
require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-CATALOGO/CAPA-DATOS/capa-acceso.php');

class RepositorioQuery implements IRepositorioQuery{

    // metodo para obtener datos del territorio a partir del id 
    public function get_info_territorio($territorio_id)
    {
            //aca instancio a la conexion y hago toda la query y la retorno.
            $conexion = new Conexion();
            $query = 'SELECT t.fec_bbdd_date, t.territorio_simpli,t.fec_bbdd,t.descripcion FROM "MIC-CATALOGO".territorio t WHERE t.territorio_id = '.$territorio_id;

            return $conexion->get_consulta($query);
    }

}

