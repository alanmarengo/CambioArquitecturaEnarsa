<?php

include("../pgconfig.php");

$page = $_POST["page"];
$dt_id = $_POST["dt_id"];
$dt_variables = $_POST["dt_variables"];
$dt_cruce = $_POST["dt_cruce"];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$query_string = "SELECT * FROM mod_estadistica.get_dt_from($dt_id,'$dt_variables','$dt_cruce') AS query";

$query = pg_query($conn,$query_string);

$data = pg_fetch_assoc($query);

$rquery_string = $data["query"];

?>
	
<div class="dataset">

	<div class="dataset-row dataset-row-header dataset-columns-row">

	<?php

	$query_string_a = array();
	$col = array();
	$coltypes = array();
	$colgroup = array();
	$bannedCols = array("geo_table_base","gid","geo_table_cruce","gid_cruce","cod_temp");
	
	$query = pg_query($conn,$rquery_string);
	
	while($r = pg_fetch_assoc($query)) {
		
		$i=0;
		$j=0;
		
		foreach($r as $colname => $val) {
			
			if (!in_array($colname,$bannedCols)) {
				
				if ($j<3) {					
					
					array_push($colgroup,$colname);
					
				}
				
				$query_test = pg_query($conn,"SELECT \"$colname\",pg_typeof(\"$colname\") as coltype FROM ($rquery_string) AS sub LIMIT 1");
				$query_test_data = pg_fetch_assoc($query_test);
				$coltype = $query_test_data["coltype"];
				
				$textTypes = array("varchar","text","unknown","character varying");
				
				if (in_array($coltype,$textTypes)) {
					
					$type = "text";
					
				}else{
					
					$type = $coltype;
					
				}
				
				array_push($query_string_a,"SELECT DISTINCT " . $colname. " FROM ($rquery_string) AS sub");
				array_push($coltypes,$type);
				array_push($col,$colname);
				
				$query_string_col_desc = "SELECT * FROM mod_estadistica.vw_variables WHERE dt_variable_nombre = '" . $colname . "'";
				$query_col_desc = pg_query($conn,$query_string_col_desc);
				$query_col_desc_data = pg_fetch_assoc($query_col_desc);
				
				?>
				
				<div class="dataset-cell dataset-cell-header" 
					data-col-index="<?php echo $i; ?>" 
					data-col-name="<?php echo $colname; ?>"
					data-col-type="<?php echo $coltype; ?>"
					>
					<input type="text" readonly="readonly" class="dataset-header-input" value="<?php echo $colname; ?>" title="<?php echo $colname; ?>" alt="<?php echo $colname; ?>">
					<!--<span></span>-->
					<i class="fa fa-info-circle" title="<?php echo $query_col_desc_data["dt_variable_defincion"]; ?>"></i>
				</div>
				
				<?php
				
				$j++;
			
			}
			
			$i++;
			
		}
		
		break;
		
	}
	
	?>

	</div>
	
	<div class="dataset-row dataset-row-header dataset-filter-row">

	<?php
	
	for ($i=0; $i<sizeof($query_string_a); $i++) {
		
		$query = pg_query($conn,$query_string_a[$i]);
		
		?>
		
		<div class="dataset-cell dataset-cell-header"
					data-col-index="<?php echo $i; ?>" 
					data-col-name="<?php echo $col[$i]; ?>"
					data-col-type="<?php echo $coltypes[$i]; ?>">
			<select class="selectpicker filter-combo">		
				<option value="-1">TODOS</option>
				
				<?php
				
				if ($coltypes[$i] == "text") {					
					
				?>
					<option value="=">IGUAL A </option>
					
				<?php
					
				}else{					
					
				?>
				
					<option value="=">IGUAL A </option>
					<option value=">">MAYOR QUE </option>
					<option value="<">MENOR QUE </option>
					
				<?php
					
					
				}
				
				?>
				
			</select>
			<input type="text" class="col-filter">
		</div>
			
		<?php
	
	}

	?>

	</div>
	
	<div class="dataset-row dataset-row-header dataset-operation-row">

	<?php
	
	for ($i=0; $i<sizeof($col); $i++) {
		
		if ($coltypes[$i] == "text") {
		
	?>	
	
		<div class="dataset-cell"
					data-col-index="<?php echo $i; ?>" 
					data-col-name="<?php echo $col[$i]; ?>"
					data-col-type="<?php echo $coltypes[$i]; ?>">>
			<select class="selectpicker operation-combo" tabindex="-98">
				<option value="-1">OPERACIONES</option>
				<option value="MIN">MIN</option>
				<option value="MAX">MAX</option>
			</select>
		</div>
	
	<?php		
	
		}else{
		
	?>
	
		<div class="dataset-cell"
					data-col-index="<?php echo $i; ?>" 
					data-col-name="<?php echo $col[$i]; ?>"
					data-col-type="<?php echo $coltypes[$i]; ?>">>
			<select class="selectpicker operation-combo" tabindex="-98">
				<option value="-1">OPERACIONES</option>
				<option value="SUM">SUMA</option>
				<option value="AVG">PROMEDIO</option>
				<option value="MIN">MIN</option>
				<option value="MAX">MAX</option>
				<option value="COUNT">CUENTA</option>
			</select>
		</div>
			
	<?php
			
		}
	
	}

	?>

	</div>
	
	<input type="hidden" name="colstr" id="colstr" value="<?php echo implode(",",$col); ?>">
	<input type="hidden" name="coltypestr" id="coltypestr" value="<?php echo implode(",",$coltypes); ?>">
	<input type="hidden" name="colgroup" id="colgroup" value="<?php echo implode(",",$colgroup); ?>">

</div>