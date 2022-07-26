<?php
require_once(dirname(__FILE__,4).'\MIC-GEOVISOR\CAPA-DOMINIO\INTERFACE-REPOSITORIO-QUERY\INTERFACE-REPOSITORIO-QUERY.php');
require_once(dirname(__FILE__,4).'\MIC-GEOVISOR\CAPA-DATOS\capa-acceso.php');

//reemplazar los paths aboslutos por la nueva y linda forma que encontramos


class RepositorioQueryGeovisor implements IRepositorioQueryGeovisor{

	/*
	public $consulta_principal;

	public function _construct(){

		$this->consulta_principal=  'SELECT c.origen, c.origen_id, c.origen_id_especifico, c.origen_search_text, 
										c.subclase_id, c.estudios_id, c.cod_esia_id, c.cod_temporalidad_id, 
										c.objetos_id, ce.cap AS esia_cap, ce.titulo AS esia_titulo, 
										ce.orden_esia AS esia_orden_esia, ce.ruta AS esia_ruta, 
										ce.cod_esia AS esia_cod_original, e.estudios_palabras_clave, 
										e.sub_proyecto_id, e.estudio_estado_id, e.nombre, e.fecha, e.institucion, 
										e.responsable, e.equipo, e.cod_oficial, e.descripcion, 
										e.fecha_text_original, e.institucion_id, e.sub_proyecto_desc, e.proyecto_id, 
										e.proyecto_desc, e.proyecto_extent, e.institucion_nombre, e.institucion_tel, 
										e.institucion_contacto, e.institucion_email, t.cod_temp, 
										t.desde AS tempo_desde, t.hasta AS tempo_hasta, t.descripcion AS tempo_desc, 
										sc.clase_id, sc.subclase_desc, sc.subclase_cod, sc.estado_subclase, 
										sc.cod_unsubclase, sc.descripcio, sc.cod_nom, sc.fec_bbdd, cs.clase_desc
									FROM mod_geovisores.catalogo c
									LEFT JOIN mod_catalogo.vw_estudio e ON c.estudios_id = e.estudios_id
									LEFT JOIN mod_catalogo.cod_esia ce ON ce.cod_esia_id = c.cod_esia_id
									LEFT JOIN mod_catalogo.cod_temporalidad t ON t.cod_temporalidad_id = c.cod_temporalidad_id
									LEFT JOIN mod_catalogo.subclase sc ON sc.subclase_id = c.subclase_id
									LEFT JOIN mod_catalogo.clase cs ON cs.clase_id = sc.clase_id;';
	}

	*/


    public function ListaProyectos()
	{
		// NOTA IMPORTANTE: por el momento la tabla Proyectos no exite en MIC-GEOVISORES porque tampoco existe en la bd AHRSC
		// por lo que aparentemente esa tabla existe en la base de datos de produccion nada mas 
		// una vez se replique esa tabla a la bd la funcion se ejecutara correctamente .
        $query_string = 'SELECT proyecto_id,proyecto_titulo FROM "MIC-GEOVISORES".proyectos ORDER BY proyecto_titulo ASC'; 

		$conexion = new ConexionGeovisores();        
        //realizo la consulta            
        $consulta = $conexion->get_consulta($query_string);   	

		 // recorro el arreglo con los datos de la consulta 
		for($x=0; $x<=count($consulta)-1; $x++)
		{  
			?>

			<a class="dropdown-item" href="#" data-id="<?php echo  $consulta[$x]["proyecto_id"]; ?>"><?php echo  $consulta[$x]["proyecto_titulo"]; ?></a>          
		
			<?php 
		}
	
		
	}

}

