<?php
interface IRepositorioQueryGeovisor{
    public function ListaProyectos();
    public function DrawAbr();
    public function DrawLayers($clase_id);
}