<?php 

//include("./login.php");

error_reporting(0);

if ((isset($_SESSION)) && (sizeof($_SESSION) > 0)) {

?>

	<li class="dropdown">
		<a href="#" id="navbarDropdown-help" title="Datos de Usuario" role="button" data-toggle="dropdown" aria-expanded="false" title="Menu de usuario">
			<i class="fa fa-user"></i>
		</a>
		<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown-help" id="dropdown-help">
			<ul>
				<!--
				<li>
					<a class="dropdown-item" href="#">Mi Panel</a>
				</li>
				<li>
					<a class="dropdown-item" href="#">Mi Colección</a>
				</li>
				-->
				<?php if( $_SESSION["user_info"]["perfil_usuario_id"]=='3'){echo '<li><a class="dropdown-item" href="./backend/backend-index.php">Gestión de contenidos</a></li>'; }; ?>
				
				<li>
					<a class="dropdown-item" href="./CMD-logout.php">Cerrar Sesión</a>
				</li>
				<li style="line-height:10px; height:10px;">
					<span></span>
				</li>
			</ul>
		</div>            
	</li>

<?php }else{ ?>
	
	<li class="dropdown">
		<a href="#" id="navbarDropdown-user"title="Acceder" role="button" data-toggle="dropdown" aria-expanded="false" title="Menu de usuario">
			<i class="fa fa-user"></i>
		</a>
		<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown-user" id="dropdown-user">
			<form method="post" action="./CMD-login.php" id="frm">
				<ul>
					<li>
						<div class="form-group form-group-login">
							<i class="fa fa-user"></i>
							<input type="text" placeholder="Usuario" name="user-name" data-placeholder="Usuario">
						</div>
					</li>
					<li>
						<div class="form-group form-group-login">
							<i class="fa fa-key"></i>
							<input type="password" placeholder="Contraseña" name="user-password" data-placeholder="Contraseña">
						</div>
					</li>
					<li>
						<div class="form-group form-group-button">
							<a href="#" class="login-black-button" onclick="document.getElementById('frm').submit();">INGRESAR</a>
						</div>
					</li>
					<!--<li class="form-group form-group-link">
						<a href="#">Olvidé mi contraseña</a>
					</li>-->
					<li style="line-height:10px; height:10px;">
						<span></span>
					</li>
				</ul>
			</form>
		</div>
	</li>

<?php
	
}

?>
