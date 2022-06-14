<?php

	$ico = array(
		"./images/icons/nav/icon_01.png",
		"./images/icons/nav/icon_01.png",
		"./images/icons/nav/icon_01.png",
		"./images/icons/nav/icon_01.png",
		"./images/icons/nav/icon_01.png",
		"./images/icons/nav/icon_01.png"
	);

	$labels = array(
		"TRANSPARENCIA",
		"PARTICIPACIÓN CIUDADANA",
		"PUEBLOS ORIGINARIOS",
		"EDUCACIÓN AMBIENTAL",
		"AGENDA GLOBAL",
		"ORDENAMIENTO TERRITORIAL"
	);

	$href = array(
		"#",
		"#",
		"#",
		"#",
		"#",
		"#"
	);

?>

<div class="col col-xs-8 col-sm-8 col-md-3 col-lg-3 col-xl-3" id="navigation">

	<div class="arrow"></div>

	<ul class="nav">
		
		<?php for ($i=0; $i<sizeof($ico); $i++) { ?>
		
		<li>
			<img src="<?php echo $ico[$i]; ?>" height="28">
			<a href="#"><?php echo $labels[$i]; ?></a>
		</li>
		
		<?php } ?>
		
	</div>

</div>