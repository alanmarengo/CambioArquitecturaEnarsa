<div id="page_repositorio">
    <div class="row" style="margin-right: 10px;">
        <div id="uxTemasContainer" data-simplebar class="col-md-3">
            <div id="uxTemas"></div>
        </div>
        <div id="uxInfoContainer" data-simplebar class="col-md-9">
            <div id="uxInfo">
                <h2 id="uxTitulo"></h2>
                <div class="row">
                    <div class="col-7">
                        <p id="uxDescripcion"></p>
                        <p id="uxCantidades">
                            Datasets: <span id="uxDatasets"></span><br />
                            Mapas: <span id="uxMapas"></span><br />
                            Recursos: <span id="uxRecursos"></span><br />
                        </p>
                    </div>
                    <div class="col-5">
                        <img src="" />
                    </div>
                </div>
            </div>
        </div>

        <div id="uxDataContainer" class="col-md-9" style="display: none;">
            <div id="uxDataTitulo">
                <span class="tema">
                </span> /
                <span class="subtema">
                </span> /
                <span class="dataset" style="white-space: nowrap;">
                </span>
            </div>

            <div id="uxData">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="uxTabTabla" data-toggle="tab" href="#uxTabla" role="tab">TABLA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="uxTabGrafico" data-toggle="tab" href="#uxGrafico" role="tab">GR&Aacute;FICO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="uxTabMapa" data-toggle="tab" href="#uxMapa" role="tab">MAPA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="uxTabMeta" data-toggle="tab" href="#uxMeta" role="tab">METADATOS</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="uxTabla" role="tabpanel">
                        <div class="row" style="padding-bottom: 10px;">
                            <div class="col text-right barra-iconos">
                                <!-- 
                                <a href="#">
                                    <img src="./images/icono-print" />
                                </a> 
                                -->
                                <a id="uxTablaDownload" href="#">
                                    <img src="./images/icono-download.png" />
                                </a>
                            </div>
                        </div>
                        <div id="uxTablaContainer" data-simplebar style="overflow: auto;">
                        </div>
                    </div>

                    <div class="tab-pane fade" id="uxGrafico" role="tabpanel">
                        <div class="row" style="padding-bottom: 10px;">
                            <div class="col">
                                <select id="uxGraficoTipo" data-width="500">
                                </select>
                            </div>
                        </div>

                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe id="uxIGrafico" class="embed-responsive-item" src=""></iframe>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="uxMapa" role="tabpanel">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe id="uxIMapa" class="embed-responsive-item" src=""></iframe>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="uxMeta" role="tabpanel">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="fila">
                                    <div class="label">T&Iacute;TULO:</div>
                                    <div class="value" id="uxTitulo"></div>
                                </div>
                                <div class="fila">
                                    <div class="label">DESCRIPCI&Oacute;N:</div>
                                    <div class="value" id="uxDescripcion"></div>
                                </div>
                                <div class="fila">
                                    <div class="label">FUENTE:</div>
                                    <div class="value" id="uxFuente"></div>
                                </div>
                                <div class="fila">
                                    <div class="label">FECHA:</div>
                                    <div class="value" id="uxFecha"></div>
                                </div>
                                <div class="fila">
                                    <div class="label">PERI&Oacute;DO:</div>
                                    <div class="value" id="uxDesde"></div>
                                    <div class="value" id="uxHasta"></div>
                                </div>
                                <div class="fila">
                                    <div class="label">LINK DE INTER&Eacute;S:</div>
                                    <div class="value" id="uxLinks"></div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <img id="uxImagen" src="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>

<script src="./js/site.repositorio.js" type='text/javascript'>
</script>