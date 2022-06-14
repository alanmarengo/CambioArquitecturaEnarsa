$(document).ready(function() {
	
	$(".nav-tabs .nav-link").bind("click",function(e) {
		
		/*if ((this.id != "tab-link-busqueda") && (!dataset_ob[dataset_ob.id_name])) {
			
			e.stopImmediatePropagation()
			 
			$("#tab-link-busqueda").trigger("click");
			
			alert("Debe crear un nuevo dataset o editar uno existente para abrir estas secciones");		
			
		}*/
		
	});
	
	dataset_ob = new dtob(
		{
			
			id_name:"recurso_id",
			urls:{
				new_id:"./php/get-new-recurso-id.php",
				drop:"./php/delete-recurso.php",
				load:"./php/get-recurso-by-id.php",
				save:"./php/save-recurso.php"
			},
			dir_reader:{
			
				server_path:"./js/directory_reader/",
				dir:"/mnt/sga/",
				showListContainer:document.getElementById("recurso_lista_archivos"),
				fileInfoContainer:document.getElementById("file-info-div")
				
			},
			file_dropper:{
		
				drop_zone:document.getElementById("recursos_archivos"),
				server_path:"./js/file_dropper/",
				global_folder:"recursos"
				
			},
			onNewId:function(new_id) {
				
				dataset_ob.load(new_id);
				
			},
			onLoad:function(data) {
				
				dataset_ob.load_with_grid(document.getElementById("frm-backend-main"),data);
				document.getElementById("recurso_current").innerHTML = "<span> Recurso Actual, Id:" + data.recurso_id + ", Titulo: " + data.recurso_titulo + "</span>";
				
				if (data.dt_id) {
					$("#grid-dt-graficos").jsGrid("loadData");
					$("#grid-dt-layers").jsGrid("loadData");
					$("#grid-dt-subtemas").jsGrid("loadData");
				}
				
			},
			onSave:function() {
				
				$('#grid-recurso').jsGrid('loadData');
				
			},
			onDrop:function() {
				
				document.getElementById("recurso_current").innerHTML = "<span>Sin Dataset Actual</span>";
				
				$(".nav-link").removeClass("active");
				$(".tab-pane").removeClass("active");
				
				$("#tab-link-busqueda").addClass("active");
				$("#tab-busqueda").addClass("active");
				
				$('#grid-recurso').jsGrid('loadData');
				
			}

		}
	);
	
	$(".roverlay").Roverlay();
	
});