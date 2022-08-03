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
}