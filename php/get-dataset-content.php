<?php

include("../pgconfig.php");

$dt_id = $_POST["dt_id"];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$query_string = "SELECT dt_titulo,dt_desc,dt_table_source,(SELECT COUNT(*) FROM mod_estadistica.get_dt_variales(vwdt.dt_id)) AS var_cant FROM mod_estadistica.vw_dt vwdt WHERE dt_id = " . $dt_id;

$query = pg_query($conn,$query_string);

$r = pg_fetch_assoc($query);

$query_string_dataset_records = "SELECT COUNT(*) AS registros FROM " . $r["dt_table_source"];

$query_dataset_records = pg_query($conn,$query_string_dataset_records);

$data_records = pg_fetch_assoc($query_dataset_records);

?>

<div class="row jump-row panel-dataset-detail-title" id="dataset-detail-header">
		
	<p><?php echo $r["dt_titulo"]; ?></p>
	<p>Numero de Registros: <?php echo $data_records["registros"]; ?></p>
	<p>Variables: <?php echo $r["var_cant"]; ?></p>
	<input type="hidden" id="inp_dt_titulo" value="<?php echo $r["dt_titulo"]; ?>">

</div>

<div class="row jump-row panel-dataset-detail-content jump-scroll" id="dataset-detail-body">

	<div class="mt-30 dataset-detail-body-inner">

		<p><?php echo $r["dt_desc"]; ?></p>
	
	</div>

</div>