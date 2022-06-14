<div class="row" id="page_mediateca">
    <div id="UxPrevSearch" class="col-sm-12 col-md-12 col-xl-4 d-none">

    </div>

    <div class="page-title-sticky">
        <div class="col-md-12 page-title d-flex justify-content-between">
            Mediateca
        </div>

        <?php 
				if(isset($_POST['elemento_id']) && isset($_POST['tipo_elemento'])){
                    $elemento_id = $_POST['elemento_id'];
                    $tipo_elemento = $_POST['tipo_elemento'];
                    $panel_id = $_POST['panel_id'];

                    $html = '<input type="hidden" id="infoIndicadores" data-elemento_id='.$elemento_id.' data-tipo_elemento='.$tipo_elemento.' data-panel_id='.$panel_id.'>';
                    echo $html;
				}
			?>

        <div class="" style="background-color: #ddd;">
            <div class="col-md-12 nav-content-tabs">
                <!-- BARRA DE HERRAMIENTAS (SEPTIEMMBRE 2021) -->
                <div class="toolbar-container">
                    
                    <div class="toolbar-items">                
                        <i class="fas fa-sort-amount-up" id="iconoOrdenar" data-btn="ordenar" title="Ordenar recursos"></i>
                        <span class="tooltip-mobile"> ORDENAR </span>

                            <div class="background_mobile closeBTN d-none" id="background_orden"> </div>
                            <div id="ordenar_container" class="d-none">                                
                                <div id="ordenar_titulo_container">
                                    <p id="ordenar_titulo"> ORDENAR </p>
                                    <i class="fas fa-times closeOrdenar closeBTN" id="close"></i>                                
                                </div>
                                <div id="ordenar_content">
                                    <div class="ordenar_option" data-value=0>     A - Z       </div>
                                    <div class="ordenar_option" data-value=1>     Z - A       </div>                                    
                                    <div class="ordenar_option" data-value=5>     ANTIGUOS    </div>
                                    <div class="ordenar_option active" data-value=4>     FECHA DOCUMENTO   </div>
                                    <div class="ordenar_option" data-value=6>     FECHA PUBLICACION    </div>
                                </div>
                                <div class="footer_mobile"> </div>
                            </div>
                        
                    </div>


                    <div class="toolbar-items"> 
                        <i class="fas fa-filter" id="iconoFiltrar" data-btn="filtrar" title="Filtrar recursos"></i>
                        <span class="tooltip-mobile"> FILTRAR </span>
                    </div>


                    <div class="toolbar-items"> 
                        <i class="fas fa-share-alt" id="iconoCompartir" data-btn="compartir" title="Compartir resultados de búsqueda"></i>
                        <span class="tooltip-mobile"> COMPARTIR </span>

                        <div class="background_mobile closeBTN d-none" id="background_compartir"> </div>
                        <div id="compartir_container" class="d-none">                            
                            <div id="compartir_titulo_container">
                                <p id="compartir_titulo"> COMPARTIR </p>
                                <i class="fas fa-times closeCompartir closeBTN" id="close"></i>
                            </div>
                            <input type="text" id="compartir_input">
                            <button id="compartir_btn"> COPIAR </button>
                            <p id="compartir_copy_success" class="d-none"> ¡Enlace copiado correctamente! </p>
                            <div class="footer_mobile"> </div>
                        </div>
                    </div>

                </div>
                <!-- FIN DE BARRA DE HERRAMIENTAS -->            
                <ul class="nav nav-tabs">
                    <li class="nav-item nav-item-active">
                        <a class="nav-link active" data-tab="0" href="javascript:void(0)">DOCUMENTOS <span id="uxQtyDocs"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-tab="1" href="javascript:void(0)">RECURSOS AUDIOVISUALES <span id="uxQtyMedias"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-tab="2" href="javascript:void(0)">RECURSOS TÉCNICOS <span id="uxQtyTechs"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-tab="3" href="javascript:void(0)">NOVEDADES <span id="uxQtyNews"></span></a>
                    </li>
                </ul>
            </div>
<!--             <div class="col-md-2 text-right" style="padding: 16px 50px 10px 20px; background-color: #ddd;">
                <select id="uxOrden" class="selectpicker" data-width="150">
                    <option>Ordenar por</option>
                    <option value="0">A - Z</option>
                    <option value="1">Z - A</option> -->
<!--                     <option value="2">MÁS VISTOS</option>
                    <option value="3">MENOS VISTOS</option> -->
<!--                     <option value="4">RECIENTES</option>
                    <option value="5">ANTIGUOS</option>
                </select>
            </div> -->
        </div>


    </div>


    <div class="col-md-12 page-search" style="display: none;">
        <div class="row">
            <div class="col-md-4">
                <div class="input-group mb-3">
                    <input id="uxSearchText" name="uxSearchText" type="text" class="form-control">
                    <div class="input-group-append">
                        <span class="input-group-text" id="uxSearchButton">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </div>
                <div id="uxUrl"></div>
            </div>
        </div>
    </div>

    <div class="col-md-12 page-tabs" style="background-color:#F2F2F2; padding-top:15px;">
        <div class="row" style="display:flex; justify-content:center;">
<!--             <div class="x0 col-md-3" style="position: relative;">
                <div id="uxFilters-box" class="pinned" style="position: absolute;"></div>
            </div> -->
            <div class="col-md-11 col-xl-10">
                <div id="uxFiltersChecked"></div>
                <div id="uxPager1" class="content-pager" style="display: none;"></div>
                <a href="#top" class="btn-upTop d-none" id="btnUpTop"> 
                    <i class="fas fa-chevron-up"></i>
                </a>
                <div id="uxData" style="min-height: 70vh; padding-top:15px;"></div>
                <div id="uxPager2" class="content-pager" style="display: none; margin-bottom:20px;"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uxFicha" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

</div>
<?php include("./widget-links.php"); ?>



<div class="modal fade" id="previewmodal" style="margin-top: 100px;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 9999;">
    <div class="modal-dialog modal-lg2">
        <div class="modal-content" style="background-color: transparent; border: none;">
            <div class="modal-body">
                <button id="uxPreviewClose" type="button" class="close" data-dismiss="modal" style="color: #fff; font-size: 50px;"><span aria-hidden="true">&times;</span></button>
                <div style="text-align: center;">
                    <div id="preview"> </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="./js/hc-sticky.js" type="text/javascript"></script>
<script src="./js/site.mediateca.js" type='text/javascript'>
</script>
