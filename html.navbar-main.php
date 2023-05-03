
<div class="navbar flebox jump-navbar" id="navbar-main">
	
<!---
	<div class="row jump-row menu-row" style="background-color: #ccc; font-size: 11px; padding: 1px!important;align-items: center;">
		item1 | item2 | item3
	</div>
-->
	<div class="row jump-row default-row">

		<div class="col col-xs-12 col-sm-12 col-md-5 col-lg-8 flexbox" id="contentNewName">

		
			<div id="hamburguer" class="inline-b ml-15">
				<span></span>
				<span></span>
				<span></span>
			</div>
			<div id="hamburguer-line" class="inline-b ml-25">
				<span></span>
			</div>

			
			
			<div id="brand" class="inline-b ml-15 logo_desktop">				
						<!-- ACA VA EL LOGO, SE COLOCA CON JS AL FINAL DE ESTE ARCHIVO -->			
			</div>
			
		</div>
		
		<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 flexbox new_logo_Search">
				
			<?php
			
				$search_ph = "Buscar en todo el sitio";
				
				if (strpos($_SERVER["SCRIPT_FILENAME"],"mediateca")) {
					
					$search_ph = "Buscar en mediateca";
					
				}
				
			
			?>
				
			<ul class="ml-10 mr-15" style="margin-right: 10px !important;">
				<li class="input-li">	
					<input id="main-search" name="main-search" type="text" data-mediateca="<?php echo strpos($_SERVER["SCRIPT_FILENAME"],"mediateca.php"); ?>" data-jump-placeholder="<?php echo $search_ph; ?>" placeholder="<?php echo $search_ph; ?>">
					<a href="#" title="Buscar" id="main-search-btn" data-mediateca="<?php echo strpos($_SERVER["SCRIPT_FILENAME"],"mediateca.php"); ?>">
						<i class="fa fa-search"></i>
					</a>							
				</li>
				<li class="dropdown" style="display:none;">
					<!-- <a href="#" id="navbarDropdown-help" role="button" data-toggle="dropdown" aria-expanded="false" title="Ayuda">
						<i class="fa fa-question-circle"></i>
					</a> -->
					<div id="navbarDropdown-help" title="Manual de usuario en mantenimiento" class="inactive">
						<i class="fa fa-question-circle"></i>
					</div> 
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown-help" id="dropdown-help">
						<ul>
							<li>
								<a class="dropdown-item" target="_blank" href="./images/EIASA Manual Observatorio.pdf">Manual de Usuario</a>
							</li>
							<!--
							<li>
								<a class="dropdown-item" href="#">Video Explicativo</a>
							</li>
							-->
						</ul>
					</div>            
				</li>
				<?php 
				
				include("./login.menu.php");
				
				?>
				
			
			</ul>
				
			
		</div>
	
	
	</div>
	
	<div class="row jump-row responsive-row">
	</div>

</div>
<script>
let isGeo35 = false
const logoContentDesktop = document.getElementsByClassName('logo_desktop'); 

if(window.location.href.includes('geovisor.php?geovisor=35')){
	isGeo35 = true
}

$(logoContentDesktop).html(`
	<a href="./index.php" class="logo_content">
		<div class="imgContentLogo"> 
			<img src="./images/nuevo_logo/nuevo_logo_low_w.png" class="nuevo_logo">
		</div>
		<div class="contentTextLogo">
			<h4> OBSERVATORIO </h4>	
			<!-- <div class="textLogo" style="display: ${isGeo35 === true ? 'none' : ''}">	
					APROVECHAMIENTOS HIDROELÉCTRICOS <br/>
					DEL RIO SANTA CRUZ
			</div> -->
		</div>
	</a>
`)


</script>