<script type="text/javascript">

	$(document).ready(function() {
		
		var grafico_id = <?php echo $_GET["grafico_id"]; ?>;
		
		var req = $.ajax({
			
			async:false,
			type:"get",
			data:{grafico_id:grafico_id},
			url:"./php/get-json-grafico.php",
			success:function(d){}
			
		});
		
		var js = JSON.parse(req.responseText);
		
		eval("draw_grafico_"+js.grafico_tipo_id+"('grafico_container',js)");
		
	});

</script>