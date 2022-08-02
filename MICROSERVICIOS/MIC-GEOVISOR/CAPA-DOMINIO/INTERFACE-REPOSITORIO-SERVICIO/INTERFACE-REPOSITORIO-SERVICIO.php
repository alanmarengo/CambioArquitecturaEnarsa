<?php

interface IRepositorioServicioGeovisor{
    public function Get_Layer_Security($user_id,$layer_id);
    public function ListaProyectos();
    public function DrawAbr();
    public function DrawLayers($clase_id);
    public function DrawLayersSearch($pattern);
    public function DrawDatasetSearch($pattern);
    public function DrawProyectos();
}