<?php include("./header.php"); ?>

<div id="page_herramientas" class="page">
    <div class="row">
        <div class="col-md-12 page-section-1">
            Herramientas Geográficas
        </div>

        <div class="col-md-12 page-section-2 section-sticky">
            <div class="row">
                <div class="col-md-4">
                    <a id="link-mapas" data-target="#mapas" href="#" class="btn btn-dark btn-block">MAPAS Y VISORES</a>
                </div>
                <div class="col-md-4">
                    <a id="link-visores" data-target="#visores" href="#" class="btn btn-dark btn-block">GEOVISORES</a>
                </div>
                <div class="col-md-4">
                    <a id="link-servicios" data-target="#servicios" href="#" class="btn btn-dark btn-block">GEOSERVICIOS</a>
                </div>
            </div>
        </div>

        <div style="padding: 30px;">

            <div class="col-md-12" style="padding: 0px 20px 20px 20px;">
                Son instrumentos de visualización y gestión de información geográfica orientados por proyectos o por temas relacionados con las obras de IEASA y fundamentalmente  de los Aprovechamientos Hidroeléctricos del Río Santa Cruz (AHRSC).  Se provee en línea herramientas de indagación y tratamiento de la información geográfica de fácil uso y acceso. Es un recurso integrador de información de diversas disciplinas y fuentes acorde con la complejidad del desarrollo de proyectos de infraestructura energética.
            </div>

            <a id="mapas"></a>
            <div class="row" style="padding-left: 20px;">
                <div class="col-md-4 page-box">
                    <div href="./geovisor-basico.php" class="box">
                        <div class="page-box-image" style="background-image: url(./images/herramientas/1.png);"></div>
                        <p class="page-box-title">VISOR IEASA</p>
                        <p class="page-box-description">Conocé la localización y características técnicas de los proyectos y de las obras de IEASA distribuidas en todo el país.</p>
                    </div>
                </div>
                <div class="col-md-4 page-box">
                    <div href="" class="box">
                        <div class="page-box-image" style="background-image: url(./images/herramientas/2.png);"></div>
                        <p class="page-box-title">DE COMUNICACION Y GESTION PARTICIPATIVA</p>
                        <p class="page-box-description">Conocé la localización de las actividades de IEASA en territorio en el marco del proyecto  AHRSC que permiten fortalecer la comunicación y participación de toda la comunidad.</p>
                    </div>
                </div>
            </div>

            <a id="visores"></a>
            <div class="row" style="padding-left: 20px;">
                <div class="col-md-4 page-box">
                    <div href="./geovisor.php" class="box">
                        <div class="page-box-image" style="background-image: url(./images/herramientas/3.png);"></div>
                        <p class="page-box-title">GEOVISOR INTEGRAL</p>
                        <p class="page-box-description">Visualizá, gestioná y accedé en línea a la totalidad de la información de este Observatorio y conectate e integrá información de otros organismos externos, tanto para consulta como para generar nueva información.</p>
                    </div>
                </div>
                <div class="col-md-4 page-box">
                    <div href="" class="box">
                        <div class="page-box-image" style="background-image: url(./images/herramientas/4.png);"></div>
                        <p class="page-box-title">GEOVISOR DE OBRA AHRSC</p>
                        <p class="page-box-description">Visualizá y consultá las características técnicas de los proyectos de AHRSC, a través de la documentación ejecutiva y de los modelos tridimensionales con tecnología BIM que contiene toda la información técnica y física en una base de datos inteligente y dinámica.</p>
                    </div>
                </div>
                <div class="col-md-4 page-box">
                    <div href="http://hidrosantacruz.com.ar" class="box">
                        <div class="page-box-image" style="background-image: url(./images/herramientas/5.png);"></div>
                        <p class="page-box-title">SIT</p>
                        <p class="page-box-description">Accedé al geovisor del Sistema de Información Territorial de Santa Cruz (SIT) con información espacial pública de la provincia orientadas a la gestión y toma de decisiones.</p>
                    </div>
                </div>
                <div class="col-md-4 page-box">
                    <div href="" class="box">
                        <div class="page-box-image" style="background-image: url(./images/herramientas/6.png);"></div>
                        <p class="page-box-title">GEOVISOR AHRSC</p>
                        <p class="page-box-description">Conocé los AHRSC,  sus características técnicas y toda la información ambiental de línea de base y monitoreos actuales. Indagá y generá tu propia información y vinculate a otros organismos externos para integrar nueva información.</p>
                    </div>
                </div>
            </div>

            <a id="servicios"></a>
            <div class="row" style="padding-left: 20px; padding-right: 20px; background-color: #eee;">
                <div class="col-md-12">
                    <div style="padding: 20px 0px; font-size: 1.8em; font-weight: bold;">
                        GEOSERVICIOS
                    </div>
                    <p>
                        A través de los siguientes geoservicios estándares visualizá, accedé y consultá la información espacial de IEASA. Estos geoservicios, podrán ser vinculados con diversas instancias de publicación, de acceso e intercambio de información que aplique estándares OGC (ISO 19111, 19115:2003).
                    </p>
                </div>

                <div class="col-md-12">
                    <div class="geonetwork">
                        <!-- <a href="http://observatorio.ieasa.com.ar:8080/geonetwork" class="row"> -->
                        <a href="http://observatorio.energia-argentina.com.ar:8080/geonetwork" class="row">
                            <div class="col-md-4">
                                <div class="page-box-image2" style="background-image: url(./images/herramientas/7.png);"></div>
                            </div>
                            <div class="col-md-8" style="padding: 20px;">
                                <div style="padding-bottom: 10px; font-weight: bold;">GEONETWORK</div>
                                <div>
                                    Esta aplicación instalada en servidores de la empresa, de código abierto y diseñado para la catalogación de recursos georreferenciados, permite la búsqueda y acceso en múltiples formatos de la información geográfica y servicios de IEASA. Accedé a través del siguiente link.
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
                                <!-- <div class="col-md-8">http://observatorio.ieasa.com.ar</div> --> 
                                <div class="col-md-8">http://observatorio.energia-argentina.com.ar</div>
                                <div class="col-md-4">
                                    <a class="badge badge-secondary" style="color: #fff;">COPIAR</a>
                                </div>
                            </div>
                        </p>
                        <p class="page-wbox-description">Copiá este link para usar en tu SIG o Cliente WEB, y visualizá información georreferenciada actualizada de la empresa en formato de imagen conocidos (GIF, JPG, etc.) </p>
                    </div>
                </div>
                <div class="col-md-4 page-wbox">
                    <div class="wbox">
                        <p class="page-wbox-title">WFS</p>
                        <p class="page-wbox-link">
                            <div class="row">
                                <!-- <div class="col-md-8">http://observatorio.ieasa.com.ar</div> -->
                                <div class="col-md-8">http://observatorio.energia-argentina.com.ar</div>
                                <div class="col-md-4">
                                    <a class="badge badge-secondary" style="color: #fff;">COPIAR</a>
                                </div>
                            </div>
                        </p>
                        <p class="page-wbox-description">Copiá este link para acceder desde tu aplicación cliente SIG acceder a información georreferenciada. De esta manera se ponen a disposición los vectores y datos asociados de los distintos  proyectos en formatos vectoriales (Shapefile, geoJSON, GML, etc.)</p>
                    </div>
                </div>
                <div class="col-md-4 page-wbox">
                    <div class="wbox">
                        <p class="page-wbox-title">CSW</p>
                        <p class="page-wbox-link">
                            <div class="row">
                                <!-- <div class="col-md-8">http://observatorio.ieasa.com.ar</div> -->
                                <div class="col-md-8">http://observatorio.energia-argentina.com.ar</div>
                                <div class="col-md-4">
                                    <a class="badge badge-secondary" style="color: #fff;">COPIAR</a>
                                </div>
                            </div>
                        </p>
                        <p class="page-wbox-description">Utilizá este link para acceder, a través de cliente SIG o aplicación de catalogación, a los metadatos de toda la información georreferenciada actualizada, buscar y consultar metadatos relacionados a datos, servicios presentes en esta plataforma.GML, etc.)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("./widget-links.php"); ?>

<script type='text/javascript'>
$(document).ready(function() {
    $('.section-sticky a').on('click', function() {
        let selector = $(this).data('target');
        $('html, body').animate({
            scrollTop: $(selector).offset().top - 80
        }, 500)
    });
    
    $('.box').on('click', function() {
        let href = $(this).attr('href');
        if (href)
            window.location.replace(href);
    });

    let target = $.urlParam('target');
    if (target)
        $('#link-' + target).trigger('click');

});
</script>

<?php include("./footer.php"); ?>