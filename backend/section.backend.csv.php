<?php 

$dt_data = array(); 

?>

<div class="row pv-30">

	<div class="col hidden-xs hidden-sm col-md-1 col-lg-1"></div>
	<div class="col col-xs-10 col-sm-10 col-md-6 col-lg-6 backend-wrapper">
					
		<form name="frm-backend-main" id="frm-backend-main" action="./backend-csv-procesar.php" method="POST">
			<div class="form-group">
				<label for="dt_tabla">Tabla donde restaurar</label>
				<input type="text" class="form-control" name="dt_tabla" id="dt_tabla" aria-describedby="dt_tabla" placeholder="Tabla..."></div>
			<div class="form-group">
				<label for="dt_titulo">Archivo CSV</label>
				<input type="file" title="CSV con delimitador ;(punto y coma)" class="form-control d-none" name="dt_csv" id="dt_csv" aria-describedby="dt_csv" placeholder="Csv...">
				<input type="button"  title="CSV con delimitador ;(punto y coma)" class="btn" value="Examinar" onclick="document.getElementById('dt_csv').click();">
				<input type="text" readonly="readonly" class="form-control mt-20" name="dt_filename" id="dt_filename" aria-describedby="dt_filename" placeholder="Nombre de archivo...">
				<input type="text" class="form-control d-none" name="dt_csv_content" id="dt_csv_content" aria-describedby="dt_csv_content" placeholder="Csv...">
			</div>
			<hr>
			<button type="submit" class="btn btn-primary">Subir Archivo</button>
		</form>

		<p class="mt-30"><a class="btn btn-primary" href="./backend-index.php">Volver</a></p>
		
	</div>
	
</div>
