<?php
//esto devuelve get_recursos_filtrado
class RecursosFiltros{
    public $recursos;
    public $aux_cadena_filtros;
    public $lista_recursos_restringidos;
    public $CantidadPaginas;
    public $EstadisticasFiltros;


    public function __construct($recursos,$aux_cadena_filtros,$CantidadPaginas,$EstadisticasFiltros,$lista_recursos_restringidos){
        $this->recursos=$recursos;
        $this->aux_cadena_filtros=$aux_cadena_filtros; 
        $this->CantidadPaginas=$CantidadPaginas;
        $this->EstadisticasFiltros=$EstadisticasFiltros;
        $this->lista_recursos_restringidos=$lista_recursos_restringidos;
    }
}

//esto devuelve get_recursos
class Recursos{
    public $recursos;
    public $lista_recursos_restringidos;
    public $CantidadPaginas;
    public function __construct($recursos,$CantidadPaginas,$lista_recursos_restringidos){
        $this->recursos=$recursos;
        $this->CantidadPaginas=$CantidadPaginas;
        $this->lista_recursos_restringidos=$lista_recursos_restringidos;
    }
}



class EstadisticasFiltros{
    public $estadistica_documentos;
    public $estadistica_recursos_audiovisuales;
    public $estadistica_novedades;

    public function __construct($estadistica_documentos,$estadistica_recursos_audiovisuales,$estadistica_novedades){
        $this->estadistica_documentos=$estadistica_documentos;
        $this->estadistica_recursos_audiovisuales=$estadistica_recursos_audiovisuales;
        $this->estadistica_novedades=$estadistica_novedades;

    }
}


class Respuesta{
    public $recordset;
    public $filtros;
    public $paginas;
    public $solapa;
    public $pagina;
    public $estudio_nombre;
    public $mode_label;
    public $registros_total_0;
    public $registros_total_1;
    public $registros_total_2;
    public $registros_total_3;
    public $rec_per_page;
    public $current_page = 20;

    public function __construct($recordset,$filtros,$paginas,$solapa,$estudio_nombre,$mode_label,$registros_total_0,$registros_total_1,$registros_total_2,$registros_total_3,$rec_per_page){
        $this->recordset=$recordset;
        $this->filtros=$filtros;
        $this->paginas=$paginas;
        $this->solapa=$solapa;
        $this->pagina=$pagina;
        $this->estudio_nombre=$estudio_nombre;
        $this->mode_label=$mode_label;
        $this->registros_total_0=$registros_total_0;
        $this->registros_total_1=$registros_total_1;
        $this->registros_total_2=$registros_total_2;
        $this->registros_total_3=$registros_total_3;
        $this->rec_per_page=20;

    }


}