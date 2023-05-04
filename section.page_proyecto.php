<link rel="stylesheet" type="text/css" href="./css/page_template.css" />
<link rel="stylesheet" type="text/css" href="./css/galeria_imagenes.css" />
<script src="./js/galeria_imagenes.js"></script>

<?php
//include("./Get_Link.php");
//include_once("pgconfig.php");
// se importa el repositorio de servicios del microservicio catalogo
require_once(dirname(__FILE__).'/MICROSERVICIOS/MIC-CATALOGO/CAPA-APLICACION/SERVICIO/REPOSITORIO-SERVICIO.php');

$servicio_catalogo = new RepositorioServicioCatalogo();



?>
<div id="page_proyecto" class="page page_template">
    <div>
        <div class="section-sticky">
            <div class="col-md-12 page-title">
                Aprovechamientos Hidroeléctricos del Río Santa Cruz
            </div>

            <div class="col-md-12 top-buttons">
                <a id="link-ahrsc" href="#" data-target="#ahrsc">AHRSC</a>
                <a id="link-condor" href="#" data-target="#condor">Néstor Kirchner</a>
                <a id="link-barrancosa" href="#" data-target="#barrancosa">Jorge Cepernic</a>
                <a id="link-leat" href="#" data-target="#leat">Línea de Alta Tensión</a>
            </div>
        </div>

        <!---------------------------------------------->
        <div class="col-md-12 section-a pl-0 pr-0" style="margin-top: 100px;">
            <img src="./images/proyecto_fondov2.jpg" style="width: 100%; height: auto;">
        </div>

        <!---------------------------------------------->
        <div class="col-md-12 section-a">
            <div class="row">
                <div class="col-md-6 text-justify">
                    El río Santa Cruz, de 385 km de extensión, cruza la provincia homónima de oeste a este, partiendo del lago Argentino, a una altitud de 180 metros sobre el nivel del mar hasta su desembocadura en el océano Atlántico. La cuenca de este río tiene una superficie de 25.000 km2.
                    <br />
                    <br />
                    El Santa Cruz tiene el mayor potencial hidroeléctrico aprovechable de los ríos interiores de nuestro país, con particularidades que optimizan su aprovechamiento, como su doble regulación natural. En primer lugar, al ser un río de aporte glaciario, su caudal no depende solo de las precipitaciones estacionales, sino de la radiación solar que fusiona los hielos. En segundo lugar, el lago Argentino hace las veces de un embalse, regulando el caudal del río. 
                    <br />
                    <br />
                    Esta regularidad en el comportamiento hidráulico del río hace posible que el diseño operativo de las obras permita evitar la afectación sobre el estuario, ya que la central Jorge Cepernic descargará en forma permanente el mismo caudal que ingresa al río Santa Cruz desde el lago Argentino.
                    <br />
                    <br />
                    La presa Néstor Kirchner (NK) estará ubicada en la progresiva 253 del río, a 170 km de la ciudad de El Calafate, mientras que la presa Jorge Cepernic (JC) estará ubicada en la progresiva 187, a 135 km de la localidad de Comandante Luis Piedra Buena.
                    <br />
                    <br />
                </div>
                <div class="col-md-6 text-justify">
                    En su nivel máximo de operación normal (NAON), la presa NK generará un embalse de 238,5 km2 de superficie (equivalente al 16 % de la superficie del lago Argentino). El embalse JC, según la cota NAON, tendrá una superficie 190 km2 (equivalente al 13 % de la superficie del mismo lago).
                    <br />
                    <br />
                    Los aprovechamientos fueron modificados respecto del proyecto ejecutivo de licitación (2012), reduciendo la cota en NK, menor cantidad de turbinas en función de la modificación del diseño operativo en JC y una ampliación del caudal de los descargadores de fondo, entre otras modificaciones. 
                    <br />
                    <br />
                    Se ha realizado una readecuación de NK dada la sensibilidad mostrada por los estribos al avanzar en las excavaciones necesarias para fundar las estructuras. Los resultados de los estudios y ensayos e investigaciones geotécnicas realizados permitieron adoptar los parámetros correspondientes, y con ello definir las alternativas de las estructuras de fundación descriptas anteriormente. 
                    <br />
                    <br />
                    A su vez, sobre ambos estribos de la presa de cierre se han proyectado importantes rellenos de consolidación, minimizando las excavaciones, modificando la geometría en planta de la presa, mediante cambios de dirección de su eje, que hace que se emplace hacia aguas arriba.
                    <br />
                    <br />
                    A diferencia de otros proyectos hidroeléctricos, los embalses no requieren reasentamiento de población. Ello implica que se reduzcan sensiblemente las complejidades sociales del emprendimiento.
                    <br />
                    <br />
                </div>
            </div>
        </div>

        <!---------------------------------------------->
        <div class="col-md-12 section-b">
            <a id="ahrsc"></a>
            <h3 style="margin-bottom: 1em; color: #333;">AHRSC y obras complementarias</h3>

            <div class="embed-responsive" style="padding-top: 40%;">
                <iframe src="./geovisor.combo.php" frameborder="0"></iframe>
            </div>
        </div>

        <!---------------------------------------------->
        <div class="col-md-12 section-a">
             <!--
            <h3 style="margin-bottom: 1em; color: #333;">Avance de Obra</h3>
           
            <div class="embed-responsive" style="padding-top: 55%;">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/_wUvp8EoyiU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
             -->
        </div> 

        <!---------------------------------------------->
<div class="col-md-12  section-a condor">
    <a id="condor"></a>
    <h3 style="margin-bottom: 1em; color: #4f81bd;">Presa Presidente Nestor Kirchner</h3>

    <p style="font-size: 14px;">
        La presa Pte. Néstor Kirchner es del tipo CFRD (concrete face rockfill dam), es decir, una presa de materiales sueltos con pantalla de hormigón, construida con materiales naturales procedentes de yacimientos cercanos al lugar. Presenta una presa principal que cierra el cauce del río y la mayor parte del valle extendiéndose desde la margen derecha, donde la misma presenta una curvatura hacia aguas arriba, hasta alcanzar las obras de hormigón cubriendo una longitud total de unos 1250 m. La margen izquierda se cierra con una presa curva que se extiende desde las obras de hormigón hacia aguas arriba hasta su empotramiento en la margen izquierda con una longitud total de unos 655 m. El coronamiento posee un ancho de 12 m, a un nivel de 180,6 mIGN. Sobre el mismo se dispone de una calzada pavimentada de 7,30 m, con su correspondiente vereda de 2,00 m. Hacia aguas arriba, se coloca un muro rompeolas que también cumple la función de baranda. El volumen de terraplén es de aproximadamente 10 millones de metros cúbicos. La altura de la presa desde su coronamiento hasta el fondo del cauce es de 68 m.
        <br />
        <br />
                <div class="contentIMG_page">
                    <img src="./images/pagina_proyecto/img-1.webp" class="default_img_proyecto" /> 
                </div>
                <div class="text_img">
                    Planta general de las obras
                </div>
        <!----------------------------------
        <div class="subtitulo_proyecto">
                Planta general de las obras
        </div>
        ---------------------------------->
        La pantalla de hormigón se materializa mediante losas de 15 m de ancho y 0,35 m de espesor, con juntas verticales entre losas. 
        <br />
        <br />
        En particular, esta presa se funda sobre el aluvión del río. Por este motivo, se ejecutará un muro colado de hormigón armado de 0,80 m de espesor, ejecutado por medio de paneles de 6,00 m de ancho con el objetivo de efectuar el cierre del escurrimiento subterráneo. Se prevé que este muro penetre en la roca una profundidad de 7 m, aunque este valor deberá ser ajustado en la ingeniería de detalle. 
        <br />
        <br />  
        
        
        <div class="subtitulo_proyecto">
                Obra de descarga
        </div>
        Los órganos de seguridad se materializan mediante una obra de descarga que incluye al vertedero, los descargadores de fondo y medio fondo, la obra de desvío y la obra de disipación de energía. A la derecha de la obra de descarga se integra un muro de ala como contención y empalme con la presa principal. La obra de descarga se ubica en la margen izquierda sobre un sector del valle, en la margen izquierda junto con la obra de la central en el extremo del cierre. 
                <div class="contentIMG_page">
                    <img src="./images/pagina_proyecto/img-2.png" class="default_img_proyecto" /> 
                </div>
                <div class="text_img">
                    NK – Corte de la obra de descarga
                </div>
        Sus características principales son: <br />
            <ul style="margin-left:20px;">
                <li>   
                    4 vanos de vertedero superficial de 12 m de ancho, con cresta a cota 167.5 m equipado con compuertas de 9.5 m de altura diseñados para descargar la crecida asociada según  el Pliego a 10.000 años de recurrencia de 4163 m3/s con una cota de embalse de 179.3 m.<br />
                    El diseño propone una rápida escalonada, protegida con la incorporación de un aireador al inicio de la misma, que logra reducir significativamente la potencia a disipar en el cuenco disipador. La disipación final es realizada por medio de un resalto hidráulico en un cuenco ubicado a cota +97 m y de 100 m de longitud. Aguas abajo del cuenco se realizará una obra de protección.<br />
                    El cuenco presenta un muro central que divide el vertedero en dos, permitiendo, entre otras cosas, la posibilidad de cerrar medio vertedero para la inspección, mantenimiento o reparación por períodos prolongados sin anular la capacidad de descarga del proyecto.<br />
                    También es de notar que la capacidad de descarga de diseño estipulada ha resultado compatible con las recientes determinaciones de los hidrogramas de Crecida Máxima Probable desarrollados. Incluso, de acuerdo con las recomendaciones para este tipo de obras, se han realizado análisis de situaciones de falla de equipamiento mecánico lo que permite concluir que el proyecto muestra una gran flexibilidad y robustez en relación con su capacidad de descarga por el vertedero, tanto en el caso que se encuentren todas sus compuertas operativas como en el caso de falla de una de ellas.
                 </li> <br />
                 <li>
                    4 descargadores de Fondo con capacidad de 1400 m3/s para la cota 176.5 m. Los descargadores de fondo presentan compuertas radiales de 3 m x 4 m con un umbral a cota 122 m y compuertas planas de guardia aguas arriba. Además, está previsto la construcción de una guía para poder materializar un tercer cierre para permitir su mantenimiento general.
                 </li> <br />
                 <li>
                 	4 descargadores Auxiliares de Medio Fondo para complementar la capacidad de descarga de fondo a ser utilizados sólo y eventualmente durante la operación del llenado del embalse y ante la necesidad de una operación de vaciado de emergencia. Son conductos de 4 m x 5 m con un umbral a cota 150 m. Presentan una capacidad de 1400 m3/s a cota 176.5 mIGN.
                 </li> <br />
                 <li>
                    4 conductos de desvío con capacidad de 2100 m3/s para cota aproximadamente 121 m. Son conductos de 8 m x 10 m con un umbral a cota 100 m que funcionarán para todo el rango operativo a presión debido a ubicarse por debajo de la cota mínima de restitución. Cada conducto presenta dos tomas de 4 m x 10 m para permitir su cierre desde aguas arriba y poder finalmente ser taponados.
                 </li> <br />
            </ul>

        <br />


        <div class="subtitulo_proyecto">
            Obras de Toma para la Casa de Máquinas
        </div>
        La obra de toma posee la función de recibir el agua y posteriormente, mediante las tuberías forzadas, conducirla hacia la casa de máquinas. Consiste en una estructura de hormigón de gravedad de 5 bloques de 27 m de ancho cada uno donde se incorpora la toma con rejas de protección con una embocadura acampanada convergente a una sección de 9 m de diámetro donde comienza la tubería de presión del mismo diámetro. Se contempla una compuerta de emergencia, y una recata que posibilita la instalación de ataguías para realizar mantenimiento. Luego, el caudal 
        <br />
        <br />
        recorre una transición desde una sección rectangular hacia la sección circular de 9 m de diámetro, coincidente con las dimensiones de la tubería forzada, que posee una longitud de aproximadamente 100 m hasta su conexión con las turbinas ubicadas en la casa de máquinas. 
        <br />
        <br />
        Esta estructura, en su coronamiento, es recorrida longitudinalmente por una grúa pórtico. Posee la capacidad de manipular las rejas y los juegos de ataguías. Asimismo, otorga la posibilidad de facilitar el montaje y mantenimiento de las compuertas del cierre de emergencia con su respectivo sistema de accionamiento. 
        <br />
        <br />
                <div class="contentIMG_page">
                    <img src="./images/pagina_proyecto/img-3.webp" class="default_img_proyecto" /> 
                </div>
                <div class="text_img">
                    NK - Obra de toma
                </div>



        <div class="subtitulo_proyecto">
            Casa de Máquinas
        </div>
        La casa de máquinas es una estructura de hormigón armado, ubicada a pie de presa, con una superestructura de cerramiento, a partir del nivel de techo de los generadores que se materializa mediante una estructura metálica. Se compone de un sector principal constituido por 5 módulos de 27 m de ancho cada uno, donde se alojan los 5 grupos turbogeneradores tipo Francis de 190 MW para un caudal de 350 m3/s, totalizando una capacidad de turbinado total de 1750 m3/s, la nave de montaje de 48 m y una nave auxiliar de servicios de 12 m de ancho. Hacia aguas abajo, por encima del nivel de generadores se encuentra el sector de emplazamiento de transformadores y por debajo las galerías eléctricas y mecánicas.
        <br />
        <br />
        El acceso principal se realiza desde el extremo de margen derecha, donde se ubica la nave de montaje. En el otro extremo se encuentra un área de soporte a las operaciones y la sala de control. 
        <br />
        <br />
        A nivel 123,77 m IGN, se encuentra la sala de generadores. Por sobre la misma se encuentra un puente grúa, equipado con un gancho principal y un gancho auxiliar, que se desplaza sobre las unidades y la nave de montaje. Este equipamiento se utiliza tanto para el montaje como para tareas de mantenimiento. En el sector exterior, se ubican 3 transformadores con sus respectivos pórticos de salida. Hacia aguas abajo se encuentra un pórtico grúa que se utiliza para la colocación de las ataguías del tubo de aspiración, cuando así lo requieran las tareas de mantenimiento.
        <br />
        <br />
        En niveles inferiores se ubican dos galerías eléctricas, donde desarrollan su recorrido las barras de salida hacia los transformadores. Adicionalmente se ubican los diversos equipos eléctricos, como tableros, que acompañan a las instalaciones de este tipo. En un nivel inferior se ha proyectado una galería mecánica. En la misma se distribuyen los distintos sistemas auxiliares como, por ejemplo, circuitos de aire comprimido, aceite, agua, etc. A su vez, se dispone de áreas que podrán ser utilizadas como talleres, tanto eléctricos como mecánicos o, por ejemplo, pañoles donde se almacenan repuestos.
        <br />
        <br />
        El Canal de Fuga de la Central comparte su muro derecho con el del cuenco disipador de la obra de descarga. Finalmente, el canal de descarga de la central está unificado con el de la obra de descarga.
                <div class="contentIMG_page">
                    <img src="./images/pagina_proyecto/img-4.webp" class="default_img_proyecto" /> 
                </div>
                <div class="text_img">
                    NK - Sección típica de la casa de máquinas
                </div>



        <div class="subtitulo_proyecto">
            Escala de Peces
        </div>
        La presa está diseñada con una escala para transferencia de peces, cuyo objeto es posibilitar la migración hacia aguas arriba de la fauna íctica. A partir del prediseño disponible, se seguirán los lineamientos de ingeniería de la escala de JC que ha sido adaptada y mejorada. 
        <br /><br />
                <div class="contentIMG_page">
                    <img src="./images/pagina_proyecto/img-5.png" class="default_img_proyecto" /> 
                </div>
                <div class="text_img">
                </div>


        <div class="subtitulo_proyecto">
            Obra de desvío
        </div>
        Para posibilitar la construcción de la presa, el río será desviado sobre la margen izquierda a través de un canal con una capacidad de conducción de 2.100 m3/s, correspondiente a un caudal de recurrencia de 25 años. El desvío es un proceso que se subdivide en cuatro etapas:
        <ol style="margin-left:20px;"> <br />
                <li>   
                    Excavación en roca del canal sobre la margen izquierda, emplazando dos ataguías de materiales sueltos aguas arriba y aguas debajo de este para que el canal quede aislado del río;
                 </li> <br />
                 <li>
                    Construcción de la estructura del canal en hormigón armado;
                 </li> <br />
                 <li>
                    Apertura de ambas ataguías y cierre del río, para promover el escurrimiento del agua por el desvío, de manera tal que la zona de obra quede seca para poder realizar los trabajos. Una vez que la obra civil haya concluido se procede a la etapa siguiente;
                 </li> <br />
                 <li>
                    Cierre de cuatro de los ocho módulos del canal y transformación de los cuatro restantes en el descargador de fondo de la presa.
                 </li>
            </ol>
        </p>

<!-- 
<br />
Link   a inmagenes en la mediateka 
<a target="_blank" href="<?php $servicio_catalogo->GET_LINK(8);?>" >Néstor Kirchner en imágenes</a> 
<br />
-->
            
            <div class="row" style="padding-left: 2em; padding-right: 2em;">

                        <!-- <a target="_blank" href="./sga/recursos/difusion/componentes_cc.pdf">Descripción de componentes</a>-->
                        <!-- <a target="_blank" href="./fichas/componentes_cc.docx">Descripción de componentes</a>-->
                        <!-- <a target="_blank" href="./sga/recursos/difusion/cc_ficha.pdf">Ficha técnica</a>-->
                        <!--<a target="_blank" href="./fichas/ficha_tecnica_cc.pdf">Ficha técnica</a>-->
                        <br />
              </div>
            </div>
        </div>
        <!--------- GALERIA DE IMAGENES NK ------------->
        <div id="galery_nk">    </div>
        <div id="img_open"> </div>


        <!---------------------------------------------->
        <div class="col-md-12 section-a barrancosa">
            <a id="barrancosa"></a>
            <h3 style="margin-bottom: 1em; color: #4f81bd;">Presa Gobernador Jorge Cepernic</h3>

            <p style="font-size: 14px;">
                La presa Gobernador Jorge Cepernic posee características similares a NK, y se ubica a 65 km aguas abajo. 
                <br /><br />
                Tiene una longitud de 2.445,25 m, el coronamiento a un nivel de 118,50 mIGN con un ancho de 12 m. La altura máxima sobre el cauce es de 41 m. 
                <br /><br />
                El volumen de terraplén que constituye el cuerpo de la presa es de aproximadamente 6 millones de metros cúbicos y se encuentra zonificado mediante distintos tipos de materiales que tienen como característica permitir el drenaje de posibles filtraciones e impedir el arrastre de materiales finos y la pérdida de resistencia estructural. Al estar fundada sobre aluvión, dispone de un muro colado que garantiza el cierre hidráulico subterráneo.
                <br /><br />
                Sobre la margen derecha, inmediatamente a continuación de la casa de máquinas, el cierre se materializa mediante un muro de gravedad de hormigón. El mismo se extiende en una longitud de 90m.
                
                <div class="subtitulo_proyecto">
                    Obras de seguridad
                </div>
                El vertedero se localiza sobre el sector de la margen derecha del cierre. Dispone de cinco vanos de 12 m cada uno, con capacidad de descarga de 4.163 m3/s (diseñado con una recurrencia de 10.000 años). Dentro de la estructura del vertedero se ubican los conductos y dispositivos de cierre que constituyen el descargador de fondo con capacidad para 1.200 m3/s. El equipamiento se completa con ataguías de mantenimiento, compuertas de emergencia y control de caudales.
                <br /><br />
                Asimismo, para la etapa de desvío del río dispondrá de 6 conductos oficiando como estructura de control durante esta etapa. Una vez concluida su operación, se procederá a rellenar estos orificios con hormigón.
                <br /><br />
                Sobre el coronamiento, ubicado aguas arriba del eje del vertedero, se ubica el puente carretero. Hacia aguas abajo se presenta una grúa pórtico que recorre longitudinalmente la estructura. Este dispositivo se ha diseñado para permitir el manipuleo de las ataguías para mantenimiento del descargador de fondo y del vertedero. 
                <br /><br />
                En correspondencia con los niveles cercanos a la fundación, se dispone de dos galerías de inspección, desde las cuales se prevé realizar la cortina de inyecciones para impermeabilización de la fundación. 
                
                <div class="contentIMG_page">
                    <img src="./images/pagina_proyecto/img-6.jpg" class="default_img_proyecto" /> 
                </div>
                <div class="text_img">
                    JC - Corte de la obra de descarga
                </div>

                <div class="subtitulo_proyecto">
                    Casa de máquinas
                </div>
                La casa de máquinas se localiza hacia la izquierda del vertedero. Es una estructura de hormigón, con cubierta metálica. Se compone de 3 módulos de 28 m cada uno, donde la toma se encuentra incorporada a la casa de máquinas. Aloja tres turbinas del tipo Kaplan de 120 MW cada una (360 MW en total). El régimen de operación es de base y la generación anual estimada es 1.903 GWh/año. Atendiendo a consideraciones ambientales, la operación normal de JC consistirá en erogar el mismo volumen de agua que ingresa al río desde el lago Argentino en cada momento, de modo tal que aguas abajo de la presa (que incluye la zona del estuario) el río reciba el mismo caudal que recibiría si ambas obras no existiesen. De esta manera, la central de JC operará las 24 horas del día, generando la energía que el caudal ingresante al río le permita, respetando las variaciones naturales del río Santa Cruz en la embocadura. Se encuentra equipada con un juego de rejas inclinada que se moviliza mediante un pórtico grúa. El mismo también se utiliza para la colocación del juego de ataguías de mantenimiento. El cierre de emergencia se efectúa mediante una compuerta plana equipada con ruedas y accionada mediante un sistema hidráulico.
                
                <div class="contentIMG_page">
                    <img src="./images/pagina_proyecto/img-7.jpg" class="default_img_proyecto" /> 
                </div>
                <div class="text_img">
                    JC – Sección típica de la casa de máquinas
                </div>

                La sala de generadores se encuentra a cota 84,25 mIGN. El acceso se realiza desde el extremo derecho, donde ubica también la nave de montaje. Sobre las 3 unidades y la nave de montaje, se encuentra el puente grúa que se utiliza principalmente para el montaje y el posterior mantenimiento de las unidades. En el sector exterior, se encuentran los transformadores y el pórtico grúa que opera para la colocación y retiro del juego de ataguías cuando se quiere cerrar el tubo de aspiración.
                <br /><br />            
                A cotas inferiores, se encuentran las galerías eléctricas y mecánicas. La funcionalidad y el equipamiento que se dispone es equivalente al mencionado para la casa de máquinas de NK.

                <div class="subtitulo_proyecto">
                    Escala de peces
                </div>
                El aprovechamiento posee una escala de peces, que ha sido mejorada respecto de la propuesta del pliego, que era exclusivamente para salmónidos. El diseño actual consiste en una escala mixta que contará con una rampa de acceso cuyas adaptaciones permiten el ingreso de la Lamprea. Como complemento, se instalará una escala específica para esta especie nativa.
                <br /><br /> 
                La descarga de la escala de peces no será directamente al embalse sino que se diseña una Estación de Conteo y Monitoreo, con el objetivo de flexibilizar el manejo de los ejemplares que ascienden por la escala, pudiendo capturarlos para su análisis en el laboratorio instalado en el sector, previo a su salida al embalse. El proyecto cuenta además con un Centro de Visitantes.
                <div class="contentIMG_page">
                    <img src="./images/pagina_proyecto/img-8.png" class="default_img_proyecto" /> 
                </div>
                <div class="text_img">
                    JC – Esquema 3D de la escala de peces
                </div>

                <div class="subtitulo_proyecto">
                    Desvío del río 
                </div>
                La obra de desvío se compone de un canal a cielo abierto de sección trapezoidal, con ancho de solera de 120 m y taludes 1V:2,5H, que conduce el caudal desde el cauce natural de río, hasta la estructura de control. La estructura de control mencionada tendrá diez conductos, dos en cada vano del vertedero. Posteriormente, los seis conductos ubicados a la derecha del canal se reconvertirán, conformando el descargador de fondo, obturándose los cuatro restantes.
                <br /><br /> 
                Para este aspecto constructivo, pueden distinguirse dos etapas:
                <ol style="margin-left:20px;"> <br />
                    <li>   
                        Excavación del Canal de Desvío y construcción del vertedero con sus 5 vanos y 10 orificios en el cuerpo de hormigón, los cuales serán utilizados en la segunda etapa para el desvío del río. En esta etapa, el río se mantendrá en su curso natural por la margen izquierda del valle.
                    </li> <br />
                    <li>
                        Finalizada la construcción del vertedero y la excavación del canal de desvío, se procede al cierre del cauce natural mediante una ataguía de materiales sueltos, permitiendo el desvío del río a través del canal excavado y los 10 orificios construidos en el cuerpo del vertedero.
                    </li>
                </ol>

            </p>
            </div>
            <!--------- GALERIA DE IMAGENES JC ------------->
            <div id="galery_jc">    </div>
 

<!-- Link a imagenes en mediateka
<a target="_blank" href="<?php   $servicio_catalogo->GET_LINK(7);?>" >Jorge Cepernic en imágenes</a> 
-->
<!--
<a target="_blank" href="./sga/recursos/difusion/lb_ficha.pdf">Ficha técnica</a>        
-->


        <!---------------------------------------------->
        <a id="leat"></a>
        <div class="section-a">
            <h3 style="color: #4f81bd;">Línea eléctrica de alta tensión (LEAT)</h3>
            <div style="display:flex; flex-wrap:wrap; justify-content:space-between;">
                <div style="width:48%;">
                    <p>
                    Los aprovechamientos estarán conectados al Sistema Argentino de Interconexión (SADI) a través de una línea de extra alta tensión (LEAT) de 500 kV. Tanto la central NK como la JB poseen estaciones transformadoras de 500 kV, el voltaje en el cual se trasmite la electricidad a largas distancias. Adicionalmente, se instalarán los equipos necesarios en las estaciones Río Santa Cruz, Río Santa Cruz Norte y Puerto Madryn. 
                        <br />
                        <br />
                    </p>
                </div>
                <div style="width:48%;">
                    <p>
                    La LEAT tendrá su punto de partida en la playa de maniobras de NK y estará conectada con la instalación correspondiente en JC. La longitud de este tramo es de aproximadamente 71 km. A partir de este punto, recorre aproximadamente 102 km hasta conectarse a la estación transformadora 500/132 kV Río Santa Cruz, cercana a la localidad de Comandante Luis Piedra Buena.
                        <br />
                        <br />
                        <!--<a target="_blank" href="./sga/recursos/difusion/leat_ficha.pdf" title="EN DESARROLLO">Ficha t&eacute;cnica</a>-->                        
                    </p>
                </div>                
                <a target="_blank" href="./sga/recursos/difusion/leat_ficha.pdf" style="width:100%;">Ficha Técnica de la LEAT</a>
                  
            </div>
        </div> 
        <!--------- GALERIA DE IMAGENES LEAT ------------->
        <div id="galery_leat">    </div>
    
</div>

<script type='text/javascript'>
$(document).ready(function() {
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

    $('.section-footer-button2').hover(
        function() {
            let key = $(this).data('key');
            $(this).css('background-image', 'url("./images/icono-' + key + '-relleno-hover.png")')
        },
        function() {
            let key = $(this).data('key');
            $(this).css('background-image', 'url("./images/icono-' + key + '-relleno.png")')
        }
    )


    get_data_galery('NK','galery_nk')
    get_data_galery('JC','galery_jc')
    get_data_galery('LEAT','galery_leat')


});
</script>
