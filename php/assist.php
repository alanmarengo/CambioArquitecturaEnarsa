
	
<div class="dataset">

	<div class="dataset-row dataset-row-header dataset-columns-row">

	<?php

	$query_string_a = array();
	$col = array();
	
	$query = pg_query($conn,$query_string);
	
	while($r = pg_fetch_assoc($query)) {
		
	?>
		
		<div class="dataset-cell dataset-cell-header">
			<span><?php echo $r["column_name"]; ?></span>
			<i class="fa fa-info-circle"></i>
		</div>
		
	<?php
		
		array_push($query_string_a,"SELECT DISTINCT " . $r["column_name"] . " FROM \"".$schema."\".\"".$table."\"");
		array_push($col,$r["column_name"]);
		
	}

	?>

	</div>
	
	<div class="dataset-row dataset-row-header dataset-operation-row">

	<?php
	
	for ($i=0; $i<sizeof($query_string_a); $i++) {
		
		$query = pg_query($conn,$query_string_a[$i]);
		
		?>
		
		<div class="dataset-cell dataset-cell-header">
			<select class="selectpicker">		
				<option value="-1">Todo</option>
		<?php
		
		while($r = pg_fetch_assoc($query)) {
			
		?>
				<option value="<?php echo $r[$col[$i]]; ?>"><?php echo $r[$col[$i]]; ?></option>
			
		<?php
			
		}
		
		?>
			</select>
		</div>
			
		<?php
	
	}

	?>

	</div>
	
	<div class="dataset-row">

	<?php
	
	/*$col_str = implode($col,",");
	
	$query_string = "SELECT $col FROM \"".$schema."\".\"".$table."\"";

	$query = pg_query($conn,$query_string);
			
	while($r = pg_fetch_assoc($query)) {
	
	?>
	
	<div class="dataset-cell">
		<span>28º</span>
	</div>
	
	<?php
		
	}*/

	?>

	</div>

</div>