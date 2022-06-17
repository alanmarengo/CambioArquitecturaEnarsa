<?php
require_once('C:/xampp/htdocs/atic/nuevo_repo/CambioArquitecturaEnarsa/MICROSERVICIOS/MIC-CATALOGO/CAPA-APLICACION/SERVICIOS/REPOSITORIO-SERVICIO.php');

class Recurso{
    public $solapa = null;
    public $origen_id = null;
    public $id_recurso = null;
    public $titulo = null;
    public $descripcion = null;
    public $link_imagen = null;
    public $metatag = null;
    public $autores = null;
    public $estudios_id = null;
    public $fecha = null;
    public $tema = null;
    public $ico = null;
    public $estudios=array();
    public $territorio_id = null;
    public $territorio_desc = null;
    public $territorio_fec_bbdd_date = null;
    public $territorio_simpli = null;
    public $territorio_fec_bbdd = null;

    public function __construct($solapa,$origen_id,$id_recurso,$titulo,$descripcion,$link_imagen,$metatag,$autores,$estudios_id,$fecha,$tema,$ico,$territorio_id){
        
        $this->solapa = $solapa;
        $this->origen_id = $origen_id;
        $this->id_recurso = $id_recurso;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->link_imagen = $link_imagen;
        $this->metatag = $metatag;
        $this->autores = $autores;
        $this->estudios_id = $estudios_id;
        $this->fecha = $fecha;
        $this->tema = $tema;
        $this->ico = $ico;
        $this->territorio_id = $territorio_id;
        $this->territorio_desc;
        $this->territorio_fec_bbdd_date;
        $this->territorio_simpli;
        $this->territorio_fec_bbdd;       

        // si id_territorio es distinto de vacio, se llama al metodo para completar la informacion 
        if($territorio_id != null){

            $RepoCatalogo= new RepositorioServicioCatalogo();
            $InfoTerritorio = $RepoCatalogo->get_info_territorio($this->territorio_id);
            
            $this->territorio_desc=$InfoTerritorio[0];
            $this->territorio_fec_bbdd_date=$InfoTerritorio[1];
            $this->territorio_simpli=$InfoTerritorio[2];
            $this->territorio_fec_bbdd=$InfoTerritorio[3];

        } 
    }



    //HOLA JUAN Y PABLO
}

class EstadisticaInicial{
    public $documentos;
    public $recursos_audiovisuales;
    public $recursos_tecnicos;
    public $novedades;

    public function __construct($documentos,$recursos_audiovisuales,$recursos_tecnicos,$novedades){
        $this->documentos = $documentos;
        $this->recursos_audiovisuales = $recursos_audiovisuales;
        $this->recursos_tecnicos = $recursos_tecnicos;
        $this->novedades = $novedades;
    }

}