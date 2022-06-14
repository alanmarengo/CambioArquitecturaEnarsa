<?php

include("../pgconfig.php");

$dt_id = $_POST["dt_id"];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$query_string_origenes = "SELECT DISTINCT origen FROM mod_estadistica.get_dt_variales(".$dt_id.") ORDER BY origen ASC";

$query_string = "SELECT * FROM mod_estadistica.get_dt_variales(".$dt_id.") ORDER BY origen ASC";

$query = pg_query($conn,$query_string);

$query_origenes = pg_query($conn,$query_string_origenes);

$count = pg_num_rows($query_origenes);

$origen = "-1";

$first = true;

while ($r = pg_fetch_assoc($query)) {
	
	if ($r["origen"] != $origen) {
		
		$origen = $r["origen"];
		
		if (!$first) {
			
			?>
			
			</div>
				</div>
			
			<?php
			
		}
		
		?>
		
		<div class="panel-dataset-group-list">
			
			<div class="panel-dataset-group-list-header">
				<span>SELECCIONAR VARIABLE DE ORIGEN: <?php echo $r["origen"]; ?></span>
				<a href="#" class="toggeable-icon" onclick="$(this).children('i').toggleClass('fa-plus-circle'); $(this).parent().next().slideToggle('fast'); scroll.refresh();">
					<i class="fa fa-minus-circle <?php if($count>1) { echo "fa-plus-circle"; } ?>"></i>
				</a>
			</div>
			<div class="panel-dataset-group-list-body" <?php if($count>1) { echo "style=\"display:none;\""; } ?>>
		
				<div class="panel-dataset-group-item">							
					<div class="pretty p-icon p-curve">
						<input type="checkbox" class="dataset-var-check" value="<?php echo $r["dt_variable_id"]; ?>"/>
						<div class="state">
							<i class="icon mdi mdi-check"></i>
							<label><?php echo $r["dt_variable_nombre"]; ?></label>
						</div>
					</div>
				</div>
		
		<?php
		
	}else{
		
		?>
		
		<div class="panel-dataset-group-item">							
			<div class="pretty p-icon p-curve">
				<input type="checkbox" class="dataset-var-check" value="<?php echo $r["dt_variable_id"]; ?>"/>
				<div class="state">
					<i class="icon mdi mdi-check"></i>
					<label><?php echo $r["dt_variable_nombre"]; ?></label>
				</div>
			</div>
		</div>
		
		<?php
		
	}
	
	$first = false;
	
}

?>
		
	</div>
</div>