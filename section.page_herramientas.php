<link rel="stylesheet" type="text/css" href="./css/page_template.css" />

<div id="page_herramientas" class="page page_template">
    <div class="row">
        <div class="section-sticky">
            <div class="col-md-12 page-title">
                Herramientas Geográficas
            </div>

            <div class="col-md-12 top-buttons">
                <a id="link-geovisores" href="#" data-target="#geovisores">geovisores</a>
                <a id="link-geoservicios" href="#" data-target="#geoservicios">geoservicios</a>
            </div>
        </div>

        <div class="col-md-12 section-a geovisores">
            <a id="geovisores"></a>
            <h3>GEOVISORES</h3>

            <div class="row" style="padding-left: 20px;">
                <div class="col-md-4 page-box">
                    <a href="./geovisor.php" class="box" style="position: relative;">
                        <div class="page-box-image" style="background-image: url(./images/herramientas/3.png);"></div>
                        <div class="text-over">GeObi</div>
                        
                        <p class="page-box-title">Geovisor de Observatorio de IEASA</p>
                        <p class="page-box-description">Visualizá, gestioná y accedé en línea a la totalidad de la
                            información de este Observatorio y conectate e integrá información de otros organismos
                            externos, tanto para consulta como para generar nueva información.</p>
                    </a>
                </div>
                <div class="col-md-4 page-box">
                    <a href="./geovisor.php?geovisor=1" class="box">
                        <!--<div class="page-box-image" style="background-image: url(./images/herramientas/5.png);"></div>-->
                        <div class="page-box-image" style="background-image: url(./images/index/caja11.jpg);"></div>
                        <!--<p class="page-box-title">SIG Santa Cruz</p>-->
                        <p class="page-box-title">SIG Ambiental Santa Cruz</p>

                        <!--<p class="page-box-description">Accedé al geovisor del Sistema de Información Territorial de
                            Santa Cruz (SIT) con información espacial pública de la provincia orientadas a la gestión y
                            toma de decisiones.</p>-->
                        <p class="page-box-description">Visualizador oficial de geoinformación ambiental 
                        de la provincia de Santa Cruz desarrollado en cooperación entre el Gobierno de Santa Cruz y
                         la Estación Experimental Agropecuaria Santa Cruz de INTA.</p>
                    </a>
                </div>
                <div class="col-md-4 page-box">
                    <a href="./geovisor.php?geovisor=2" class="box">
                        <div class="page-box-image" style="background-image: url(./images/herramientas/6.png);"></div>
                        <p class="page-box-title">GEOVISOR AHRSC</p>
                        <p class="page-box-description">Conocé los AHRSC, sus características técnicas y toda la
                            información ambiental de línea de base y monitoreos actuales. Indagá y generá tu propia
                            información y vinculate a otros organismos externos para integrar nueva información.</p>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-12 section-b geoservicios">
            <a id="geoservicios"></a>
            <h3>GEOSERVICIOS</h3>

            <div class="row" style="padding-left: 20px; padding-right: 20px;">
                <div class="col-md-12">
                    <p>
                        A través de los siguientes geoservicios estándares visualizá, accedé y consultá la información
                        espacial de IEASA. Estos geoservicios, podrán ser vinculados con diversas instancias de
                        publicación, de acceso e intercambio de información que aplique estándares OGC (ISO 19111,
                        19115:2003).
                    </p>
                </div>

                <div class="col-md-12">
                    <div class="geonetwork">
                        <a href="http://observatorio.ieasa.ar:8080/geonetwork" class="row">
                            <div class="col-md-4">
                                <div class="page-box-image2"
                                    style="background-image: url(./images/herramientas/7.png);"></div>
                            </div>
                            <div class="col-md-8" style="padding: 20px;">
                                <div style="padding-bottom: 10px; font-weight: bold;">GEONETWORK</div>
                                <div>
                                    Esta aplicación instalada en servidores de la empresa, de código abierto y diseñado
                                    para la catalogación de recursos georreferenciados, permite la búsqueda y acceso en
                                    múltiples formatos de la información geográfica y servicios de IEASA. Accedé a
                                    través del siguiente link.
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-4 page-wbox">
                    <div class="wbox">
                        <p class="page-wbox-title">WMS</p>
                        <p class="page-wbox-link">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control" readonly style="font-size: 12px;" value="http://observatorio.ieasa.ar:8080/geoserver/ows?">
                                        <span class="input-group-btn">
                                            <button class="clipboard-copy btn btn-default" style="color: #333;" title="Copiar" data-clipboard-text="http://observatorio.ieasa.com.ar:8080/geoserver/ows?">
                                                <i class="fa fa-clone"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </p>
                        <p class="page-wbox-description">Copiá este link para usar en tu SIG o Cliente WEB, y visualizá
                            información georreferenciada actualizada de la empresa en formato de imagen conocidos (GIF,
                            JPG, etc.) </p>
                    </div>
                </div>
                <div class="col-md-4 page-wbox">
                    <div class="wbox">
                        <p class="page-wbox-title">WFS</p>
                        <p class="page-wbox-link">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control" readonly style="font-size: 12px;" value="http://observatorio.ieasa.ar:8080/geoserver/ows?">
                                        <span class="input-group-btn">
                                            <button class="clipboard-copy btn btn-default" style="color: #333;" title="Copiar" data-clipboard-text="http://observatorio.ieasa.com.ar:8080/geoserver/ows?">
                                                <i class="fa fa-clone"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </p>
                        <p class="page-wbox-description">Copiá este link para acceder desde tu aplicación cliente SIG
                            acceder a información georreferenciada. De esta manera se ponen a disposición los vectores y
                            datos asociados de los distintos proyectos en formatos vectoriales (Shapefile, geoJSON, GML,
                            etc.)</p>
                    </div>
                </div>
                <div class="col-md-4 page-wbox">
                    <div class="wbox">
                        <p class="page-wbox-title">CSW</p>
                        <p class="page-wbox-link">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control" readonly style="font-size: 12px;" value="http://observatorio.ieasa.ar:8080/geonetwork/srv/spa/csw?">
                                        <span class="input-group-btn">
                                            <button class="clipboard-copy btn btn-default" style="color: #333;" title="Copiar" data-clipboard-text="http://observatorio.ieasa.com.ar:8080/geonetwork/srv/spa/csw?">
                                                <i class="fa fa-clone"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </p>
                        <p class="page-wbox-description">Utilizá este link para acceder, a través de cliente SIG o
                            aplicación de catalogación, a los metadatos de toda la información georreferenciada
                            actualizada, buscar y consultar metadatos relacionados a datos, servicios presentes en esta
                            plataforma.GML, etc.)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.4/clipboard.min.js"></script>
<script type='text/javascript'>
$(document).ready(function() {
    var clipboard = new ClipboardJS('.clipboard-copy');

    clipboard.on('success', function(e) {
        //alert('Copiado!')
    });

    $('.section-sticky a').on('click', function() {
        $('.section-sticky a').removeClass('selected');
        $(this).addClass('selected');

        let selector = $(this).data('target');
        $('html, body').animate({
            scrollTop: $(selector).offset().top - 200
        }, 500)
    });

    let target = $.urlParam('target');
    if (target)
        $('#link-' + target).trigger('click');

});
</script>
