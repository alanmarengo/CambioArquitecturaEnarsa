<?php

	$color = array(
	
		"#6fcc64",
		"#343399",
		"#4b9e82",
		"#b2e656",
		"#363794",
		"#193a41",
		"#ffa81a",
		"#2b4aa5",
		"#009dbc",
	
	);

	$bgcolor = array(
	
		"#578d5c",
		"#3a407e",
		"#497d71",
		"#85a856",
		"#3a407e",
		"#2b4449",
		"#9d7b3b",
		"#344d86",
		"#237688",
	
	);
	$display = "block";
	for ($i=0; $i<sizeof($color); $i++) {
		
			?>
			
			<div class="layer-container" data-color="<?php echo $color[$i]; ?>" data-cid="<?php echo ($i+1); ?>" style="border-color: <?php echo $color[$i]; ?>; display: <?php echo $display; ?>;">
				<div class="layer-container-header" style="background-color:<?php echo $bgcolor[$i]; ?>;">				
					<span>TEMA (<span id="abr-layer-count-1" class="abr-layer-count">2</span>)</span>		
				</div>
				<div class="layer-container-body scrollbar-content">
							
					<div class="layer-group" data-state="0" data-layer="27" data-cid="<?php echo ($i+1); ?>" data-layer-type="3">
					
						<div class="layer-header">
							
							<a href="#" class="layer-label" onclick="$(this).parent().next().slideToggle('slow');">
								<span>DATASET</span>
							</a>
							
						</div>
					
					</div>
					
							
					<div class="layer-group" data-state="0" data-layer="28" data-cid="<?php echo ($i+1); ?>" data-layer-type="3">
					
						<div class="layer-header">
							
							<a href="#" class="layer-label" onclick="$(this).parent().next().slideToggle('slow');">
								<span>DATASET</span>
							</a>
						</div>
					
					</div><div class="layer-group" data-state="0" data-layer="27" data-cid="<?php echo ($i+1); ?>" data-layer-type="3">
					
						<div class="layer-header">
							
							<a href="#" class="layer-label" onclick="$(this).parent().next().slideToggle('slow');">
								<span>DATASET</span>
							</a>
							
						</div>
					
					</div>
					
							
					<div class="layer-group" data-state="0" data-layer="28" data-cid="<?php echo ($i+1); ?>" data-layer-type="3">
					
						<div class="layer-header">
							
							<a href="#" class="layer-label" onclick="$(this).parent().next().slideToggle('slow');">
								<span>DATASET</span>
							</a>
						</div>
					
					</div>
				
				</div>
			
			</div>
			
			<?php
		$display = "none";
	}
	
?>