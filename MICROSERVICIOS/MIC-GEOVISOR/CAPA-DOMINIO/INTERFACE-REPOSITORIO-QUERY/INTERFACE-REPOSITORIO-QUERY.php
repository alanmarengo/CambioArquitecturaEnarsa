<?php

interface IRepositorioQueryGeovisor{
    public function ListaProyectos();
    public function DrawAbr();
    public function DrawLayers($clase_id);
    public function DrawLayersSearch($pattern);
    public function DrawDatasetSearch($pattern);
    public function DrawProyectos();
    public function DrawComboSimple($id,$desc,$schema,$table,$opini,$opini_label,$opini_val,$hname,$hid);
    public function DrawComboSimpleFN($id,$desc,$schema,$table,$opini,$opini_label,$opini_val,$hname,$hid,$fn);
    public function DrawComboSimpleClase($id,$desc,$schema,$table,$opini,$opini_label,$opini_val,$hname,$hid);
    public function GetLayerLabel($layer_name);
    public function filter_proyectos_basic($lista_recursos_restringidos, $proyectos, $geovisor);
    public function wms_get_layer_extent($str_layer_name);
    public function get_layer_extent($layer_id);
    public function get_coor_transformed($lon, $lat);
    public function get_medicion($wkt, $type);
    public function get_buffer($wkt, $layers);
    public function get_layer_preview($layer_id);
    public function get_consulta($query_string);
    public function get_consulta_ahrsc($query_string);
}


