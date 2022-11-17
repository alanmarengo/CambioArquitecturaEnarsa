<?php
require_once(dirname(__FILE__,4).'\MIC-USUARIO\CAPA-DOMINIO\INTERFACE-REPOSITORIO-QUERY\INTERFACE-REPOSITORIO-QUERY.php');
require_once(dirname(__FILE__,4).'\MIC-USUARIO\CAPA-DATOS\capa-acceso.php');



class RepositorioQueryUsuario implements IRepositorioQueryUsuario{

    public function get_recursos_id(){
        // instancio la conexion
        $conexion = new ConexionUsuario();
        // realizo la consulta y la ejecuto
        $query = 'SELECT p.objeto_id FROM "MIC-USUARIO".permisos as p;';
        
        //retorno un fetch_row o fetch_assoc        
        return $conexion->get_consulta($query); // resultado, array assoc de los archivos bloqueados 
    }

    public function get_recursos_id_user($user_id){
        // instancio la conexion
        $conexion = new ConexionUsuario();

        $query = 'SELECT pe.objeto_id
                  FROM "MIC-USUARIO".permisos as pe
                  WHERE pe.perfil_usuario_id != (SELECT pu.perfil_usuario_id 
                                                 FROM "MIC-USUARIO".user_data as ud 
                                                 LEFT JOIN "MIC-USUARIO".perfil_usuario as pu ON ud.perfil_usuario_id = pu.perfil_usuario_id 
                                                 WHERE ud.user_id ='.$user_id.')';
        
        return $conexion->get_consulta($query); // resultado, array assoc de los archivos bloqueados 
    }
    
    public function login($user_name,$user_pass)
    {   
        // se instancia una nueva clase de conexion
        $conexion = new ConexionUsuario();

        // primeramente se verifica que el usuario exista y no este dado de baja 
        $query_usuario = $conexion->conect->prepare('SELECT 1 FROM "MIC-USUARIO".user_data as ud WHERE ud.user_name = :user AND ud.user_estado_id=1 ;');
        $query_usuario->bindParam(':user', $user_name, PDO::PARAM_STR);
        $query_usuario->execute();
        $resultado_user = $query_usuario->fetchAll();

        if($resultado_user) // cumplida esa condicion, se evalua la constraseña 
        {
            // se crea la consulta definitiva, se escapan los caracteres
            // como en la plataforma actual, la contraseña se cifra bajo MD5
            $query_pass = $conexion->conect->prepare('SELECT * FROM "MIC-USUARIO".user_data as ud WHERE ud.user_name = :user AND ud.user_pass LIKE md5(:pass) ;'); 
            $query_pass->bindParam(':user', $user_name, PDO::PARAM_STR);
            $query_pass->bindParam(':pass', $user_pass, PDO::PARAM_STR);
            $query_pass->execute();
            $resultado_pass = $query_pass->fetchall(PDO::FETCH_ASSOC);

            if($resultado_pass) // en caso de verificar que la clave sea correcta, se devuelven las credenciales del usuario 
            {
                echo json_encode($resultado_pass); // una vez configurada la API, se configurara la respuesta. por el momento devuelve  las credenciales del user

            }else{
                
                echo "Constraseña Incorrecta";
            }

        }else{
            
            echo "Usuario Inexistente";
        }
        
    }

}

