<?php include("./fn.php"); ?>
<?php

$b=1;

if (isset($_GET["b"])) { $b = $_GET["b"]; } 

?>

<!DOCTYPE html>
<html lang="es">
<head>
	
	<?php include("./scripts.analytics.php"); ?>

	<title>PROYECTO</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<?php include("./scripts.default.php"); ?>
	<?php include("./scripts.openlayers.php"); ?>	
	<?php include("./scripts.map.patrim.php"); ?>
	<?php include("./scripts.onresize.php"); ?>

	<script src ="./js/geovisorpatrim.js" type='text/javascript'></script>
	
	<style>
	
		#popup-results,#popup-results-preparse {
			
			display:none;
			
		}
		
		.buttons {
			
			position:absolute;
			z-index:10000;
			display:flex;
			justify-content:center;
			width:100%;
			padding-top:10px;
			
		}
		
		.buttons .black-button {
			
			margin-right:15px;
			display: inline-flex;
			justify-content:center;
			width:30%;
			
		}
		
		.buttons .black-button:first-child {
			
			margin-left:15px !Important;
			
		}
		
		.buttons .black-button:last-child {
			
			margin-right:0px !Important;
			
		}
		
		#zoom-navbar {
			
			position:absolute !important;
			
		}
		
	</style>
	
</head>
<body style="overflow:hidden;">

	<div id="page" style="background-color: #f4f4f4;" class="h100p">
		
		<div class="page-container h100p">
		
			<?php include("./section.page_geovisor_patrim.php"); ?>
			
		</div>
		
	</div>
	
	<div id="popup-results"></div>	
	<div id="popup-results-preparse"></div>
	
	<script type="text/javascript">

		B="<?php echo $b; ?>";
		if (B!="") { document.getElementById("btn-com-"+B).click(); }else{ document.getElementById("btn-com-1").click(); }

	</script>
	
</body>
</html>