<?php 

$dt_data = array(); 

?>

<div class="row pv-30">

	<div class="col hidden-xs hidden-sm col-md-1 col-lg-1"></div>
	<div class="col col-xs-10 col-sm-10 col-md-6 col-lg-6 backend-wrapper">
					
		<?php
		
		$date_unique = date("c");
							
		$bad = array("+","-",":");
		
		$good = array("","","");
		
		$date = str_replace($bad,$good,$date_unique);
		
		$file_name = "dt_csv_" . $date . "_" . rand(0,99999) . ".csv";
		
		$file_string = "./tmp/" . $file_name;
		
		$file_content = $_POST["dt_csv_content"];
		
		$file = base64ToFile($file_content,$file_string);
		
		$tabla = $_POST["dt_tabla"];
		
		if (trim($tabla) == "") {
			
			echo "Debe ingresar un nombre para cargar la tabla";
			
		}else{
		
			if ($file) {
				
				$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
			
				$conn = pg_connect($string_conn);

				$file_name =  pg_csv_visible_path.$file_name;  
				
				$query_string = "SELECT sinia_datos.insertar_datos_from_csv('$file_name','$tabla')";
			
				$query = pg_query($conn,$query_string);
				
				//echo $query_string . "<br><br>";

				if ($query) 
				{
					
					$data = pg_fetch_assoc($query);
					
					$data = $data["insertar_datos_from_csv"];

					if($data=='t')
					{
						echo "Datos importados correctamente!, redirigiendo aguarde por favor";
					}
					else
					{
						echo "No se pudo importar los datos,<br>$file_name $tabla,<br> redirigiendo aguarde por favor";
					};	
					//echo "Se ha ejecutado la consulta de CSV con resultado: " . $data . " redirigiendo aguarde por favor";
					
				}
				else
				{
					
					echo "Error al ejecutar la consulta, redirigiendo aguarde por favor";
					
				}
				
			}else{
				
				echo "Error al subir este archivo CSV, redirigiendo aguarde por favor";
				
			}
		
		}
		
		?>
		
		<script type="text/javascript">
					
			setTimeout(function() {
							
				location.href = "./backend-csv.php"
							
			},5000);
				
		</script>
		
	</div>
	
</div>
