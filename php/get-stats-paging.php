<div class="row jump-row" id="paging">
	
	<div class="jus-between-f100 mt-30 align-center">

		<div>
	
			<a href="./estadisticas.php" id="stats-proceed" class="mt-10">&lt; VOLVER</a>
		
		</div>
	
		<div class="pagination">
	
			<ul class="mp0" data-qs="<?php echo $new_query_string; ?>">
			
				<?php
	
				//$query_string = "SELECT $col_str FROM \"".$schema."\".\"".$table."\"";
				$records = pg_num_rows(pg_query($conn,$pure_new_query_string));
				$pageCount = ceil($records/10);
				/*echo $query_string;
				echo "<p>PAGECOUNT: " . $pageCount . "</p>";
				echo "<p>PAGE: " . $page . "</p>";*/
				
				
				if ($pageCount <= 10) {
					
					$class = "";
					
					for ($i=0; $i<$pageCount; $i++) {
					
						if ($page==($i+1)) {
							$class = " class=\"page-item page-active\"";
						}else{
							$class = " class=\"page-item\"";							
						}
						
						?>
						
						<li>
							<a href="javascript:void(0);" <?php echo $class; ?> data-page="<?php echo ($i+1); ?>"><?php echo ($i+1); ?></a>
						</li>
						
						<?php
						
					}
					
				}else{
					
					if (($page <= 3) || ($page > $pageCount -3)) {
						
						$class = "";
						
						for ($i=0; $i<5; $i++) {
							
							if ($page==($i+1)) {
								$class = " class=\"page-item page-active\"";
							}else{
								$class = " class=\"page-item\"";							
							}
							?>
							
							<li>
								<a href="javascript:void(0);"<?php echo $class; ?> data-page="<?php echo ($i+1); ?>"><?php echo ($i+1); ?></a>
							</li>
							
							<?php
							
						}
						
						$mid = round($pageCount/2);
						
						?>
						
						<li>
							<span>...</span>
						</li>
						<li>
							<a href="javascript:void(0);" <?php if ($page == ($mid-1)) { $class = " class=\"page-active\""; }else{ $class = " class=\"page-item\""; } echo $class;  ?> data-page="<?php echo ($mid-1); ?>"><?php echo ($mid-1); ?></a>
						</li>						
						<li>
							<a href="javascript:void(0);" <?php if ($page == ($mid)) { $class = " class=\"page-active\""; }else{ $class = " class=\"page-item\""; } echo $class; ?>  data-page="<?php echo ($mid); ?>"><?php echo ($mid); ?></a>
						</li>						
						<li>
							<a href="javascript:void(0);" <?php if ($page == ($mid+1)) { $class = " class=\"page-active\""; }else{ $class = " class=\"page-item\""; } echo ($mid+1); ?> data-page="<?php echo ($mid+1); ?>"><?php echo ($mid+1); ?></a>
						</li>	
						<li>
							<span>...</span>
						</li>
						
						<?php
						
						$class = "";
						
						for ($i=$pageCount-5; $i<$pageCount; $i++) {
							
							if ($page==($i+1)) {
								$class = " class=\"page-item page-active\"";
							}else{
								$class = " class=\"page-item\"";							
							}
							
							?>
							
							<li>
								<a href="javascript:void(0);" <?php echo $class; ?> data-page="<?php echo ($i+1); ?>"><?php echo ($i+1); ?></a>
							</li>
							
							<?php
							
						}
						
					}else{
						
						if ($page <= 6) {
							
							$class = "";
							
							for ($i=0; $i<6; $i++) {
					
								if ($page==($i+1)) {
									$class = " class=\"page-item page-active\"";
								}else{
									$class = " class=\"page-item\"";							
								}
						
								?>
								
								<li>
									<a href="javascript:void(0);"<?php echo $class; ?> data-page="<?php echo ($i+1); ?>"><?php echo ($i+1); ?></a>
								</li>
								
								<?php		
								
							}
							
							$mid = round($pageCount/2);
							
							?>
						
							<li>
								<span>...</span>
							</li>
							<li>
								<a href="javascript:void(0);" <?php if ($page == ($mid-1)) { $class = " class=\"page-active\""; }else{ $class = " class=\"page-item\""; } echo $class;  ?> data-page="<?php echo ($mid-1); ?>"><?php echo ($mid-1); ?></a>
							</li>						
							<li>
								<a href="javascript:void(0);" <?php if ($page == ($mid)) { $class = " class=\"page-active\""; }else{ $class = " class=\"page-item\""; } echo $class; ?>  data-page="<?php echo ($mid); ?>"><?php echo ($mid); ?></a>
							</li>						
							<li>
								<a href="javascript:void(0);" <?php if ($page == ($mid+1)) { $class = " class=\"page-active\""; }else{ $class = " class=\"page-item\""; } echo ($mid+1); ?> data-page="<?php echo ($mid+1); ?>"><?php echo ($mid+1); ?></a>
							</li>	
							<li>
								<span>...</span>
							</li>
							
							<?php
							
							$class = "";
							
							for ($i=$pageCount-3; $i<$pageCount; $i++) {
								
								if ($page==($i+1)) {
									$class = " class=\"page-item page-active\"";
								}else{
									$class = " class=\"page-item\"";							
								}
								
								?>
								
								<li>
									<a href="javascript:void(0);"<?php echo $class; ?> data-page="<?php echo ($i+1); ?>"><?php echo ($i+1); ?></a>
								</li>
								
								<?php
								
							}
							
						}else{
							
							if ($page > ($pageCount -6)) {
								
								$class = "";
								
								for ($i=0; $i<3; $i++) {
									
									if ($page==($i+1)) {
										$class = " class=\"page-item page-active\"";
									}else{
										$class = " class=\"page-item\"";							
									}
									
									?>
									
									<li>
										<a href="javascript:void(0);"<?php echo $class; ?> data-page="<?php echo ($i+1); ?>"><?php echo ($i+1); ?></a>
									</li>
									
									<?php
									
								}								
							
								$mid = round($pageCount/2);
								
								?>
							
								<li>
									<span>...</span>
								</li>
								<li>
									<a href="javascript:void(0);" <?php if ($page == ($mid-1)) { $class = " class=\"page-active\""; }else{ $class = " class=\"page-item\""; } echo $class;  ?> data-page="<?php echo ($mid-1); ?>"><?php echo ($mid-1); ?></a>
								</li>						
								<li>
									<a href="javascript:void(0);" <?php if ($page == ($mid)) { $class = " class=\"page-active\""; }else{ $class = " class=\"page-item\""; } echo $class; ?>  data-page="<?php echo ($mid); ?>"><?php echo ($mid); ?></a>
								</li>						
								<li>
									<a href="javascript:void(0);" <?php if ($page == ($mid+1)) { $class = " class=\"page-active\""; }else{ $class = " class=\"page-item\""; } echo $class; ?> data-page="<?php echo ($mid+1); ?>"><?php echo ($mid+1); ?></a>
								</li>	
								<li>
									<span>...</span>
								</li>
								
								<?php
								
								$class = "";
								
								for ($i=$pageCount-6; $i<$pageCount; $i++) {
									
									if ($page==($i+1)) {
										$class = " class=\"page-item page-active\"";
									}else{
										$class = " class=\"page-item\"";							
									}
									
									?>
									
									<li>
										<a href="javascript:void(0);"<?php echo $class; ?> data-page="<?php echo ($i+1); ?>"><?php echo ($i+1); ?></a>
									</li>
									
									<?php
									
								}
								
							}else{
								
								$class = "";
								
								for ($i=0; $i<3; $i++) {
									
									if ($page==($i+1)) {
										$class = " class=\"page-item page-active\"";
									}else{
										$class = " class=\"page-item\"";							
									}
									
								?>
								
								<li>
									<a href="javascript:void(0);"<?php echo $class; ?> data-page="<?php echo ($i+1); ?>"><?php echo ($i+1); ?></a>
								</li>
								
								<?php
								
								}
								
								?>
								
								<li>
									<span>...</span>
								</li>
								<li>
									<a href="javascript:void(0);" data-page="<?php echo ($page-1); ?>" class="page-item"><?php echo ($page-1); ?></a>
								</li>						
								<li>
									<a href="javascript:void(0);" data-page="<?php echo ($page); ?>" class="page-active"><?php echo $page; ?></a>
								</li>						
								<li>
									<a href="javascript:void(0);" data-page="<?php echo ($page+1); ?>" class="page-item"><?php echo ($page+1); ?></a>
								</li>		
								<li>
									<span>...</span>
								</li>
								
								<?php
								
								$class = "";
								
								for ($i=$pageCount-3; $i<$pageCount; $i++) {
									
									if ($page==($i+1)) {
										$class = " class=\"page-item page-active\"";
									}else{
										$class = " class=\"page-item\"";							
									}
									
									?>
									
									<li>
										<a href="javascript:void(0);"<?php echo $class; ?> data-page="<?php echo ($i+1); ?>"><?php echo ($i+1); ?></a>
									</li>
									
									<?php
									
								}
								
							}
							
						}
						
					}
					
				}
				
				?>
				
			</ul>
		
		</div>
	
		<div>
	
			<a href="javascript:void(0);" class="black-button" onclick="stats.view.premapear()">MAPEAR</a>
			<a href="javascript:void(0);" class="black-button" onclick="stats.view.pregraficar()">GRAFICAR</a>
		
		</div>

	</div>

</div>