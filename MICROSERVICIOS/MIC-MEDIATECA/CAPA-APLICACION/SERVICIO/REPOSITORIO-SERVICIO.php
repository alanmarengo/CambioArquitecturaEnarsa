<?php

require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-MEDIATECA/CAPA-DOMINIO/INTERFACE-REPOSITORIO-SERVICIO/INTERFACE-REPOSITORIO-SERVICIO.php');
require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-MEDIATECA/CAPA-APLICACION/QUERY/REPOSITORIO-QUERY.php');
require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-USUARIO/CAPA-APLICACION/SERVICIOS/REPOSITORIO-SERVICIOS.php');
require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-MEDIATECA/CAPA-DOMINIO/ENTIDADES/ENTIDADES.php');

//DESPUES VAMOS A TENER QUE INJECTAR TODOS LOS SERVICIOS DE LOS MICROSERVICIOS: ARTICULOS, ESTADISTICA, GEOVISORES E INDICADORES.




class RepositorioServicioMediateca  implements IRepositorioServicioMediateca
{
    public $query;

    public function __construct(){
        $this->query= new RepositorioQueryMediateca();
    }


    // funcion para traer todos los recursos de la mediateca 
    public function get_Recursos_idUser($user_id, $solapa)
    {
        //UTILIZAR EL METODO DEL USUARIO PARA SABER QUE RECURSOS TIENE RESTRINGIDOS/DENEGADOS.
        $lista_recursos_restringidos = array();
        $servicio_usuario = new RepositorioServicioUsuario();
        $lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos_user($user_id);
        
        //return $lista_recursos_restringidos;
        $recursos_mediateca= $this->query->get_recursos($lista_recursos_restringidos, $solapa); 

        
        $array_recursos_mediateca = array();

        for($x=0; $x<=count($recursos_mediateca)-1; $x++)
        {
            $solapa= $recursos_mediateca[$x]['origen'];
            $origen_id= $recursos_mediateca[$x]['origen_id'];
            $id_recurso= $recursos_mediateca[$x]['origen_id_especifico'];
            $titulo= $recursos_mediateca[$x]['recurso_titulo'];
            $descripcion= $recursos_mediateca[$x]['recurso_desc'];
            $link_imagen= $recursos_mediateca[$x]['recurso_path_url']; 
            $autores= $recursos_mediateca[$x]['recurso_autores']; 
            $fecha= $recursos_mediateca[$x]['recurso_fecha'];
            $territorio_id= $recursos_mediateca[$x]['territorio_id'];
            $estudios_id= $recursos_mediateca[$x]['sub_proyecto_id'];            
            $metatag= $recursos_mediateca[$x]['recurso_categoria_desc'];
            $tema= $recursos_mediateca[$x]['recurso_categoria_desc'];            

            switch ($origen_id)
            {
                case 0:
                    $ico = './images/types/wms.png'; /* GIS */ ; break;
                
                case 2:
                    $ico = './images/types/indicadores.png';/* ESTADISTICA */ ;break;
                    
                case 3:
                    $ico = './images/types/indicadores.png';/* INDICADORES */; break;
                       
                case 4:
                    $ico = './images/types/generico.png';/* ARTICULOS */  ; break;
                           
                case 5:/* RECURSOS */
                    $ico = ''; break;
                default:
                    $ico = './images/types/generico.png'; break;
            }

            $recurso = new Recurso($solapa,$origen_id,$id_recurso,$titulo,$descripcion,$link_imagen,$metatag,$autores,$estudios_id,$fecha,$tema,$ico,$territorio_id);
            array_push($array_recursos_mediateca,$recurso);
        }

        return $array_recursos_mediateca;
                
       
        //$lista_recursos_mediateca = get_recursos($lista_recursos_restringidos, $solapa);

        

        //ACA IDENTIFICO UN FLAG DEL FRONT SI ES QUE DEBO CALCULAR O NO LAS ESTADISTICAS. SI NO LAS DEBO CALCULAR, LAS VOY A BUSCAR A BASE DE DATOS.
        //SI LAS DEBO CALCULAR, DEBO CALCULAR LAS ESTADISTICAS CON LOS FILTROS, TANTO ACA EN MEDIATECA COMO EN LOS DEMAS MICROSERVICIOS.
        //LA ENCARGADA DE DEVOLVER LOS FILTROS Y LAS ESTADISITCAS DE ESOS FILTROS SERA EL MICROSERVICIO CATALOGO

        //aca abajo le pedimos a los otros microservicios sus recursos y estadisticas, en el caso de que la solapa sea la 2 o de que se halla accionado un filtro.




    }

    public function get_Recursos($solapa)
    {
        //UTILIZAR EL METODO DEL USUARIO PARA SABER QUE RECURSOS TIENE RESTRINGIDOS/DENEGADOS.
        $lista_recursos_restringidos = array();
        $servicio_usuario = new RepositorioServicioUsuario();
        $lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos();
        
        //return $lista_recursos_restringidos;
        $recursos_mediateca= $this->query->get_recursos($lista_recursos_restringidos, $solapa); 

        
        $array_recursos_mediateca = array();

        for($x=0; $x<=count($recursos_mediateca)-1; $x++)
        {
            $solapa= $recursos_mediateca[$x]['origen'];
            $origen_id= $recursos_mediateca[$x]['origen_id'];
            $id_recurso= $recursos_mediateca[$x]['origen_id_especifico'];
            $titulo= $recursos_mediateca[$x]['recurso_titulo'];
            $descripcion= $recursos_mediateca[$x]['recurso_desc'];
            $link_imagen= $recursos_mediateca[$x]['recurso_path_url']; 
            $autores= $recursos_mediateca[$x]['recurso_autores']; 
            $fecha= $recursos_mediateca[$x]['recurso_fecha'];
            $territorio_id= $recursos_mediateca[$x]['territorio_id'];
            $estudios_id= $recursos_mediateca[$x]['sub_proyecto_id'];            
            $metatag= $recursos_mediateca[$x]['recurso_categoria_desc'];
            $tema= $recursos_mediateca[$x]['recurso_categoria_desc'];            

            switch ($origen_id)
            {
                case 0:
                    $ico = './images/types/wms.png'; /* GIS */ ; break;
                
                case 2:
                    $ico = './images/types/indicadores.png';/* ESTADISTICA */ ;break;
                    
                case 3:
                    $ico = './images/types/indicadores.png';/* INDICADORES */; break;
                       
                case 4:
                    $ico = './images/types/generico.png';/* ARTICULOS */  ; break;
                           
                case 5:/* RECURSOS */
                    $ico = ''; break;
                default:
                    $ico = './images/types/generico.png'; break;
            }

            $recurso = new Recurso($solapa,$origen_id,$id_recurso,$titulo,$descripcion,$link_imagen,$metatag,$autores,$estudios_id,$fecha,$tema,$ico,$territorio_id);
            array_push($array_recursos_mediateca,$recurso);
        }

        return $array_recursos_mediateca;
                

    }
    
    


}


$obtener_recursos_mediateca = new RepositorioServicioMediateca();
print_r($obtener_recursos_mediateca->get_recursos(0));
print_r($obtener_recursos_mediateca->get_Recursos_idUser(10,0));






