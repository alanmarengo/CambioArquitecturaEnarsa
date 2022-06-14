<div id="panel-left" class="phanel panel">
	
	<div class="panel-container p0">
	
		<div class="panel-body">
		
			<div class="row">

				<div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
				
					<div class="form-group form-group-dark-big-input w85p mt-30 ml-20">
						
						<i class="fa fa-search"></i>
						<input type="text" readonly="readonly" placeholder="BUSCAR INFORMACIÓN" class="icon-input ml-20 w75p" id="panel-seach-input">
						<!--<span class="text-white" id="info-cant">(15)</span>-->
					
					</div>
					
					<div id="layers-wrapper">
					
						<div id="abr-container">
						
							<?php DrawAbr(); ?>
						
						</div>
						
						<div id="layers-container">
						
							<?php DrawContainers(); ?>
						
						</div>
					
					</div>
				
				</div>
				
			</div>
		
		</div>
	
	</div>
	
	<div class="panel-arrow-container">
		<div class="panel-arrow">
			<a href="#" class="panel-arrow-link" id="panel-arrow-link" data-state="1">
				<img src="./images/panel.icon.arrow.1.png">
			</a>
		</div>
	</div>	

</div>