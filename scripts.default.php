<!-- CSS -->	

<!-- PRETTY CHECKBOX -->

<link rel="stylesheet" href="./css/pretty-checkbox.css"/>
<link href="https://cdn.materialdesignicons.com/3.6.95/css/materialdesignicons.min.css" rel="stylesheet"> <!-- CHECKBOX FONTS -->

<!-- FONTS -->

<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="./fontawesome-5.8.1/css/all.min.css" />	

<!-- BOOTSTRAP + LIBS -->

<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="./css/bootstrap-datepicker.min.css" />
<link rel="stylesheet" type="text/css" href="./css/bootstrap-select.css" />
<link rel="stylesheet" type="text/css" href="./css/HoldOn.min.css" />
<link rel="stylesheet" type="text/css" href="./css/perfect-scrollbar.css" />
<link rel="stylesheet" type="text/css" href="./css/widget-links.css" />

<!-- SITE CSS -->

<link rel="stylesheet" type="text/css" href="./css/bodyfix.css">
<link rel="stylesheet" type="text/css" href="./css/nav.css">
<link rel="stylesheet" type="text/css" href="./css/navbar.main.css">
<link rel="stylesheet" type="text/css" href="./css/navbar.tools.css">
<link rel="stylesheet" type="text/css" href="./css/navbar.zoom.css">
<link rel="stylesheet" type="text/css" href="./css/hamburguer.css">
<link rel="stylesheet" type="text/css" href="./css/flexbox.css">
<link rel="stylesheet" type="text/css" href="./css/chrome_compat_fixes.css">

<!-- JUMP CSS -->

<link rel="stylesheet" type="text/css" href="./css/jump.align.css">
<link rel="stylesheet" type="text/css" href="./css/jump.button.css">
<link rel="stylesheet" type="text/css" href="./css/jump.spacers.css">
<link rel="stylesheet" type="text/css" href="./css/jump.displays.css"/>
<link rel="stylesheet" type="text/css" href="./css/jump.link.css"/>
<link rel="stylesheet" type="text/css" href="./css/jump.position.css"/>
<link rel="stylesheet" type="text/css" href="./css/jump.resizer.css"/>
<link rel="stylesheet" type="text/css" href="./css/jump.rowcol.css"/>
<link rel="stylesheet" type="text/css" href="./css/jump.spacers.css"/>
<link rel="stylesheet" type="text/css" href="./css/jump.sliders.css"/>
<link rel="stylesheet" type="text/css" href="./css/jump.scroll.css"/>
<link rel="stylesheet" type="text/css" href="./css/jump.theme.css" />
<link rel="stylesheet" type="text/css" href="./css/jump.window.css" />

<!-- GEOVISOR -->

<link rel="stylesheet" href="./css/geovisor/align.css"/>
<link rel="stylesheet" href="./css/geovisor/buttons.css"/>
<link rel="stylesheet" href="./css/geovisor/forms.css"/>
<link rel="stylesheet" href="./css/geovisor/layers.css"/>
<link rel="stylesheet" href="./css/geovisor/map.css"/>
<link rel="stylesheet" href="./css/geovisor/panel.css"/>
<link rel="stylesheet" href="./css/geovisor/popup.css"/>
<link rel="stylesheet" href="./css/geovisor/input.css"/>
<link rel="stylesheet" href="./css/geovisor/spacers.css"/>
<link rel="stylesheet" href="./css/geovisor/sizers.css"/>
<link rel="stylesheet" href="./css/geovisor/sliders.css"/>
<link rel="stylesheet" href="./css/geovisor/style.css"/>

<!-- COLORPICKER CSS -->

<link rel="stylesheet" href="./js/colorpicker/css/colorpicker.css"/>
<link rel="stylesheet" href="./css/spectrum.css"/>

<!-- TOOLTIPSTER CSS -->

<link rel="stylesheet" href="./js/tooltipster/dist/css/tooltipster.bundle.min.css"/>
<link rel="stylesheet" href="./js/tooltipster/dist/css/tooltipster-sideTip-shadow.min.css"/>

<link rel="stylesheet" type="text/css" href="./css/site.css" />
<!-- SCRIPTS -->

<!-- JQUERY + UI -->	

<script type="text/javascript" src="./js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="./js/jquery-ui/jquery-ui.min.js"></script>	
<script type="text/javascript" src="./js/jquery-ui/dragfix.js"></script>	

<!-- POPPER -->	
<script src="./js/popper-1.12.9.min.js"></script>

<!-- BOOTSTRAP + LIBS -->	
<script type="text/javascript" src="./js/bootstrap.min.js"></script>
<script src="./js/bootstrap-datepicker.min.js"></script>
<script src="./js/bootstrap-datepicker.es.min.js"></script>
<script src="./js/bootstrap-select.js"></script>
<script src="./js/HoldOn.min.js"></script>

<script src="./js/perfect-scrollbar.js" type="text/javascript"></script>
<script src="./js/scrollbars.js" type="text/javascript"></script>
<script src="./js/moment.js"></script>
<script src="./js/moment-es.js"></script>
<script src="./js/site.js" type="text/javascript"></script>
<script src="./js/widget-links.js" type="text/javascript"></script>

<!-- COLORPICKER JS -->

<script src="./js/colorpicker/js/colorpicker.js" type="text/javascript"></script>
<script src="./js/spectrum.js" type="text/javascript"></script>

<!-- TOOLTIPSTER JS -->

<script src="./js/tooltipster/dist/js/tooltipster.bundle.min.js" type="text/javascript"></script>

<!-- HTML 2 CANVAS -->

<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script src="./js/dom-to-image.js"></script>

<!-- JUMP JS -->

<script src="./js/jump.js"></script>
<script src="./js/jump.flotant.js"></script>
<script src="./js/jump.nav.js"></script>
<script src="./js/jump.hovimage.js"></script>
<script src="./js/jump.resizer.js"></script>
<script src="./js/jump.scroll.js"></script>
<script src="./js/jump.toggleimage.js"></script>
<script src="./js/jump.window.js"></script>

<script type="text/javascript">

<?php
    // DEFINICION DE URL PARA API
    $remote_addr = $_SERVER["REMOTE_ADDR"];
    $api_url = $remote_addr=='127.0.0.1' || $remote_addr=='::1' ? 
        'https://observatorio-dev.energia-argentina.com.ar/' : // LOCAL
        '.'; // SERVER

    echo "var GlobalApiUrl = '$api_url';";
    //echo "var GlobalApiUrl = '.';";
?>


</script>
