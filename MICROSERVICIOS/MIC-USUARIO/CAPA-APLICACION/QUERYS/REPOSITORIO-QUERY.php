<?php

require_once('C:/xampp/htdocs/atic/obs_nueva_arq/obs_op/MICROSERVICIOS/MIC-USUARIO/CAPA-DOMINIO/INTERFACE-QUERYS/REPOSITORIO-INTERFACE-QUERY.php');
require_once('C:/xampp/htdocs/atic/obs_nueva_arq/obs_op/MICROSERVICIOS/MIC-USUARIO/CAPA-DATOS/capa-acceso.php');



class RepositorioQueryUsuario implements IRepositorioQueryUsuario{

    public function get_recursos_id(){
        // abro la conexion
        $conexion = new Conexion();
        // realizo la consulta y la ejecuto
        $query = 'SELECT p.objeto_id FROM "MIC-USUARIO".permisos as p;';
        //solo traes objetos_id        
        //retorno un fetch_row o fetch_assoc        
        return $conexion->get_consulta($query); // resultado, array assoc de los archivos bloqueados 
    }

    public function get_recursos_id_user($user_id){
        // abro la conexion
        $conexion = new Conexion();

        $query = 'SELECT pe.objeto_id
                  FROM "MIC-USUARIO".permisos as pe
                  WHERE pe.perfil_usuario_id != (SELECT pu.perfil_usuario_id 
                                                 FROM "MIC-USUARIO".user_data as ud 
                                                 LEFT JOIN "MIC-USUARIO".perfil_usuario as pu ON ud.perfil_usuario_id = pu.perfil_usuario_id 
                                                 WHERE ud.user_id ='.$user_id.')';
        
        return $conexion->get_consulta($query); // resultado, array assoc de los archivos bloqueados 
    }


}
