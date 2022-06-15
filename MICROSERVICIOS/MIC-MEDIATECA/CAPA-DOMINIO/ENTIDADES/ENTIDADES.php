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
        
        //ACA DEBO SETEAR TODOS LOS ATRIBUTOS CON LO QUE ME LLEGA EN EL CONSTRUCTOR. 
        $this->solapa;
        $this->origen_id;
        $this->id_recurso;
        $this->titulo;
        $this->descripcion;
        $this->link_imagen;
        $this->metatag;
        $this->autores;
        $this->estudios_id;
        $this->fecha;
        $this->tema;
        $this->ico;
        $this->estudios;
        $this->territorio_id;
        $this->territorio_desc;
        $this->territorio_fec_bbdd_date;
        $this->territorio_simpli;
        $this->territorio_fec_bbdd;
        //TAMBIEN DEBO LLENAR CON VALORES PRESETEADOS O NULOS LO QUE CORRESPONDA.        
        $this->territorio_id=$territorio_id;

        if($territorio_id != null){

            $RepoCatalogo= new RepositorioServicioCatalogo();
            $InfoTerritorio = $RepoCatalogo->get_info_territorio($territorio_id);
            
            $this->territorio_desc=$InfoTerritorio[0];
            $this->territorio_fec_bbdd_date=$InfoTerritorio[1];
            $this->territorio_simpli=$InfoTerritorio[2];
            $this->territorio_fec_bbdd=$InfoTerritorio[3];

        } 
    }
}