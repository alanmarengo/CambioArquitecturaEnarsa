<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ieasa - Observatorio Ambiental</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="./fontawesome-5.8.1/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="./fonts/gotham/gotham.css"/>
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="./css/bootstrapfix.navbar.css" />
    <link rel="stylesheet" type="text/css" href="./css/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="./css/bootstrap-select.css" />
    <link rel="stylesheet" type="text/css" href="./css/site.css" />
    <link rel="stylesheet" type="text/css" href="./css/perfect-scrollbar.css" />
    <link rel="stylesheet" type="text/css" href="./css/scrollbars.css" />
    <link rel="stylesheet" type="text/css" href="./css/sidenav-index.css" />
	<link rel="stylesheet" type="text/css" href="./css/widget-links.css"/>

    <script src="./js/jquery-3.2.1.min.js"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/bootstrap-datepicker.min.js"></script>
    <script src="./js/bootstrap-datepicker.es.min.js"></script>
    <script src="./js/bootstrap-select.js"></script>
    <script src="./js/popper-1.12.9.min.js"></script>
    <script src="./js/openlayers/ol.js" type="text/javascript"></script>
    <script src="./js/perfect-scrollbar.js" type="text/javascript"></script>
    <script src="./js/scrollbars.js" type="text/javascript"></script>
    <script src="./js/moment.js"></script>
    <script src="./js/moment-es.js"></script>
    <script src="./js/site.js" type="text/javascript"></script>
    <script src="./js/map.js" type="text/javascript"></script>
    <script src="./js/nav.js" type="text/javascript"></script>
    <script src="./js/widget-links.js" type="text/javascript"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.css">
    <script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js"></script>
	
	<script type="text/javascript">
	
		window.addEventListener("load",function() {	
			
			setNav();					
			
			scrollbars = new scrollbars();
			scrollbars.create();
			scrollbars.updateSize();
			
		});
	
	</script>
	
</head>

<body>

<?php include("./htmlnav.php"); ?>

<div id="page">

    <nav class="navbar navbar-dark bg-light" id="nav-1">
        <button class="navbar-toggler" type="button" data-toggle="collapse" 
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" onclick="nav();">
            <span class="navbar-toggler-icon">
                <i class="fa fa-navicon"></i>
            </span>
        </button>

        <a class="navbar-brand" href="./index.php">
            Observatorio
            <img src="./images/ieasa_logo.png" id="logo_ieasa" height="30">
        </a>

        <div class="nav navbar-expand navbar-right" style="display: inline-block;" id="navIcons">
            <ul class="navbar-nav">
                <li class="nav-item nav-item-search">
                    <a class="nav-link nav-item-button nav-link-button">
                        <i class="fa fa-search"></i>
                        <input id="main-search" name="main-search" type="text" placeholder="Buscar en todo el sitio">
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-item-button nav-link-button" href="#" id="navbarDropdown-help" role="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-question-circle"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown-help">
						<a class="dropdown-item" href="./images/EIASA Manual Observatorio.pdf">Manual de Usuario</a>
						<a class="dropdown-item" href="#">Video Explicativo</a>
					</div>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-item-button nav-link-button" href="#">
                        <i class="fa fa-user"></i>
                    </a>
                </li>
            </ul>
        </div>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            </ul>
        </div>
    </nav>
