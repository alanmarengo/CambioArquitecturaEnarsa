
<?php

	
	define("pg_server","127.0.0.1");
	define("pg_user","postgres");
	define("pg_password","plahe100%");
	define("pg_portv",5432);
	define("pg_db",'ahrsc');
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
	function  insertar_db($sensor_id,$sensor_index,$json_response)
	{
		global $string_conn;
		
		$con = pg_connect($string_conn);
				
		$SQL  = "INSERT INTO mod_sensores.sensor_data_davis_v2(";
		$SQL .= "sensor_id,";
		$SQL .= "fecha,";
		$SQL .= "ts,";
		$SQL .= "bar_trend,"; 
		$SQL .= "bar,";
		$SQL .= "temp_in,";
		$SQL .= "hum_in,";
		$SQL .= "temp_out,";
		$SQL .= "wind_speed,";
		$SQL .= "wind_speed_10_min_avg,";
		$SQL .= "wind_dir,";
		$SQL .= "temp_extra_1,";
		$SQL .= "temp_extra_2,";
		$SQL .= "temp_extra_3,";
		$SQL .= "temp_extra_4,";
		$SQL .= "temp_extra_5,";
		$SQL .= "temp_extra_6,";
		$SQL .= "temp_extra_7,";
		$SQL .= "temp_soil_1,";
		$SQL .= "temp_soil_2,";
		$SQL .= "temp_soil_3,";
		$SQL .= "temp_soil_4,";
		$SQL .= "temp_leaf_1,";
		$SQL .= "temp_leaf_2,";
		$SQL .= "temp_leaf_3,";
		$SQL .= "temp_leaf_4,";
		$SQL .= "hum_out,";
		$SQL .= "hum_extra_1,";
		$SQL .= "hum_extra_2,";
		$SQL .= "hum_extra_3,";
		$SQL .= "hum_extra_4,";
		$SQL .= "hum_extra_5,";
		$SQL .= "hum_extra_6,";
		$SQL .= "hum_extra_7,";
		$SQL .= "rain_rate_clicks,";
		$SQL .= "rain_rate_in,";
		$SQL .= "rain_rate_mm,";
		$SQL .= "uv,";
		$SQL .= "solar_rad,";
		$SQL .= "rain_storm_clicks,";
		$SQL .= "rain_storm_in,";
		$SQL .= "rain_storm_mm,";
		$SQL .= "rain_day_clicks,";
		$SQL .= "rain_day_in,";
		$SQL .= "rain_day_mm,";
		$SQL .= "rain_month_clicks,";
		$SQL .= "rain_month_in,";
		$SQL .= "rain_month_mm,";
		$SQL .= "rain_year_clicks,";
		$SQL .= "rain_year_in,";
		$SQL .= "rain_year_mm,";
		$SQL .= "et_day,";
		$SQL .= "et_month,";
		$SQL .= "et_year,";
		$SQL .= "moist_soil_1,";
		$SQL .= "moist_soil_2,";
		$SQL .= "moist_soil_3,";
		$SQL .= "moist_soil_4,";
		$SQL .= "wet_leaf_1,";
		$SQL .= "wet_leaf_2,";
		$SQL .= "wet_leaf_3,";
		$SQL .= "wet_leaf_4)";
		$SQL .= "VALUES(";
		$SQL .= "$sensor_id,";
		$SQL .= "to_timestamp(".$json_response->sensors[$sensor_index]->data[0]->ts."),";
		$SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->ts."',"; 
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->bar_trend."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->bar."',"; 
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->temp_in."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->hum_in."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->temp_out."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->wind_speed."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->wind_speed_10_min_avg."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->wind_dir."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->temp_extra_1."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->temp_extra_2."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->temp_extra_3."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->temp_extra_4."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->temp_extra_5."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->temp_extra_6."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->temp_extra_7."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->temp_soil_1."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->temp_soil_2."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->temp_soil_3."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->temp_soil_4."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->temp_leaf_1."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->temp_leaf_2."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->temp_leaf_3."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->temp_leaf_4."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->hum_out."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->hum_extra_1."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->hum_extra_2."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->hum_extra_3."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->hum_extra_4."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->hum_extra_5."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->hum_extra_6."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->hum_extra_7."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->rain_rate_clicks."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->rain_rate_in."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->rain_rate_mm."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->uv."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->solar_rad."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->rain_storm_clicks."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->rain_storm_in."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->rain_storm_mm."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->rain_day_clicks."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->rain_day_in."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->rain_day_mm."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->rain_month_clicks."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->rain_month_in."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->rain_month_mm."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->rain_year_clicks."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->rain_year_in."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->rain_year_mm."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->et_day."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->et_month."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->et_year."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->moist_soil_1."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->moist_soil_2."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->moist_soil_3."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->moist_soil_4."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->wet_leaf_1."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->wet_leaf_2."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->wet_leaf_3."',";
        $SQL .= "'".$json_response->sensors[$sensor_index]->data[0]->wet_leaf_4."');";
		
		$recordset = pg_query($con,$SQL);
		//echo $SQL;
		pg_close($con);
		
	};

	$url		='https://api.weatherlink.com/v2/';
	$api_key	='zuzw0cy20ikiciiuxbs6okte6bvd0ttg';
	$api_secret	='xqhmnwqlc9rtrgperbcosajzxszpz7ie';
	
	echo "******************* API V2 - Descargando Estación DAVIS EMA 11 Guanaco (IP) 001D0A00E497 ID 63426 *********************".PHP_EOL;
 	
	$t			= time();
	
	$estacion_id='63426';
	
	$api_signature_string='api-key'.$api_key.'station-id'.$estacion_id.'t'.$t;

	$api_signature = hash_hmac("sha256", $api_signature_string, $api_secret);
	
	$request=$url.'current/'.$estacion_id.'?api-key='.$api_key.'&t='.$t.'&api-signature='.$api_signature;
	
	$con = curl_init($request);
	
	curl_setopt($con,CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($con,CURLOPT_RETURNTRANSFER, true);
	
	$response = curl_exec($con);

	curl_close($con);
	
	$datos = json_decode($response, false);
	
	insertar_db(5,0,$datos);
	
	echo '******************************** API V2 - Descargando Estación DAVIS EMA 20 Condor Cliff (GPRS) 001D0AF19249 ID 72713 ****************'.PHP_EOL;
		
	$t			= time();
	
	$estacion_id='72713';
	
	$api_signature_string='api-key'.$api_key.'station-id'.$estacion_id.'t'.$t;

	$api_signature = hash_hmac("sha256", $api_signature_string, $api_secret);
	
	$request=$url.'current/'.$estacion_id.'?api-key='.$api_key.'&t='.$t.'&api-signature='.$api_signature;
	
	$con = curl_init($request);
	
	curl_setopt($con,CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($con,CURLOPT_RETURNTRANSFER, true);
	
	$response = curl_exec($con);

	curl_close($con);
	
	$datos = json_decode($response, false);
	
	insertar_db(6,0,$datos);
		
	echo '******************************** API V2 - Descargando Estación DAVIS EMA 22 La Barrancosa (IP) 001D0A00ED92 ID 63431  ****************'.PHP_EOL;

	$t			= time();
	
	$estacion_id='63431';
	
	$api_signature_string='api-key'.$api_key.'station-id'.$estacion_id.'t'.$t;

	$api_signature = hash_hmac("sha256", $api_signature_string, $api_secret);
	
	$request=$url.'current/'.$estacion_id.'?api-key='.$api_key.'&t='.$t.'&api-signature='.$api_signature;
	
	$con = curl_init($request);
	
	curl_setopt($con,CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($con,CURLOPT_RETURNTRANSFER, true);
	
	$response = curl_exec($con);

	curl_close($con);
	
	$datos = json_decode($response, false);
	
	insertar_db(7,0,$datos);	
?>
