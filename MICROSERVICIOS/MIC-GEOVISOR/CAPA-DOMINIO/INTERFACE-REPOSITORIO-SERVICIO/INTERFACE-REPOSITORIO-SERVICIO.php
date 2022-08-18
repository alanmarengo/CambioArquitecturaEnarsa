<?php

interface IRepositorioServicioGeovisor{
    public function Get_Layer_Security($user_id,$layer_id);
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
    public function filter_proyectos_basic($user_id, $proyectos, $geovisor);
    public function get_layer_extent($layer_id);
    public function get_coor_transformed($lon, $lat);
}