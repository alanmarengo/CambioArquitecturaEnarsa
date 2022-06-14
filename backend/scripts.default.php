<!-- CSS -->	

<!-- FONTS -->

<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="./fontawesome-5.8.1/css/all.min.css" />	

<!-- BOOTSTRAP + LIBS -->

<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="./css/bootstrap-datepicker.min.css" />
<link rel="stylesheet" type="text/css" href="./css/bootstrap-select.css" />
<link rel="stylesheet" type="text/css" href="./css/HoldOn.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/simplebar/4.2.3/simplebar.css" />
<link rel="stylesheet" type="text/css" href="./css/site.css" />
<link rel="stylesheet" type="text/css" href="./css/margins.css" />
<link rel="stylesheet" type="text/css" href="./css/nav.css" />

<!-- SITE CSS -->

<!-- TOOLTIPSTER CSS -->

<link rel="stylesheet" href="./js/tooltipster/dist/css/tooltipster.bundle.min.css"/>
<link rel="stylesheet" href="./js/tooltipster/dist/css/tooltipster-sideTip-shadow.min.css"/>

<!-- SCRIPTS -->

<!-- JQUERY + UI -->	

<script type="text/javascript" src="./js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="./js/jquery-ui/jquery-ui.min.js"></script>	

<!-- POPPER -->	
<script src="./js/popper-1.12.9.min.js"></script>

<!-- BOOTSTRAP + LIBS -->	
<script type="text/javascript" src="./js/bootstrap.bundle.min.js"></script>
<script src="./js/bootstrap-datepicker.min.js"></script>
<script src="./js/bootstrap-datepicker.es.min.js"></script>
<script src="./js/bootstrap-select.js"></script>
<script src="./js/HoldOn.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/simplebar/4.2.3/simplebar.js"></script>
<script src="./js/moment.js"></script>
<script src="./js/moment-es.js"></script>
<script src="./js/site.js" type="text/javascript"></script>
<script src="./js/datepicker.js" type="text/javascript"></script>	
<script src="./js/nav.js" type="text/javascript"></script>	

<!-- COLORPICKER JS -->

<script src="./js/colorpicker/js/colorpicker.js" type="text/javascript"></script>
<script src="./js/spectrum.js" type="text/javascript"></script>

<!-- TOOLTIPSTER JS -->

<script src="./js/tooltipster/dist/js/tooltipster.bundle.min.js" type="text/javascript"></script>

<script type="text/javascript">

<?php
    // DEFINICION DE URL PARA API
    $remote_addr = $_SERVER["REMOTE_ADDR"];
    $api_url = $remote_addr=='127.0.0.1' || $remote_addr=='::1' ? 
        'http://sinia.atic.com.ar' : // LOCAL
        '.'; // SERVER

    echo "var GlobalApiUrl = '$api_url';";
?>


</script>
