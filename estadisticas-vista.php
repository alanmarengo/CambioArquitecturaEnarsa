<?php

if (!isset($_GET["dt_id"])) { die("Invalid Token;"); }
if (!isset($_GET["dt_v"])) { die("Invalid Token;"); }
if (!isset($_GET["dt_c"])) { die("Invalid Token;"); }
if (!isset($_GET["dt_t"])) { die("Invalid Token;"); }

$dt_id = $_GET["dt_id"];
$dt_variables = $_GET["dt_v"];
$dt_cruce = $_GET["dt_c"];
$dt_titulo = $_GET["dt_t"];

?>

<?php include("pgconfig.php"); ?>
<?php include("stats.fn.php"); ?>
<?php include("./fn.php"); ?>
<?php include("./login.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	
	<?php include("./scripts.analytics.php"); ?>

	<title>Estadísticas</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<script src="./js/sldlib.js" type="text/javascript"></script>	
			
	<?php include("./scripts.default-stats-view.php"); ?>	
	<?php include("./scripts.stats.view.php"); ?>	
	<?php include("./scripts.onresize.php"); ?>	
	<?php include("./scripts.openlayers.php"); ?>	
	<?php include("./scripts.highcharts.php"); ?>
	<?php include("./scripts.document_ready.stats.view.php"); ?>
	
	<?php // include("./scripts.default.php"); ?>
	
</head>
<body>

	<form id="frm-dt">
		<input type="hidden" name="dt_id" id="dt_id" value="<?php echo $dt_id; ?>">
		<input type="hidden" name="dt_v" id="dt_v" value="<?php echo $dt_variables; ?>">
		<input type="hidden" name="dt_c" id="dt_c" value="<?php echo $dt_cruce; ?>">
	</form>
	
	<div id="page">
	
		<?php include("./html.navbar-main.php"); ?>
		<?php include("./html.navbar-tools-stats-view.php"); ?>
		
		<div class="page-container" style="width:98%;">
		
			<?php //include("./section.index.php"); ?>
			
			<?php include("./html.navs.php"); ?>
			
			<div class="row jump-row">
			
				<?php include("./html.panel-view.php"); ?>
			
			</div>
			
		</div>
		
	</div>
	
	<?php include("./widget-links.php"); ?>
	<?php include("./popup.gm.php"); ?>
	<?php include("./html.jalert.php"); ?>
	<?php include("./popup.share.php"); ?>
	
	<div id="print-view">
	
		<div class="row jump-row">
		
			<div class="col col-md-12 col-xs-12 col-sm-12 col-xs-12 jump-posrel">
			
				<img src="./images/print-header.png">
				
				<a href="#" id="close-print" onclick="$('#print-view').hide(); $('#print-body').empty();">
				
					<i class="fa fa-times"></i>
					
				</a>
				
				<a href="#" id="icon-print" onclick="stats.printBrowser();">
				
					<i class="fa fa-print"></i>
					
				</a>
			
			</div>
		
		</div>
		
		<hr class="mt-30">
		
		<div class="row jump-row" id="print-body">
		
		
		
		</div>
	
	</div>

</body>
</html>
