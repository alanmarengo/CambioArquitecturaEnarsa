<link rel="stylesheet" type="text/css" href="./css/page_template.css" />
<script type="text/javascript">
    function getLink(event, id){
        event.preventDefault();
        const url = "./Get_Link.php?id="+id
        $.get(url,function(data){
            console.log(data)
            //$(location).attr('href',data);
            window.open(data, '_blank')
        })
    }
</script>
<div id="page_monitoreo" class="page page_template">
    <div class="row">
        <div class="section-sticky">
            <div class="col-md-12 page-title">
                Monitoreo Hidrosedimentol&oacute;gico e Hidroambiental del R&iacute;o Santa Cruz
            </div>

            <div class="col-md-12 top-buttons">
                <a id="link-hidrico" href="#" data-target="#hidrico">RED DE MONITOREO H&Iacute;DRICO</a>
                <a id="link-hidroambiental" href="#" data-target="#hidroambiental">MONITOREO HIDROAMBIENTAL</a>
                <a id="link-hidrosedimentologico" href="#" data-target="#hidrosedimentologico">MONITOREO HIDROSEDIMENTOL&Oacute;GICO</a>
                <a id="link-registro" href="#" data-target="#registro">REGISTRO ESTAD&Iacute;STICO Y GR&Aacute;FICO</a>
            </div>
        </div>

        <!---------------------------------------------->
        <div class="col-md-12 section-a" style="padding-left: 8em; padding-right: 8em;">
            <a id="hidrico"></a>
            <h3 style="margin-bottom: 1em; color: #333;">RED DE MONITOREO H&Iacute;DRICO DE LA CUENCA DEL R&Iacute;O SANTA CRUZ</h3>

            <div class="embed-responsive" style="padding-top: 40%; height:100vh;">
                <iframe id="uxVisor" src="./geovisor.estaciones.php" frameborder="0" width="100%"></iframe>
            </div>
        </div>

        <!---------------------------------------------->
        <div class="col-md-12 section-b">
            <a id="hidroambiental"></a>
            <h3 style="margin-bottom: 1em; color: #333;">MONITOREO HIDROAMBIENTAL</h3>

            <div class="row">
                <div class="col-md-6 text-justify">
                    La medición de diferentes variables físicas, químicas y biológicas relacionadas con el clima y la hidrología de la cuenca es esencial para el proyecto, para concretar un sistema de alerta ante eventos hidrometeorologicos de diferente magnitud y para ampliar el conocimiento de la cuenca. A su vez, permite conocer el sistema en los momentos previos y posteriores a la formación de los embalses y evaluar los cambios que se produzcan.
                    <br />
                    <br />
                    La información será de utilidad para la gestión del recurso y la mitigación de impactos potenciales; a su vez podrá ser utilizada por diversos proyectos y actividades que se desarrollan en la actualidad o que se planifiquen en el futuro.
                    <br />
                    <br />
                    La red se compone de estaciones de medición fijas en tierra y otras ubicadas en el cauce de los ríos Santa Cruz y La Leona.
                    <br />
                    <br />
                 </div>
                <div class="col-md-6 text-justify">
                    Las primeras medirán, entre otras, las siguientes variables: oxígeno disuelto, clorofila, conductividad eléctrica, material en suspensión, nivel del agua, temperatura del agua y del aire, pluviometría, velocidad del viento y radiación solar. 
                    <br />
                    <br />
                    Las boyas medirán entre otras variables: altura y periodo de olas, perfil de temperatura del agua en 6 niveles de profundidad, dirección y velocidad del viento, además de otras variables que también serán registradas por las estaciones fijas. 
                    <br />
                    <br />
                    La provisión de datos está prevista con una frecuencia de entre 1 y 2 horas, dependiendo de la capacidad de transmisión de datos.
                    <br />
                    <br />
                </div>
            </div>

            <div id="slider-monitoreo1" class="carousel slide slider2" data-ride="carousel" data-interval="5000">
                <div class="carousel-inner">
                </div>
                <div class="carousel-prev" href="#slider-monitoreo1" role="button" data-slide="prev">
                    <i class="fa fa-chevron-left"></i>
                </div>
                <div class="carousel-next" href="#slider-monitoreo1" role="button" data-slide="next">
                    <i class="fa fa-chevron-right"></i>
                </div>
            </div>

            <div class="text-center" style="margin-top: 2em;">
                <a class="button button-2 pe-auto" onclick="getLink(event, 1)" style="cursor: pointer;">
                    VER RECURSOS ASOCIADOS
                    <img src="./images/icono-mediateca-br.png" style="height: 20px; width: 20px;" />
                </a>
            </div>
        </div>

        <!---------------------------------------------->
        <div class="col-md-12 section-a">
            <a id="hidrosedimentologico"></a>
            <h3 style="margin-bottom: 1em; color: #333;">MONITOREO HIDROSEDIMENTOL&Oacute;GICO</h3>

            <div class="row">
                <div class="col-md-6 text-justify">
                    El río Santa Cruz tiene una baja carga de sedimentos naturales provenientes de la erosión de la cuenca y del propio cauce. La escasa presencia y actividad humana de la región también limitan los aportes de origen antrópico. 
                    <br />
                    <br />
                    Los sedimentos provenientes de la erosión son de tamaño más pequeño (compuestos por limos y arcillas) y se transportan casi uniformemente, con un régimen que depende de las precipitaciones. Los sedimentos del cauce son la fracción más gruesa y presentan una diferente distribución vertical, aumentando exponencialmente hacia el fondo del cauce, mientras que la capacidad de transporte depende de las condiciones hidráulicas de la corriente. 
                    <br />
                    <br />
                    Los sedimentos por erosión incluyen también los aportes de partículas arrastradas por los vientos y depositadas en el cauce del río Santa Cruz. 
                    <br />
                    <br />
                </div>
                <div class="col-md-6 text-justify">
                    Los dispositivos y metodologías para el muestreo varían de acuerdo el tipo de sedimento. En las estaciones Leona Sur, Charles Fuhr, Presa Cóndor Cliff, Presa La Barrancosa y Puente Viejo se realiza el muestreo de sedimentos para conocer el transporte de la fracción sólida  simultáneamente con los aforos líquidos (medición de caudales).
                    <br />
                    <br />
                    La medición de sedimentos tiene una alta importancia en la cuenta. En primer lugar, se trata de un factor que puede afectar la vida útil de los embalses, ya que puede ser una causa de colmatación. Por otra parte, los sedimentos están relacionados con la dinámica de nutrientes y, en consecuencia, con el ecosistema acuático. 
                    <br />
                    <br />
                    Durante la etapa de construcción de las presas, una fuente adicional (no natural) de sedimentos son los movimientos de suelo propio de las obras y el polvo de la circulación de vehículos, entre otros.
                    <br />
                    <br />
                </div>
            </div>

            <div id="slider-monitoreo2" class="carousel slide slider2" data-ride="carousel" data-interval="5000">
                <div class="carousel-inner">
                </div>
                <div class="carousel-prev" href="#slider-monitoreo2" role="button" data-slide="prev">
                    <i class="fa fa-chevron-left"></i>
                </div>
                <div class="carousel-next" href="#slider-monitoreo2" role="button" data-slide="next">
                    <i class="fa fa-chevron-right"></i>
                </div>
            </div>

            <div class="text-center" style="margin-top: 2em;">
                <a class="button button-2 pe-auto" onclick="getLink(event, 2)" style="cursor: pointer;">
                    VER RECURSOS ASOCIADOS
                    <img src="./images/icono-mediateca-br.png" style="height: 20px; width: 20px;" />
                </a>
            </div>
        </div>

        <!---------------------------------------------->

        <div class="col-md-12 section-b">
            <!--<h3 style="margin-bottom: 1em; color: #333;">REGISTRO ESTAD&Iacute;STICO Y GR&Aacute;FICO DE LA RED DE MONITOREO H&Iacute;DRICO DE LA CUENCA DEL R&Iacute;O SANTA CRUZ</h3>-->
			
            <a id="registro"></a>
            <h3 style="margin-bottom: 1em; color: #333;">REGISTRO ESTADÍSTICO Y GRÁFICO DE LA RED DE MONITOREO HÍDRICO DE LA CUENCA DEL RÍO SANTA CRUZ</h3>
            <div class="row">
			    <iframe id="box4" src="./geovisor.redesbox.php" frameborder="0" style="overflow:hidden;height:130vh;" height="100%" width="100%"></iframe>
            </div>

        </div>
       
    </div>
</div>

<script src="./js/slide.js"></script>
<script type='text/javascript'>
$(document).ready(function() {
    var data1 = [
        {
            media_url: './images/index/s1.jpg',
            media_tipo: 'jpg',
            texto: 'Jornada informativa en Río Gallegos, previa a la Audiencia pública provincial. 16 de octubre de 2015',
            url: 'javascript:void(0);',
            tag: '',
        },
        {
            media_url: 'https://mdbootstrap.com/img/video/Agua-natural.mp4',
            media_tipo: 'mp4',
            texto: 'VIDEO',
            url: 'javascript:void(0);',
            tag: '',
        },
        {
            media_url: './images/index/s4.jpg',
            media_tipo: 'jpg',
            texto: 'ITEM 3',
            url: 'javascript:void(0);',
            tag: '',
        },
        {
            media_url: './images/index/s5.jpg',
            media_tipo: 'jpg',
            texto: 'ITEM 4',
            url: 'javascript:void(0);',
            tag: '',
        }
    ];

    var data2 = [
        {
            media_url: './images/index/s6.jpg',
            media_tipo: 'jpg',
            texto: 'Jornada informativa en Río Gallegos, previa a la Audiencia pública provincial. 16 de octubre de 2015',
            url: 'javascript:void(0);',
            tag: '',
        },
        {
            media_url: './images/index/s1.jpg',
            media_tipo: 'jpg',
            texto: 'ITEM 2',
            url: 'javascript:void(0);',
            tag: '',
        },
        {
            media_url: './images/index/s4.jpg',
            media_tipo: 'jpg',
            texto: 'ITEM 3',
            url: 'javascript:void(0);',
            tag: '',
        },
        {
            media_url: './images/index/s3.jpg',
            media_tipo: 'jpg',
            texto: 'ITEM 4',
            url: 'javascript:void(0);',
            tag: '',
        }
    ];
    //-----------------------------------------------
    
    <?php include("./slider_monitoreo_db.php"); ?>

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

    //------------------------------------------------------
    slide('#slider-monitoreo1', data1, '');
    slide('#slider-monitoreo2', data2, '');

});
</script>
