<?php include("./pgconfig.php"); ?>

<?php
	
	//include("../include.vars.pg.php");
	
	if ((isset($_POST["usuario_login_name"])) && (isset($_POST["usuario_pass"]))) {
		
		$user_name = trim($_POST["usuario_login_name"]);
		
		$user_password = trim($_POST["usuario_pass"]);
		
		$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
		$conn = pg_connect($string_conn);
		
		$query_string = "SELECT * FROM mod_login.user_data WHERE user_name = '$user_name' AND user_pass = md5('$user_password')";
		
		$query = pg_query($conn,$query_string);
		
		$n_registros = pg_num_rows($query);
		
		$result = pg_fetch_assoc($query);
		
		$logged = false;
		
		if ($n_registros > 0) {
			
			$logged = true;
			
			session_start();
			
			$_SESSION["user_info"] = $result;
			
		}
		
	}else{
		
		die("Invalid Token");
		
	}
	
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Inicio</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php include("./scripts.default.php"); ?>
	<?php include("./scripts.onresize.php"); ?>		
	<?php include("./scripts.document_ready.php"); ?>
</head>
<body>
	<div id="index">
	
		<div class="page-container">			
				
			<?php include("./header.php"); ?>
			
			<div class="row">
			
				<div class="col col-md-4 col-lg-4 col-xs-12 col-sm-12"></div>
				
				<div class="col col-md-4 col-lg-4 col-xs-12 col-sm-12 pv-30">
					
					<?php if ($result) { ?>
						
						<h2 class="m-v-50" style="font-size:24px;">
							<p>Bienvenido <?php echo $_SESSION["user_info"]["user_full_name"]; ?>!</p>
						</h2>
						
						<h3 class="text-success" style="font-size:14px;"> Redireccionando por favor espere... </h3>
						
						<?php
						
					}else{
						
						?>
						
						<h2 class="m-v-50" style="font-size:16px;">
							<p>Los datos ingresados son incorrectos</p>
							<p>Por favor verifique la información ingresada y vuelva a intentar</p>
						</h2>
						
						<h3 class="text-danger" style="font-size:14px;"> Redireccionando por favor espere... </h3>
						
						<?php
						
					}
					
					?>
					
					<script type="text/javascript">
					
						setTimeout(function() {
										
							location.href = "<?php echo $_SERVER["HTTP_REFERER"]; ?>"
										
						},5000);
							
					</script>
			
				</div>
			
			</div>
			
			<?php include("./footer.php"); ?>
			
		</div>
		
	</div>
	
</body>
</html>