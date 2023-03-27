<?php
require_once(dirname(__FILE__,4).'/MIC-CATALOGO/CAPA-APLICACION/SERVICIO/REPOSITORIO-SERVICIO.php');

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
    public $ico = './images/types/generico.png';
    public $estudios=array();
    public $territorio_id = null;
    public $territorio_desc = null;
    public $territorio_fec_bbdd_date = null;
    public $territorio_simpli = null;
    public $territorio_fec_bbdd = null;

    public function __construct($solapa,$origen_id,$id_recurso,$titulo,$descripcion,$link_imagen,$metatag,$autores,$estudios_id,$fecha,$tema,$territorio_id){
        
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
        $this->territorio_id = $territorio_id;
        $this->territorio_desc;
        $this->territorio_fec_bbdd_date;
        $this->territorio_simpli;
        $this->territorio_fec_bbdd;       

        // si id_territorio es distinto de vacio, se llama al metodo para completar la informacion 
        if(!empty($territorio_id)){

            $RepoCatalogo= new RepositorioServicioCatalogo();
            $InfoTerritorio = $RepoCatalogo->get_info_territorio($this->territorio_id);
            
            $this->territorio_desc = $InfoTerritorio->detalle[0]['descripcion'];
            $this->territorio_fec_bbdd_date = $InfoTerritorio->detalle[0]['fec_bbdd_date'];;
            $this->territorio_simpli = $InfoTerritorio->detalle[0]['territorio_simpli'];
            $this->territorio_fec_bbdd = $InfoTerritorio->detalle[0]['fec_bbdd'];

        } 
    }



  
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



