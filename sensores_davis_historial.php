<?php

	$fecha_desde = time()-86400;/* 24 horas menos */
	$fecha_hasta = time();

	$url		='https://api.weatherlink.com/v2/';
	$api_key	='zuzw0cy20ikiciiuxbs6okte6bvd0ttg';
	$api_secret	='xqhmnwqlc9rtrgperbcosajzxszpz7ie';
	$t			= time();
	
	$estacion_id='63426';
	
	$api_signature_string='api-key'.$api_key.'end-timestamp'.$fecha_hasta.'start-timestamp'.$fecha_desde.'station-id'.$estacion_id.'t'.$t;
	
	$api_signature = hash_hmac("sha256", $api_signature_string, $api_secret);
	
	$request=$url.'historic/'.$estacion_id.'?api-key='.$api_key.'&t='.$t.'&start-timestamp='.$fecha_desde.'&end-timestamp='.$fecha_hasta.'&api-signature='.$api_signature;
 	
	$con = curl_init($request);
	
	curl_setopt($con,CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($con,CURLOPT_RETURNTRANSFER, true);
	
	$response = curl_exec($con);

	curl_close($con);
	
	$datos = json_decode($response, false);
	
	echo "request: ".$request;
	
	#echo "bar: ".$datos->sensors[0]->data[0]->bar;
	
?>
