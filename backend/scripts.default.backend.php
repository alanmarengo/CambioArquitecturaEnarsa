<!-- CSS -->	

<!-- FONTS -->

<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="./fontawesome-5.8.1/css/all.min.css" />	

<link rel="stylesheet" href="./css/ti-icons/css/themify-icons.css">

<!-- BOOTSTRAP + LIBS -->

<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="./css/bootstrap-datepicker.min.css" />
<link rel="stylesheet" type="text/css" href="./css/bootstrap-select.css" />
<link rel="stylesheet" type="text/css" href="./css/HoldOn.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/simplebar/4.2.3/simplebar.css" />
<link rel="stylesheet" type="text/css" href="./css/site.css" />

<!-- SITE CSS -->

<link rel="stylesheet" type="text/css" href="./css/flex.css" />
<link rel="stylesheet" type="text/css" href="./css/margins.css" />
<link rel="stylesheet" type="text/css" href="./css/sizes.css" />
<link rel="stylesheet" type="text/css" href="./css/backend.css" />

<!-- SCRIPTS -->

<!-- JQUERY + UI -->	

<link rel="stylesheet" type="text/css" href="./css/jquery_ui.css" />
<script type="text/javascript" src="./js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="./js/jquery-ui/jquery-ui.min.js"></script>	

<!-- JS GRID -->

<link rel="stylesheet" type="text/css" href="./js/jsgrid/jsgrid.min.css" />
<link rel="stylesheet" type="text/css" href="./js/jsgrid/jsgrid-theme.min.css" />

<!-- ROVERLAY -->

<link rel="stylesheet" type="text/css" href="./css/roverlay.css" />
<link rel="stylesheet" type="text/css" href="./css/roverlay-theme.css" />
<link rel="stylesheet" type="text/css" href="./css/info-box.css" />
<script type="text/javascript" src="./js/roverlay.js"></script>

<!-- DT OB -->

<script type="text/javascript" src="./js/dtob.js"></script>

<!-- FILE DROPPER -->

<link rel="stylesheet" type="text/css" href="./js/file_dropper/css/file_dropper.css" />
<script type="text/javascript" src="./js/file_dropper/file_dropper.js"></script>

<!-- DIRECTORY READER -->

<link rel="stylesheet" type="text/css" href="./js/directory_reader/css/directory_reader.css" />
<script type="text/javascript" src="./js/directory_reader/directory_reader.js"></script>

<!-- TOOLTIPSTER CSS -->

<link rel="stylesheet" href="./js/tooltipster/dist/css/tooltipster.bundle.min.css"/>
<link rel="stylesheet" href="./js/tooltipster/dist/css/tooltipster-sideTip-shadow.min.css"/>

<!-- POPPER -->	
<script src="./js/popper-1.12.9.min.js"></script>

<!-- BOOTSTRAP + LIBS -->	
<script type="text/javascript" src="./js/bootstrap.bundle.min.js"></script>
<script src="./js/bootstrap-select.js"></script>
<script src="./js/HoldOn.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/simplebar/4.2.3/simplebar.js"></script>
<script src="./js/moment.js"></script>
<script src="./js/moment-es.js"></script>
<script src="./js/site.js" type="text/javascript"></script>
<script src="./js/datepicker.js" type="text/javascript"></script>	

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
        'http://observatorio.atic.com.ar' : // LOCAL
        '.'; // SERVER

    echo "var GlobalApiUrl = '$api_url';";
?>


</script>