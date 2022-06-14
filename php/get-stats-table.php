<?php

include("../pgconfig.php");

$page = $_POST["page"];
$dt_id = $_POST["dt_id"];
$dt_variables = $_POST["dt_variables"];
$dt_cruce = $_POST["dt_cruce"];
$operations = $_POST["operations"];
$colstr = $_POST["colstr"];
$colgroup = $_POST["colgroup"];
$groupbycol = $_POST["groupbycol"];
$groupindex = $_POST["groupbycol_index"];
$groupname = $_POST["groupbycol_name"];
$groupby_val = $_POST["groupby_val"];
$gm_var = $_POST["gm_var"];
$colstr_original = $colstr;
$gm_var_values = array();
$gm_labels = array();
$fdesde = $_POST["fdesde"];
$fhasta = $_POST["fhasta"];

$colstrType = -1;

if (isset($_POST["colstrType"])) {
	$colstrType = $_POST["colstrType"];
}
$filters = -1;

if (isset($_POST["filters"])) {
	$filters = $_POST["filters"];
}
	
$no_op = false;
	
for ($i=0; $i<sizeof($operations); $i++) {
	
	if ($operations[$i] == -1) {
		
		$no_op = true;
		break;
		
	}
	
}

$group = "";

if (($groupby_val == 2) || ($groupby_val == 3)) {
	
	$no_op = true;
	
}else{
	
	if (($groupby_val != 1) && ($groupby_val != -1)) {
		
		$group = " GROUP BY \"$groupby_val\"";
		
	}
	
}

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$activeFilters = false;

for ($i=0; $i<sizeof($filters); $i++) {
	
	if ($filters[$i]["filtertype"] != -1) {
		
		$activeFilters = true;
		break;
		
	}
	
}

if ($filters != -1) {
	
	$filter_str = "";
	
	for ($i=0; $i<sizeof($filters); $i++) {
		
		if ($filters[$i]["filtertype"] != -1) {
			
			$slashes = "";
			
			if ($filters[$i]["coltype"] == "text") {
	
				$slashes = "\"";
				$filter_str .= "\"".$filters[$i]["colname"]."\" ILIKE '%" . $filters[$i]["filterval"] . "%' AND ";
				
			}else{
				
				$slashes = "";
				$filter_str .= "\"".$filters[$i]["colname"]."\" " . $filters[$i]["filtertype"] . " " . $slashes . $filters[$i]["filterval"] . $slashes . " AND ";
				
			}
			
			
			
		}		
	
	}
	
	$filter_str = substr($filter_str,0,strlen($filter_str)-5);
	
	$andStr = "";
	
	if ($activeFilters) {
	
		$andStr = " AND ";		
	
	}
	
	if ((!empty($fdesde)) && (!empty($fhasta))) {
		
		$filter_str .= $andStr . "mod_estadistica.filtro_temp(cod_temp,'$fdesde','$fhasta')";
		
	}else{
		
		$filter_str .= "1=1";
		
	}
	
}else{
	
	if ((!empty($fdesde)) && (!empty($fhasta))) {
		
		$filter_str = " mod_estadistica.filtro_temp(cod_temp,'$fdesde','$fhasta')";
		
	}else{
		
		$filter_str .= "1=1";
		
	}
	
}

$query_string = "SELECT * FROM mod_estadistica.get_dt_from($dt_id,'$dt_variables','$dt_cruce') AS query";

$query = pg_query($conn,$query_string);

$data = pg_fetch_assoc($query);

$rquery_string = $data["query"];

$colstr_select = "\"" . implode("\"::TEXT,\"",explode(",",$colstr)) . "\"::TEXT";
$colstr = "\"" . implode("\",\"",explode(",",$colstr)) . "\"";

$colstr_order = str_replace(","," ASC,",$colstr) . " ASC";
//$colstr_order = substr($colstr_order,0,strlen($colstr)-1);
$colstr_order = " ORDER BY " . $colstr_order;

if ($no_op) {
	
	if ($colstrType == -1) {
	
		$colstr_select = "\"" . implode("\"::TEXT,\"",explode(",",$colstr)) . "\"::TEXT";
	
	}else{
		
		$col = explode(",",$colstr);
		$colType = explode(",",$colstrType);
		$colstr_select = "";
		
		for ($i=0; $i<sizeof($col); $i++) {
			
			$colstr_select .= $col[$i] . "::" . $colType[$i] . " AS $col[$i],";
			
		}
		
	}
	
}else{
	
	$col = explode(",",$colstr);
	$colType = explode(",",$colstrType);
	$colstr_select = "";
	
	for ($i=0; $i<sizeof($col); $i++) {
		
		if ($operations[$i] == "NONE") {
			
			$colstr_select .= $col[$i] . "::" . $colType[$i] . " AS " . $col[$i] . ",";
			
		}else{
			
			if ($i<3) {				
			
				if ($groupbycol == 1) {
					
					$colstr_select .="MAX('')::TEXT AS " . $col[$i] . ",";
			
				}else{
				
					$colstr_select .= $operations[$i] . "(" . $col[$i] . ")::" . $colType[$i] . " AS " . $col[$i] . ",";
					
				}
				
			}else{
				
				$colstr_select .= $operations[$i] . "(" . $col[$i] . ")::" . $colType[$i] . " AS " . $col[$i] . ",";
				
			}
		
		}
		
	}
	
}

$colstr_select = substr($colstr_select,0,strlen($colstr_select)-1);

$group_by_str = " GROUP BY " . $groupby_val;

$distinct = "";

if ($groupby_val == 2) {
	
	$distinct = " DISTINCT";
	
}

if ($page != -1) {
	
	$limit = "LIMIT 10 OFFSET " . (($page-1)*10);
	
}else{
	
	$limit = "";
	
}

if ($filter_str == "") {

	$pure_new_query_string = "SELECT$distinct $colstr_select FROM ($rquery_string) AS sub $group $colstr_order";
	$new_query_string = "SELECT$distinct $colstr_select FROM ($rquery_string) AS sub $group $colstr_order " . $limit;
	
	if (($groupbycol == 1) && ($groupindex == 0)) {
	
		$gm_query_string = "SELECT geo_table_cruce AS geotabla, gid_cruce::BIGINT AS gid,$colstr_select FROM ($rquery_string) AS sub $group,geo_table_cruce,gid_cruce $colstr_order";
	
	}
	
	if (($groupbycol == 1) && ($groupindex == 1)) {
	
		$gm_query_string = "SELECT geo_table_base AS geotabla, gid,$colstr_select FROM ($rquery_string) AS sub $group,geo_table_base,gid $colstr_order";
	
	}
	
}else{
	
	$pure_new_query_string = "SELECT$distinct $colstr_select FROM ($rquery_string) AS sub WHERE $filter_str $group $colstr_order";
	$new_query_string = "SELECT$distinct $colstr_select FROM ($rquery_string) AS sub WHERE $filter_str $group $colstr_order " . $limit;
	
	if (($groupbycol == 1) && ($groupindex == 0)) {
		
		$gm_query_string = "SELECT geo_table_cruce AS geotabla, gid_cruce::BIGINT AS gid,$colstr_select FROM ($rquery_string) AS sub WHERE $filter_str $group,geo_table_cruce,gid_cruce $colstr_order";
	
	}
	
	if (($groupbycol == 1) && ($groupindex == 1)) {
	
		$gm_query_string = "SELECT geo_table_base AS geotabla, gid,$colstr_select FROM ($rquery_string) AS sub WHERE $filter_str $group,geo_table_base,gid $colstr_order";
	
	}
	
}

//echo "<p>" . $pure_new_query_string . "</p>";

$gm = -1;
$gm_id = -1;

if (($groupindex == 0) || ($groupindex == 1)) {
	
	if ($gm_var != -1) {
	
		$gm_query_string = str_replace("'","''",$gm_query_string);
		
		$query_map_string = "INSERT INTO mod_estadistica.dt_mapeo(dt_id, dt_mapeo_query, dt_mapeo_column_value)
		VALUES ($dt_id, '$gm_query_string', '$gm_var') RETURNING dt_mapeo_id";
		
		$query = pg_query($conn,$query_map_string);
		
		$data = pg_fetch_assoc($query);
		
		if ($query) {
			
			$gm = 1;
			$gm_id = $data["dt_mapeo_id"];
			
		}else{
			
			echo "ERROR " . pg_last_error($conn);
			
		}
	
	}

}

?>

<div id="dataset" class="dataset" data-gm="<?php echo $gm; ?>" data-gm-id="<?php echo $gm_id; ?>">

	<?php

	$col = explode(",",$colstr_original);
	
	$query = pg_query($conn,$new_query_string);
	
	while($r = pg_fetch_assoc($query)) {
		
	?>

	<div class="dataset-row dataset-columns-row">
	
	<?php
		
		for($i=0; $i<sizeof($col); $i++) {
			
			if ($col[$i] == $gm_var) {
				
				array_push($gm_labels,$r[$groupby_val]);
				array_push($gm_var_values,$r[$col[$i]]);
				
			}
			
			?>
			
				<?php
				
					$celltext = $r[$col[$i]];
					
					if ($celltext == "") {
						
						$celltext = "-";
						
					}
				
				?>
				
			<div class="dataset-cell dataset-cell-header" data-col-index="<?php echo $i; ?>">
				<span data-test=""><?php echo $celltext; ?></span>
			</div>
			
			<?php
			
		}

		?>

	</div>
	
	<?php
		
	}
	
	?>
	
</div>
	
<input id="graficar-values" type="hidden" value="<?php echo implode(",",$gm_var_values); ?>">
<input id="graficar-labels" type="hidden" value="<?php echo implode(",",$gm_labels); ?>">

<div id="paging">
<?php include("./get-stats-paging.php"); ?>
</div>
