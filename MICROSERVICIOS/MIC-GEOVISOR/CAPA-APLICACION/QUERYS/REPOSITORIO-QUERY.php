<?php
require_once('C:/xampp/htdocs/atic/obs_nueva_arq/obs_op/MICROSERVICIOS/MIC-GEOVISOR/CAPA-DOMINIO/INTERFACE-QUERYS/REPOSITORIO-INTERFACE-QUERY.php');
require_once('C:/xampp/htdocs/atic/obs_nueva_arq/obs_op/MICROSERVICIOS/MIC-GEOVISOR/CAPA-DATOS/capa-acceso.php');

//reemplazar los paths aboslutos por la nueva y linda forma que encontramos


class RepositorioQueryGeovisor implements IRepositorioQueryGeovisor{


    public function ListarProyectos(){

        $query_string = "SELECT proyecto_id,proyecto_titulo FROM mod_geovisores.proyectos ORDER BY proyecto_titulo ASC";
	
	    $query = pg_query($conn,$query_string);
	
	    while ($r = pg_fetch_assoc($query)) {
		
		?>
		
		<a class="dropdown-item" href="#" data-id="<?php echo $r["proyecto_id"]; ?>"><?php echo $r["proyecto_titulo"]; ?></a>
		
		<?php
		
	}


    }

}