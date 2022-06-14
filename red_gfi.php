<?php

	header('Content-Type: application/json');

	$url = $_REQUEST["url"];

	$wms_request = $url;
	
	$con = curl_init($wms_request);
	
	curl_setopt($con,CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($con,CURLOPT_RETURNTRANSFER, true);
	
	$response = curl_exec($con);

	echo curl_error($con);

	curl_close($con);
	
	echo $response;

?>
