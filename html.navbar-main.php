
<div class="navbar flebox jump-navbar" id="navbar-main">
	
<!---
	<div class="row jump-row menu-row" style="background-color: #ccc; font-size: 11px; padding: 1px!important;align-items: center;">
		item1 | item2 | item3
	</div>
-->
	<div class="row jump-row default-row">

		<div class="col col-xs-12 col-sm-12 col-md-8 col-lg-8 flexbox col-brand">

				<div id="logo_mobile_1" class="logo_mobile">
<!-- 					<a href="./index.php" id="logo_content">
						<img src="./images/logo_observatorio_ieasa_mobile_1.png" class="ml-15">
					</a>	 -->	
				</div>			
			<div id="hamburguer" class="inline-b ml-15">
				<span></span>
				<span></span>
				<span></span>
			</div>
			
			<div id="hamburguer-line" class="inline-b ml-25">
				<span></span>
			</div>
				<div id="logo_mobile_2" class="logo_mobile">
<!-- 					<a href="./index.php">
						<img src="./images/logo_observatorio_ieasa_mobile_2.png" class="ml-15">
					</a> -->		
				</div>
			
			<div id="brand" class="inline-b ml-15 logo_desktop">				
<!-- 				<a href="./index.php">
					<img src="./images/logo_observatorio_ieasa.png" height="60">
				</a> -->				
			</div>
			
		</div>
		
		<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 flexbox">
				
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
				<li class="dropdown">
					<a href="#" id="navbarDropdown-help" role="button" data-toggle="dropdown" aria-expanded="false" title="Ayuda">
						<i class="fa fa-question-circle"></i>
					</a>
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
console.log(window.location.href)
const logoContentMobile1 = document.getElementById('logo_mobile_1');
const logoContentMobile2 = document.getElementById('logo_mobile_2');
const logoContentDesktop = document.getElementsByClassName('logo_desktop'); 

//Para el geovisor 35, le ponemos otra imagen de logo

if(window.location.href.includes('geovisor.php?geovisor=35')){
	$(logoContentMobile1).html(`
		<a href="./index.php" id="logo_content">
			<img src="./images/logo_observatorio_ieasa_mobile_1.png" class="ml-15">
		</a>	
	`)
	$(logoContentMobile2).html(`
		<a href="./index.php">
			<img src="./images/logo_observatorio_ieasa_mobile_2.png" class="ml-15">
		</a>
	`)
	$(logoContentDesktop).html(`
		<a href="./index.php" id="logo_content">
			<img src="./images/logo_observatorio_ieasa_mobile_1.png" class="ml-15">
		</a>	
	`)

}else{
	$(logoContentMobile1).html(`
		<a href="./index.php" id="logo_content">
			<img src="./images/logo_observatorio_ieasa_mobile_1.png" class="ml-15">
		</a>	
	`)
	$(logoContentMobile2).html(`
		<a href="./index.php">
			<img src="./images/logo_observatorio_ieasa_mobile_2.png" class="ml-15">
		</a>
	`)
	$(logoContentDesktop).html(`
		<a href="./index.php">
					<img src="./images/logo_observatorio_ieasa.png" height="60">
		</a>
	`)
}


</script>