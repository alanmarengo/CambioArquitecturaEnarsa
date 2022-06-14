<?php

include("./pgconfig.php");

$proyectos = $_POST["proyectos"];
$geovisor = $_POST["geovisor"];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$query_string = $_GET["q"];

?>

<html>
	<head>	
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="./css/pretty-checkbox.css"/>
	
	<script type="text/javascript" src="./js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript">
	
		$(document).ready(function() {
			
			readquery();			
			
		});
		
		function readquery() {
			
			var req = $.ajax({
				
				async:false,
				url:"./queryer-read.php",
				type:"post",
				data:{
					q:$("#query").val()
				},
				success:function(d){}
				
			});
			
			$("#queryresult").html(req.responseText);
			
		}
	
	</script>
	
	<style>
	
	body {
			
			width:10000px;
			
		}
		
		table {
			
			margin:20px;
			
		}
		
		th {
			
			background-color:#efefef;
			
		}
		
		td, th {
			
			padding:10px;
			border-top:1px solid #ccc;
			border-left:1px solid #ccc;
			width:150px;
			
		}
		
		tr td:last-child,th td:last-child {			
			
			border-right:1px solid #ccc;
			
		}
		
		tr:last-child td,tr:last-child th {			
			
			border-bottom:1px solid #ccc;
			
		}
		
	</style>
	
	</head>
	<body>
	
		<div style="padding:10px; border:1px solid #ccc; width:100%;">
			
			<p><textarea name="query" id="query" style="width:600px; min-height:70px;"></textarea></p>
			<p><button onclick="readquery();">Procesar</button></p>	
		
			<div id="queryresult" style="margin-top:30px; border:1px dashed #ccc; padding:10px;"></div>
			
		</div>
	
	</body>
</html>