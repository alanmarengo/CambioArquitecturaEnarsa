$(document).ready(function() {
	
	$(".nav-tabs .nav-link").bind("click",function(e) {
		
		if ((this.id != "tab-link-busqueda") && (!dataset_ob[dataset_ob.id_name])) {
			
			e.stopImmediatePropagation()
			 
			$("#tab-link-busqueda").trigger("click");
			
			alert("Debe crear un nuevo gráfico o editar uno existente para abrir estas secciones");		
			
		}
		
	});
	
	dataset_ob = new dtob(
		{
			
			id_name:"grafico_id",
			urls:{
				new_id:"./php/get-new-grafico_id.php",
				drop:"./php/delete-grafico.php",
				load:"./php/get-grafico-by-id.php",
				save:"./php/save-grafico.php"
			},
			onNewId:function(new_id) {
				
				dataset_ob.load(new_id);
				
			},
			onLoad:function(data) {
				
				dataset_ob.load_with_grid(document.getElementById("frm-backend-graficos"),data);
				document.getElementById("grafico_current").innerHTML = "<span> Grafico Actual, Id:" + data.grafico_id + ", Titulo: " + data.grafico_titulo + "</span>";
				
			},
			onSave:function() {
				
				$('#grid-dt-graficos-abm').jsGrid('loadData');
				
			},
			onDrop:function() {
				
				document.getElementById("grafico_current").innerHTML = "<span>Sin Dataset Actual</span>";
				
				$(".nav-link").removeClass("active");
				$(".tab-pane").removeClass("active");
				
				$("#tab-link-busqueda").addClass("active");
				$("#tab-busqueda").addClass("active");
				
				$('#grid-dt-graficos-abm').jsGrid('loadData');
				
			}

		}
	);
	
	$(".roverlay").Roverlay();
	
});