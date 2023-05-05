<?php// include("./pgconfig.php"); ?>
<?php include("./fn.php"); ?>
<?php// include("./ldap.php"); ?>
<?php
	
	require_once(dirname(__FILE__).'/MICROSERVICIOS/MIC-USUARIO/CAPA-APLICACION/SERVICIO/REPOSITORIO-SERVICIO.php');

	//$_POST["user-name"] = "fcaroff";
	//$_POST["user-password"] = "";
	//include("../include.vars.pg.php");
	
	if ((isset($_POST["user-name"])) && (isset($_POST["user-password"]))) 
	{	/*
		$logged = false;
		$servicio_usuario = new RepositorioServicioUsuario();

		$result = $servicio_usuario->login($_POST["user-name"],$_POST["user-password"]);

		if($result->flag)
		{	
			$logged = true;
			
			session_start();
			
			$_SESSION["user_info"] = $result->detalle['user_info'];
			
		}else{

			die("Invalid Token");
		} */
		
		//$user_name = trim($_POST["user-name"]);
		
		$user_name = pg_escape_string($_POST["user-name"]);
		
		//$user_password = trim($_POST["user-password"]);
		
		$user_password = pg_escape_string($_POST["user-password"]);
		
		//$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
		//$conn = pg_connect($string_conn);
		
		//$query_string = "SELECT * FROM mod_login.user_data WHERE user_name = '$user_name' AND user_pass = md5('$user_password')";
		
		//$query_string = "SELECT * FROM mod_login.user_data WHERE user_name = '$user_name' AND user_estado_id=1;"; //Si el usuario existe 
		
		//$query = pg_query($conn,$query_string);
		
		//$n_registros = pg_num_rows($query);
		
		//$result = pg_fetch_assoc($query);		
		
		$logged = false;

		$servicio_usuario = new RepositorioServicioUsuario();
		$result = $servicio_usuario->login($_POST["user-name"],$_POST["user-password"]);
				
		//var_dump($n_registros);
		//var_dump($result);
		
		if ($result->flag) 
		{			
			//$query_string = "SELECT * FROM mod_login.user_data WHERE user_name = '$user_name' AND user_pass = md5('$user_password')";
		
			//$query = pg_query($conn,$query_string);
		
			//$n_registros = pg_num_rows($query);
		
			//$result = pg_fetch_assoc($query);
			
			$logged = true;
		
			session_start();
		
			$_SESSION["user_info"] = $result->detalle["user_info"][0];

			//if(($n_registros>0)&&(strlen($user_password)>0))
			//{				

			//}

			
		} else  { die("Invalid Token"); };
		
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
	
</head>
<body style="overflow:hidden;">

	<div id="page">
	
		<?php include("./html.navbar-main.php"); ?>
		
		<div class="page-container" style="background-color: #FFFFFF; height:100%; padding:100px;">
		
			<?php
		
		if ($result->flag) {
			
			?>
			
			<h2 class="m-v-50" style="font-size:12px;">
				<p>Bienvenido <?php echo $_SESSION["user_info"]["user_full_name"]; ?>!</p>
			</h2>
			
			<h3 class="text-success" style="font-size:14px;"> Redireccionando por favor espere... </h3>
			
			<?php
			
		}else{
			
			?>
			
			<h2 class="m-v-50" style="font-size:12px;">
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
			
	<?php include("./html.navs.php"); ?>
			
	<?php include("./footer.php"); ?>
	
	<?php //include("./widget-links.php"); ?>

</body>
</html>
